<?php
namespace App\Http\Controllers\Frontend\Customer;
use App\Http\Controllers\Controller;
use App\Services\BkashService;

use Illuminate\Http\Request;
use App\Models\Branch_package;
use App\Models\Branch_transaction;
use App\Models\Customer;
use App\Models\Customer_device;
use App\Models\Customer_log;
use App\Models\Customer_recharge;
use App\Models\Grace_recharge;
use App\Models\Router as Mikrotik_router;
use App\Models\Send_message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function App\Helpers\check_pop_balance;
use function App\Helpers\customer_log;
use function App\Helpers\formate_uptime;
use function App\Helpers\get_mikrotik_user_info;
use function App\Helpers\send_message;
use function App\Helpers\router_activation;
use function App\Helpers\process_customer_single_recharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RouterOS\Client;
use RouterOS\Query;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class Recharge_controller extends Controller
{
    public function __construct(private BkashService $bkash) {}
    public function customer_recharge(Request $request) {
        $request->validate([
            'customer_id'    => 'required',
            'amount'         => 'required|numeric|min:1',
            'recharge_month' => 'required|array|min:1',
            'voucher_no'     => 'nullable',
        ]);

        /*------------Month Validation---------*/
        $validMonths = [];
        foreach ($request->recharge_month as $monthYear) {
            if (preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $monthYear)) {
                $validMonths[] = $monthYear;
            } else {
                return redirect()->back()->with('error', "Invalid month format: $monthYear. Use YYYY-MM.");
            }
        }

        /*-------Check Balance & Existing Recharge--------*/
        $pop_balance = check_pop_balance(auth()->guard('customer')->user()->pop_id);
        if ($pop_balance < $request->amount) {
            return redirect()->back()->with('error', "Pop balance is not enough");
        }

        foreach ($validMonths as $monthYear) {
            $existingRecharge = Customer_recharge::where('customer_id', $request->customer_id)
                ->where('recharge_month', $monthYear)
                ->exists();

            if ($existingRecharge) {
                $formattedMonth = Carbon::parse($monthYear)->translatedFormat('F Y');
                return redirect()->back()->with('error', "Recharge for month $formattedMonth already exists.");
            }
        }

        try {
            $customer = auth()->guard('customer')->user();
            $invoice_id = "INV-" . time() . "-" . $request->customer_id;
            /*-------Pending Payments Replace Session--------*/
            DB::table('pending_payments')->insert([
                'invoice_id'     => $invoice_id,
                'customer_id'    => $request->customer_id,
                'valid_months'   => json_encode($validMonths),
                'amount'         => $request->amount,
                'payable_amount' => $request->payable_amount ?? $request->amount,
                'note'           => $request->note ?? 'Online Recharge',
                'voucher_no'     => $request->voucher_no,
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            $apiKey = 'a7494e23051286c6eb9de9f7d5050f994e8dbea59287448935';
            $url = 'https://payment.nexuscloudsoft.com/api/checkout/redirect';
            $clean_username = Str::slug($customer->username ?? 'customer', '');
            $data = [
                'full_name'     => !empty($customer->username) ? $customer->username : ($customer->fullname ?? 'Customer'),
                'email_address' => !empty($customer->email) ? $customer->email : "{$clean_username}@gmail.com",
                'mobile_number' => !empty($customer->phone) ? $customer->phone : '01700000000',
                'amount'        => (string)$request->amount,
                'currency'      => 'BDT',
                'metadata'      => json_encode([
                    'invoice_id' => $invoice_id,
                ]),
                'return_url'    => route('payment.success', ['invoice_id' => $invoice_id]),
                'webhook_url'   => route('payment.webhook'),
            ];

            $response = Http::withHeaders([
                'MHS-PIPRAPAY-API-KEY' => $apiKey,
                'Content-Type'         => 'application/json',
                'Accept'               => 'application/json',
            ])->post($url, $data);

            $result = $response->json();

            if (!$response->successful()) {
                $errorMessage = is_array($result) && isset($result['message'])
                    ? $result['message']
                    : ($response->body() ?: 'HTTP Error Code: ' . $response->status());

                return redirect()->back()->with('error', 'Payment initialization failed: ' . $errorMessage);
            }

            if (!empty($result['pp_url'])) {
                return redirect()->away($result['pp_url']);
            }

            return redirect()->back()->with('error', 'Payment URL not found in response.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment Error: ' . $e->getMessage());
        }
    }

    public function payment_success(Request $request) {
        if ($request->get('pp_status') !== 'completed') {
            return redirect()->route('customer.portal')->with('error', 'Payment failed or cancelled.');
        }

        $invoice_id = $request->get('invoice_id');

        /*------Searching Payment Invoice-------*/
        $pendingPayment = DB::table('pending_payments')
            ->where('invoice_id', $invoice_id)
            ->where('status', 'pending')
            ->first();

        if (!$pendingPayment) {
            return redirect()->route('customer.portal')->with('error', 'Invalid transaction or payment already processed.');
        }

        $validMonths = json_decode($pendingPayment->valid_months, true);

        DB::beginTransaction();
        try {
            $result = process_customer_single_recharge(
                $pendingPayment->customer_id,
                $validMonths,
                'bkash',
                $pendingPayment->amount,
                $pendingPayment->note,
                $pendingPayment->voucher_no
            );

            if (!$result['success']) {
                DB::rollBack();
                return redirect()->route('customer.portal')->with('error', $result['message']);
            }

            $customer = $result['customer'];

           /*------ Payment Status Update-------*/
            DB::table('pending_payments')
                ->where('invoice_id', $invoice_id)
                ->update([
                    'status'     => 'completed',
                    'updated_at' => now(),
                ]);

            /*------Send Message For Customer---------*/
            $message = ""
                . "USER: {$customer->username}\n"
                . "ID: {$customer->id}\n"
                . "NAME: {$customer->fullname}\n"
                . "BILL: Tk {$pendingPayment->payable_amount}\n"
                . "TXN: {$request->get('transaction_ref')}\n\n"
                . "Thanks for your online payment";

            $send_message = new Send_message();
            $send_message->pop_id      = $customer->pop_id;
            $send_message->area_id     = $customer->area_id;
            $send_message->customer_id = $customer->id;
            $send_message->message     = $message;
            $send_message->sent_at     = Carbon::now();

            send_message($customer->phone, $message);
            $send_message->save();

            DB::commit();

            return redirect()->route('customer.portal')->with('success', "Recharge Successfully Completed!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.portal')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function payment_webhook(Request $request)
    {
        Log::info('PipraPay Webhook Data:', $request->all());

        return response()->json(['status' => 'success'], 200);
    }
    public function bkash_callback(Request $request){
        $paymentID  = session('bkash_payment_id');
        $data       = session('recharge_data');

        if (!$paymentID) {
            return redirect()->route('customer.portal')
                ->with('error', 'Invalid payment request!');
        }

        try {
        /***----------- bKash execute----------****/
        $execute = $this->bkash->executePayment($paymentID);

        if (!empty($execute['transactionStatus']) && $execute['transactionStatus'] === 'Completed') {

            $object                     = new Customer_recharge();
            $object->user_id            = null;
            $object->customer_id        = auth()->guard('customer')->user()->id;
            $object->pop_id             = auth()->guard('customer')->user()->pop_id;
            $object->area_id            = auth()->guard('customer')->user()->area_id;
            $object->recharge_month     = implode(',', $data['recharge_month']);
            $object->transaction_type   = 'bkash';
            $object->amount             = $data['amount'];
            $object->note               = $data['note'] ?? '';
            $object->voucher_no         = $execute['merchantInvoiceNumber'] ?? '';

            $customer = Customer::find(auth()->guard('customer')->user()->id);

            foreach ($data['recharge_month'] as $monthYear) {
                $existingRecharge = Customer_recharge::where('customer_id', auth()->guard('customer')->user()->id)
                    ->where('pop_id', auth()->guard('customer')->user()->pop_id)
                    ->where('area_id', auth()->guard('customer')->user()->area_id)
                    ->where('recharge_month', $monthYear)
                    ->exists();

                if ($existingRecharge) {
                     $formattedMonth = Carbon::parse($monthYear)->translatedFormat('F Y');
                    return response()->json([
                        'success' => false,
                        'message' => "Recharge for month $formattedMonth already exists.",
                    ]);
                }
            }

            $months_count           = count($data['recharge_month']);
            $base_date              = strtotime($customer->expire_date) > time() ? $customer->expire_date : date('Y-m-d');
            $new_expire_date        = date('Y-m-d', strtotime("+$months_count months", strtotime($base_date)));
            $customer->expire_date  = $new_expire_date;
            $object->paid_until     = $new_expire_date;

            $customer->update();
            /*-----------Customer Grace Recharge Start----------------*/
            $get_grace_recharge = Grace_recharge::where('customer_id', $customer->id)->first();
            if ($get_grace_recharge) {
                $customer_data = Customer::find($customer->id);
                /*Remove Grace Recharge Days*/
                if ($customer_data->expire_date) {
                    $customer_data->expire_date = \Carbon\Carbon::parse($customer_data->expire_date)->subDays($get_grace_recharge->days);
                    $customer_data->save();
                }
                /*Delete Grace Rechage**/
                $get_grace_recharge->delete();
                customer_log($object->customer_id, 'recharge',null, 'Customer Grace Recharge Remove!');
            }
            if ($object->save()) {
                customer_log($object->customer_id, 'recharge',null, 'Customer Recharge Bkash Completed!');

                /*Call Router activation Function*/
                router_activation($object->customer_id);


                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Recharge successfully.',
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Recharge failed. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('customer.portal')
                ->with('error', 'bKash payment failed or cancelled!');
        }
    } catch (\Throwable $e) {
        return redirect()->route('customer.portal')
            ->with('error', $e->getMessage());
    }

    }
}

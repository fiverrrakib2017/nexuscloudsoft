<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PricingHeader;
use App\Models\PricingPlan;
use App\Models\PricingTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PricingController extends Controller
{
    public function index()
    {
        $header = PricingHeader::first();
        return view('Backend.Pages.Pricing_section', compact('header'));
    }

    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = PricingHeader::first() ?? new PricingHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Pricing Section Header updated successfully!']);
    }

    public function getPlans()
    {
        $plans = PricingPlan::with('tiers')->orderBy('sort_order', 'asc')->get();
        return response()->json(['status' => 200, 'plans' => $plans]);
    }

    public function storePlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'setup_fee'    => 'required|string|max:100',
            'setup_label'  => 'nullable|string|max:255',
            'icon'         => 'required|string|max:100',
            'theme_color'  => 'required|string|max:50',
            'btn_text'     => 'nullable|string|max:100',
            'btn_link'     => 'nullable|string|max:255',
            'user_ranges'  => 'required|array|min:1',
            'user_ranges.*'=> 'required|string',
            'prices'       => 'required|array|min:1',
            'prices.*'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $plan = new PricingPlan();
            $plan->name        = $request->name;
            $plan->icon        = $request->icon;
            $plan->setup_fee   = $request->setup_fee;
            $plan->setup_label = $request->setup_label ?? 'One-time Setup Charge';
            $plan->theme_color = $request->theme_color;
            $plan->is_featured = $request->has('is_featured') ? 1 : 0;
            $plan->badge_text  = $request->badge_text ?? 'Most Popular';
            $plan->btn_text     = $request->btn_text ?? 'Get Started';
            $plan->btn_link     = $request->btn_link ?? '#';
            $plan->save();

            // Store Tiers
            if ($request->user_ranges && count($request->user_ranges) > 0) {
                foreach ($request->user_ranges as $index => $range) {
                    if (!empty($range) && !empty($request->prices[$index])) {
                        PricingTier::create([
                            'pricing_plan_id' => $plan->id,
                            'user_range'      => $range,
                            'price'           => $request->prices[$index],
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Pricing Plan created successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function editPlan($id)
    {
        $plan = PricingPlan::with('tiers')->find($id);
        if ($plan) {
            return response()->json(['status' => 200, 'plan' => $plan]);
        }
        return response()->json(['status' => 444, 'message' => 'Plan Not Found!']);
    }

    public function updatePlan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'setup_fee'    => 'required|string|max:100',
            'setup_label'  => 'nullable|string|max:255',
            'icon'         => 'required|string|max:100',
            'theme_color'  => 'required|string|max:50',
            'btn_text'     => 'nullable|string|max:100',
            'btn_link'     => 'nullable|string|max:255',
            'user_ranges'  => 'required|array|min:1',
            'user_ranges.*'=> 'required|string',
            'prices'       => 'required|array|min:1',
            'prices.*'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $plan = PricingPlan::find($id);
        if (!$plan) {
            return response()->json(['status' => 444, 'message' => 'Plan Not Found!']);
        }

        DB::beginTransaction();
        try {
            $plan->name        = $request->name;
            $plan->icon        = $request->icon;
            $plan->setup_fee   = $request->setup_fee;
            $plan->setup_label = $request->setup_label ?? 'One-time Setup Charge';
            $plan->theme_color = $request->theme_color;
            $plan->is_featured = $request->has('is_featured') ? 1 : 0;
            $plan->badge_text  = $request->badge_text ?? 'Most Popular';
            $plan->btn_text     = $request->btn_text ?? 'Get Started';
            $plan->btn_link     = $request->btn_link ?? '#';
            $plan->save();

            // Re-sync Tiers
            PricingTier::where('pricing_plan_id', $plan->id)->delete();

            if ($request->user_ranges && count($request->user_ranges) > 0) {
                foreach ($request->user_ranges as $index => $range) {
                    if (!empty($range) && !empty($request->prices[$index])) {
                        PricingTier::create([
                            'pricing_plan_id' => $plan->id,
                            'user_range'      => $range,
                            'price'           => $request->prices[$index],
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Pricing Plan updated successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deletePlan($id)
    {
        $plan = PricingPlan::find($id);
        if ($plan) {
            $plan->delete();
            return response()->json(['status' => 200, 'message' => 'Pricing Plan deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Plan Not Found!']);
    }
}
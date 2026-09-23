<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ValueHeader; 
use App\Models\ValueItem; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
class ValueController extends Controller
{
    public function index()
    {
        $header = ValueHeader::first();
        return view('Backend.Pages.Values_section', compact('header'));
    }

    // Update Header Section Title & Subtitle
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = ValueHeader::first() ?? new ValueHeader();
        $header->title = $request->title;
        $header->subtitle = $request->subtitle;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Header updated successfully!']);
    }

    // Fetch Cards List via AJAX
    public function getCards()
    {
        $cards = ValueItem::latest()->get();
        return response()->json(['status' => 200, 'cards' => $cards]);
    }

    // Store New Card
    public function storeCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $card = new ValueItem();
        $card->title       = $request->title;
        $card->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'value_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/values'), $imageName);
            $card->image = 'uploads/values/' . $imageName;
        }

        $card->save();

        return response()->json(['status' => 200, 'message' => 'New Card added successfully!']);
    }

    // Edit Card Data
    public function editCard($id)
    {
        $card = ValueItem::find($id);
        if ($card) {
            return response()->json(['status' => 200, 'card' => $card]);
        }
        return response()->json(['status' => 444, 'message' => 'Card Not Found!']);
    }

    // Update Card
    public function updateCard(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $card = ValueItem::find($id);
        if (!$card) {
            return response()->json(['status' => 444, 'message' => 'Card Not Found!']);
        }

        $card->title       = $request->title;
        $card->description = $request->description;

        if ($request->hasFile('image')) {
            if ($card->image && file_exists(public_path($card->image))) {
                @unlink(public_path($card->image));
            }
            $image = $request->file('image');
            $imageName = 'value_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/values'), $imageName);
            $card->image = 'uploads/values/' . $imageName;
        }

        $card->save();

        return response()->json(['status' => 200, 'message' => 'Card updated successfully!']);
    }

    // Delete Card
    public function deleteCard($id)
    {
        $card = ValueItem::find($id);
        if ($card) {
            if ($card->image && file_exists(public_path($card->image))) {
                @unlink(public_path($card->image));
            }
            $card->delete();
            return response()->json(['status' => 200, 'message' => 'Card deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Card Not Found!']);
    }
}
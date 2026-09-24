<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FaqHeader;
use App\Models\FaqItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $header = FaqHeader::first();
        return view('Backend.Pages.Faq_section', compact('header'));
    }

    // Update Section Header
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = FaqHeader::first() ?? new FaqHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'FAQ Header updated successfully!']);
    }

    // Fetch All FAQ Items via AJAX
    public function getItems()
    {
        $items = FaqItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New FAQ Item
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = new FaqItem();
        $item->question = $request->question;
        $item->answer   = $request->answer;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'FAQ Item added successfully!']);
    }

    // Edit FAQ Item
    public function editItem($id)
    {
        $item = FaqItem::find($id);
        if ($item) {
            return response()->json(['status' => 200, 'item' => $item]);
        }
        return response()->json(['status' => 444, 'message' => 'FAQ Item Not Found!']);
    }

    // Update FAQ Item
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = FaqItem::find($id);
        if (!$item) {
            return response()->json(['status' => 444, 'message' => 'FAQ Item Not Found!']);
        }

        $item->question = $request->question;
        $item->answer   = $request->answer;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'FAQ Item updated successfully!']);
    }

    // Delete FAQ Item
    public function deleteItem($id)
    {
        $item = FaqItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['status' => 200, 'message' => 'FAQ Item deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'FAQ Item Not Found!']);
    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AltFeatureHeader;
use App\Models\AltFeatureItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AltFeatureController extends Controller
{
    // View Page
    public function index()
    {
        $header = AltFeatureHeader::first();
        return view('Backend.Pages.Alt_features_section', compact('header'));
    }

    // Update Header Side Image
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = AltFeatureHeader::first() ?? new AltFeatureHeader();

        if ($request->hasFile('image')) {
            if ($header->image && file_exists(public_path($header->image))) {
                @unlink(public_path($header->image));
            }
            $image = $request->file('image');
            $imageName = 'alt_feature_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/alt_features'), $imageName);
            $header->image = 'uploads/alt_features/' . $imageName;
        }

        $header->save();

        return response()->json(['status' => 200, 'message' => 'Alt Feature Image updated successfully!']);
    }

    // Fetch Items List via AJAX
    public function getItems()
    {
        $items = AltFeatureItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Item
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:100',
            'color'       => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = new AltFeatureItem();
        $item->title       = $request->title;
        $item->description = $request->description;
        $item->icon        = $request->icon;
        $item->color       = $request->color;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Alt Feature Item added successfully!']);
    }

    // Edit Item
    public function editItem($id)
    {
        $item = AltFeatureItem::find($id);
        if ($item) {
            return response()->json(['status' => 200, 'item' => $item]);
        }
        return response()->json(['status' => 444, 'message' => 'Alt Feature Item Not Found!']);
    }

    // Update Item
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:100',
            'color'       => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = AltFeatureItem::find($id);
        if (!$item) {
            return response()->json(['status' => 444, 'message' => 'Alt Feature Item Not Found!']);
        }

        $item->title       = $request->title;
        $item->description = $request->description;
        $item->icon        = $request->icon;
        $item->color       = $request->color;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Alt Feature Item updated successfully!']);
    }

    // Delete Item
    public function deleteItem($id)
    {
        $item = AltFeatureItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['status' => 200, 'message' => 'Alt Feature Item deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Alt Feature Item Not Found!']);
    }
}
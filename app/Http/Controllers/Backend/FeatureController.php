<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FeatureHeader;
use App\Models\FeatureItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
{
    // View Page
    public function index()
    {
        $header = FeatureHeader::first();
        return view('Backend.Pages.Features_section', compact('header'));
    }

    // Update Header Section Title, Subtitle & Image
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = FeatureHeader::first() ?? new FeatureHeader();
        $header->title    = $request->title;
        $header->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            if ($header->image && file_exists(public_path($header->image))) {
                @unlink(public_path($header->image));
            }
            $image = $request->file('image');
            $imageName = 'feature_header_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/features'), $imageName);
            $header->image = 'uploads/features/' . $imageName;
        }

        $header->save();

        return response()->json(['status' => 200, 'message' => 'Features Header updated successfully!']);
    }

    // Fetch Feature Items List via AJAX
    public function getItems()
    {
        $items = FeatureItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Feature Item
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = new FeatureItem();
        $item->title = $request->title;
        $item->icon  = $request->icon;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'New Feature Item added successfully!']);
    }

    // Edit Feature Item
    public function editItem($id)
    {
        $item = FeatureItem::find($id);
        if ($item) {
            return response()->json(['status' => 200, 'item' => $item]);
        }
        return response()->json(['status' => 444, 'message' => 'Feature Item Not Found!']);
    }

    // Update Feature Item
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = FeatureItem::find($id);
        if (!$item) {
            return response()->json(['status' => 444, 'message' => 'Feature Item Not Found!']);
        }

        $item->title = $request->title;
        $item->icon  = $request->icon;
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Feature Item updated successfully!']);
    }

    // Delete Feature Item
    public function deleteItem($id)
    {
        $item = FeatureItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['status' => 200, 'message' => 'Feature Item deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Feature Item Not Found!']);
    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceHeader;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $header = ServiceHeader::first();
        return view('Backend.Pages.Services_section', compact('header'));
    }

    // Update Section Title & Subtitle
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = ServiceHeader::first() ?? new ServiceHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Services Section Header updated successfully!']);
    }

    // Fetch All Service Items via AJAX
    public function getItems()
    {
        $items = ServiceItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Service Item
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:100',
            'color_class' => 'required|string|max:50',
            'btn_text'    => 'nullable|string|max:100',
            'btn_link'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = new ServiceItem();
        $item->title       = $request->title;
        $item->description = $request->description;
        $item->icon        = $request->icon;
        $item->color_class = $request->color_class;
        $item->btn_text    = $request->btn_text ?? 'Learn More';
        $item->btn_link    = $request->btn_link ?? '#';
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Service Item added successfully!']);
    }

    // Edit Service Item
    public function editItem($id)
    {
        $item = ServiceItem::find($id);
        if ($item) {
            return response()->json(['status' => 200, 'item' => $item]);
        }
        return response()->json(['status' => 444, 'message' => 'Service Item Not Found!']);
    }

    // Update Service Item
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'required|string|max:100',
            'color_class' => 'required|string|max:50',
            'btn_text'    => 'nullable|string|max:100',
            'btn_link'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = ServiceItem::find($id);
        if (!$item) {
            return response()->json(['status' => 444, 'message' => 'Service Item Not Found!']);
        }

        $item->title       = $request->title;
        $item->description = $request->description;
        $item->icon        = $request->icon;
        $item->color_class = $request->color_class;
        $item->btn_text    = $request->btn_text ?? 'Learn More';
        $item->btn_link    = $request->btn_link ?? '#';
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Service Item updated successfully!']);
    }

    // Delete Service Item
    public function deleteItem($id)
    {
        $item = ServiceItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['status' => 200, 'message' => 'Service Item deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Service Item Not Found!']);
    }
}
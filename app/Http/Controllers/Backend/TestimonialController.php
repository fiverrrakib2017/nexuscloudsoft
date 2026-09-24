<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TestimonialHeader;
use App\Models\TestimonialItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $header = TestimonialHeader::first();
        return view('Backend.Pages.Testimonials_section', compact('header'));
    }

    // Update Section Header
    public function updateHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'sub_title' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $header = TestimonialHeader::first() ?? new TestimonialHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Testimonial Header updated successfully!']);
    }

    // Fetch All Testimonial Items via AJAX
    public function getItems()
    {
        $items = TestimonialItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Testimonial
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'review'      => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = new TestimonialItem();
        $item->client_name   = $request->client_name;
        $item->designation   = $request->designation ?? 'Trusted ISP Partner';
        $item->review        = $request->review;
        $item->rating        = $request->rating;
        // Auto set avatar letter from first character of name
        $item->avatar_letter = strtoupper(substr(trim($request->client_name), 0, 1));
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Testimonial added successfully!']);
    }

    // Edit Testimonial Item
    public function editItem($id)
    {
        $item = TestimonialItem::find($id);
        if ($item) {
            return response()->json(['status' => 200, 'item' => $item]);
        }
        return response()->json(['status' => 444, 'message' => 'Testimonial Item Not Found!']);
    }

    // Update Testimonial Item
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'review'      => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $item = TestimonialItem::find($id);
        if (!$item) {
            return response()->json(['status' => 444, 'message' => 'Testimonial Item Not Found!']);
        }

        $item->client_name   = $request->client_name;
        $item->designation   = $request->designation ?? 'Trusted ISP Partner';
        $item->review        = $request->review;
        $item->rating        = $request->rating;
        $item->avatar_letter = strtoupper(substr(trim($request->client_name), 0, 1));
        $item->save();

        return response()->json(['status' => 200, 'message' => 'Testimonial updated successfully!']);
    }

    // Delete Testimonial Item
    public function deleteItem($id)
    {
        $item = TestimonialItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['status' => 200, 'message' => 'Testimonial deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Testimonial Item Not Found!']);
    }
}
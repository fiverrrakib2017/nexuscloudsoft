<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TeamHeader;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $header = TeamHeader::first();
        return view('Backend.Pages.Team_section', compact('header'));
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

        $header = TeamHeader::first() ?? new TeamHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Team Section Header updated successfully!']);
    }

    // Fetch All Team Members via AJAX
    public function getItems()
    {
        $items = TeamMember::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Team Member
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'twitter'     => 'nullable|string|max:255',
            'facebook'    => 'nullable|string|max:255',
            'instagram'   => 'nullable|string|max:255',
            'linkedin'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $member = new TeamMember();
        $member->name        = $request->name;
        $member->designation = $request->designation;
        $member->twitter     = $request->twitter;
        $member->facebook    = $request->facebook;
        $member->instagram   = $request->instagram;
        $member->linkedin    = $request->linkedin;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'team_' . time() . '_' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/team'), $imageName);
            $member->image = 'uploads/team/' . $imageName;
        }

        $member->save();

        return response()->json(['status' => 200, 'message' => 'Team member added successfully!']);
    }

    // Edit Team Member
    public function editItem($id)
    {
        $member = TeamMember::find($id);
        if ($member) {
            return response()->json(['status' => 200, 'member' => $member]);
        }
        return response()->json(['status' => 444, 'message' => 'Team member not found!']);
    }

    // Update Team Member
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'twitter'     => 'nullable|string|max:255',
            'facebook'    => 'nullable|string|max:255',
            'instagram'   => 'nullable|string|max:255',
            'linkedin'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['status' => 444, 'message' => 'Team member not found!']);
        }

        $member->name        = $request->name;
        $member->designation = $request->designation;
        $member->twitter     = $request->twitter;
        $member->facebook    = $request->facebook;
        $member->instagram   = $request->instagram;
        $member->linkedin    = $request->linkedin;

        if ($request->hasFile('image')) {
            if ($member->image && file_exists(public_path($member->image))) {
                @unlink(public_path($member->image));
            }
            $image = $request->file('image');
            $imageName = 'team_' . time() . '_' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/team'), $imageName);
            $member->image = 'uploads/team/' . $imageName;
        }

        $member->save();

        return response()->json(['status' => 200, 'message' => 'Team member updated successfully!']);
    }

    // Delete Team Member
    public function deleteItem($id)
    {
        $member = TeamMember::find($id);
        if ($member) {
            if ($member->image && file_exists(public_path($member->image))) {
                @unlink(public_path($member->image));
            }
            $member->delete();
            return response()->json(['status' => 200, 'message' => 'Team member deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Team member not found!']);
    }
}
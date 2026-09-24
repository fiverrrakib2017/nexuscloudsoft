<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DemoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemoRequestController extends Controller
{
    // Show Public Demo Request Page
    public function showForm()
    {
        return view('Frontend.Pages.Demo_request');
    }

    public function store(Request $request)
    {
        
        $request->validate([
           'company_name' => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|max:255',
            'district'     => 'nullable|string|max:100',
            'user_count'   => 'nullable|string|max:100',
            'message'      => 'nullable|string',
        ]);

        

        DemoRequest::create([
            'company_name' => $request->company_name,
            'name'         => $request->name,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'district'     => $request->district,
            'user_count'   => $request->user_count,
            'message'      => $request->message,
            'status'       => 'pending',
        ]);

        return redirect()->back()->with('success', 'ধন্যবাদ! আপনার ডেমো রিকোয়েস্টটি সফলভাবে জমা হয়েছে। আমাদের টিম খুব শীঘ্রই আপনার সাথে যোগাযোগ করবে।');
    }

    // Admin Panel: View Main List Page
    public function index()
    {
        return view('Backend.Pages.Demo_request');
    }

    // Admin Panel: Get Demo Requests List via AJAX
    public function getData()
    {
        $requests = DemoRequest::latest()->get();
        return response()->json(['status' => 200, 'requests' => $requests]);
    }

    // Admin Panel: Update Status (Pending / Contacted / Completed / Rejected)
    public function updateStatus(Request $request, $id)
    {
        $demo = DemoRequest::find($id);
        if ($demo) {
            $demo->status = $request->status;
            $demo->save();
            return response()->json(['status' => 200, 'message' => 'Status updated successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Demo request not found!']);
    }

    // Admin Panel: Delete Request
    public function delete($id)
    {
        $demo = DemoRequest::find($id);
        if ($demo) {
            $demo->delete();
            return response()->json(['status' => 200, 'message' => 'Demo request deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Demo request not found!']);
    }
}
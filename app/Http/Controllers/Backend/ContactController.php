<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // View Main Index Page in Admin Panel
    public function index()
    {
        $setting = ContactSetting::first();
        return view('Backend.Pages.Contact_section', compact('setting'));
    }

    // Update Contact Settings & Header
    public function updateSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'sub_title'       => 'nullable|string|max:255',
            'address_line1'   => 'nullable|string|max:255',
            'address_line2'   => 'nullable|string|max:255',
            'phone1'          => 'nullable|string|max:255',
            'phone2'          => 'nullable|string|max:255',
            'email1'          => 'nullable|email|max:255',
            'email2'          => 'nullable|email|max:255',
            'open_hours_days' => 'nullable|string|max:255',
            'open_hours_time' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $setting = ContactSetting::first() ?? new ContactSetting();
        $setting->title           = $request->title;
        $setting->sub_title       = $request->sub_title;
        $setting->address_line1   = $request->address_line1;
        $setting->address_line2   = $request->address_line2;
        $setting->phone1          = $request->phone1;
        $setting->phone2          = $request->phone2;
        $setting->email1          = $request->email1;
        $setting->email2          = $request->email2;
        $setting->open_hours_days = $request->open_hours_days;
        $setting->open_hours_time = $request->open_hours_time;
        $setting->save();

        return response()->json(['status' => 200, 'message' => 'Contact Settings updated successfully!']);
    }

    // Fetch Messages Received from Frontend Form
    public function getMessages()
    {
        $messages = ContactMessage::latest()->get();
        return response()->json(['status' => 200, 'messages' => $messages]);
    }

    // Delete Received Message
    public function deleteMessage($id)
    {
        $msg = ContactMessage::find($id);
        if ($msg) {
            $msg->delete();
            return response()->json(['status' => 200, 'message' => 'Message deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Message not found!']);
    }

    // Frontend Form Submit Endpoint (AJAX)
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 200, 'message' => 'Your message has been sent. Thank you!']);
    }
}
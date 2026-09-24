<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClientHeader;
use App\Models\ClientItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $header = ClientHeader::first();
        return view('Backend.Pages.Clients_section', compact('header'));
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

        $header = ClientHeader::first() ?? new ClientHeader();
        $header->title     = $request->title;
        $header->sub_title = $request->sub_title;
        $header->save();

        return response()->json(['status' => 200, 'message' => 'Clients Header updated successfully!']);
    }

    // Fetch All Client Logos via AJAX
    public function getItems()
    {
        $items = ClientItem::latest()->get();
        return response()->json(['status' => 200, 'items' => $items]);
    }

    // Store New Client Logo
    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'nullable|string|max:255',
            'logo'        => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url'         => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $client = new ClientItem();
        $client->client_name = $request->client_name;
        $client->url         = $request->url;

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = 'client_' . time() . '_' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/clients'), $imageName);
            $client->logo = 'uploads/clients/' . $imageName;
        }

        $client->save();

        return response()->json(['status' => 200, 'message' => 'Client logo added successfully!']);
    }

    // Edit Client Logo
    public function editItem($id)
    {
        $client = ClientItem::find($id);
        if ($client) {
            return response()->json(['status' => 200, 'client' => $client]);
        }
        return response()->json(['status' => 444, 'message' => 'Client item not found!']);
    }

    // Update Client Logo
    public function updateItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'url'         => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $client = ClientItem::find($id);
        if (!$client) {
            return response()->json(['status' => 444, 'message' => 'Client item not found!']);
        }

        $client->client_name = $request->client_name;
        $client->url         = $request->url;

        if ($request->hasFile('logo')) {
            if ($client->logo && file_exists(public_path($client->logo))) {
                @unlink(public_path($client->logo));
            }
            $image = $request->file('logo');
            $imageName = 'client_' . time() . '_' . rand(100, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/clients'), $imageName);
            $client->logo = 'uploads/clients/' . $imageName;
        }

        $client->save();

        return response()->json(['status' => 200, 'message' => 'Client logo updated successfully!']);
    }

    // Delete Client Logo
    public function deleteItem($id)
    {
        $client = ClientItem::find($id);
        if ($client) {
            if ($client->logo && file_exists(public_path($client->logo))) {
                @unlink(public_path($client->logo));
            }
            $client->delete();
            return response()->json(['status' => 200, 'message' => 'Client logo deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Client item not found!']);
    }
}
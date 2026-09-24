<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use App\Models\FooterSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    // View Main Index Page
    public function index()
    {
        $setting = FooterSetting::first();
        return view('Backend.Pages.Footer_section', compact('setting'));
    }

    // Update Footer Settings
    public function updateSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cta_title'      => 'required|string|max:255',
            'site_name'      => 'required|string|max:255',
            'copyright_text' => 'required|string|max:255',
            'developed_by'   => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $setting = FooterSetting::first() ?? new FooterSetting();
        $setting->cta_title          = $request->cta_title;
        $setting->cta_description    = $request->cta_description;
        $setting->cta_btn1_text      = $request->cta_btn1_text;
        $setting->cta_btn1_url       = $request->cta_btn1_url;
        $setting->cta_btn2_text      = $request->cta_btn2_text;
        $setting->cta_btn2_url       = $request->cta_btn2_url;

        $setting->site_name          = $request->site_name;
        $setting->about_text         = $request->about_text;
        $setting->phone              = $request->phone;
        $setting->email              = $request->email;

        $setting->social_description = $request->social_description;
        $setting->facebook           = $request->facebook;
        $setting->youtube            = $request->youtube;
        $setting->linkedin           = $request->linkedin;
        $setting->github             = $request->github;

        $setting->copyright_text     = $request->copyright_text;
        $setting->developed_by       = $request->developed_by;
        $setting->save();

        return response()->json(['status' => 200, 'message' => 'Footer Settings updated successfully!']);
    }

    // Fetch Solutions List
    public function getSolutions()
    {
        $solutions = FooterSolution::latest()->get();
        return response()->json(['status' => 200, 'solutions' => $solutions]);
    }

    // Store New Solution Link
    public function storeSolution(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        FooterSolution::create([
            'title' => $request->title,
            'url'   => $request->url ?? '#',
        ]);

        return response()->json(['status' => 200, 'message' => 'Solution link added successfully!']);
    }

    // Edit Solution Link
    public function editSolution($id)
    {
        $solution = FooterSolution::find($id);
        if ($solution) {
            return response()->json(['status' => 200, 'solution' => $solution]);
        }
        return response()->json(['status' => 444, 'message' => 'Solution not found!']);
    }

    // Update Solution Link
    public function updateSolution(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $solution = FooterSolution::find($id);
        if (!$solution) {
            return response()->json(['status' => 444, 'message' => 'Solution not found!']);
        }

        $solution->title = $request->title;
        $solution->url   = $request->url ?? '#';
        $solution->save();

        return response()->json(['status' => 200, 'message' => 'Solution link updated successfully!']);
    }

    // Delete Solution Link
    public function deleteSolution($id)
    {
        $solution = FooterSolution::find($id);
        if ($solution) {
            $solution->delete();
            return response()->json(['status' => 200, 'message' => 'Solution link deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Solution not found!']);
    }
}
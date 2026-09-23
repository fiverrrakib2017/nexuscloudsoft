<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
class HeroController extends Controller
{
    
    public function index(){
        $hero = HeroSection::first();
        return view('Backend.Pages.Hero_section',compact('hero'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'subtitle'  => 'required|string',
            'btn_text'  => 'required|string|max:100',
            'btn_url'   => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        }

        $hero = HeroSection::first() ?? new HeroSection();

        $hero->title     = $request->title;
        $hero->subtitle  = $request->subtitle;
        $hero->btn_text  = $request->btn_text;
        $hero->btn_url   = $request->btn_url;
        $hero->video_url = $request->video_url;

        // Image Upload
        if ($request->hasFile('image')) {
            if ($hero->image && file_exists(public_path($hero->image))) {
                @unlink(public_path($hero->image));
            }

            $image = $request->file('image');
            $imageName = 'hero_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/hero'), $imageName);
            $hero->image = 'uploads/hero/' . $imageName;
        }

        $hero->save();

        return response()->json([
            'status'  => 200,
            'message' => 'Hero Section is updated successfully!',
            'data'    => $hero
        ]);
    }
}

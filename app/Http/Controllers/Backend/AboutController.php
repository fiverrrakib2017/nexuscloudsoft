<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSection; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
class AboutController extends Controller
{
    
    public function index(){
        $about = AboutSection::first();
        return view('Backend.Pages.About_section',compact('about'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_title'   => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'btn_text'    => 'required|string|max:100',
            'btn_url'     => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        }

        // Get first record or initiate new instance
        $about = AboutSection::first() ?? new AboutSection();

        $about->sub_title   = $request->sub_title;
        $about->title       = $request->title;
        $about->description = $request->description;
        $about->btn_text    = $request->btn_text;
        $about->btn_url     = $request->btn_url;

        // Image Upload Processing
        if ($request->hasFile('image')) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }

            $image = $request->file('image');
            $imageName = 'about_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/about'), $imageName);
            $about->image = 'uploads/about/' . $imageName;
        }

        $about->save();

        return response()->json([
            'status'  => 200,
            'message' => 'About Section content updated successfully!',
            'data'    => $about
        ]);
    }
}

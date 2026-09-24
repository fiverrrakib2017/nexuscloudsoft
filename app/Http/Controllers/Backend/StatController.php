<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatItem; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
class StatController extends Controller
{
    // View Page
    public function index()
    {
        return view('Backend.Pages.Stats_section');
    }

    // Fetch Stats List via AJAX
    public function getStats()
    {
        $stats = StatItem::latest()->get();
        return response()->json(['status' => 200, 'stats' => $stats]);
    }

    // Store New Stat
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'count' => 'required|numeric|min:0',
            'icon'  => 'required|string|max:100',
            'color' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $stat = new StatItem();
        $stat->title = $request->title;
        $stat->count = $request->count;
        $stat->icon  = $request->icon;
        $stat->color = $request->color;
        $stat->save();

        return response()->json(['status' => 200, 'message' => 'New Counter Stat added successfully!']);
    }

    // Edit Stat Data
    public function edit($id)
    {
        $stat = StatItem::find($id);
        if ($stat) {
            return response()->json(['status' => 200, 'stat' => $stat]);
        }
        return response()->json(['status' => 444, 'message' => 'Stat Item Not Found!']);
    }

    // Update Stat Data
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'count' => 'required|numeric|min:0',
            'icon'  => 'required|string|max:100',
            'color' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $stat = StatItem::find($id);
        if (!$stat) {
            return response()->json(['status' => 444, 'message' => 'Stat Item Not Found!']);
        }

        $stat->title = $request->title;
        $stat->count = $request->count;
        $stat->icon  = $request->icon;
        $stat->color = $request->color;
        $stat->save();

        return response()->json(['status' => 200, 'message' => 'Stat item updated successfully!']);
    }

    // Delete Stat Item
    public function delete($id)
    {
        $stat = StatItem::find($id);
        if ($stat) {
            $stat->delete();
            return response()->json(['status' => 200, 'message' => 'Stat item deleted successfully!']);
        }
        return response()->json(['status' => 444, 'message' => 'Stat Item Not Found!']);
    }
}
<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\GradingRequest;
use App\Models\PokemonCard;
use App\Models\GradingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentTab = $request->get('tab', 'pickup');
        $packageFilter = $request->get('package_id');

        $packages = GradingPackage::all();
        
        $query = GradingRequest::with(['pokemonCard', 'package', 'pokemonCard.user'])->latest();

        if ($currentTab === 'pickup') {
            $requests = $query->where('logistics_status', 'Waiting_For_Pickup')->get();
        } elseif ($currentTab === 'lab') {
            $query->where('logistics_status', 'In_Lab');
            if ($packageFilter) {
                $query->where('package_id', $packageFilter);
            }
            $requests = $query->get();
        } elseif ($currentTab === 'dropoff') {
            $requests = $query->where('logistics_status', 'Grading_Done')->get();
        } else {
            $requests = collect();
        }

        $gradingRequest = null;
        if ($request->has('grading_id')) {
            $gradingRequest = GradingRequest::with('pokemonCard')->findOrFail($request->grading_id);
        }

        return view('staff.dashboard', compact('requests', 'currentTab', 'packages', 'packageFilter', 'gradingRequest'));
    }

    public function pickup($id)
    {
        $req = GradingRequest::findOrFail($id);
        
        $req->update(['logistics_status' => 'In_Lab']);
        if ($req->pokemonCard) {
            $req->pokemonCard->update(['status' => 'In_Grading']);
        }

        return redirect()->route('staff.dashboard', ['tab' => 'pickup'])->with('success', 'Kartu berhasil di-pickup dan dipindahkan ke Lab.');
    }

    public function submitLabGrading(Request $request, $id)
    {
        $request->validate([
            'centering_score' => 'required|integer|min:1|max:10',
            'corners_score' => 'required|integer|min:1|max:10',
            'edges_score' => 'required|integer|min:1|max:10',
            'surface_score' => 'required|integer|min:1|max:10',
            'final_grade' => 'required|integer|min:1|max:10',
            'graded_image' => 'required|image|max:2048', 
        ]);

        $req = GradingRequest::findOrFail($id);

        $imagePath = $request->file('graded_image')->store('graded_cards', 'public');

        $req->update([
            'grader_id' => Auth::id(),
            'centering_score' => $request->centering_score,
            'corners_score' => $request->corners_score,
            'edges_score' => $request->edges_score,
            'surface_score' => $request->surface_score,
            'final_grade' => $request->final_grade,
            'logistics_status' => 'Grading_Done'
        ]);

        if ($req->pokemonCard) {
            $req->pokemonCard->update([
                'grade' => $request->final_grade,
                'graded_image_url' => $imagePath,
                'status' => 'Graded_Inventory' 
            ]);
        }

        return redirect()->route('staff.dashboard', ['tab' => 'lab'])->with('success', 'Penilaian selesai! Foto bukti slab dan skor berhasil direkam.');
    }

    public function dropoff($id)
    {
        $req = GradingRequest::findOrFail($id);

        $req->update(['logistics_status' => 'Completed']);
        if ($req->pokemonCard) {
            $req->pokemonCard->update(['status' => 'Graded_Inventory']);
        }

        return redirect()->route('staff.dashboard', ['tab' => 'dropoff'])->with('success', 'Status penyerahan selesai. Kartu telah kembali ke tangan Customer.');
    }
}
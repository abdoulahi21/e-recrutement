<?php

namespace App\Http\Controllers\Recru;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $offers = Offer::where('user_id', $user->id)->get();

        $query = Apply::with(['user', 'offer'])
            ->whereIn('offer_id', $offers->pluck('id'));

        if (request()->filled('offer_id')) {
            $query->where('offer_id', request('offer_id'));
        }

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $applications = $query->latest()->get();

        return view('rh.applications.index', compact('applications', 'offers'));
    }


    public function show(Apply $apply)
    {
        $apply->load(['user', 'offer']);
        return view('rh.applications.show', compact('apply'));
    }

    public function update(Request $request, Apply $apply)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $apply->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    public function updateStatus(Request $request, Apply $apply)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected', // adapte selon tes statuts
        ]);

        $apply->status = $request->status;
        $apply->save();

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

}

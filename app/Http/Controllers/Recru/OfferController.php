<?php

namespace App\Http\Controllers\Recru;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offers = Offer::with('user')
            ->where('user_id', Auth::id())
            ->get();
        return view('rh.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('rh.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after_or_equal:today',
            'type' => 'required|string|max:50',
        ]);
        $offer = new Offer();
        $offer->title=$request->input('title');
        $offer->description=$request->input('description');
        $offer->end_date=$request->input('end_date');
        $offer->type=$request->input('type');
        $offer->user_id=Auth::id();
        $offer->status="publier";
        $offer->save();
        return redirect()->route('rh.index')->with('success', 'Offre ajouter avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $offer=Offer::find($id);
        return view('rh.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $offers=Offer::find($id);
        return view('rh.edit', compact('offers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after_or_equal:today',
            'type' => 'required|string|max:50',
        ]);
        $offer=Offer::find($id);
        $offer->title=$request->input('title');
        $offer->description=$request->input('description');
        $offer->end_date=$request->input('end_date');
        $offer->type=$request->input('type');
        $offer->status="published";
        $offer->save();
        return redirect()->route('rh.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $offers=Offer::find($id);
        $offers->delete();
        return redirect()->route('rh.index')->with('success', 'Offre supprimée avec succès.');
    }
}

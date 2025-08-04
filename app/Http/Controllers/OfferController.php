<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function jobs(Request $request)
    {
        $query = Offer::with('user');
        // Si l'utilisateur est un recruteur (role_id = 2), on filtre par ses offres
        if (Auth::check() && Auth::user()->role_id == 2) {
            $query->where('user_id', Auth::id());
        }

        // Filtre par titre
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par date de fin (offres non expirées)
        if ($request->filled('active_only')) {
            $query->where('end_date', '>=', now()->toDateString());
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $offers = $query->paginate(12)->withQueryString();

        // Types disponibles pour le filtre
        $types = Offer::distinct()->pluck('type');

        return view('candidat.jobs', compact('offers', 'types'));
    }

    public function show(Offer $offer)
    {
        $offer->load(['user', 'apply.user']);

        return view('candidat.jobs-detail', compact('offer'));
    }

    /**
     * Apply to an offer
     */
    public function apply(Request $request, Offer $offer)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour postuler.');
        }

        // Vérifier que l'offre est active et non expirée
        if ($offer->status !== 'active' || now()->gt($offer->end_date)) {
            return redirect()->back()->with('error', 'Cette offre n\'est plus disponible.');
        }

        // Vérifier que l'utilisateur n'a pas déjà postulé
        $existingApplication = Apply::where('user_id', Auth::id())
            ->where('offer_id', $offer->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Valider les données
        $validated = $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'cv' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240' // 10MB maxs
            ]
        ], [
            'message.required' => 'La lettre de motivation est obligatoire.',
            'message.min' => 'La lettre de motivation doit contenir au moins 10 caractères.',
            'message.max' => 'La lettre de motivation ne peut pas dépasser 2000 caractères.',
            'cv.required' => 'Le CV est obligatoire.',
            'cv.mimes' => 'Le CV doit être au format PDF.',
            'cv.max' => 'Le CV ne peut pas dépasser 10MB.'
        ]);

        try {
            // Stocker le CV
            $cvPath = $request->file('cv')->store('cvs', 'public');

            // Créer la candidature
            Apply::create([
                'user_id' => Auth::id(),
                'offer_id' => $offer->id,
                'message' => $validated['message'],
                'cv' => $cvPath,
                'status' => 'pending'
            ]);

            return redirect()->route('jobs-detail', $offer)->with('success', 'Votre candidature a été envoyée avec succès!');

        } catch (\Exception $e) {
            // En cas d'erreur, supprimer le fichier s'il a été uploadé
            if (isset($cvPath) && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre candidature. Veuillez réessayer.');
        }
    }

    public function index(Request $request)
    {
        $offers = Offer::where('user_id', Auth::id())
            ->with(['apply' => function ($query) use ($request) {
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }
                $query->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statuses = ['pending' => 'En attente', 'accepted' => 'Acceptée', 'rejected' => 'Rejetée'];

        return view('rh.index', compact('offers', 'statuses'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rh.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after:today',
            'type' => 'required|string|in:stage,emploi,freelance',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active';

        Offer::create($validated);
        return redirect()->route('rh.dashboard')->with('success', 'Offre créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        return view('rh.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date|after:today',
            'type' => 'required|string|in:stage,emploi,freelance',
            'status' => 'required|string|in:active,inactive',
        ]);

        $offer->update($validated);

        return redirect()->route('rh.offers.show', $offer)->with('success', 'Offre mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('rh.offers.index')->with('success', 'Offre supprimée avec succès!');
    }

    /**
     * Show applications for an offer (for offer owner)
     */
    public function applications(Offer $offer)
    {
        $applications = $offer->apply()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('rh.apply', compact('offer', 'applications'));
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, Offer $offer, Apply $application)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,accepted,rejected'
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Statut de la candidature mis à jour avec succès!');
    }

}

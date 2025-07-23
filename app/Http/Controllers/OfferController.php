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

}

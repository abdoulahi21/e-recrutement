<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CandidatDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer toutes les candidatures de l'utilisateur
        $userApplications = Apply::where('user_id', $user->id)
            ->with('offer')
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques générales
        $totalApplications = $userApplications->count();
        $pendingApplications = $userApplications->where('status', 'pending')->count();
        $acceptedApplications = $userApplications->where('status', 'accepted')->count();
        $rejectedApplications = $userApplications->where('status', 'rejected')->count();

        // Candidatures de ce mois
        $thisMonthApplications = $userApplications->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $lastMonthApplications = Apply::where('user_id', $user->id)
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->count();

        // Taux d'acceptation
        $acceptanceRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100)
            : 0;

        // Taux de réponse (candidatures qui ne sont plus en attente)
        $respondedApplications = $acceptedApplications + $rejectedApplications;
        $responseRate = $totalApplications > 0
            ? round(($respondedApplications / $totalApplications) * 100)
            : 0;

        // Candidatures récentes (5 dernières)
        $recentApplications = $userApplications->take(5);

        // Calcul de la complétude du profil
        $profileCompleteness = $this->calculateProfileCompleteness($user);

        // Notifications récentes
        $recentNotifications = $this->getRecentNotifications($userApplications);

        // Offres recommandées (basées sur le profil utilisateur)
        $recommendedOffers = $this->getRecommendedOffers($user);

        // Activité récente
        $recentActivity = $this->getRecentActivity($userApplications);

        // Statistiques par type d'emploi
        $applicationsByType = $this->getApplicationsByType($userApplications);

        // Progression mensuelle
        $monthlyProgress = $this->getMonthlyProgress($user);

        return view('candidat.applications', compact(
            'totalApplications',
            'thisMonthApplications',
            'lastMonthApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications',
            'acceptanceRate',
            'responseRate',
            'profileCompleteness',
            'recentApplications',
            'recentNotifications',
            'recommendedOffers',
            'recentActivity',
            'applicationsByType',
            'monthlyProgress'
        ));
    }

    /**
     * Calculer le pourcentage de complétude du profil
     */
    private function calculateProfileCompleteness($user)
    {
        $fields = ['firs_name', 'last_name', 'email', 'number_phone', 'password', 'role_id', 'image', 'compagny_name', 'compagny_description', 'compagny_logo'];
        $completedFields = 0;

        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }

        return round(($completedFields / count($fields)) * 100);
    }

    /**
     * Générer les notifications récentes basées sur les candidatures
     */
    private function getRecentNotifications($applications)
    {
        $notifications = [];

        // Notifications basées sur les changements de statut récents
        foreach ($applications->take(3) as $application) {
            switch ($application->status) {
                case 'accepted':
                    $notifications[] = [
                        'message' => "Candidature acceptée pour \"{$application->offer->title}\"",
                        'time' => $application->updated_at->diffForHumans(),
                        'color' => 'green',
                        'icon' => 'check-circle'
                    ];
                    break;
                case 'rejected':
                    $notifications[] = [
                        'message' => "Réponse reçue pour \"{$application->offer->title}\"",
                        'time' => $application->updated_at->diffForHumans(),
                        'color' => 'red',
                        'icon' => 'x-circle'
                    ];
                    break;
                case 'pending':
                    $notifications[] = [
                        'message' => "Candidature envoyée pour \"{$application->offer->title}\"",
                        'time' => $application->created_at->diffForHumans(),
                        'color' => 'blue',
                        'icon' => 'clock'
                    ];
                    break;
            }
        }

        // Ajouter d'autres types de notifications
        if (empty($notifications)) {
            $notifications[] = [
                'message' => 'Bienvenue sur votre tableau de bord !',
                'time' => 'Maintenant',
                'color' => 'blue',
                'icon' => 'sparkles'
            ];
        }

        return array_slice($notifications, 0, 5);
    }

    /**
     * Obtenir les offres recommandées
     */
    private function getRecommendedOffers($user)
    {
        // Récupérer les offres actives non postulées par l'utilisateur
        $appliedOfferIds = Apply::where('user_id', $user->id)->pluck('offer_id');

        return Offer::where('status', 'active')
            ->where('end_date', '>=', Carbon::now())
            ->whereNotIn('id', $appliedOfferIds)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }

    /**
     * Obtenir l'activité récente
     */
    private function getRecentActivity($applications)
    {
        $activities = [];

        foreach ($applications->take(10) as $application) {
            $activities[] = [
                'type' => 'application',
                'message' => "Candidature pour {$application->offer->title}",
                'status' => $application->status,
                'date' => $application->created_at,
                'offer_title' => $application->offer->title
            ];
        }

        return collect($activities)->sortByDesc('date')->take(5);
    }

    /**
     * Statistiques par type d'emploi
     */
    private function getApplicationsByType($applications)
    {
        return $applications->groupBy('offer.type')
            ->map(function ($group, $type) {
                return [
                    'type' => $type ?: 'Non spécifié',
                    'count' => $group->count(),
                    'accepted' => $group->where('status', 'accepted')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                    'rejected' => $group->where('status', 'rejected')->count(),
                ];
            });
    }

    /**
     * Progression mensuelle des 6 derniers mois
     */
    private function getMonthlyProgress($user)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $applications = Apply::where('user_id', $user->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->get();

            $months[] = [
                'month' => $date->format('M'),
                'year' => $date->year,
                'total' => $applications->count(),
                'accepted' => $applications->where('status', 'accepted')->count(),
                'pending' => $applications->where('status', 'pending')->count(),
                'rejected' => $applications->where('status', 'rejected')->count(),
            ];
        }

        return collect($months);
    }

    /**
     * Récupérer les statistiques détaillées
     */
    public function stats()
    {
        $user = Auth::user();

        // Statistiques par mois pour les graphiques
        $monthlyStats = Apply::where('user_id', $user->id)
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count, status')
            ->whereYear('created_at', '>=', Carbon::now()->subYear()->year)
            ->groupBy('month', 'year', 'status')
            ->get()
            ->groupBy(['year', 'month']);

        // Statistiques par type d'offre
        $typeStats = Apply::where('user_id', $user->id)
            ->join('offers', 'apply.offer_id', '=', 'offers.id')
            ->selectRaw('offers.type, COUNT(*) as count, apply.status')
            ->groupBy('offers.type', 'apply.status')
            ->get()
            ->groupBy('type');

        return view('dashboard.stats', compact('monthlyStats', 'typeStats'));
    }

    /**
     * API pour récupérer les données de graphiques
     */
    public function chartData()
    {
        $user = Auth::user();

        $monthlyData = $this->getMonthlyProgress($user);
        $typeData = $this->getApplicationsByType(
            Apply::where('user_id', $user->id)->with('offer')->get()
        );

        return response()->json([
            'monthly' => $monthlyData,
            'types' => $typeData
        ]);
    }
}

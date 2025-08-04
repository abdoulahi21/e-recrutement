<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RhDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer toutes les offres de l'utilisateur RH
        $userOffers = Offer::where('user_id', $user->id)
            ->with(['apply.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Récupérer toutes les candidatures pour les offres de cet utilisateur
        $allApplications = Apply::whereIn('offer_id', $userOffers->pluck('id'))
            ->with(['user', 'offer'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques générales
        $totalOffers = $userOffers->where('status', 'active')->count();
        $totalApplications = $allApplications->count();
        $pendingApplications = $allApplications->where('status', 'pending')->count();
        $acceptedApplications = $allApplications->where('status', 'accepted')->count();
        $rejectedApplications = $allApplications->where('status', 'rejected')->count();

        // Offres de ce mois
        $thisMonthOffers = $userOffers->where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Candidatures de cette semaine
        $thisWeekApplications = $allApplications->where('created_at', '>=', Carbon::now()->startOfWeek())->count();

        // Taux d'acceptation
        $acceptanceRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100)
            : 0;

        // Calcul du changement du taux d'acceptation par rapport au mois dernier
        $lastMonthApplications = Apply::whereIn('offer_id', $userOffers->pluck('id'))
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->get();

        $lastMonthAccepted = $lastMonthApplications->where('status', 'accepted')->count();
        $lastMonthTotal = $lastMonthApplications->count();
        $lastMonthAcceptanceRate = $lastMonthTotal > 0
            ? round(($lastMonthAccepted / $lastMonthTotal) * 100)
            : 0;

        $acceptanceRateChange = $acceptanceRate - $lastMonthAcceptanceRate;

        $recentOffers = Offer::where('user_id', auth()->id())
            ->latest()
            ->withCount('apply')
            ->take(5)
            ->get();

        // Candidatures récentes (5 dernières)
        $recentApplications = $allApplications->take(5);

        // Progression mensuelle des 6 derniers mois
        $monthlyProgress = $this->getMonthlyProgress($user);

        // Notifications récentes
        $recentNotifications = $this->getRecentNotifications($allApplications);

        // Activité récente
        $recentActivity = $this->getRecentActivity($allApplications);

        // Statistiques par type d'offre
        $offersByType = $this->getOffersByType($userOffers);

        $months = $monthlyProgress ? $monthlyProgress->pluck('month') : collect(['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun']);
        $totals = $monthlyProgress ? $monthlyProgress->pluck('total') : collect([12, 19, 15, 25, 22, 30]);

        return view('rh.dashboard', compact(
            'months',
            'totals',
            'totalOffers',
            'thisMonthOffers',
            'totalApplications',
            'thisWeekApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications',
            'acceptanceRate',
            'acceptanceRateChange',
            'recentOffers',
            'recentApplications',
            'monthlyProgress',
            'recentNotifications',
            'recentActivity',
            'offersByType'
        ));
    }

    /**
     * Progression mensuelle des candidatures des 6 derniers mois
     */
    private function getMonthlyProgress($user)
    {
        $months = [];
        $userOfferIds = Offer::where('user_id', $user->id)->pluck('id');

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $applications = Apply::whereIn('offer_id', $userOfferIds)
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
     * Générer les notifications récentes basées sur les candidatures
     */
    private function getRecentNotifications($applications)
    {
        $notifications = [];

        // Notifications basées sur les candidatures récentes
        foreach ($applications->take(3) as $application) {
            switch ($application->status) {
                case 'pending':
                    $notifications[] = [
                        'message' => "Nouvelle candidature de {$application->user->name} pour \"{$application->offer->title}\"",
                        'time' => $application->created_at->diffForHumans(),
                        'color' => 'blue',
                        'icon' => 'user-plus'
                    ];
                    break;
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
                        'message' => "Candidature traitée pour \"{$application->offer->title}\"",
                        'time' => $application->updated_at->diffForHumans(),
                        'color' => 'gray',
                        'icon' => 'x-circle'
                    ];
                    break;
            }
        }

        // Ajouter d'autres types de notifications
        if (empty($notifications)) {
            $notifications[] = [
                'message' => 'Bienvenue sur votre espace RH !',
                'time' => 'Maintenant',
                'color' => 'blue',
                'icon' => 'sparkles'
            ];
        }

        return array_slice($notifications, 0, 5);
    }

    /**
     * Obtenir l'activité récente
     */
    private function getRecentActivity($applications)
    {
        $activities = [];

        foreach ($applications->take(10) as $application) {
            $activities[] = [
                'type' => 'application_received',
                'message' => "Candidature reçue de {$application->user->name} pour {$application->offer->title}",
                'status' => $application->status,
                'date' => $application->created_at,
                'user_name' => $application->user->name,
                'offer_title' => $application->offer->title
            ];
        }

        return collect($activities)->sortByDesc('date')->take(5);
    }

    /**
     * Statistiques par type d'offre
     */
    private function getOffersByType($offers)
    {
        return $offers->groupBy('type')
            ->map(function ($group, $type) {
                $applications = $group->pluck('apply')->flatten();

                return [
                    'type' => $type ?: 'Non spécifié',
                    'offers_count' => $group->count(),
                    'applications_count' => $applications->count(),
                    'accepted' => $applications->where('status', 'accepted')->count(),
                    'pending' => $applications->where('status', 'pending')->count(),
                    'rejected' => $applications->where('status', 'rejected')->count(),
                ];
            });
    }

    /**
     * Récupérer les statistiques détaillées
     */
    public function stats()
    {
        $user = Auth::user();
        $userOfferIds = Offer::where('user_id', $user->id)->pluck('id');

        // Statistiques par mois pour les graphiques
        $monthlyStats = Apply::whereIn('offer_id', $userOfferIds)
            ->selectRaw("strftime('%m', created_at) as month, strftime('%Y', created_at) as year, COUNT(*) as count, status")
            ->whereRaw("strftime('%Y', created_at) >= ?", [Carbon::now()->subYear()->year])
            ->groupBy('month', 'year', 'status')
            ->get()
            ->groupBy(['year', 'month']);

        // Statistiques par type d'offre
        $typeStats = Apply::whereIn('offer_id', $userOfferIds)
            ->join('offers', 'apply.offer_id', '=', 'offers.id')
            ->selectRaw('offers.type, COUNT(*) as count, apply.status')
            ->groupBy('offers.type', 'apply.status')
            ->get()
            ->groupBy('type');

        return view('rh.stats', compact('monthlyStats', 'typeStats'));
    }

    /**
     * API pour récupérer les données de graphiques
     */
    public function chartData()
    {
        $user = Auth::user();

        $monthlyData = $this->getMonthlyProgress($user);
        $typeData = $this->getOffersByType(
            Offer::where('user_id', $user->id)->with('apply')->get()
        );

        return response()->json([
            'monthly' => $monthlyData,
            'types' => $typeData
        ]);
    }

    /**
     * Marquer les notifications comme lues
     */
    public function markNotificationsAsRead()
    {
        // Logique pour marquer les notifications comme lues
        // Cela dépendra de votre système de notifications

        return response()->json(['success' => true]);
    }

    /**
     * Obtenir le résumé des performances
     */
    public function getPerformanceSummary()
    {
        $user = Auth::user();
        $userOffers = Offer::where('user_id', $user->id)->get();
        $allApplications = Apply::whereIn('offer_id', $userOffers->pluck('id'))->get();

        // Calculs des métriques de performance
        $totalViews = $userOffers->sum('views') ?? 0; // Si vous trackez les vues
        $averageApplicationsPerOffer = $userOffers->count() > 0
            ? round($allApplications->count() / $userOffers->count(), 1)
            : 0;

        $responseTime = $this->calculateAverageResponseTime($allApplications);

        return [
            'total_views' => $totalViews,
            'average_applications' => $averageApplicationsPerOffer,
            'response_time' => $responseTime,
            'active_offers' => $userOffers->where('status', 'active')->count()
        ];
    }

    /**
     * Calculer le temps de réponse moyen
     */
    private function calculateAverageResponseTime($applications)
    {
        $processedApplications = $applications->whereIn('status', ['accepted', 'rejected']);

        if ($processedApplications->isEmpty()) {
            return 0;
        }

        $totalHours = 0;
        $count = 0;

        foreach ($processedApplications as $application) {
            if ($application->updated_at && $application->created_at) {
                $hours = $application->created_at->diffInHours($application->updated_at);
                $totalHours += $hours;
                $count++;
            }
        }

        return $count > 0 ? round($totalHours / $count, 1) : 0;
    }
}

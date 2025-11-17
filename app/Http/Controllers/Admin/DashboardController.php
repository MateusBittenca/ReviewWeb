<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::where('is_active', true)->count(),
            'total_reviews' => Review::count(),
            'total_positive' => Review::positive()->count(),
            'total_negative' => Review::negative()->count(),
            'average_rating' => round(Review::avg('rating'), 2),
        ];

        // Últimas avaliações
        $recent_reviews = Review::with('company')
            ->latest()
            ->limit(10)
            ->get();

        // Avaliações negativas não lidas (últimas 24h)
        $negative_alerts = Review::with('company')
            ->negative()
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get();

        // Gráfico de avaliações por dia (últimos 7 dias)
        $reviews_chart = Review::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN is_positive = 1 THEN 1 ELSE 0 END) as positive'),
                DB::raw('SUM(CASE WHEN is_positive = 0 THEN 1 ELSE 0 END) as negative')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top empresas por avaliações
        $top_companies = Company::withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_reviews',
            'negative_alerts',
            'reviews_chart',
            'top_companies'
        ));
    }
}






<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReviewsExport;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        
        $query = Review::with(['company', 'reviewPage']);

        // Filtros
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('type')) {
            if ($request->type === 'positive') {
                $query->positive();
            } elseif ($request->type === 'negative') {
                $query->negative();
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reviews = $query->recent()->paginate(20);

        return view('admin.reviews.index', compact('reviews', 'companies'));
    }

    public function negatives()
    {
        $reviews = Review::with(['company', 'reviewPage'])
            ->negative()
            ->recent()
            ->paginate(20);

        return view('admin.reviews.negatives', compact('reviews'));
    }

    public function export(Request $request, Company $company)
    {
        $filters = $request->only(['rating', 'type', 'date_from', 'date_to']);
        
        return Excel::download(
            new ReviewsExport($company, $filters),
            "avaliacoes_{$company->slug}_" . now()->format('Y-m-d') . ".xlsx"
        );
    }

    public function exportCsv(Request $request, Company $company)
    {
        $filters = $request->only(['rating', 'type', 'date_from', 'date_to']);
        $data = $this->reviewService->exportReviews($company, $filters);

        $filename = "avaliacoes_{$company->slug}_" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalhos
            fputcsv($file, array_keys($data[0] ?? []), ';');
            
            // Dados
            foreach ($data as $row) {
                fputcsv($file, $row, ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}






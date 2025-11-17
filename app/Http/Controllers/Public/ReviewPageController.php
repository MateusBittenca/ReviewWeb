<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ReviewPage;
use App\Services\ReviewService;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\StoreFeedbackRequest;
use Illuminate\Http\Request;

class ReviewPageController extends Controller
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    public function show(string $token)
    {
        $reviewPage = ReviewPage::with('company')
            ->where('public_token', $token)
            ->firstOrFail();

        // Verificar se empresa está ativa
        if (!$reviewPage->company->is_active) {
            abort(404);
        }

        // Incrementar contador de visualizações
        $reviewPage->incrementViews();

        return view('public.review-page', compact('reviewPage'));
    }

    public function store(StoreReviewRequest $request, string $token)
    {
        $reviewPage = ReviewPage::where('public_token', $token)->firstOrFail();
        
        $review = $this->reviewService->createReview(
            $reviewPage,
            $request->validated()
        );

        // Se for positiva, redirecionar para Google
        if ($review->is_positive) {
            return response()->json([
                'success' => true,
                'redirect_to_google' => true,
                'google_url' => $review->company->google_review_url,
            ]);
        }

        // Se for negativa, retornar sucesso para mostrar formulário de feedback
        return response()->json([
            'success' => true,
            'redirect_to_google' => false,
            'review_id' => $review->id,
        ]);
    }

    public function storeFeedback(StoreFeedbackRequest $request, string $token)
    {
        $review = \App\Models\Review::findOrFail($request->review_id);
        
        $this->reviewService->addFeedback($review, $request->feedback);

        return response()->json([
            'success' => true,
            'message' => 'Obrigado pelo seu feedback! Entraremos em contato em breve.',
        ]);
    }
}






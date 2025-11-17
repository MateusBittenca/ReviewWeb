<?php

namespace App\Services;

use App\Models\Review;
use App\Models\ReviewPage;
use App\Models\Company;
use Illuminate\Support\Facades\Request;

class ReviewService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function createReview(ReviewPage $reviewPage, array $data): Review
    {
        $company = $reviewPage->company;
        
        // Determinar se é positiva ou negativa
        $isPositive = $data['rating'] >= $company->positive_threshold;
        
        // Criar avaliação
        $review = Review::create([
            'company_id' => $company->id,
            'review_page_id' => $reviewPage->id,
            'rating' => $data['rating'],
            'whatsapp' => $this->formatWhatsapp($data['whatsapp']),
            'comment' => $data['comment'] ?? null,
            'is_positive' => $isPositive,
            'redirected_to_google' => $isPositive, // Marca como redirecionado se positivo
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);

        // Enviar notificação
        $this->notificationService->notifyNewReview($review);

        return $review;
    }

    public function addFeedback(Review $review, string $feedback): Review
    {
        $review->update(['feedback' => $feedback]);

        // Enviar notificação de feedback negativo
        $this->notificationService->notifyNegativeFeedback($review);

        return $review;
    }

    public function getReviewsByCompany(Company $company, array $filters = [])
    {
        $query = $company->reviews()->with('reviewPage');

        // Filtro por rating
        if (isset($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        // Filtro por tipo (positivo/negativo)
        if (isset($filters['type'])) {
            if ($filters['type'] === 'positive') {
                $query->positive();
            } elseif ($filters['type'] === 'negative') {
                $query->negative();
            }
        }

        // Filtro por período
        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->recent()->paginate($filters['per_page'] ?? 20);
    }

    public function exportReviews(Company $company, array $filters = []): array
    {
        $reviews = $this->getReviewsByCompany($company, array_merge($filters, ['per_page' => 10000]))
            ->items();

        $data = [];
        foreach ($reviews as $review) {
            $data[] = [
                'Data' => $review->created_at->format('d/m/Y H:i'),
                'Nota' => $review->rating,
                'WhatsApp' => $review->whatsapp,
                'Comentário' => $review->comment,
                'Feedback' => $review->feedback,
                'Tipo' => $review->is_positive ? 'Positiva' : 'Negativa',
            ];
        }

        return $data;
    }

    private function formatWhatsapp(string $whatsapp): string
    {
        // Remove todos os caracteres não numéricos
        $cleaned = preg_replace('/[^0-9]/', '', $whatsapp);
        
        // Adiciona +55 se não tiver código do país
        if (strlen($cleaned) === 11 && !str_starts_with($cleaned, '55')) {
            $cleaned = '55' . $cleaned;
        }

        return $cleaned;
    }
}






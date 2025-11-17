<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReviewsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        protected Company $company,
        protected array $filters = []
    ) {}

    public function collection()
    {
        $query = $this->company->reviews();

        if (isset($this->filters['rating'])) {
            $query->where('rating', $this->filters['rating']);
        }

        if (isset($this->filters['type'])) {
            if ($this->filters['type'] === 'positive') {
                $query->positive();
            } elseif ($this->filters['type'] === 'negative') {
                $query->negative();
            }
        }

        if (isset($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Data/Hora',
            'Nota',
            'WhatsApp',
            'Comentário',
            'Feedback',
            'Tipo',
            'Redirecionado',
        ];
    }

    public function map($review): array
    {
        return [
            $review->created_at->format('d/m/Y H:i:s'),
            $review->rating,
            $review->whatsapp,
            $review->comment ?? '-',
            $review->feedback ?? '-',
            $review->is_positive ? 'Positiva' : 'Negativa',
            $review->redirected_to_google ? 'Sim' : 'Não',
        ];
    }
}






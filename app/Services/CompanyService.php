<?php

namespace App\Services;

use App\Models\Company;
use App\Models\ReviewPage;
use Illuminate\Http\UploadedFile;

class CompanyService
{
    public function __construct(
        private FileUploadService $fileUploadService
    ) {}

    public function create(array $data): Company
    {
        // Upload de arquivos se fornecidos
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo_path'] = $this->fileUploadService->uploadLogo($data['logo']);
            unset($data['logo']);
        }

        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            $data['background_image_path'] = $this->fileUploadService->uploadBackground($data['background_image']);
            unset($data['background_image']);
        }

        // Criar empresa
        $company = Company::create($data);

        // Criar página de avaliação automaticamente
        ReviewPage::create([
            'company_id' => $company->id,
        ]);

        return $company->load('reviewPage');
    }

    public function update(Company $company, array $data): Company
    {
        // Upload de nova logo se fornecida
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            // Deletar logo antiga
            if ($company->logo_path) {
                $this->fileUploadService->delete($company->logo_path);
            }
            $data['logo_path'] = $this->fileUploadService->uploadLogo($data['logo']);
            unset($data['logo']);
        }

        // Upload de nova imagem de fundo se fornecida
        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            // Deletar imagem antiga
            if ($company->background_image_path) {
                $this->fileUploadService->delete($company->background_image_path);
            }
            $data['background_image_path'] = $this->fileUploadService->uploadBackground($data['background_image']);
            unset($data['background_image']);
        }

        $company->update($data);

        return $company->fresh();
    }

    public function delete(Company $company): bool
    {
        // Deletar arquivos
        if ($company->logo_path) {
            $this->fileUploadService->delete($company->logo_path);
        }
        if ($company->background_image_path) {
            $this->fileUploadService->delete($company->background_image_path);
        }

        return $company->delete();
    }

    public function getStatistics(Company $company): array
    {
        return [
            'total_reviews' => $company->reviews()->count(),
            'positive_reviews' => $company->positiveReviews()->count(),
            'negative_reviews' => $company->negativeReviews()->count(),
            'average_rating' => $company->average_rating,
            'total_views' => $company->reviewPage->views_count ?? 0,
            'conversion_rate' => $this->calculateConversionRate($company),
        ];
    }

    private function calculateConversionRate(Company $company): float
    {
        $views = $company->reviewPage->views_count ?? 0;
        $reviews = $company->reviews()->count();

        if ($views === 0) {
            return 0;
        }

        return round(($reviews / $views) * 100, 2);
    }
}






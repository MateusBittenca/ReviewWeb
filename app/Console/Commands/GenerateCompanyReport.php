<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Mail;

class GenerateCompanyReport extends Command
{
    protected $signature = 'reviews:company-report {company_id} {--email=}';
    protected $description = 'Gera relatório de avaliações de uma empresa';

    public function __construct(
        private ReviewService $reviewService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $companyId = $this->argument('company_id');
        $company = Company::find($companyId);

        if (!$company) {
            $this->error('❌ Empresa não encontrada!');
            return self::FAILURE;
        }

        $this->info("📊 Gerando relatório para: {$company->name}");

        $stats = [
            'total' => $company->reviews()->count(),
            'positivas' => $company->positiveReviews()->count(),
            'negativas' => $company->negativeReviews()->count(),
            'media' => $company->average_rating,
        ];

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total de Avaliações', $stats['total']],
                ['Avaliações Positivas', $stats['positivas']],
                ['Avaliações Negativas', $stats['negativas']],
                ['Média de Avaliação', $stats['media']],
            ]
        );

        // Exportar para CSV se solicitado
        if ($this->option('email')) {
            $data = $this->reviewService->exportReviews($company);
            
            $filename = "relatorio_{$company->slug}_" . now()->format('Y-m-d') . ".csv";
            $path = storage_path("app/{$filename}");
            
            $file = fopen($path, 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, array_keys($data[0] ?? []), ';');
            foreach ($data as $row) {
                fputcsv($file, $row, ';');
            }
            fclose($file);

            // Enviar por e-mail
            Mail::raw(
                "Segue em anexo o relatório de avaliações da empresa {$company->name}.",
                function ($message) use ($path, $filename) {
                    $message->to($this->option('email'))
                        ->subject('Relatório de Avaliações')
                        ->attach($path, ['as' => $filename]);
                }
            );

            unlink($path);
            $this->info("✅ Relatório enviado para: {$this->option('email')}");
        }

        return self::SUCCESS;
    }
}






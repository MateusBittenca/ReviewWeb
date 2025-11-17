<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Review;
use App\Mail\ContactsExport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendContactsExport extends Command
{
    protected $signature = 'reviews:send-contacts-export 
                            {--period=weekly : Period for export (daily, weekly, monthly)}
                            {--company= : Specific company ID to export}
                            {--test= : Test email address}';

    protected $description = 'Envia relatório automático de contatos coletados por e-mail';

    public function handle()
    {
        $period = $this->option('period');
        $companyId = $this->option('company');
        $testEmail = $this->option('test');

        $this->info("📊 Iniciando exportação automática de contatos ({$period})...");

        $dateRange = $this->getDateRange($period);

        $companies = $companyId 
            ? Company::where('id', $companyId)->where('status', 'published')->get()
            : Company::where('status', 'published')->get();

        if ($companies->isEmpty()) {
            $this->warn('⚠️  Nenhuma empresa publicada encontrada.');
            return Command::FAILURE;
        }

        $this->info("📧 Processando {$companies->count()} empresa(s)...");

        $bar = $this->output->createProgressBar($companies->count());
        $bar->start();

        $successCount = 0;
        $failCount = 0;

        foreach ($companies as $company) {
            try {
                $reviews = Review::where('company_id', $company->id)
                    ->whereBetween('created_at', $dateRange)
                    ->orderBy('created_at', 'desc')
                    ->get();

                if ($reviews->isEmpty()) {
                    $this->newLine();
                    $this->line("  ℹ️  {$company->name}: Nenhum contato no período.");
                    $bar->advance();
                    continue;
                }

                $contacts = $reviews->map(function ($review) {
                    return [
                        'Data' => $review->created_at->format('d/m/Y H:i'),
                        'Nota' => $review->rating,
                        'WhatsApp' => $review->whatsapp,
                        'Comentário' => $review->comment ?? '',
                        'Feedback' => $review->feedback ?? '',
                        'Tipo' => $review->is_positive ? 'Positiva' : 'Negativa',
                    ];
                })->toArray();

                $recipientEmail = $testEmail ?: $company->negative_email;

                if (!$recipientEmail) {
                    $this->newLine();
                    $this->warn("  ⚠️  {$company->name}: E-mail de contato não configurado.");
                    $bar->advance();
                    $failCount++;
                    continue;
                }

                Mail::to($recipientEmail)->send(
                    new ContactsExport($company, $contacts, $period)
                );

                $this->newLine();
                $this->line("  ✅ {$company->name}: {$reviews->count()} contato(s) enviado(s) para {$recipientEmail}");
                
                $successCount++;
                
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("  ❌ {$company->name}: Erro - {$e->getMessage()}");
                $failCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("📊 Resumo da Exportação:");
        $this->line("  ✅ Sucesso: {$successCount}");
        $this->line("  ❌ Falhas: {$failCount}");
        $this->line("  📅 Período: {$dateRange[0]->format('d/m/Y')} até {$dateRange[1]->format('d/m/Y')}");

        return Command::SUCCESS;
    }

    private function getDateRange(string $period): array
    {
        $endDate = Carbon::now()->endOfDay();
        
        switch ($period) {
            case 'daily':
            case 'day':
                $startDate = Carbon::now()->startOfDay();
                break;
            
            case 'weekly':
            case 'week':
                $startDate = Carbon::now()->subWeek()->startOfDay();
                break;
            
            case 'monthly':
            case 'month':
                $startDate = Carbon::now()->subMonth()->startOfDay();
                break;
            
            default:
                $startDate = Carbon::now()->subWeek()->startOfDay();
        }

        return [$startDate, $endDate];
    }
}



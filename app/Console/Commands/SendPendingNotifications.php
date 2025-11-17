<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review;
use App\Services\NotificationService;

class SendPendingNotifications extends Command
{
    protected $signature = 'reviews:send-notifications';
    protected $description = 'Envia notificações de avaliações que ainda não foram notificadas';

    public function __construct(
        private NotificationService $notificationService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $pendingReviews = Review::whereNull('notified_at')
            ->with('company')
            ->get();

        if ($pendingReviews->isEmpty()) {
            $this->info('✅ Não há notificações pendentes.');
            return self::SUCCESS;
        }

        $this->info("📧 Enviando {$pendingReviews->count()} notificações...");

        $bar = $this->output->createProgressBar($pendingReviews->count());
        $bar->start();

        foreach ($pendingReviews as $review) {
            try {
                if ($review->feedback) {
                    $this->notificationService->notifyNegativeFeedback($review);
                } else {
                    $this->notificationService->notifyNewReview($review);
                }
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("\n❌ Erro ao enviar notificação para review #{$review->id}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Notificações enviadas com sucesso!');

        return self::SUCCESS;
    }
}






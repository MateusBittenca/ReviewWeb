<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review;
use Carbon\Carbon;

class CleanOldReviews extends Command
{
    protected $signature = 'reviews:clean {--days=365 : Dias para manter}';
    protected $description = 'Remove avaliações antigas (mais de X dias)';

    public function handle(): int
    {
        $days = $this->option('days');
        $date = Carbon::now()->subDays($days);

        if (!$this->confirm("Deseja realmente excluir avaliações anteriores a {$date->format('d/m/Y')}?")) {
            $this->info('Operação cancelada.');
            return self::SUCCESS;
        }

        $count = Review::where('created_at', '<', $date)->count();
        
        if ($count === 0) {
            $this->info('✅ Não há avaliações antigas para excluir.');
            return self::SUCCESS;
        }

        $this->info("🗑️  Excluindo {$count} avaliações antigas...");
        
        Review::where('created_at', '<', $date)->delete();
        
        $this->info('✅ Avaliações antigas removidas com sucesso!');

        return self::SUCCESS;
    }
}






<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Forçar HTTPS em produção (Railway)
        // Importante para emails e URLs geradas fora de requisições HTTP
        if (config('app.env') === 'production' || 
            (app()->runningInConsole() === false && request()->secure())) {
            URL::forceScheme('https');
        }
        
        // Garantir que APP_URL use HTTPS em produção
        if (config('app.env') === 'production') {
            $appUrl = config('app.url');
            if ($appUrl && !str_starts_with($appUrl, 'https://')) {
                // Substituir http:// por https:// se não for localhost
                if (str_starts_with($appUrl, 'http://') && !str_contains($appUrl, 'localhost')) {
                    config(['app.url' => str_replace('http://', 'https://', $appUrl)]);
                }
            }
        }
    }
}

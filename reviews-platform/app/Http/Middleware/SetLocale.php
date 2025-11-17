<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se há parâmetro de idioma na URL
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }
        
        // Obter locale da sessão ou usar padrão
        $locale = Session::get('locale', 'pt_BR');
        
        // Garantir que o locale é válido
        if (!in_array($locale, ['pt_BR', 'en_US'])) {
            $locale = 'pt_BR';
        }
        
        // Configurar o locale
        App::setLocale($locale);
        
        return $next($request);
    }
}


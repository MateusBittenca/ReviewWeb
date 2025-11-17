<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxAuthController;

/*
|--------------------------------------------------------------------------
| AJAX Routes
|--------------------------------------------------------------------------
|
| Rotas específicas para requisições AJAX com autenticação web normal
|
*/

// Essas rotas já incluem o middleware 'web'
Route::middleware('web')->group(function () {
    // Rotas usadas no painel principal
    Route::get('/api/companies', [AjaxAuthController::class, 'getCompanies']);
    Route::get('/api/reviews', [AjaxAuthController::class, 'getReviews']);
    Route::get('/api/reviews/negative', [AjaxAuthController::class, 'getNegativeReviews']);
    Route::get('/api/companies/{companyId}/contacts', [AjaxAuthController::class, 'exportContacts']);
    Route::get('/api/users/with-companies', [AjaxAuthController::class, 'getUsersWithCompanies']);
});

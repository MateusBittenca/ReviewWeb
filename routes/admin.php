<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ReviewController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Empresas
    Route::resource('companies', CompanyController::class);
    
    // Avaliações
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/negatives', [ReviewController::class, 'negatives'])->name('reviews.negatives');
    Route::get('/companies/{company}/reviews/export', [ReviewController::class, 'export'])->name('reviews.export');
    Route::get('/companies/{company}/reviews/export-csv', [ReviewController::class, 'exportCsv'])->name('reviews.export-csv');
});






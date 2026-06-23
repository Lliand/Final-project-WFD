<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CardSetController;
use App\Http\Controllers\Admin\GradingPackageController;

Route::get('/', function () {
    return view('welcome');
});

// Rute khusus Admin
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('card-sets', CardSetController::class);
    Route::resource('grading-packages', GradingPackageController::class);
    
});

require __DIR__.'/auth.php';
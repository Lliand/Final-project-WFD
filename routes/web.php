<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CardSetController;
use App\Http\Controllers\Admin\GradingPackageController;
use App\Http\Controllers\Customer\CollectionController;
use App\Http\Controllers\Customer\HallOfFameController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuditController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'Admin') {
        return redirect()->route('admin.card-sets.index');
    } 
    elseif (Auth::user()->role === 'Staff') {
        return redirect()->route('staff.dashboard');
    } 
    else {
        return redirect()->route('halloffame.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute khusus Admin
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('card-sets', CardSetController::class);
    Route::resource('grading-packages', GradingPackageController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('/admin/grading-audit', [AuditController::class, 'index'])->name('admin.grading_audit.index');
});

// Rute untuk Customer (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // Hall of Fame
    Route::get('/hall-of-fame', [HallOfFameController::class, 'index'])->name('halloffame.index');

    // My Collection
    Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
    Route::get('/collection/create', [CollectionController::class, 'create'])->name('collection.create');
    Route::post('/collection/insert', [CollectionController::class, 'store'])->name('collection.insert');
    Route::get('/collection/edit/{id}', [CollectionController::class, 'edit'])->name('collection.edit');
    Route::put('/collection/update/{id}', [CollectionController::class, 'update'])->name('collection.update');
    Route::delete('/collection/destroy/{id}', [CollectionController::class, 'destroy'])->name('collection.destroy');

});

Route::get('/grading/request', [App\Http\Controllers\Customer\GradingRequestController::class, 'create'])->name('grading.request.create');
Route::post('/grading/request', [App\Http\Controllers\Customer\GradingRequestController::class, 'store'])->name('grading.request.store');
Route::get('/grading/history', [App\Http\Controllers\Customer\GradingRequestController::class, 'index'])->name('grading.history');

// Staff
Route::middleware(['auth', 'role:Staff'])->prefix('staff')->name('staff.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', [App\Http\Controllers\Staff\StaffDashboardController::class, 'index'])->name('dashboard');
    Route::put('/request/{id}/pickup', [App\Http\Controllers\Staff\StaffDashboardController::class, 'pickup'])->name('request.pickup');
    Route::put('/request/{id}/lab-submit', [App\Http\Controllers\Staff\StaffDashboardController::class, 'submitLabGrading'])->name('request.lab-submit');
    Route::put('/request/{id}/dropoff', [App\Http\Controllers\Staff\StaffDashboardController::class, 'dropoff'])->name('request.dropoff');    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
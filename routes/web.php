<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/',
    [\App\Http\Controllers\OfferController::class, 'jobs']
)->name('jobs');

Route::get('/jobs/{offer}',
    [\App\Http\Controllers\OfferController::class, 'show']
)->name('jobs-detail');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/offers/{offer}/apply',
        [\App\Http\Controllers\OfferController::class, 'apply']
    )->name('offers.apply');

    Route::get('/apply',
        [\App\Http\Controllers\CandidatDashboardController::class, 'index']
    )->name('candidat.dashboard');
});

require __DIR__.'/auth.php';

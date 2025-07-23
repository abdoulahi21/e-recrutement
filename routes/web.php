<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recru\ApplyController;
use App\Http\Controllers\Recru\OfferController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',
    [\App\Http\Controllers\OfferController::class, 'jobs']
)->name('jobs');


Route::get('/jobs/{offer}',
    [\App\Http\Controllers\OfferController::class, 'show']
)->name('jobs-detail');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rh/dashboard', function () {
        return view('rh.dashboard');
    })->name('rh.dashboard');

    Route::get('/candidat/applications', function () {
        return view('candidat.applications');
    })->name('candidat.applications');
});


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
Route::resources([
    'rh' => OfferController::class,
    'offer' => ApplyController::class,
]);
Route::get('/dashboard',[OfferController::class,'home'])->name('rh.dashboard');

require __DIR__.'/auth.php';

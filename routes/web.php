<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recru\ApplyController;
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


Route::middleware(['auth', 'verified'])->group(function () {

    Route::group(['prefix' => 'rh'], function () {

        Route::get('/stats',
            [\App\Http\Controllers\RhDashboardController::class, 'stats']
        )->name('rh.stats');
        Route::get('/chart-data',
            [\App\Http\Controllers\RhDashboardController::class, 'chartData']
        )->name('rh.chart.data');
        Route::get('/offers',
            [\App\Http\Controllers\OfferController::class, 'jobs']
        )->name('rh.offers.index');
        Route::get('/offers/{offer}',
            [\App\Http\Controllers\OfferController::class, 'show']
        )->name('rh.offers.show');
        Route::get('/offer',
            [\App\Http\Controllers\OfferController::class, 'create']
        )->name('rh.offers.create');
        Route::post('/offers',
            [\App\Http\Controllers\OfferController::class, 'store']
        )->name('rh.offers.store');

        Route::get('/offer/{offer}/edit',
            [\App\Http\Controllers\OfferController::class, 'edit']
        )->name('rh.offers.edit');
        Route::put('/offers/{offer}',
            [\App\Http\Controllers\OfferController::class, 'update']
        )->name('rh.offers.update');
        Route::delete('/offers/{offer}',
            [\App\Http\Controllers\OfferController::class, 'destroy']
        )->name('rh.offers.destroy');
        Route::get('/offers/{offer}/applications',
            [\App\Http\Controllers\OfferController::class, 'applications']
        )->name('rh.offers.applications');
        Route::patch('/offers/{offer}/applications/{application}/status',
            [\App\Http\Controllers\OfferController::class, 'updateApplicationStatus']
        )->name('rh.applications.status');

        // apply
        Route::get('/applications',
            [ApplyController::class, 'index']
        )->name('rh.applications.index');
        Route::get('/applications/{apply}',
            [ApplyController::class, 'show']
        )->name('rh.applications.show');
        Route::patch('/applications/{apply}',
            [ApplyController::class, 'update']
        )->name('rh.applications.update');
        Route::patch('/applications/{apply}/status',
            [ApplyController::class, 'updateStatus']
        )->name('rh.applications.updateStatus');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/candidat/applications', function () {
        return view('candidat.applications');
    })->name('candidat.applications');

    Route::post('/offers/{offer}/apply',
        [\App\Http\Controllers\OfferController::class, 'apply']
    )->name('offers.apply');

    Route::get('/apply',
        [\App\Http\Controllers\CandidatDashboardController::class, 'index']
    )->name('candidat.dashboard');
    Route::get('/rh',
        [\App\Http\Controllers\RhDashboardController::class, 'index']
    )->name('rh.dashboard');

});
//Route::resources([
//    'rh' => OfferController::class,
//    'offer' => ApplyController::class,
//]);
//Route::get('/dashboard',[OfferController::class,'home'])->name('rh.dashboard');

require __DIR__.'/auth.php';

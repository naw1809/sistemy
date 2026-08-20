<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AuthController;

/*  
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which contains the "web" middleware group. Now create something great!           
|
*/

// RUTE PUBLIK (Bisa diakses tanpa login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// RUTE PROTECTED (Harus login terlebih dahulu)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $totalMinuta = \App\Models\Minuta::count();
        $totalBast = \App\Models\Bast::count();
        $totalStaff = \App\Models\User::count();
        
        $recentMinutas = \App\Models\Minuta::with(['user', 'bast'])
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('totalMinuta', 'totalBast', 'totalStaff', 'recentMinutas'));
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/bast/{id}/export', [App\Http\Controllers\BastController::class, 'export'])->name('bast.export');

    Route::resource('/minuta', App\Http\Controllers\MinutaController::class)->parameters([
        'minuta' => 'minuta'
    ]);
    Route::get('/bast/history', [App\Http\Controllers\BastController::class, 'history'])->name('bast.history');
    Route::resource('/bast', App\Http\Controllers\BastController::class)->parameters([
        'bast' => 'bast'
    ]);
});














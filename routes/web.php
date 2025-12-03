<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Candidate\Dashboard as CandidateDashboard;
use App\Livewire\Candidate\RegisterPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route candidature (accessible sans authentification)
Route::get('/candidature', RegisterPage::class)
    ->name('candidate.register');

// Routes candidat (authentification requise)
Route::middleware(['auth'])->group(function () {
    Route::get('/candidat/dashboard', CandidateDashboard::class)
        ->middleware('role:candidate')
        ->name('candidate.dashboard');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

// Routes admin (authentification + rôle admin requis)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)
        ->name('admin.dashboard');
});

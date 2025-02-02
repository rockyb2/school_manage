<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\EmptController;
use App\Http\Middleware\EnsureEnseignantIsAuthenticated;

Route::get('/', function () {
    return view('filament.index');
});

Route::get('/login', [EnseignantController::class, 'showLoginForm'])->name('login');
Route::post('/login', [EnseignantController::class, 'login']);
Route::get('/logout', [EnseignantController::class, 'logout'])->name('logout');

Route::get('/enseignant/auth/login',[EnseignantController::class, 'showLoginForm'])->name('enseignant.auth.login');
Route::get('/enseignant/dashboard', function () {
    $enseignant = session('enseignant');
    return view('enseignant.dashboard', compact('enseignant'));
})->name('dashboard');

Route::get('/enseignant/disponibilite', [DisponibiliteController::class, 'index'])->name('disponibilite.index');
Route::get('/enseignant/disponibilite/create', [DisponibiliteController::class, 'create'])->name('disponibilite.create');
Route::post('/enseignant/disponibilite', [DisponibiliteController::class, 'store'])->name('disponibilite.store');

Route::get('/enseignant/emplois_du_temps', function () {
    $enseignant = session('enseignant');
    return view('enseignant.emplois_du_temps', compact('enseignant'));
})->name('emplois_du_temps');
Route::get('tables.emplois-du-temps', [EmptController::class, 'index']);

<?php

use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\EmptController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantsController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('filament.index');
});

Route::get('/emplois_du_temps', [EmptController::class, 'index'])->name('emplois_du_temps.index');
Route::post('/emplois_du_temps/generate', [EmptController::class, 'generateSchedule'])->name('emplois_du_temps.generate');

Route::get('/login', [EnseignantController::class, 'showLoginForm'])->name('login');
Route::post('/login', [EnseignantController::class, 'login']);
Route::get('/enseignant/auth/login', [EnseignantController::class, 'showLoginForm'])->name('enseignant.auth.login');
Route::get('/enseignant/forgot-password', [EnseignantController::class, 'showForgotPasswordForm'])->name('enseignant.forgot_password');
Route::post('/enseignant/forgot-password', [EnseignantController::class, 'sendResetLink']);

Route::get('/etudiant/auth/login', [EtudiantsController::class, 'showLoginForm'])->name('etudiant.auth.login');
Route::post('/etudiant/auth/login', [EtudiantsController::class, 'login']);

Route::middleware(['auth', 'role:enseignant', 'sync.role.profile'])->group(function () {
    Route::get('/logout', [EnseignantController::class, 'logout'])->name('logout');
    Route::post('/logout', [EnseignantController::class, 'logout']);

    Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');

    Route::get('/enseignant/disponibilite', [DisponibiliteController::class, 'index'])->name('disponibilite.index');
    Route::get('/enseignant/disponibilite/create', [DisponibiliteController::class, 'create'])->name('disponibilite.create');
    Route::post('/enseignant/disponibilite', [DisponibiliteController::class, 'store'])->name('disponibilite.store');
    Route::resource('disponibilite', DisponibiliteController::class);

    Route::get('/enseignant/emploi-du-temps', [EnseignantController::class, 'downloadEmploiDuTemps'])->name('enseignant.emploi_du_temps_pdf');
    Route::get('/send-emplois-du-temps-notification', [EnseignantController::class, 'sendEmploisDuTempsNotification'])->name('send.emplois_du_temps_notification');
    Route::get('/enseignant.emplois_du_temps', [EnseignantController::class, 'showEmploisDuTemps'])->name('emplois_du_temps');
    Route::get('/generate-pdf', [PdfController::class, 'generatePdf'])->name('generate.pdf');

    Route::get('/enseignant/composition', function () {
        return view('enseignant.composition.index');
    })->name('composition.index');

    Route::get('/enseignant/notes', [NoteController::class, 'index'])->name('notes.index');
});

Route::middleware(['auth', 'role:etudiant', 'sync.role.profile'])->group(function () {
    Route::get('/etudiant/logout', [EtudiantsController::class, 'logout'])->name('etudiant.logout');

    Route::get('/etudiant/dashboard', [EtudiantsController::class, 'getMoyenne'])->name('etudiant.dashboard');
    Route::get('/etudiant/emplois_du_temps', [EtudiantsController::class, 'emploisDuTemps'])->name('etudiant.emplois_du_temps');
    Route::get('/etudiant/notes', [EtudiantsController::class, 'notes'])->name('etudiant.notes');
    Route::get('/etudiant/emplois-du-temps/pdf', [EtudiantsController::class, 'downloadEmploisDuTemps'])->name('etudiant.emplois_du_temps_pdf');
});

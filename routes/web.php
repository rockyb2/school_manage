<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\DisponibiliteController;
use App\Http\Controllers\EmptController;
use App\Http\Middleware\EnsureEnseignantIsAuthenticated;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CompositionController;
use App\Models\Classe;
use App\Models\Matieres;
use App\Livewire\CompositionCrud;

Route::get('/', function () {
    return view('filament.index');
});

Route::get('/emplois_du_temps', [EmptController::class, 'index'])->name('emplois_du_temps.index');
Route::post('/emplois_du_temps/generate', [EmptController::class, 'generateSchedule'])->name('emplois_du_temps.generate');

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
Route::resource('disponibilite', DisponibiliteController::class);

Route::get('/enseignant/emploi-du-temps', [EnseignantController::class, 'downloadEmploiDuTemps'])->name('enseignant.emploi_du_temps_pdf');
Route::get('/send-emplois-du-temps-notification', [EnseignantController::class, 'sendEmploisDuTempsNotification'])->name('send.emplois_du_temps_notification');
Route::get('/enseignant.emplois_du_temps', [EnseignantController::class, 'showEmploisDuTemps'])->name('emplois_du_temps');
Route::get('/generate-pdf', [PdfController::class, 'generatePdf'])->name('generate.pdf');

//ROUTE POUR LES COMPOSITIONS
// Route::get('/enseignant/composition', [CompositionController::class, 'index'])->name('composition.index');
// Route::get('/enseignant/composition/create', function () {
//     $enseignant = session('enseignant');
//     $classes = Classe::all();
//     $matieres = Matieres::all();
//     return view('enseignant.composition.create', compact('enseignant', 'classes', 'matieres'));
// })->name('composition.create');
// Route::post('/enseignant/composition', [CompositionController::class, 'store'])->name('composition.store');
// Route::resource('composition', CompositionController::class);
Route::get('/enseignant/composition', function () {
    return view('enseignant.composition.index');
})->name('composition.index');

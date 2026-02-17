<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use App\Notifications\EmptNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'enseignant') {
            return redirect()->route('dashboard');
        }

        return view('enseignant.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('role', 'enseignant')->first();
        if (!$user) {
            return back()->withInput()->withErrors([
                'email' => 'L\'email ou le mot de passe ne correspond pas',
            ]);
        }

        $isValidPassword = Hash::check($request->mot_de_passe, $user->password);

        if (!$isValidPassword) {
            // Compatibility for legacy plaintext password stored in enseignants.mot_de_passe.
            $enseignantLegacy = Enseignant::where('email', $request->email)->first();
            if ($enseignantLegacy && !empty($enseignantLegacy->mot_de_passe) && $enseignantLegacy->mot_de_passe === $request->mot_de_passe) {
                $user->password = Hash::make($request->mot_de_passe);
                $user->save();
                $isValidPassword = true;
            }
        }

        if (!$isValidPassword) {
            return back()->withInput()->withErrors([
                'email' => 'L\'email ou le mot de passe ne correspond pas',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $enseignant = $user->enseignant;
        if (!$enseignant) {
            Auth::logout();
            return back()->withInput()->withErrors([
                'email' => 'Profil enseignant introuvable pour ce compte.',
            ]);
        }

        $request->session()->put('enseignant', $enseignant);

        return redirect()->route('dashboard');
    }

    public function showForgotPasswordForm()
    {
        return view('enseignant.auth.login')->with('success', 'Contactez l\'administration pour reinitialiser votre mot de passe.');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        return back()->with('success', 'Si le compte existe, la demande a ete prise en charge par l\'administration.');
    }

    public function dashboard()
    {
        $enseignant = $this->getCurrentEnseignant();
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $totalCours = DB::table('cours')
            ->where('enseignant_id', $enseignant->id)
            ->count();

        return view('enseignant.dashboard', compact('enseignant', 'totalCours'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('enseignant');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Deconnexion reussie.');
    }

    public function sendEmploisDuTempsNotification()
    {
        $enseignants = Enseignant::all();

        foreach ($enseignants as $enseignant) {
            $enseignant->notify(new EmptNotification());
        }

        return back()->with('success', 'Notifications envoyees avec succes.');
    }

    public function downloadEmploiDuTemps()
    {
        $enseignant = $this->getCurrentEnseignant();
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $emploisDuTemps = $this->getEmploisDuTemps($enseignant->id);
        $anneeSemestre = [
            'annee_academique' => '2023-2024',
            'semestre_nom' => 'Semestre 1',
        ];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $pdf = Pdf::loadView('enseignant.emplois_du_temps_pdf', [
            'emploisDuTemps' => $emploisDuTemps,
            'anneeSemestre' => $anneeSemestre,
            'jours' => $jours,
            'enseignant' => $enseignant,
        ]);

        return $pdf->download('emplois_du_temps_M' . $enseignant->nom . '.pdf');
    }

    protected function getEmploisDuTemps($enseignantId)
    {
        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('e.id', $enseignantId)
            ->select(
                'c.*',
                'cl.nom_classe as classe_nom',
                'm.nom_matiere as matiere_nom',
                'e.nom as enseignant_nom',
                's.nom_salle as salle_nom',
                'a.annee as annee_academique',
                'sem.nom_semestre as semestre_nom',
                'c.jour',
                'c.heure_debut',
                'c.heure_fin'
            )
            ->get();

        $grouped = [];
        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $grouped[$cour->jour][$horaire][] = $cour;
        }

        return $grouped;
    }

    public function showEmploisDuTemps()
    {
        $enseignant = $this->getCurrentEnseignant();
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $emploisDuTemps = $this->getEmploisDuTemps($enseignant->id);
        $anneeSemestre = [
            'annee_academique' => '2025',
            'semestre_nom' => 'Semestre 2',
        ];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return view('enseignant.emplois_du_temps', compact('enseignant', 'emploisDuTemps', 'anneeSemestre', 'jours'));
    }

    public function getTotalCour()
    {
        $enseignant = $this->getCurrentEnseignant();
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $totalCours = DB::table('cours')
            ->where('enseignant_id', $enseignant->id)
            ->count();

        return response()->json(['total_cours' => $totalCours]);
    }

    public function getListClasses()
    {
        $enseignant = $this->getCurrentEnseignant();
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $classes = DB::table('classes')
            ->join('cours', 'classes.id', '=', 'cours.classe_id')
            ->where('cours.enseignant_id', $enseignant->id)
            ->select('classes.*')
            ->distinct()
            ->get();

        return view('enseignant.classes_list', compact('classes'));
    }

    private function getCurrentEnseignant(): ?Enseignant
    {
        $user = Auth::user();

        if ($user && $user->role === 'enseignant' && $user->enseignant) {
            session()->put('enseignant', $user->enseignant);
            return $user->enseignant;
        }

        $fromSession = session('enseignant');
        if ($fromSession instanceof Enseignant) {
            return $fromSession;
        }

        return null;
    }
}

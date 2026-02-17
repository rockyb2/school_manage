<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtudiantsController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'matricule' => 'required',
        ]);

        $etudiant = Etudiants::where('matricule', $request->matricule)->first();

        if (!$etudiant || !$etudiant->user || $etudiant->user->role !== 'etudiant') {
            return back()->withInput()->withErrors([
                'matricule' => 'Matricule incorrect',
            ]);
        }

        Auth::login($etudiant->user);
        $request->session()->regenerate();
        $request->session()->put('etudiant', $etudiant);

        return redirect()->route('etudiant.dashboard');
    }

    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'etudiant') {
            return redirect()->route('etudiant.dashboard');
        }

        return view('Etudiants.auth.login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('etudiant');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('etudiant.auth.login');
    }

    public function dashboard(Request $request)
    {
        $etudiant = $this->getCurrentEtudiant($request);
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        $etudiant->matieres_count = 5;

        return view('Etudiants.dashboard', compact('etudiant'));
    }

    public function emploisDuTemps(Request $request)
    {
        $etudiant = $this->getCurrentEtudiant($request);
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('cl.id', $etudiant->classe_id)
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

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];

        return view('Etudiants.emplois_du_temps', [
            'etudiant' => $etudiant,
            'jours' => $jours,
            'horaires' => $horaires,
            'emploisDuTemps' => $grouped,
        ]);
    }

    public function notes(Request $request)
    {
        $etudiant = $this->getCurrentEtudiant($request);
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        $matieres = DB::table('matieres as m')
            ->join('cours as c', 'm.id', '=', 'c.matiere_id')
            ->where('c.classe_id', $etudiant->classe_id)
            ->select('m.id', 'm.nom_matiere')
            ->distinct()
            ->get();

        $noteEtude = DB::table('notes as n')
            ->join('compositions as c', 'n.composition_id', '=', 'c.id')
            ->where('n.etudiant_id', $etudiant->id)
            ->select('n.*', 'c.titre', 'c.matiere_id')
            ->get();

        foreach ($matieres as $matiere) {
            $matiere->notes = $noteEtude->where('matiere_id', $matiere->id)->pluck('note');
            $matiere->moyenne = $matiere->notes->count() ? round($matiere->notes->avg(), 2) : '-';
        }

        return view('Etudiants.notes', compact('etudiant', 'matieres'));
    }

    public function getMoyenne(Request $request)
    {
        $etudiant = $this->getCurrentEtudiant($request);
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        $etudiant->matieres_count = DB::table('cours')
            ->where('classe_id', $etudiant->classe_id)
            ->distinct('matiere_id')
            ->count('matiere_id');

        $notes = DB::table('notes as n')
            ->join('compositions as c', 'n.composition_id', '=', 'c.id')
            ->where('n.etudiant_id', $etudiant->id)
            ->select('n.note', 'c.matiere_id')
            ->get();

        $etudiant->moyenne_generale = $notes->count() ? round($notes->avg('note'), 2) : '-';

        return view('Etudiants.dashboard', compact('etudiant'));
    }

    public function downloadEmploisDuTemps(Request $request)
    {
        $etudiant = $this->getCurrentEtudiant($request);
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('cl.id', $etudiant->classe_id)
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

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];

        $pdf = Pdf::loadView('Etudiants.emplois_du_temps_pdf', [
            'etudiant' => $etudiant,
            'jours' => $jours,
            'horaires' => $horaires,
            'emploisDuTemps' => $grouped,
        ]);

        return $pdf->download('emplois_du_temps_' . $etudiant->nom . '.pdf');
    }

    private function getCurrentEtudiant(Request $request): ?Etudiants
    {
        $user = Auth::user();

        if ($user && $user->role === 'etudiant' && $user->etudiant) {
            $request->session()->put('etudiant', $user->etudiant);
            return $user->etudiant;
        }

        $fromSession = $request->session()->get('etudiant');
        if ($fromSession instanceof Etudiants) {
            return $fromSession;
        }

        return null;
    }
}

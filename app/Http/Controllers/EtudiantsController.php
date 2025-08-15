<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EtudiantsController extends Controller
{




    public function login(Request $request)
    {
        $request->validate([
            'matricule' => 'required',
        ]);

        $Etudiant = Etudiants::where('matricule', $request->matricule)->first();

        if ($Etudiant) {
            $request->session()->put('etudiant', $Etudiant);
            return redirect()->route('etudiant.dashboard');
        }

        return back()->withInput()->withErrors([
            'matricule' => 'Matricule incorrect',
        ]);
    }



    public function showLoginForm()
    {
        if (session()->has('etudiant')) {
            return redirect()->route('etudiant.dashboard');
        }
        return view('Etudiants.auth.login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('etudiant');
        return redirect()->route('etudiant.auth.login');
    }

    public function dashboard()
    {
        $etudiant = session('etudiant');
        // Ajoute ici le calcul du nombre de matières si besoin
        $etudiant->matieres_count = 5; // exemple
        return view('Etudiants.dashboard', compact('etudiant'));
    }

    public function emploisDuTemps()
    {
        $etudiant = session('etudiant');
        if (!$etudiant) {
            return redirect()->route('etudiant.auth.login');
        }

        // Récupère les cours de la classe de l'étudiant
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

        // Grouper les résultats par jour et créneau horaire
        $grouped = [];
        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $grouped[$cour->jour][$horaire][] = $cour;
        }

        // Liste des jours et horaires pour la vue
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];

        return view('Etudiants.emplois_du_temps', [
            'etudiant' => $etudiant,
            'jours' => $jours,
            'horaires' => $horaires,
            'emploisDuTemps' => $grouped,
        ]);
    }

    public function notes()
    {
        $etudiant = session('etudiant');
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


    
    
public function getMoyenne()
{
    $etudiant = session('etudiant');

    // Nombre de matières
    $etudiant->matieres_count = DB::table('cours')
        ->where('classe_id', $etudiant->classe_id)
        ->distinct('matiere_id')
        ->count('matiere_id');

    // Récupérer toutes les notes de l'étudiant
    $notes = DB::table('notes as n')
        ->join('compositions as c', 'n.composition_id', '=', 'c.id')
        ->where('n.etudiant_id', $etudiant->id)
        ->select('n.note', 'c.matiere_id')
        ->get();

    // Calculer la moyenne générale
    $etudiant->moyenne_generale = $notes->count() ? round($notes->avg('note'), 2) : '-';

    return view('Etudiants.dashboard', compact('etudiant'));
}


public function downloadEmploisDuTemps()
{
    $etudiant = session('etudiant');
    if (!$etudiant) {
        return redirect()->route('etudiant.auth.login');
    }

    // Récupère les cours de la classe de l'étudiant (même logique que emploisDuTemps)
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

    // Grouper les résultats par jour et créneau horaire
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
}

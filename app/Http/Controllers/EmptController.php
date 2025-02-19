<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Annee_academique;
use App\Models\Semestre;

class EmptController extends Controller
{
    public function index()
    {

        $anneesAcademiques = Annee_academique::all();
        $semestres = Semestre::all();

        return view('filament.pages.emplois_du_temps', compact('anneesAcademiques', 'semestres'));
    }

    public function generateSchedule(Request $request)
    {
        $request->validate([
            'annee_academique_id' => 'required',
            'semestre_id' => 'required',
        ]);

        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('edt.annee_academique_id', $request->annee_academique_id)
            ->where('edt.semestre_id', $request->semestre_id)
            ->select(
                'c.*',
                'cl.nom_classe as classe_nom',
                'm.nom_matiere as matiere_nom',
                'e.nom as enseignant_nom',
                'e.email as enseignant_email',
                's.nom_salle as salle_nom',
                'a.annee as annee_academique',
                'sem.nom_semestre as semestre_nom',
                'c.jour',
                'c.heure_debut',
                'c.heure_fin'
            )
            ->get();

        $emplois_du_temps = [];

        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $emplois_du_temps[$cour->classe_nom][$cour->jour][$horaire][] = $cour;
        }

        $anneeSemestre = [];
if ($results->isNotEmpty()) {
    $first = $results->first();
    $anneeSemestre = [
        'annee_academique' => $first->annee_academique ?? '',
        'semestre_nom' => $first->semestre_nom ?? '',
    ];
}

        return view('filament.pages.emplois_du_temps', [
            'emploisDuTemps' => $emplois_du_temps,
            'anneeSemestre' => $anneeSemestre,
            'jours' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            'anneesAcademiques' => Annee_academique::pluck('annee', 'id')->toArray(), // Ajouté ici
            'semestres' => Semestre::pluck('nom_semestre', 'id')->toArray(), // Ajouté ici
        ]);
    }
}

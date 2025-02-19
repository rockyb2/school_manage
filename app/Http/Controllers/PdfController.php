<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Récupérer les données nécessaires pour générer le PDF
        $results = $this->getEmploisDuTemps();
        $emplois_du_temps = [];

        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $emplois_du_temps[$cour->classe_nom][$cour->jour][$horaire][] = $cour;
        }

        $anneeSemestre = [
            'annee_academique' => '2024-2025', // Remplacez par les données réelles
            'semestre_nom' => 'Semestre 2', // Remplacez par les données réelles
        ];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        // Générer le PDF
        $pdf = PDF::loadView('filament.pages.pdf', [
            'emploisDuTemps' => $emplois_du_temps,
            'anneeSemestre' => $anneeSemestre,
            'jours' => $jours,
        ]);

        return $pdf->download('emplois_du_temps.pdf');
    }

    protected function getEmploisDuTemps()
    {
        // Remplacez par la logique pour récupérer les données réelles
        return DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
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
    }
}

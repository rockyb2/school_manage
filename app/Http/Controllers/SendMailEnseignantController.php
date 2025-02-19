<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignant;
use App\Jobs\SendEmploisDuTempsEmail;
use Illuminate\Support\Facades\DB;

class SendMailEnseignantController extends Controller
{
    public function sendEmploisDuTempsNotification()
    {
        $enseignants = Enseignant::all();

        foreach ($enseignants as $enseignant) {
            // Récupérer les emplois du temps de l'enseignant
            $emploisDuTemps = $this->getEmploisDuTemps($enseignant->id);

            // Dispatch le job pour envoyer l'email
            SendEmploisDuTempsEmail::dispatch($enseignant, $emploisDuTemps);
        }

        return back()->with('success', 'Notifications envoyées avec succès.');
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

        // Grouper les résultats par jour et par créneau horaire
        $grouped = [];
        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $grouped[$cour->jour][$horaire][] = $cour;
        }

        return $grouped;
    }
}

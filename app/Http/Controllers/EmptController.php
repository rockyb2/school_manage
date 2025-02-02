<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\Emplois_Du_Temps;

class EmptController extends Controller
{
    public function genererEmploisDuTemps(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'semestre_id' => 'required|exists:semestre,id',
            'annee_academique_id' => 'required|exists:annee_academique,id',
        ]);

        // Récupérer le semestre et l'année académique
        $semestreId = $request->semestre_id;
        $anneeAcademiqueId = $request->annee_academique_id;

        // Récupérer tous les cours disponibles
        $cours = Cours::all();

        // Générer les emplois du temps pour chaque cours
        foreach ($cours as $cour) {
            // Vérifier les conflits
            $conflict = Emplois_Du_Temps::where('jour', $cour->jour)
                ->where('heure_debut', '<=', $cour->heure_fin)
                ->where('heure_fin', '>=', $cour->heure_debut)
                ->whereHas('cours', function ($query) use ($cour) {
                    $query->where('classe_id', $cour->classe_id)
                        ->orWhere('matiere_id', $cour->matiere_id)
                        ->orWhere('enseignant_id', $cour->enseignant_id)
                        ->orWhere('salles_id', $cour->salles_id);
                })->first();

            // Si aucun conflit n'est détecté, créer l'emploi du temps
            if (!$conflict) {
                Emplois_Du_Temps::create([
                    'cours_id' => $cour->id,
                    'semestre_id' => $semestreId,
                    'annee_academique_id' => $anneeAcademiqueId,

                ]);
            }
        }

        // Retourner une notification de succès
        return redirect()->back()->with('success', 'Les emplois du temps ont été générés avec succès.');
    }
}

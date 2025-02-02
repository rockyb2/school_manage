<?php

namespace App\Filament\Resources\CoursResource\Pages;

use App\Filament\Resources\CoursResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Emplois_du_temps;

class CreateCours extends CreateRecord
{
    protected static string $resource = CoursResource::class;

    /**
     * Cette méthode intercepte les données du formulaire et effectue la création dans une transaction.
     */
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Récupérer les champs dédiés à l'emploi du temps
        $anneeAcademiqueId = $data['annee_academique_id'];
        $semestreId        = $data['semestre_id'];

        // Retirer ces champs du tableau avant de créer le cours
        unset($data['annee_academique_id'], $data['semestre_id']);

        return DB::transaction(function () use ($data, $anneeAcademiqueId, $semestreId) {
            // Création du cours
            $cours = static::$resource::getModel()::create($data);

            // Création de l'emploi du temps associé
            Emplois_du_temps::create([
                'cours_id'            => $cours->id,
                'annee_academique_id' => $anneeAcademiqueId,
                'semestre_id'         => $semestreId,
            ]);

            return $cours;
        });
    }
}

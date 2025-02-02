<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Matieres;
use App\Models\Salles;
use App\Models\Cours;

class CoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enseignant = Enseignant::factory()->create();
        $classe = Classe::factory()->create();
        $matiere = Matieres::factory()->create();
        $salle = Salles::factory()->create();

        Cours::create([
            'enseignant_id' => $enseignant->id,
            'classe_id' => $classe->id,
            'matiere_id' => $matiere->id,
            'jour' => 'lundi',
            'heure_debut' => '08:00:00',
            'heure_fin' => '10:00:00',
            'salle_id' => $salle->id,
        ]);
    }
}

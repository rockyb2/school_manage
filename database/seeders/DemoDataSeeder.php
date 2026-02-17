<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $adminUserId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'admin@school.test',
            'role' => 'admin',
            'password' => Hash::make('admin12345'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('admin')->insert([
            'user_id' => $adminUserId,
            'nom' => 'Super Admin',
            'email' => 'admin@school.test',
            'password' => Hash::make('admin12345'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $filiereInfoId = DB::table('filieres')->insertGetId([
            'nom_filiere' => 'Informatique',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $filiereGestionId = DB::table('filieres')->insertGetId([
            'nom_filiere' => 'Gestion',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $classeL1InfoId = DB::table('classes')->insertGetId([
            'filiere_id' => $filiereInfoId,
            'nom_classe' => 'L1 INFO A',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $classeL2InfoId = DB::table('classes')->insertGetId([
            'filiere_id' => $filiereInfoId,
            'nom_classe' => 'L2 INFO B',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $classeL1GestionId = DB::table('classes')->insertGetId([
            'filiere_id' => $filiereGestionId,
            'nom_classe' => 'L1 GESTION A',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $matiereAlgoId = DB::table('matieres')->insertGetId([
            'nom_matiere' => 'Algorithmique',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $matiereBaseDonneesId = DB::table('matieres')->insertGetId([
            'nom_matiere' => 'Base de donnees',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $matiereReseauId = DB::table('matieres')->insertGetId([
            'nom_matiere' => 'Reseaux',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $matiereComptaId = DB::table('matieres')->insertGetId([
            'nom_matiere' => 'Comptabilite',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $salleA1Id = DB::table('salles')->insertGetId([
            'nom_salle' => 'A1',
            'capacite' => 40,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $salleB2Id = DB::table('salles')->insertGetId([
            'nom_salle' => 'B2',
            'capacite' => 35,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $salleC3Id = DB::table('salles')->insertGetId([
            'nom_salle' => 'C3',
            'capacite' => 50,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $anneeId = DB::table('annee_academique')->insertGetId([
            'annee' => 2025,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $semestreId = DB::table('semestre')->insertGetId([
            'nom_semestre' => 'Semestre 1',
            'date_debut' => '2025-10-01',
            'date_fin' => '2026-02-28',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $enseignants = [
            [
                'nom' => 'Kouassi',
                'prenoms' => 'Jean Marc',
                'specialite' => 'Informatique',
                'tel' => '0700000001',
                'email' => 'jean.kouassi@school.test',
                'mot_de_passe' => 'teacher123',
                'password' => 'teacher123',
            ],
            [
                'nom' => 'Diop',
                'prenoms' => 'Awa',
                'specialite' => 'Reseaux',
                'tel' => '0700000002',
                'email' => 'awa.diop@school.test',
                'mot_de_passe' => 'teacher123',
                'password' => 'teacher123',
            ],
            [
                'nom' => 'Nguessan',
                'prenoms' => 'Mireille',
                'specialite' => 'Gestion',
                'tel' => '0700000003',
                'email' => 'mireille.nguessan@school.test',
                'mot_de_passe' => 'teacher123',
                'password' => 'teacher123',
            ],
        ];

        $enseignantIds = [];
        foreach ($enseignants as $teacher) {
            $userId = DB::table('users')->insertGetId([
                'name' => $teacher['nom'] . ' ' . $teacher['prenoms'],
                'email' => $teacher['email'],
                'role' => 'enseignant',
                'password' => Hash::make($teacher['password']),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $enseignantIds[] = DB::table('enseignants')->insertGetId([
                'user_id' => $userId,
                'nom' => $teacher['nom'],
                'prenoms' => $teacher['prenoms'],
                'specialite' => $teacher['specialite'],
                'tel' => $teacher['tel'],
                'email' => $teacher['email'],
                'mot_de_passe' => $teacher['mot_de_passe'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('disponibilite')->insert([
            ['enseignant_id' => $enseignantIds[0], 'Jour' => 'Lundi', 'periode' => '08H00-12H30', 'created_at' => $now, 'updated_at' => $now],
            ['enseignant_id' => $enseignantIds[1], 'Jour' => 'Mardi', 'periode' => '08H00-12H30', 'created_at' => $now, 'updated_at' => $now],
            ['enseignant_id' => $enseignantIds[2], 'Jour' => 'Mercredi', 'periode' => '13H00-17H00', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $etudiantsData = [
            ['nom' => 'Yao', 'prenoms' => 'Kevin', 'email' => 'kevin.yao@school.test', 'classe_id' => $classeL1InfoId],
            ['nom' => 'Traore', 'prenoms' => 'Fatou', 'email' => 'fatou.traore@school.test', 'classe_id' => $classeL1InfoId],
            ['nom' => 'Kone', 'prenoms' => 'Ibrahim', 'email' => 'ibrahim.kone@school.test', 'classe_id' => $classeL1InfoId],
            ['nom' => 'Zongo', 'prenoms' => 'Aicha', 'email' => 'aicha.zongo@school.test', 'classe_id' => $classeL1InfoId],
            ['nom' => 'Diallo', 'prenoms' => 'Mamadou', 'email' => 'mamadou.diallo@school.test', 'classe_id' => $classeL2InfoId],
            ['nom' => 'Soro', 'prenoms' => 'Nadine', 'email' => 'nadine.soro@school.test', 'classe_id' => $classeL2InfoId],
            ['nom' => 'Bah', 'prenoms' => 'Oumar', 'email' => 'oumar.bah@school.test', 'classe_id' => $classeL2InfoId],
            ['nom' => 'Fofana', 'prenoms' => 'Rokia', 'email' => 'rokia.fofana@school.test', 'classe_id' => $classeL2InfoId],
            ['nom' => 'Bamba', 'prenoms' => 'Clarisse', 'email' => 'clarisse.bamba@school.test', 'classe_id' => $classeL1GestionId],
            ['nom' => 'Cisse', 'prenoms' => 'Souleymane', 'email' => 'souleymane.cisse@school.test', 'classe_id' => $classeL1GestionId],
            ['nom' => 'Adjoua', 'prenoms' => 'Ruth', 'email' => 'ruth.adjoua@school.test', 'classe_id' => $classeL1GestionId],
            ['nom' => 'Toure', 'prenoms' => 'Moussa', 'email' => 'moussa.toure@school.test', 'classe_id' => $classeL1GestionId],
        ];

        $etudiantsByClass = [
            $classeL1InfoId => [],
            $classeL2InfoId => [],
            $classeL1GestionId => [],
        ];

        $i = 1;
        foreach ($etudiantsData as $etudiant) {
            $matricule = sprintf('ETD2026%03d', $i++);

            $userId = DB::table('users')->insertGetId([
                'name' => $etudiant['nom'] . ' ' . $etudiant['prenoms'],
                'email' => $etudiant['email'],
                'role' => 'etudiant',
                'password' => Hash::make($matricule),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $etudiantId = DB::table('etudiants')->insertGetId([
                'user_id' => $userId,
                'classe_id' => $etudiant['classe_id'],
                'matricule' => $matricule,
                'nom' => $etudiant['nom'],
                'prenoms' => $etudiant['prenoms'],
                'age' => rand(18, 25),
                'sexe' => rand(0, 1) ? 'M' : 'F',
                'tel_etudiant' => '0701' . str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'email' => $etudiant['email'],
                'date_naissance' => '2004-01-15',
                'lieu_naissance' => 'Abidjan',
                'nom_pere' => 'Parent Pere',
                'nom_mere' => 'Parent Mere',
                'nom_tuteur' => 'Tuteur Test',
                'tel_pere' => '0702' . str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'tel_mere' => '0703' . str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'tel_tuteur' => '0704' . str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'photo' => null,
                'date_inscription' => '2025-10-01',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $etudiantsByClass[$etudiant['classe_id']][] = $etudiantId;
        }

        $cours = [
            [
                'nom' => 'Algo L1',
                'enseignant_id' => $enseignantIds[0],
                'classe_id' => $classeL1InfoId,
                'matiere_id' => $matiereAlgoId,
                'Jour' => 'Lundi',
                'heure_debut' => '08:00',
                'heure_fin' => '08:30',
                'salles_id' => $salleA1Id,
            ],
            [
                'nom' => 'BDD L1',
                'enseignant_id' => $enseignantIds[0],
                'classe_id' => $classeL1InfoId,
                'matiere_id' => $matiereBaseDonneesId,
                'Jour' => 'Mercredi',
                'heure_debut' => '10:00',
                'heure_fin' => '10:30',
                'salles_id' => $salleB2Id,
            ],
            [
                'nom' => 'Reseaux L2',
                'enseignant_id' => $enseignantIds[1],
                'classe_id' => $classeL2InfoId,
                'matiere_id' => $matiereReseauId,
                'Jour' => 'Mardi',
                'heure_debut' => '09:00',
                'heure_fin' => '09:30',
                'salles_id' => $salleC3Id,
            ],
            [
                'nom' => 'Compta L1',
                'enseignant_id' => $enseignantIds[2],
                'classe_id' => $classeL1GestionId,
                'matiere_id' => $matiereComptaId,
                'Jour' => 'Jeudi',
                'heure_debut' => '13:00',
                'heure_fin' => '13:30',
                'salles_id' => $salleA1Id,
            ],
        ];

        $coursIds = [];
        foreach ($cours as $cour) {
            $coursIds[] = DB::table('cours')->insertGetId([
                ...$cour,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($coursIds as $coursId) {
            DB::table('emplois_du_temps')->insert([
                'cours_id' => $coursId,
                'semestre_id' => $semestreId,
                'annee_academique_id' => $anneeId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('coefficients')->insert([
            ['classe_id' => $classeL1InfoId, 'matiere_id' => $matiereAlgoId, 'coefficent' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['classe_id' => $classeL1InfoId, 'matiere_id' => $matiereBaseDonneesId, 'coefficent' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['classe_id' => $classeL2InfoId, 'matiere_id' => $matiereReseauId, 'coefficent' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['classe_id' => $classeL1GestionId, 'matiere_id' => $matiereComptaId, 'coefficent' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $compositions = [
            [
                'titre' => 'Interro Algo 1',
                'date_composition' => '2025-11-10',
                'type' => 'Interrogation',
                'enseignant_id' => $enseignantIds[0],
                'matiere_id' => $matiereAlgoId,
                'classe_id' => $classeL1InfoId,
            ],
            [
                'titre' => 'Devoir BDD 1',
                'date_composition' => '2025-11-20',
                'type' => 'Devoir',
                'enseignant_id' => $enseignantIds[0],
                'matiere_id' => $matiereBaseDonneesId,
                'classe_id' => $classeL1InfoId,
            ],
            [
                'titre' => 'Interro Reseaux',
                'date_composition' => '2025-11-18',
                'type' => 'Interrogation',
                'enseignant_id' => $enseignantIds[1],
                'matiere_id' => $matiereReseauId,
                'classe_id' => $classeL2InfoId,
            ],
            [
                'titre' => 'Devoir Compta',
                'date_composition' => '2025-11-22',
                'type' => 'Devoir',
                'enseignant_id' => $enseignantIds[2],
                'matiere_id' => $matiereComptaId,
                'classe_id' => $classeL1GestionId,
            ],
        ];

        $compositionIds = [];
        foreach ($compositions as $composition) {
            $compositionIds[] = DB::table('compositions')->insertGetId([
                ...$composition,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($etudiantsByClass[$classeL1InfoId] as $etudiantId) {
            DB::table('notes')->insert([
                'etudiant_id' => $etudiantId,
                'composition_id' => $compositionIds[0],
                'matiere_id' => $matiereAlgoId,
                'note' => rand(90, 170) / 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('notes')->insert([
                'etudiant_id' => $etudiantId,
                'composition_id' => $compositionIds[1],
                'matiere_id' => $matiereBaseDonneesId,
                'note' => rand(90, 180) / 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($etudiantsByClass[$classeL2InfoId] as $etudiantId) {
            DB::table('notes')->insert([
                'etudiant_id' => $etudiantId,
                'composition_id' => $compositionIds[2],
                'matiere_id' => $matiereReseauId,
                'note' => rand(100, 185) / 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($etudiantsByClass[$classeL1GestionId] as $etudiantId) {
            DB::table('notes')->insert([
                'etudiant_id' => $etudiantId,
                'composition_id' => $compositionIds[3],
                'matiere_id' => $matiereComptaId,
                'note' => rand(95, 175) / 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}

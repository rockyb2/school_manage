<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        if (Schema::hasTable('notes') && Schema::hasColumn('notes', 'note')) {
            DB::statement('ALTER TABLE notes MODIFY note DECIMAL(5,2) NOT NULL');
        }

        if (Schema::hasTable('enseignants') && Schema::hasColumn('enseignants', 'tel')) {
            DB::statement('ALTER TABLE enseignants MODIFY tel VARCHAR(20) NOT NULL');
        }

        if (Schema::hasTable('etudiants')) {
            if (Schema::hasColumn('etudiants', 'tel_etudiant')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_etudiant VARCHAR(20) NOT NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_pere')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_pere VARCHAR(20) NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_mere')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_mere VARCHAR(20) NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_tuteur')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_tuteur VARCHAR(20) NULL');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        if (Schema::hasTable('notes') && Schema::hasColumn('notes', 'note')) {
            DB::statement('ALTER TABLE notes MODIFY note FLOAT NOT NULL');
        }

        if (Schema::hasTable('enseignants') && Schema::hasColumn('enseignants', 'tel')) {
            DB::statement('ALTER TABLE enseignants MODIFY tel INT NOT NULL');
        }

        if (Schema::hasTable('etudiants')) {
            if (Schema::hasColumn('etudiants', 'tel_etudiant')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_etudiant INT NOT NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_pere')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_pere INT NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_mere')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_mere INT NULL');
            }
            if (Schema::hasColumn('etudiants', 'tel_tuteur')) {
                DB::statement('ALTER TABLE etudiants MODIFY tel_tuteur INT NULL');
            }
        }
    }
};

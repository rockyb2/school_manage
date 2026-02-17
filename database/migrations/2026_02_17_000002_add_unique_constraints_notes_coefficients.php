<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('notes')
            && Schema::hasColumn('notes', 'etudiant_id')
            && Schema::hasColumn('notes', 'composition_id')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->unique(['etudiant_id', 'composition_id'], 'notes_etudiant_composition_unique');
            });
        }

        if (Schema::hasTable('coefficients')
            && Schema::hasColumn('coefficients', 'classe_id')
            && Schema::hasColumn('coefficients', 'matiere_id')) {
            Schema::table('coefficients', function (Blueprint $table) {
                $table->unique(['classe_id', 'matiere_id'], 'coefficients_classe_matiere_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('coefficients')) {
            Schema::table('coefficients', function (Blueprint $table) {
                $table->dropUnique('coefficients_classe_matiere_unique');
            });
        }

        if (Schema::hasTable('notes')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->dropUnique('notes_etudiant_composition_unique');
            });
        }
    }
};

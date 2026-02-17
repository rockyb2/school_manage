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
        if (!Schema::hasColumn('emplois_du_temps', 'cours_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade')->after('id');
            });
        }

        if (!Schema::hasColumn('emplois_du_temps', 'semestre_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->foreignId('semestre_id')->constrained('semestre')->onDelete('cascade')->after('cours_id');
            });
        }

        if (!Schema::hasColumn('emplois_du_temps', 'annee_academique_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->foreignId('annee_academique_id')->constrained('annee_academique')->onDelete('cascade')->after('semestre_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('emplois_du_temps', 'annee_academique_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->dropConstrainedForeignId('annee_academique_id');
            });
        }

        if (Schema::hasColumn('emplois_du_temps', 'semestre_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->dropConstrainedForeignId('semestre_id');
            });
        }

        if (Schema::hasColumn('emplois_du_temps', 'cours_id')) {
            Schema::table('emplois_du_temps', function (Blueprint $table) {
                $table->dropConstrainedForeignId('cours_id');
            });
        }
    }
};

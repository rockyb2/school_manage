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
        Schema::dropIfExists('semestre');
        Schema::dropIfExists('annee_academique');
        Schema::dropIfExists('emplois_du_temps');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('semestre', function (Blueprint $table) {
            $table->id();
            $table->string('nom_semestre');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();
        });

        Schema::create('annee_academique', function (Blueprint $table) {
            $table->id();
            $table->string('annee');
            $table->timestamps();
        });

        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestre')->onDelete('cascade');
            $table->foreignId('annee_academique_id')->constrained('annee_academique')->onDelete('cascade');
            $table->string('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->timestamps();
        });
    }
};

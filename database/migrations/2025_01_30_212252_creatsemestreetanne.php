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

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestre');
        Schema::dropIfExists('annee_academique');
    }
};

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
        Schema::create('etudiants',function(Blueprint $table){
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenoms');
            $table->integer('age');
            $table->string('sexe');
            $table->integer('tel_etudiant');
            $table->string('email')->unique();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalité')->nullable();
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('nom_tuteur')->nullable();
            $table->integer('tel_pere')->nullable();
            $table->integer('tel_mere')->nullable();
            $table->integer('tel_tuteur')->nullable();
            $table->date('date_inscription')->nullable();
            $table->timestamps(); // Ajouté pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};

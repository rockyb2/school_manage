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
       Schema::create('disponibilite',function(Blueprint $table){
        $table->id();
        $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
        $table->enum('Jour',['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']);
        $table->enum('periode',['matin','apres_midi']);
        $table->timestamps(); // Ajouté pour created_at et updated_at
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilite');

    }
};

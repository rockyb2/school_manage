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
        Schema::create('enseignants',function(Blueprint $table){
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('specialite');
            $table->integer('tel');
            $table->string('email')->unique();
            $table->timestamps(); // Ajouté pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant');
    }
};

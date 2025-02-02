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
        Schema::table('emplois_du_temps',function(Blueprint $table){

            $table->dropColumn('cours_id');

            $table->dropColumn('annee_academique_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emplois_du_temps',function(Blueprint $table){
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->foreignId('annee_academique_id')->constrained('annee_academique')->onDelete('cascade');
        });
    }
};

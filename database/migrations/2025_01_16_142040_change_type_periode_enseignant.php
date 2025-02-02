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
       Schema::table('disponibilite', function(Blueprint $table){
        $table->enum('periode',['08H00-12H30','13H00-17H00'])->change();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilite', function (Blueprint $table) {
            // Reverse la modification : revenir à 'time'
            $table->enum('periode',['matin','apres_midi'])->change();
        });
    }
};

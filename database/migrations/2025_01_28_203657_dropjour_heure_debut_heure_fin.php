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
        Schema::table('emplois_du_temps', function (Blueprint $table) {
            $table->dropColumn('jour');
            $table->dropColumn('heure_debut');
            $table->dropColumn('heure_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emplois_du_temps', function (Blueprint $table) {
            $table->string('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
        });
    }
};

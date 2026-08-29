<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaire_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaire_id')->constrained('inventaires')->cascadeOnDelete();
            $table->foreignId('couleur_id')->constrained('couleurs');
            $table->unsignedInteger('quantite_pleines_comptee');
            $table->unsignedInteger('quantite_vides_comptee');
            // Snapshot du stock théorique au moment du comptage, pour calculer l'écart.
            $table->unsignedInteger('quantite_pleines_theorique');
            $table->unsignedInteger('quantite_vides_theorique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaire_lignes');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_approvisionnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->cascadeOnDelete();
            $table->foreignId('marque_id')->constrained('marques');
            $table->foreignId('couleur_id')->constrained('couleurs');
            $table->unsignedInteger('quantite_demandee');
            $table->enum('statut', ['en_attente', 'validee', 'livree'])->default('en_attente');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_approvisionnements');
    }
};
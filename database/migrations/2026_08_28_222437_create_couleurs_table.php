<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couleurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marque_id')->constrained('marques')->cascadeOnDelete();
            $table->string('nom_couleur');
            $table->string('poids'); // ex: "6kg", "12,5kg"
            $table->timestamps();

            $table->unique(['marque_id', 'nom_couleur', 'poids']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('couleurs');
    }
};
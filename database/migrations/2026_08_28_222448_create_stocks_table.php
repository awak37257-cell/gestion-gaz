<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couleur_id')->constrained('couleurs')->cascadeOnDelete();
            $table->foreignId('depot_id')->constrained('depots')->cascadeOnDelete();
            $table->unsignedInteger('quantite_pleines')->default(0);
            $table->unsignedInteger('quantite_vides')->default(0);
            $table->timestamps();

            $table->unique(['couleur_id', 'depot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
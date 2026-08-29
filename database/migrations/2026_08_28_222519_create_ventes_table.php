<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->cascadeOnDelete();
            $table->foreignId('couleur_vendue_id')->constrained('couleurs');
            $table->foreignId('couleur_demandee_id')->nullable()->constrained('couleurs');
            $table->unsignedInteger('quantite')->default(1);
            $table->timestamp('date_heure')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
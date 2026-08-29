<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            // Snapshot du prix au moment de la vente : si le prix de la couleur
            // change plus tard, les anciens reçus doivent rester corrects.
            $table->unsignedInteger('prix_unitaire')->default(0)->after('quantite');
        });
    }

    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn('prix_unitaire');
        });
    }
};
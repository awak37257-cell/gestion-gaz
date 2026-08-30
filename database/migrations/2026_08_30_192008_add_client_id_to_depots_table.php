<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('depots', function (Blueprint $table) {
            // Si la colonne n'existe pas encore, on la crée (sécurité), 
            // mais si elle est déjà là, on passe directement à la contrainte.
            if (!Schema::hasColumn('depots', 'client_id')) {
                $table->foreignId('client_id')->nullable()->after('id')->constrained('clients')->cascadeOnDelete();
            } else {
                // Si elle existe déjà, on s'assure juste d'ajouter la contrainte si elle n'y est pas
                $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('depots', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_id');
        });
    }
};
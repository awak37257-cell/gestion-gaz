<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marques', function (Blueprint $table) {
            $table->foreignId('client_id')->after('id')->constrained('clients')->cascadeOnDelete();
        });

        Schema::table('marques', function (Blueprint $table) {
            // L'unicité du nom était globale ; deux clients différents doivent
            // pouvoir avoir chacun une marque "Petroci".
            $table->dropUnique(['nom']);
            $table->unique(['client_id', 'nom']);
        });
    }

    public function down(): void
    {
        Schema::table('marques', function (Blueprint $table) {
            $table->dropUnique(['client_id', 'nom']);
            $table->unique('nom');
            $table->dropConstrainedForeignId('client_id');
        });
    }
};
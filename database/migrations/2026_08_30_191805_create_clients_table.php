<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email_contact')->nullable();
            $table->string('telephone')->nullable();
            $table->enum('periode_abonnement', ['mensuel', 'trimestriel', 'annuel'])->default('mensuel');
            $table->unsignedInteger('montant_abonnement')->default(0);
            $table->date('date_debut_abonnement');
            $table->date('date_fin_abonnement');
            $table->enum('statut', ['actif', 'suspendu', 'expire'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
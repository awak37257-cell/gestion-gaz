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
        Schema::create('demandes_acces', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entreprise');
            $table->string('nom_contact');
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->string('periode_souhaitee')->default('mensuel'); // mensuel, trimestriel, annuel
            $table->text('message')->nullable();
            $table->string('statut')->default('en_attente'); // en_attente, validee, rejetee
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_acces');
    }
};

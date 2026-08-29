<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('couleurs', function (Blueprint $table) {
            $table->unsignedInteger('prix_unitaire')->default(0)->after('poids');
        });
    }

    public function down(): void
    {
        Schema::table('couleurs', function (Blueprint $table) {
            $table->dropColumn('prix_unitaire');
        });
    }
};
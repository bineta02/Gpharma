<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('statut')->default('actif'); // Ajoute la colonne statut
            $table->string('photo')->nullable()->after('email'); // Ajoute la colonne photo
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['statut', 'photo']);
        });
    }
};
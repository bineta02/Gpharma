<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Transforme le ENUM restrictif en VARCHAR(255) classique
            $table->string('role')->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Si tu as besoin de revenir en arrière
            $table->enum('role', ['admin', 'manager'])->change();
        });
    }
};
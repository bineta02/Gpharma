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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom'); // 'string' pour le prénom
            $table->string('email')->unique()->nullable(); // 'nullable' si tous les clients n'ont pas d'email
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('statut')->default('actif');
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

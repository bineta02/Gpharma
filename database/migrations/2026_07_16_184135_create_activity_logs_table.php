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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        // L'utilisateur qui fait l'action (nullable si l'action est faite par un visiteur non connecté)
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); 
        $table->string('action');      // Nature de l'action (Ex: "Création d'utilisateur", "Connexion")
        $table->text('description');   // Détail (Ex: "A créé le compte de Ndeye Ndiaye")
        $table->string('ip_address')->nullable(); // L'adresse IP de l'utilisateur
        $table->timestamps();          // created_at servira de date et heure de l'action
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

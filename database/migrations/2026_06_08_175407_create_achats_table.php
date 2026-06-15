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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produit')->constrained('produits')->onDelete('cascade');
            $table->foreignId('id_fournisseur')->constrained('fournisseurs')->onDelete('cascade');
            $table->integer('quantite'); // 'integer' pour une quantité entière
            $table->decimal('prix_unitaire', 10, 2); // 'decimal' idéal pour la monnaie (ex: 12345678.90)
            $table->string('statut')->default('en_attente'); // 'string' pour le texte du statut
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achats');
    }
};

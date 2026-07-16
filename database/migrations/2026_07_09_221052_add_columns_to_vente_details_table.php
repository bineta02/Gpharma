<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vente_details', function (Blueprint $table) {
            // Ajoute les colonnes manquantes après l'ID
            $table->foreignId('id_vente')->after('id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('id_produit')->after('id_vente')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite')->after('id_produit');
            $table->integer('prix_unitaire')->after('quantite');
        });
    }

    public function down(): void
    {
        Schema::table('vente_details', function (Blueprint $table) {
            // En cas de retour en arrière, on supprime les clés étrangères puis les colonnes
            $table->dropForeign(['id_vente']);
            $table->dropForeign(['id_produit']);
            $table->dropColumn(['id_vente', 'id_produit', 'quantite', 'prix_unitaire']);
        });
    }
};
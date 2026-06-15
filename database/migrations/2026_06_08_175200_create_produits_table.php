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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categorie')->constrained('categories')->onDelete('cascade'); // Clé étrangère propre
            $table->string('code')->unique(); // Un code produit (ex: code-barres) est souvent une chaîne de caractères unique
            $table->string('nom');
            $table->text('description')->nullable();
            $table->integer('stock_min')->default(0); // 'integer' pour les nombres entiers
            $table->integer('stock_max')->default(0); // 'integer' pour les nombres entiers
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};

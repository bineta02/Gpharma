<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->string('numero_facture')->unique()->after('id');
            $table->integer('montant_total')->after('numero_facture');
            $table->integer('montant_recu')->after('montant_total');
            $table->integer('rendu_monnaie')->after('montant_recu');
            $table->string('statut')->default('complete')->after('rendu_monnaie');
        });
    }

    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn(['numero_facture', 'montant_total', 'montant_recu', 'rendu_monnaie', 'statut']);
        });
    }
};
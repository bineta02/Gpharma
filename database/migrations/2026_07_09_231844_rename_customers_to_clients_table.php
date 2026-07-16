<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On renomme la table mal orthographiée en 'clients'
        Schema::rename('customers', 'clients');
    }

    public function down(): void
    {
        // En cas de rollback, on revient en arrière
        Schema::rename('clients', 'customers');
    }
};
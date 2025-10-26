<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migration annulée car problème de conflit de noms de colonnes
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['vendeur_id']);
            
            // Renommer la colonne
            $table->renameColumn('vendeur_id', 'idVendeur');
            
            // Recréer la contrainte de clé étrangère
            $table->foreign('idVendeur')->references('id')->on('vendeurs')->onDelete('cascade');
        });
    }
};
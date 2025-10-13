<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->id('idLigne');
            $table->integer('quantite');
            $table->decimal('prixUnitaire', 10, 2);
            $table->unsignedBigInteger('idCommande')->nullable();
            $table->unsignedBigInteger('idProduit')->nullable();
            $table->foreign('idCommande')->references('idCommande')->on('commandes')->onDelete('cascade');
            $table->foreign('idProduit')->references('idProduit')->on('produits')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ligne_commandes');
    }
};

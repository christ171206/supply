<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('idPaiement');
            $table->string('methodePaiement', 50)->nullable();
            $table->decimal('montant', 10, 2);
            $table->dateTime('datePaiement')->useCurrent();
            $table->unsignedBigInteger('idCommande')->nullable();
            $table->foreign('idCommande')->references('idCommande')->on('commandes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('paiements');
    }
};

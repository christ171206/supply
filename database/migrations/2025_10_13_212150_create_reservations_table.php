<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('idReservation');
            $table->dateTime('dateReservation')->useCurrent();
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('en_attente');
            $table->unsignedBigInteger('idProduit')->nullable();
            $table->unsignedBigInteger('idClient')->nullable();
            $table->foreign('idProduit')->references('idProduit')->on('produits')->nullOnDelete();
            $table->foreign('idClient')->references('id')->on('clients')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};

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
        Schema::create('panier_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idClient');
            $table->unsignedBigInteger('idProduit');
            $table->integer('quantite')->default(1);
            $table->timestamps();

            // Foreign keys
            $table->foreign('idClient')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idProduit')->references('idProduit')->on('produits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_items');
    }
};

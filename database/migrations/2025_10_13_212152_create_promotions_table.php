<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('idPromotion');
            $table->date('dateDebut')->nullable();
            $table->date('dateFin')->nullable();
            $table->decimal('prixPromo', 10, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('idProduit')->nullable();
            $table->foreign('idProduit')->references('idProduit')->on('produits')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('promotions');
    }
};

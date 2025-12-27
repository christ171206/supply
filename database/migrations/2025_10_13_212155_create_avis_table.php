<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('avis', function (Blueprint $table) {
            $table->id('idAvis');
            $table->integer('note')->checkBetween(1, 5);
            $table->text('commentaire')->nullable();
            $table->dateTime('dateAvis')->useCurrent();
            $table->boolean('visible')->default(true);
            $table->unsignedBigInteger('idProduit')->nullable();
            $table->unsignedBigInteger('idClient')->nullable();
            $table->foreign('idProduit')->references('idProduit')->on('produits')->onDelete('cascade');
            $table->foreign('idClient')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('avis');
    }
};

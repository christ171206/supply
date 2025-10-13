<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('idCommande');
            $table->dateTime('dateCommande')->useCurrent();
            $table->decimal('total', 10, 2)->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'livree', 'annulee'])->default('en_attente');
            $table->string('moyenPaiement', 50)->nullable();
            $table->text('adresseLivraison')->nullable();
            $table->unsignedBigInteger('idClient')->nullable();
            $table->unsignedBigInteger('idVendeur')->nullable();
            $table->foreign('idClient')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('idVendeur')->references('id')->on('vendeurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('commandes');
    }
};

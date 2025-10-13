<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produits', function (Blueprint $table) {
            $table->id('idProduit');
            $table->string('nom', 150);
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamp('dateAjout')->useCurrent();
            $table->boolean('visible')->default(true);
            $table->unsignedBigInteger('idVendeur')->nullable();
            $table->unsignedBigInteger('idCategorie')->nullable();
            $table->foreign('idVendeur')->references('id')->on('vendeurs')->onDelete('cascade');
            $table->foreign('idCategorie')->references('idCategorie')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('produits');
    }
};

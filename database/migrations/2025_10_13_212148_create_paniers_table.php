<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paniers', function (Blueprint $table) {
            $table->id('idPanier');
            $table->decimal('total', 10, 2)->default(0);
            $table->unsignedBigInteger('idClient')->nullable();
            $table->foreign('idClient')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('paniers');
    }
};

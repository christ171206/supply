<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('email', 150)->unique();
            $table->string('motDePasse');
            $table->text('adresse')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->timestamp('dateInscription')->useCurrent();
            $table->enum('role', ['client', 'vendeur', 'admin'])->default('client');
        });
    }

    public function down(): void {
        Schema::dropIfExists('utilisateurs');
    }
};

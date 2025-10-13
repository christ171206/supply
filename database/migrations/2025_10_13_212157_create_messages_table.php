<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('idMessage');
            $table->text('contenu');
            $table->dateTime('dateEnvoi')->useCurrent();
            $table->boolean('lu')->default(false);
            $table->unsignedBigInteger('expediteur_id')->nullable();
            $table->unsignedBigInteger('destinataire_id')->nullable();
            $table->foreign('expediteur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('destinataire_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};

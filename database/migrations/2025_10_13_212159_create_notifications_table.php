<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idNotification');
            $table->text('contenu');
            $table->dateTime('dateNotif')->useCurrent();
            $table->boolean('lue')->default(false);
            $table->unsignedBigInteger('idUtilisateur')->nullable();
            $table->foreign('idUtilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};

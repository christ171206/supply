<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade');
            $table->text('contenu');
            $table->foreignId('produit_id')->nullable()->constrained()->onDelete('set null');
            $table->string('piece_jointe')->nullable();
            $table->boolean('lu')->default(false);
            $table->timestamp('lu_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
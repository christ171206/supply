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
        Schema::table('paiements', function (Blueprint $table) {
            $table->unsignedBigInteger('vendeur_id')->nullable()->after('idCommande');
            $table->string('statut')->default('pending')->after('vendeur_id');
            $table->string('reference')->nullable()->after('statut');
            $table->json('details')->nullable()->after('reference');
            $table->timestamps();

            $table->foreign('vendeur_id')
                  ->references('id')
                  ->on('vendeurs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['vendeur_id']);
            $table->dropColumn(['vendeur_id', 'statut', 'reference', 'details']);
            $table->dropTimestamps();
        });
    }
};
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
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->json('settings')->nullable()->after('photoProfil');
            $table->json('boutique_settings')->nullable()->after('settings');
            $table->json('paiements_settings')->nullable()->after('boutique_settings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->dropColumn(['settings', 'boutique_settings', 'paiements_settings']);
            $table->dropTimestamps();
        });
    }
};
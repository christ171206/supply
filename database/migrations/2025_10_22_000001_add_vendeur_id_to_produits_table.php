<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->foreignId('vendeur_id')->after('idProduit')->constrained('vendeurs')->onDelete('cascade');
            $table->integer('stock_minimum')->default(5)->after('stock');
        });
    }

    public function down()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['vendeur_id']);
            $table->dropColumn('vendeur_id');
            $table->dropColumn('stock_minimum');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->string('slug')->unique()->after('nom');
            $table->string('reference')->nullable()->unique()->after('slug');
            // Ajout d'autres colonnes manquantes
            $table->timestamps();
            $table->decimal('prix_promo', 10, 2)->nullable();
            $table->timestamp('date_debut_promo')->nullable();
            $table->timestamp('date_fin_promo')->nullable();
            $table->string('dimensions')->nullable();
            $table->decimal('poids', 8, 2)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->json('caracteristiques')->nullable();
            $table->string('statut')->default('actif');
            $table->integer('seuil_alerte_stock')->default(5);
        });
    }

    public function down()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'reference',
                'created_at',
                'updated_at',
                'prix_promo',
                'date_debut_promo',
                'date_fin_promo',
                'dimensions',
                'poids',
                'meta_title',
                'meta_description',
                'caracteristiques',
                'statut',
                'seuil_alerte_stock'
            ]);
        });
    }
};
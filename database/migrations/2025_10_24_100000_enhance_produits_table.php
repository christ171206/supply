<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

return new class extends Migration
{
    public function up()
    {
        // Ajout des nouveaux champs à la table produits
        if (!Schema::hasColumn('produits', 'reference')) {
            Schema::table('produits', function (Blueprint $table) {
                // Nouveaux champs de base
                $table->string('reference')->unique()->nullable()->after('idProduit');
                $table->string('slug')->unique()->after('nom');
                $table->enum('statut', ['actif', 'inactif', 'archive'])->default('actif')->after('stock');
                $table->integer('seuil_alerte_stock')->nullable();
                
                // Champs pour promotions
                $table->decimal('prix_promo', 10, 2)->nullable();
                $table->timestamp('date_debut_promo')->nullable();
                $table->timestamp('date_fin_promo')->nullable();
                
                // Champs pour dimensions et poids
                $table->string('dimensions')->nullable();
                $table->decimal('poids', 8, 2)->nullable();
                
                // Champs pour SEO
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                
                // Caractéristiques en JSON
                $table->json('caracteristiques')->nullable();
                
                // Timestamps
                $table->timestamps();
            });
        }

        // Table pour les images supplémentaires
        if (!Schema::hasTable('produit_images')) {
            Schema::create('produit_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('produit_id');
                $table->string('chemin');
                $table->integer('ordre')->default(0);
                $table->timestamps();
                
                $table->foreign('produit_id')
                    ->references('idProduit')
                    ->on('produits')
                    ->onDelete('cascade');
            });
        }

        // Table pour les mouvements de stock
        if (!Schema::hasTable('mouvements_stock')) {
            Schema::create('mouvements_stock', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('produit_id');
                $table->enum('type', ['ajout', 'retrait']);
                $table->integer('quantite');
                $table->integer('stock_avant');
                $table->integer('stock_apres');
                $table->string('motif');
                $table->unsignedBigInteger('utilisateur_id');
                $table->timestamps();
                
                $table->foreign('produit_id')
                    ->references('idProduit')
                    ->on('produits')
                    ->onDelete('cascade');
                
                $table->foreign('utilisateur_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('mouvements_stock');
        Schema::dropIfExists('produit_images');
        
        Schema::table('produits', function (Blueprint $table) {
            $columns = [
                'reference',
                'slug',
                'statut',
                'seuil_alerte_stock',
                'prix_promo',
                'date_debut_promo',
                'date_fin_promo',
                'dimensions',
                'poids',
                'meta_title',
                'meta_description',
                'caracteristiques',
                'created_at',
                'updated_at'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('produits', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
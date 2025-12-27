<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;

try {
    // Créer un vendeur de test si nécessaire
    $vendeur = \App\Models\Utilisateur::firstOrCreate(
        ['email' => 'vendeur.test@example.com'],
        [
            'nom' => 'Vendeur Test',
            'motDePasse' => bcrypt('password123'),
            'role' => 'vendeur'
        ]
    );

    // Trouver ou créer une catégorie
    $categorie = Categorie::firstOrCreate(
        ['nom' => 'Électronique']
    );

    // Créer un produit de test
    $produit = new Produit([
        'nom' => 'Smartphone XYZ Pro',
        'description' => 'Le tout nouveau smartphone avec écran 6.5", processeur octa-core, 8GB RAM, 128GB stockage',
        'prix' => 299999.99,
        'stock' => 50,
        'idCategorie' => $categorie->idCategorie,
        'idVendeur' => $vendeur->id,
        'reference' => 'SMART-XYZ-2025',
        'statut' => 'actif',
        'seuil_alerte_stock' => 10,
        'dimensions' => '158.5 x 73.3 x 8.2 mm',
        'poids' => 189.5,
        'caracteristiques' => json_encode([
            'écran' => '6.5" AMOLED',
            'processeur' => 'Octa-core 2.5GHz',
            'ram' => '8GB',
            'stockage' => '128GB',
            'batterie' => '4500mAh'
        ])
    ]);

    $produit->save();
    
    echo "Produit créé avec succès !\n";
    echo "ID: " . $produit->idProduit . "\n";
    echo "Slug généré: " . $produit->slug . "\n";

} catch (\Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}
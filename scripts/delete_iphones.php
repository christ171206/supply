<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produit;
use Illuminate\Support\Facades\Log;

echo "Recherche des produits contenant 'iPhone'...\n";
$items = Produit::where('nom', 'like', '%iPhone%')->get();

if ($items->isEmpty()) {
    echo "Aucun produit iPhone trouvé dans la base de données.\n";
    exit(0);
}

echo "\nProduits trouvés (" . $items->count() . ") :\n";
foreach ($items as $p) {
    echo "- {$p->nom} (ID: {$p->idProduit})\n";
}

echo "\nSuppression des produits...\n";
foreach ($items as $p) {
    try {
        if (!empty($p->image)) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($p->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($p->image);
                echo "Image supprimée: {$p->image}\n";
            }
        }
        $p->delete();
        echo "Produit supprimé: {$p->nom}\n";
    } catch (\Exception $e) {
        echo "ERREUR lors de la suppression du produit {$p->idProduit}: {$e->getMessage()}\n";
    }
}

echo "\nOpération terminée.\n";
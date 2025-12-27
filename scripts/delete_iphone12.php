<?php
// Bootstrap minimal Laravel app to run Eloquent deletion outside tinker
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produit;
use Illuminate\Support\Facades\Log;

$items = Produit::where('nom', 'like', '%iPhone 12%')->get();
$found = $items->count();
if ($found === 0) {
    echo "Aucun produit trouvé correspondant à '%iPhone 12%'.\n";
    exit(0);
}

foreach ($items as $p) {
    // attempt to delete image file if stored on 'public' disk
    try {
        if (!empty($p->image)) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($p->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($p->image);
            }
        }
    } catch (\Exception $e) {
        // ignore file deletion errors but log
        Log::error('Erreur suppression image produit: ' . $e->getMessage());
    }

    try {
        $p->delete();
    } catch (\Exception $e) {
        echo "Échec suppression produit ID {$p->idProduit}: {$e->getMessage()}\n";
    }
}

echo "Suppression terminée. Produits trouvés: {$found}.\n";

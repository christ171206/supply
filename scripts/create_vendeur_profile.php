<?php

use App\Models\Vendeur;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function() {
    $user = Utilisateur::where('role', 'vendeur')->first();
    
    if (!$user) {
        // Créer un utilisateur vendeur si aucun n'existe
        $user = Utilisateur::create([
            'nom' => 'Vendeur Test',
            'email' => 'vendeur@example.com',
            'motDePasse' => bcrypt('password123'),
            'role' => 'vendeur'
        ]);
    }

    // Vérifier si le profil vendeur existe déjà
    if (!$user->vendeur) {
        $vendeur = new Vendeur();
        $vendeur->id = $user->id;
        $vendeur->statut = 'actif';
        $vendeur->statut_verification = 'en_attente';
        $vendeur->settings = $vendeur->getDefaultSettings();
        $vendeur->boutique_settings = $vendeur->getDefaultBoutiqueSettings();
        $vendeur->paiements_settings = $vendeur->getDefaultPaiementsSettings();
        $vendeur->save();

        echo "Profil vendeur créé avec succès !\n";
    } else {
        echo "Le profil vendeur existe déjà.\n";
    }
});
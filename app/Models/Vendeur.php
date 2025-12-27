<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
    use HasFactory;

    protected $table = 'vendeurs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'cni',
        'photoProfil',
        'settings',
        'boutique_settings',
        'paiements_settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'boutique_settings' => 'array',
        'paiements_settings' => 'array'
    ];

    /**
     * Obtenir les paramètres par défaut
     */
    public function getDefaultSettings(): array
    {
        return [
            'langue' => 'fr',
            'theme' => 'light',
            'timezone' => 'Africa/Abidjan',
            'notifications' => [
                'email' => true,
                'sms' => false,
                'dashboard' => true
            ]
        ];
    }

    /**
     * Obtenir les paramètres de boutique par défaut
     */
    public function getDefaultBoutiqueSettings(): array
    {
        return [
            'nom_public' => '',
            'message_bienvenue' => '',
            'visible' => false,
            'logo_path' => null,
            'logo_url' => null
        ];
    }

    /**
     * Obtenir les paramètres de paiement par défaut
     */
    public function getDefaultPaiementsSettings(): array
    {
        return [
            'moyens' => ['mtn', 'orange', 'cash'],
            'numeros' => [
                'mtn' => '',
                'orange' => ''
            ]
        ];
    }

    // 🔗 Relations
    public function utilisateur() {
        return $this->belongsTo(Utilisateur::class, 'id');
    }

    public function produits() {
        return $this->hasMany(Produit::class, 'idVendeur');
    }

    public function commandes() {
        return $this->hasMany(Commande::class, 'idVendeur');
    }

    public function paiements() {
        return $this->hasMany(Paiement::class, 'vendeur_id');
    }
}

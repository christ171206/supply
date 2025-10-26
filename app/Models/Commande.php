<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';
    protected $primaryKey = 'idCommande';

    protected $fillable = [
        'dateCommande', 'total', 'statut', 'moyenPaiement', 'adresseLivraison',
        'idClient', 'vendeur_id'
    ];

    // 🔗 Relations
    public function client() {
        return $this->belongsTo(Client::class, 'idClient');
    }

    public function vendeur() {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }

    public function lignes() {
        return $this->hasMany(LigneCommande::class, 'idCommande');
    }

    public function paiement() {
        return $this->hasOne(Paiement::class, 'idCommande');
    }
}

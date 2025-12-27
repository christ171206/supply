<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'ligne_commandes';
    protected $primaryKey = 'idLigne';
    public $timestamps = false;

    protected $fillable = [
        'quantite', 'prixUnitaire', 'idCommande', 'idProduit'
    ];

    // 🔗 Relations
    public function commande() {
        return $this->belongsTo(Commande::class, 'idCommande');
    }

    public function produit() {
        return $this->belongsTo(Produit::class, 'idProduit');
    }
}

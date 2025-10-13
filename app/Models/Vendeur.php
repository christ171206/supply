<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
    use HasFactory;

    protected $table = 'vendeurs';
    protected $primaryKey = 'id';
    public $timestamps = false;

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
}

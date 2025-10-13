<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';
    protected $primaryKey = 'idProduit';
    public $timestamps = false;

    protected $fillable = [
        'nom', 'description', 'prix', 'stock', 'image', 'idCategorie', 'idVendeur'
    ];

    public function categorie() {
        return $this->belongsTo(Categorie::class, 'idCategorie');
    }

    public function vendeur() {
        return $this->belongsTo(Vendeur::class, 'idVendeur');
    }

    public function avis() {
        return $this->hasMany(Avis::class, 'idProduit');
    }

    public function promotions() {
        return $this->hasMany(Promotion::class, 'idProduit');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'idProduit');
    }
}

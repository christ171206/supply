<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanierItem extends Model
{
    protected $table = 'panier_items';
    protected $fillable = ['idClient', 'idProduit', 'quantite'];

    // Relations
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'idProduit', 'idProduit');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'idClient', 'id');
    }
}

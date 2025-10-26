<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitImage extends Model
{
    protected $fillable = ['produit_id', 'chemin', 'ordre'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
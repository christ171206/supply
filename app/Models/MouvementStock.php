<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MouvementStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mouvements_stock';

    protected $fillable = [
        'produit_id',
        'vendeur_id',
        'type',
        'quantite',
        'stock_avant',
        'stock_apres',
        'motif'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class);
    }
}
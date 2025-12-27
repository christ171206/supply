<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fournisseur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendeur_id',
        'nom',
        'email',
        'telephone',
        'adresse',
        'ville',
        'pays',
        'contact_nom',
        'notes'
    ];

    public function vendeur()
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
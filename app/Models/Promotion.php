<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';
    protected $primaryKey = 'idPromotion';
    public $timestamps = false;

    protected $fillable = [
        'dateDebut', 'dateFin', 'prixPromo', 'active', 'idProduit'
    ];

    // 🔗 Relations
    public function produit() {
        return $this->belongsTo(Produit::class, 'idProduit');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';
    protected $primaryKey = 'idAvis';
    public $timestamps = false;

    protected $fillable = [
        'note', 'commentaire', 'visible', 'idProduit', 'idClient'
    ];

    // 🔗 Relations
    public function produit() {
        return $this->belongsTo(Produit::class, 'idProduit');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'idClient');
    }
}

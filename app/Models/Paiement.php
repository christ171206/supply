<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';
    protected $primaryKey = 'idPaiement';
    public $timestamps = true;

    protected $fillable = [
        'methodePaiement', 
        'montant', 
        'datePaiement', 
        'idCommande',
        'vendeur_id',
        'statut',
        'reference',
        'details'
    ];

    protected $casts = [
        'datePaiement' => 'datetime',
        'details' => 'array'
    ];

    protected $dates = [
        'datePaiement'
    ];

    // 🔗 Relations
    public function commande() {
        return $this->belongsTo(Commande::class, 'idCommande');
    }

    public function vendeur() {
        return $this->belongsTo(Vendeur::class, 'vendeur_id');
    }
}

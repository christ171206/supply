<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiements';
    protected $primaryKey = 'idPaiement';
    public $timestamps = false;

    protected $fillable = [
        'methodePaiement', 'montant', 'datePaiement', 'idCommande'
    ];

    // 🔗 Relations
    public function commande() {
        return $this->belongsTo(Commande::class, 'idCommande');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'idReservation';
    public $timestamps = false;

    protected $fillable = [
        'dateReservation', 'statut', 'idProduit', 'idClient'
    ];

    // 🔗 Relations
    public function produit() {
        return $this->belongsTo(Produit::class, 'idProduit');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'idClient');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // 🔗 Relations
    public function utilisateur() {
        return $this->belongsTo(Utilisateur::class, 'id');
    }

    public function commandes() {
        return $this->hasMany(Commande::class, 'idClient');
    }

    public function paniers() {
        return $this->hasMany(Panier::class, 'idClient');
    }

    public function avis() {
        return $this->hasMany(Avis::class, 'idClient');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'idClient');
    }
}


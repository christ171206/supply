<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'email',
        'motDePasse',
        'adresse',
        'telephone',
        'role'
    ];

    protected $hidden = ['motDePasse'];

    public $timestamps = false;

    // 🔗 Relations
    public function client() {
        return $this->hasOne(Client::class, 'id');
    }

    public function vendeur() {
        return $this->hasOne(Vendeur::class, 'id');
    }

    public function messagesEnvoyes() {
        return $this->hasMany(Message::class, 'expediteur_id');
    }

    public function messagesRecus() {
        return $this->hasMany(Message::class, 'destinataire_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'idUtilisateur');
    }
}

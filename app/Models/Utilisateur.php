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
        'role',
        'settings'
    ];

    protected $hidden = ['motDePasse'];

    protected $casts = [
        'settings' => 'array'
    ];

    public $timestamps = false;

    public function getSetting($key, $default = null)
    {
        if (!$this->settings) {
            return $default;
        }

        return data_get($this->settings, $key, $default);
    }

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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isVendeur(): bool
    {
        return $this->role === 'vendeur';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }
}

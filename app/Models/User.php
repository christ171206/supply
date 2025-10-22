<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
    ];

    protected $hidden = [
        'motDePasse',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false; // ✅ DÉSACTIVE created_at et updated_at

    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    public function vendeur()
    {
        return $this->hasOne(Vendeur::class, 'id');
    }
}

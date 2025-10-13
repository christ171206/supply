<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $primaryKey = 'idMessage';
    public $timestamps = false;

    protected $fillable = [
        'contenu', 'dateEnvoi', 'lu', 'expediteur_id', 'destinataire_id'
    ];

    // 🔗 Relations
    public function expediteur() {
        return $this->belongsTo(Utilisateur::class, 'expediteur_id');
    }

    public function destinataire() {
        return $this->belongsTo(Utilisateur::class, 'destinataire_id');
    }
}

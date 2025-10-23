<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'expediteur_id',
        'contenu',
        'produit_id',
        'piece_jointe',
        'lu',
        'lu_at'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'lu_at' => 'datetime'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

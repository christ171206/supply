<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'vendeur_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function dernier_message()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function messages_non_lus()
    {
        return $this->hasMany(Message::class)
            ->where('expediteur_id', '!=', auth()->id())
            ->where('lu', false);
    }

    public function getUnreadAttribute()
    {
        return $this->messages()
            ->where('expediteur_id', '!=', auth()->id())
            ->where('lu', false)
            ->exists();
    }
}
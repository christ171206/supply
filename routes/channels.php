<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Canal privé pour les vendeurs
Broadcast::channel('vendeur.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id && $user->role === 'vendeur';
});

// Canal pour les conversations
Broadcast::channel('conversation.{id}', function (User $user, $id) {
    return $user->conversations()->where('id', $id)->exists();
});

// Canal pour la messagerie
Broadcast::channel('messagerie.{conversationId}', function ($user, $conversationId) {
    return $user->conversations()->where('id', $conversationId)->exists();
});
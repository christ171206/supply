<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $notification;

    public function __construct($message, $notification)
    {
        $this->message = $message;
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        // Canal privé pour le vendeur
        return new PrivateChannel('vendeur.' . $this->message->conversation->vendeur_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'contenu' => $this->message->contenu,
                'client' => [
                    'id' => $this->message->expediteur->id,
                    'nom' => $this->message->expediteur->nom,
                    'prenom' => $this->message->expediteur->prenom,
                    'photo' => $this->message->expediteur->photo_profil,
                ],
                'conversation_id' => $this->message->conversation_id,
                'created_at' => $this->message->created_at->format('H:i'),
            ],
            'notification' => [
                'id' => $this->notification->id,
                'type' => $this->notification->type,
                'message' => "Nouveau message de {$this->message->expediteur->nom} {$this->message->expediteur->prenom}",
            ],
        ];
    }
}
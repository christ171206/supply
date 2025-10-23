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

class NouveauMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('utilisateur.' . $this->message->destinataire_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->idMessage,
                'contenu' => $this->message->contenu,
                'expediteur_id' => $this->message->expediteur_id,
                'dateEnvoi' => $this->message->dateEnvoi,
                'expediteur' => [
                    'nom' => $this->message->expediteur->nom
                ]
            ]
        ];
    }
}
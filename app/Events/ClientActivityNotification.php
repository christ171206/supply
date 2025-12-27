<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientActivityNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client_id;
    public $is_online;
    public $derniere_activite;

    public function __construct($client_id, $is_online, $derniere_activite)
    {
        $this->client_id = $client_id;
        $this->is_online = $is_online;
        $this->derniere_activite = $derniere_activite;
    }

    public function broadcastOn()
    {
        // Broadcast sur le canal public des activités des utilisateurs
        return new Channel('utilisateurs.activite');
    }

    public function broadcastAs()
    {
        return 'client.activite';
    }

    public function broadcastWith()
    {
        return [
            'client_id' => $this->client_id,
            'is_online' => $this->is_online,
            'derniere_activite' => $this->derniere_activite
        ];
    }
}
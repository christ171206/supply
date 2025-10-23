<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'content' => $message->content,
            'type' => $message->type,
            'sender_id' => $message->sender_id,
            'timestamp' => $message->created_at
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('messagerie.' . $this->message['conversation_id']);
    }
}
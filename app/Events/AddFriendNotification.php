<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\FriendRequest;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AddFriendNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\FriendRequest
     */
    public $friendRequest;

    /**
     * Create a new event instance.
     */
    public function __construct(FriendRequest $friendRequest)
    {
        $this->friendRequest = $friendRequest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('add-friend-notification.' . $this->friendRequest->receiver_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return object
     */
    public function broadcastWith()
    {
        return [
            'newFriendRequest' => $this->friendRequest::with('sender')
                ->where('sender_id', $this->friendRequest->sender_id)
                ->first(),
        ];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;
    public $errorDescription;

    /**
     * Create a new event instance.
     *
     * @param array $model
     * @param string $errorDescription
     */
    public function __construct(array $model, string $errorDescription)
    {
        $this->model = $model;
        $this->errorDescription = $errorDescription;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

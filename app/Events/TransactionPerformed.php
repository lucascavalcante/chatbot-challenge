<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TransactionPerformed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $log;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $log)
    {
        $this->log = $log;
    }

    /**
     * Log
     * 
     * @return array $log
     */
    public function log(): array
    {
        return $this->log;
    }
}

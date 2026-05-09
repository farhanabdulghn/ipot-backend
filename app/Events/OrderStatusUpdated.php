<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $orderId,
        public string $status,
        public ?int $estimatedTime = null
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel("orders.{$this->orderId}")];
    }

    public function broadcastAs(): string
    {
        return 'order.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id'       => $this->orderId,
            'status'         => $this->status,
            'estimated_time' => $this->estimatedTime,
        ];
    }
}
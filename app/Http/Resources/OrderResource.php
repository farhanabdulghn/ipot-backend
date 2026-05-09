<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'orderId'       => $this->id,
            'tableId'       => $this->table->table_code,
            'status'        => $this->status,
            'customerNote'  => $this->customer_note,
            'estimatedTime' => $this->estimated_time,
            'items'         => OrderItemResource::collection($this->items),
            'createdAt'     => $this->created_at,
        ];
    }
}
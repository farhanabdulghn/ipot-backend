<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'menuItemId'     => $this->menu_item_id,
            'name'           => $this->menuItem->name,
            'imageUrl'       => $this->menuItem->image_url,
            'quantity'       => $this->quantity,
            'unitPrice'      => (float) $this->unit_price,
            'customizations' => OrderItemCustomizationResource::collection($this->customizations),
        ];
    }
}
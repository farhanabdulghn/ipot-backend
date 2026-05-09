<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemCustomizationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'optionId'      => $this->customization_option_id,
            'name'          => $this->option->name,
            'priceModifier' => (float) $this->option->price_modifier,
            'quantity'      => $this->quantity,
        ];
    }
}
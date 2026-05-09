<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomizationOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'priceModifier' => (float) $this->price_modifier,
        ];
    }
}
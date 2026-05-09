<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomizationGroupResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'required'      => (bool) $this->required,
            'maxSelections' => $this->max_selections,
            'options'       => CustomizationOptionResource::collection($this->options),
        ];
    }
}
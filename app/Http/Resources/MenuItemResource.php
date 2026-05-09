<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'description'         => $this->description,
            'price'               => (float) $this->price,
            'categoryId'          => $this->category_id,
            'imageUrl'            => $this->image_url,
            'customizationGroups' => CustomizationGroupResource::collection($this->customizationGroups),
        ];
    }
}
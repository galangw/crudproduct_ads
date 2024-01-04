<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'assets' => $this->assets->map(function ($asset) {
                return [
                    'id' => $asset->id,
                    'url' => $asset->image,
                    'product_id' => $asset->product_id,
                ];
            }),
        ];
    }
}

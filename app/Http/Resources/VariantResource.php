<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'default_code' => $this->description,
            'price' => $this->image,
            'weight' => $this->weight,
            'article' => new ArticleResource($this->whenLoaded('article')),
        ];
    }
}

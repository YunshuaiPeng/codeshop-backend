<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'preview' => $this->preview,
            'price' => $this->price,
            'code_rows' => $this->code_rows,
            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}

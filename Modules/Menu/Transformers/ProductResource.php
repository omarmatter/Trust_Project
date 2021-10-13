<?php

namespace Modules\Menu\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'=>$this->name ,
            'price'=>$this->price,
            'description' =>$this->description,
            'category'=>$this->category->name,
            'images'=> ImageResource::collection($this->images)

        ];
    }
}

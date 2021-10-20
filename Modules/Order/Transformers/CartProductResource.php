<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Menu\Transformers\ProductResource;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return  [
          'id' =>$this->id ,
            'quantity' =>$this->quantity,
          'product' => new ProductResource($this->product),

        ];
    }
}

<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Menu\Transformers\ProductResource;

class ProductOrderResource extends JsonResource
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
       'quantity'=>$this->quantity,
       'products'=>new ProductResource($this->product)
   ];
    }
}

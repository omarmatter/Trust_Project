<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Menu\Transformers\ProductResource;

class OrderResource extends JsonResource
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
          'id'=>$this->id,
            'tax'=>$this->tax,
            'product' =>  new ProductResource($this->product),
              'quantity' =>$this->quantity,
            'price' =>$this->price,
            'payment_method'=>$this->payment_method
        ];
    }
}

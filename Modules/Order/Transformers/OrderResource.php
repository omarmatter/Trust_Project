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
            'price' =>$this->price,
            'status' =>$this->status,
            'payment_method'=>$this->order_method->order_method,
            'order_product'=>ProductOrderResource::collection( $this->order_product),

        ];
    }
}

<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Menu\Transformers\ProductResource;
use Modules\Order\Entities\CartProduct;

class cartResource extends JsonResource
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
            'id' =>$this->id ,
            'count'=>$this->cart_products_count,

            'product'=>TestResource::collection($this->cart_products) ,

//              'p'=>$this->cart_products->product
            ];
    }
}

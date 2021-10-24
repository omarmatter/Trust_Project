<?php

namespace Modules\Menu\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Entities\CartProduct;

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
            'id' => $this->id,
            'name'=>$this->name ,
            'price'=>$this->price,
            'description' =>$this->description,
            'category'=>$this->category->name,
            'inCart' => $this->cart_products_count > 0,
            'quantity' => $this->cart_products_count ?? 0,
            'images'=> ImageResource::collection($this->images)

        ];
    }
}

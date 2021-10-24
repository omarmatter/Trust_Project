<?php

namespace Modules\Order\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        $this->product->dd()
;        return [
            'name' => $this->product->name,
            'price' => $this->product->price,
            'description' => $this->product->description,
            'image_url' => $this->product->image_url,
            'total' => $this->quantity * $this->product->price
        ];
    }
}

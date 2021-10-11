<?php

namespace Modules\Menu\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
         return['Products' => $this->collection,
             "paginate"=>[
                 'total' => $this->total(),
                 'count' => $this->count(),
                 'per_page' => $this->perPage(),
                 'next_page' => $this->nextPageUrl(),
                 'total_pages' => $this->lastPage()
                 ]
         ];
    }
}

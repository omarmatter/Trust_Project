<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
           return['Users' => $this->collection,
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

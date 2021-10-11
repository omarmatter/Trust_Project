<?php

namespace App\Traits ;

trait paginateTrait{


    public  function  paginate($model){

       return ['pagination' => [
            'total' => $model->total(),
            'count' => $model->count(),
            'per_page' => $model->perPage(),
            'next_page' => $model->nextPageUrl(),
            'total_pages' => $model->lastPage()
       ]
       ]
           ;

    }
}

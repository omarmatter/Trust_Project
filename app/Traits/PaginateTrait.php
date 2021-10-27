<?php

namespace App\Traits ;

trait paginateTrait{


    public  function  paginate($model){

       return  [
           'total' => $model->total(),
           'count' => $model->count(),
           'per_page' => $model->perPage(),
           'current_page' => $model->currentPage(),
           'last_page' => $model->lastPage(),
           'from' => $model->firstItem(),
           'to' => $model->lastItem(),
           'links '=>$model->links()


       ];

    }
}

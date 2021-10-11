<?php

namespace App\Traits ;
use Modules\Menu\Entities\Image;

trait ImageableTrait{

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable', 'imageable_type', 'imageable_id', 'id');
    }







}

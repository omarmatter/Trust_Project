<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image_type','image_path','product_id'];
    protected static function newFactory()
    {
        return \Modules\Menu\Database\factories\ImageFactory::new();
    }
}

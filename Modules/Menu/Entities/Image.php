<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image'];
    protected static function newFactory()
    {
        return \Modules\Menu\Database\factories\ImageFactory::new();
    }
    protected $appends = [
        'image_url',

    ];
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageUrlAttribute()
    {

        return asset('uplode/' . $this->image);

    }
}

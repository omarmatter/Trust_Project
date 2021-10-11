<?php

namespace Modules\Menu\Entities;

use App\Traits\ImageableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory , ImageableTrait;

    protected $fillable = ['name','price','category_id','description','main_image'];

    protected $appends = [
        'image_url',

    ];
    protected static function newFactory()
    {
        return \Modules\Menu\Database\factories\ProductFactory::new();
    }
//    public function scopePrice(Builder $builder, $from, $to = null )
//    {
//        $builder->where('price', '>=', $from);
//        if ($to !== null) {
//            $builder->where('price', '<=', $to);
//        }
//    }

    public function category()
    {
        return $this->belongsTo(Categorey::class,'category_id' );
    }

    public function getImageUrlAttribute()
    {

        return asset('uplode/' . $this->main_image);

    }
}

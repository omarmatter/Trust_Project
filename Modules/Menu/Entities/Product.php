<?php

namespace Modules\Menu\Entities;

use App\Traits\ImageableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory, ImageableTrait;

    protected $fillable = ['name', 'price', 'category_id', 'description', 'main_image'];

    protected $appends = [
        'image_url',

    ];

    protected static function newFactory()
    {
        return \Modules\Menu\Database\factories\ProductFactory::new();
    }

    function scopeFillter(Builder $builder, Request $request)
    {
        $this->scopePrice($builder, $request->from, $request->to);
        $this->scopeName($builder, $request->name);
        $this->scopeCategory($builder, $request->category_id);
    }

    function scopePrice(Builder $builder, $from, $to)
    {
        if ($from && $to) {
            $builder->where('price', '>=', $from)->where('price', '<', $to);
        }
    }

    function scopeName(Builder $builder, $name)
    {
        if ($name) {
            $builder->where('name', 'like', '%' . $name . '%');
        }
    }


    function scopeCategory(Builder $builder, $category_id)
    {
        if ($category_id) {
            $builder->where('category_id', request('category_id'));
        }
    }


    public function category()
    {
        return $this->belongsTo(Categorey::class, 'category_id');
    }

    public function getImageUrlAttribute()
    {
        if (stripos($this->main_image, 'http') === 0) {
            return $this->main_image;
        }
        return asset('uplode/' . $this->main_image);

    }
}

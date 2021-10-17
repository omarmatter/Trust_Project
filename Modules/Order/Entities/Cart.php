<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Entities\Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','quantity','product_id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartFactory::new();
    }

     public function product()
     {
         return $this->belongsTo(Product::class);
     }

}

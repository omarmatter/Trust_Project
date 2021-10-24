<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Entities\Product;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quantity','product_id','cart_id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartProductFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class );
    }


}

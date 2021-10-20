<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Entities\Product;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['price','quantity','product_id','order_id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderProductFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Product::class );
    }
}

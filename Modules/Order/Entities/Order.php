<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Entities\Product;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','tax','product_id','quantity','price','payment_method'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

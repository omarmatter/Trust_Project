<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Entities\Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\CartFactory::new();
    }



       public function cart_products()
       {
           return $this->hasMany(CartProduct::class,'cart_id');
       }

       public function user()
       {
           return $this->belongsTo(User::class);
       }
}

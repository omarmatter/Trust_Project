<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Modules\Menu\Entities\Product;
use Modules\User\Entities\User;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','quantity','price','method_id','status'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }
    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function order_method()
    {
        return $this->belongsTo(OrderMethod::class,'method_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class );
    }


}

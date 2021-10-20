<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderMethod extends Model
{
    use HasFactory;

    protected $fillable = ['order_method'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderMethodFactory::new();
    }
}

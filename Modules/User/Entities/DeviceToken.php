<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = ['token'];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\DeviceTokenFactory::new();
    }
}

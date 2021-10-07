<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    use HasFactory;


    public static function getValue($key, $default = null)
    {
        $config = static::find($key);
        if (!$config) {
            return $default;
        }

        return $config->value;
    }
}

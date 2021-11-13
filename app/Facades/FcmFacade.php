<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FcmFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'FcmServeice';
    }
}

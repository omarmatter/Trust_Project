<?php

namespace App\Http\Controllers;

use App\Traits\paginateTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Modules\Order\Services\Payment\Payfort;
use Modules\Order\Services\Payment\PayfortIntegration;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , paginateTrait;






}

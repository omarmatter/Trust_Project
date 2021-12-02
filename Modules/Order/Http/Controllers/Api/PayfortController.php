<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Services\Payment\PayfortIntegration;

class PayfortController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function  index(Request  $request)
    {

        $pay = new PayfortIntegration();
        return $pay->getRedirectionData($request);
    }


public  function processResponse($r){
    $pay =new PayfortIntegration();
    return $pay->processResponse(r);

}
}

<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kreait\Firebase\Auth;
use Modules\User\Http\Requests\DeviceTokenRequest;

class DeviceTokenController extends Controller
{
   public  function  store(DeviceTokenRequest $request){
       Auth::user()->deviceTokens()->create($request->validated());
   }
}

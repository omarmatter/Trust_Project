<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Modules\User\Transformers\UserCollection;

class UserController extends Controller
{
     public function index(){
        $users = User::paginate(100);

        return coustom_response(true,'All user',  new UserCollection($users),200);



     }
}

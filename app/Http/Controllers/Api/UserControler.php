<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserControler extends Controller
{
     public function index(){
        $users = User::paginate(100);

        return coustom_response(true,'All user',  new UserCollection($users),200);



     }
}

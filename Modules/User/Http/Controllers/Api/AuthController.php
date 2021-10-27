<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserRequest;

class AuthController extends Controller
{

    public function register(UserRequest $request)
    {

        $data = $request->validated();
        $data['roles'] = 2;
        $data['password'] = Hash::make($request->password);
        $user =  User::create($data);


        return coustom_response(true, 'success add User', $user);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return coustom_response(false,'Invalid username and password combination',[],401);
        }
            $token = $user->createToken('auth');
            return coustom_response(true,'login Success',['token' => $token->plainTextToken,
            'user' => $user],200);
        }



    public function logout(Request $request)
    {
        $user =   Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'data' => 'Logout successfuley'

        ], 200);
    }
}

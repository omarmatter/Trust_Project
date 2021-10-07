<?php

namespace App\Http\Controllers\Api;

use App\Events\EventNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Listeners\SendNotificationListener;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(UserRequest $request)
    {

         $request->merge(['roles'=>2]);
         $user=  User::create($request->all());
         return $this->response($user , 200);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->response('Invalid username and password combination' ,401);

        $token = $user->createToken('auth');
        return $this->response([
            'token' => $token->plainTextToken,
            'user' => $user
        ] ,200);

    }
}


    public function logout(Request $request){
  $user=   Auth::guard('sanctum')->user();
      $user->currentAccessToken()->delete();

        return response()->json([
            'data' => 'Logout successfuley'

        ], 200);
    }

}

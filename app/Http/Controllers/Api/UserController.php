<?php

namespace App\Http\Controllers\Api;

use App\Events\EventNotification;
use App\Http\Controllers\Controller;
use App\Listeners\SendNotificationListener;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| min:8',
            'gender' => 'required',
            'phone_number' => 'required'
        ]);
        if ($validator->fails()) {

            return response()->json([
                'data' =>
                $validator->errors()
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt($request->password);
        $user->gender = $request->gender;
        $user->roles = 2;
        $user->phone_number = $request->phone_number;

        $user->save();



        event(new EventNotification($user));
        return response()->json([
            'data' =>
            'Welcome ' . $user->name . ' in Application'
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);
        if ($validator->fails()) {

            return response()->json([
                'data' =>
                $validator->errors()
            ], 400);
        }


        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid username and password combination',
            ], 401);
        }
        $token = $user->createToken('auth');

        return response()->json([
            'data' => [
                'token' => $token->plainTextToken,
                'user' => $user
            ],
        ]);
    }
}

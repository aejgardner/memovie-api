<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    //
    protected $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function register(UserRequest $request)
    {
        $check_email = $this->user->where("email", $request->email)->count();
        if ($check_email > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This email already exists, please use another email'
            ], 400);
        }


        $registerComplete = $this->user::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        if ($registerComplete) {
            return $this->login($request);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->only('email', 'password'),
            [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Please enter correct login details",
            ], 400);
        }

        $jwt_token = null;

        $input = $request->only("email", "password");

        if (!$jwt_token = auth('users')->Auth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'invalid email or password'
            ]);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }
}

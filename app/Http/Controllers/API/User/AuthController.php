<?php

namespace App\Http\Controllers\API\User;

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
    public function register(UserRequest $request)
    {
        $check_email = User::where("email", $request->email)->count();
        if ($check_email > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This email already exists, please use another email'
            ], 400);
        }

        $registerComplete = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        if ($registerComplete) {
            return $this->login($request);
        }
    }

    // use custom login request
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
                "message" => "Login details incorrect",
            ], 400);
        }

        $jwt_token = null;

        $input = $request->only("email", "password");

        if (!$jwt_token = auth('users')->attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'invalid email or password'
            ]);
        }

        // get logged in user's details such as name and id
        $user = User::find(Auth::id());

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
        ]);
    }
}

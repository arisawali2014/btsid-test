<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse('Invalid credentials', 401);
            }
        } catch (JWTException $e) {
            return $this->errorResponse('Could not create token', 500);
        }
        return $this->successResponse('Success', ['token' => $token]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return $this->errorResponse('Could not create token', 500);
        }

        return $this->successResponse('Success', ['token' => $token, 'user' => $user]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
//call validator
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        //validate the user data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        //create and save user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);

        //return response with user ID
        return response()->json([
            'status' => 'success',
            'user_id' => $user->id,
            'message' => 'User created successfully'
        ], 201);

    }

    public function login(Request $request)
    {
        //validate the user data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        //attempt to log in user
        $credentials = $request->only(['username', 'password']);
        if(!$token = Auth::attempt($credentials)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password'
            ], 401);
        }

        //return response with JWT token
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => Auth::user(),
            'token' => $token
        ], 200);
    }
}

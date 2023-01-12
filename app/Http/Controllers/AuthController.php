<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    //Register User
    public function register(Request $request)
    {
        //validation of fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        //create user
        $user = User::create([
            'name'=> $attrs['name'],
            'email'=> $attrs['email'],
            'password'=> bcrypt($attrs['password'])
        ]);

        //return user and token
        $token = $user->createToken('secret')->plainTextToken;
        return response([
            'user'=> $user,
            'token' => $token
        ]);
    }
    
    //login user
    public function login(Request $request)
    {
        $input = $request->all();

        
        $validate = Validator::make($input, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response([
                'message' => $validate->errors()->first(),
            ], 400);
        }

        $user = User::where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response([
                'message' => "Your email or password is incorrect. Please try again."
            ], 401);
        }

        $token = $user->createToken('secret')->plainTextToken;


        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    //logout user

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message'=> 'logout successful',
        ], 200);
    }

    //get user details
    
    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

}

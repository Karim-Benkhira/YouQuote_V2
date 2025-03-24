<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = $request->validate([
            'name' => 'string|max:50|required',
            'email' => 'string|max:255|required',
            'password' => 'string|max:255|required'

        ]);

        $user['password'] = bcrypt($user['password']);
        
        $user = User::create($user);
        $token = $user->createToken('YourAppName')->plainTextToken;
        return response()->json(['user'=> $user,"token"=>$token],201);
    }


    public function login(Request $request){
        $user = $request->validate([
            'email' => 'string|max:255|required',
            'password' => 'string|max:255|required'

        ]);

        if(Auth::attempt($request->only('email','password'))){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' =>$user],200);
        }else{
            return response()->json(['message' => 'email ou password est incorrect']);
        }

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logged out'],200);
    }


}

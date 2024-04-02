<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken($request->token_name);

            $name_arr = explode(" ", $request->user()->name);

            if(count($name_arr) > 1){
                $initial = $name_arr[0][0].$name_arr[1][0];
            }else{
                $initial = $request->user()->name[0].$request->user()->name[1];
            }

            $request->user()->initial = strtoupper($initial);
 
            return response()->json([
                'access_token' => $token->plainTextToken,
                'user' => json_encode($request->user()),
                'message' => "Login success"
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    
    public function logout(Request $request){
        $user = $request->user();

        // Revoke the user's access tokens
        $user->tokens->each(function (PersonalAccessToken $token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logout success'], 200);
    }

    public function passwordHash(Request $request){
        try{
            $request->validate([
                'password' => ['required']
            ]);

            $hashedPassword = Hash::make($request->password);

            return response()->json([
                'hash_password' => $hashedPassword,
                'message' => "Hash success"
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function unauthorized(){
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

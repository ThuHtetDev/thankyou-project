<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use Carbon\Carbon;
use DB;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
             return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;
        // $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $output = [
            'id' => (string) $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'type' => $user->type,
            'bearToken' => $tokenResult->accessToken,
        ];
        return response()->json($output);
    }

    public function logout(Request $request){
        Auth::user()->tokens->each(function($token,$key){
            $token->delete();
        });
        return response()->json("Logged out successfully");
    }

    public function loginPage(){
        return view('layouts.login');
    }
}

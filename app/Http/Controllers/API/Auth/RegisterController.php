<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class RegisterController extends Controller
{
    public function register(Request $request){
       
        // $request->validate([
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|max:255|unique:users', 
        //     'password' => 'required|min:8', 
        // ]);
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users', 
            'password' => 'required|min:8', 
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $newUser = new User;
        $newUser->name = $request['name'];
        $newUser->email = $request['email'];
        $newUser->type  = $request['type'];
        $newUser->password = Hash::make($request['password']);
        $newUser->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
}

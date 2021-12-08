<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ];

        $user = User::create($data);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {

        $data = $request->all();

       

        if(!Auth::attempt($data)){
            return response()->json(['status' => 'erro']);
        }

        

        return response()->json([
            'token' => auth()->user()->createToken('token')->plainTextToken
        ]);

    }

    public function logout(Request $request)
    {
        //$request->user()->tokens()->delete();
        Auth::user()->tokens()->delete();

        
        return response()->json([
            'message' => 'Tokens Revoked'
        ]);
    }
}

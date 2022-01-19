<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {

        $data = [
            'name'     => $request->name,
            'password' => bcrypt($request->password),
            'email'    => $request->email
        ];

        if(!isset($data['name']) || !isset($data['email']) || !isset($data['password'])){
            return $this->error('Por favor preencha todos os campos', 400);
        }



        $user = User::create($data);

        $token = $user->createToken('token')->plainTextToken;

        //return response()->json(['token' => $token]);
        return $this->success(['token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->all();

        if(!isset($data['email']) || !isset($data['password'])){
            //return response()->json(['status' => 'erro', 'message' => 'Por favor preencha todos os campos']);
            return $this->error('Por favor preencha todos os campos', 400);
        }

        if(!Auth::attempt($data)){
            //return response()->json(['status' => 'erro', 'message' => 'E-mail ou senha incorretos']);
            return $this->error('E-mail ou senha incorretos', 400);
        }

        $userName  = Auth::user()->name;
        $emailUser = Auth::user()->email;

        $user = ['name' => $userName, 'email' => $emailUser];
        $token = auth()->user()->createToken('token')->plainTextToken;
        
        return response()->json([
            'status' => 'Success',
            'token' => $token,
            'user' => $user
        ], 200);

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

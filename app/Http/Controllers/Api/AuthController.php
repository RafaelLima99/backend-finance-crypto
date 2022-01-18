<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use App\Traits\ApiResponser;

class AuthController extends Controller
{
    use ApiResponser;

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

        if(!isset($data['email']) || !isset($data['password'])){
            return response()->json(['status' => 'erro', 'message' => 'Por favor preencha todos os campos']);
        }

        if(!Auth::attempt($data)){
            return response()->json(['status' => 'erro', 'message' => 'E-mail ou senha incorretos']);
            //return $this->error('E-mail ou senha incorretos');
        }

       $userName  = Auth::user()->name;
       $emailUser = Auth::user()->email;

       $user = ['name' => $userName, 'email' => $emailUser];

        
        return response()->json([
            'status' => 'Success',
            'token' => auth()->user()->createToken('token')->plainTextToken,
            'user' => $user
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

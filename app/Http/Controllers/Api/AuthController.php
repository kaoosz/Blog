<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $credencials = $request->only('email','password');

        if(!auth()->attempt($credencials)){
            return $this->error('credential not match', 401);
        }
        
        return $this->success([
            'user' => auth()->user()->name,
            'email' => auth()->user()->email,
            'token' => auth()->user()->createToken('api token',['server:not'])->plainTextToken
        ]);
    }
}

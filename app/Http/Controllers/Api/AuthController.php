<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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
    
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'sucess logout'
        ];
    }
    
    public function sendPasswordResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? $this->success(null,'sucess send link check your email',200)
        : $this->error('fail reset password',401);
    }
    
}

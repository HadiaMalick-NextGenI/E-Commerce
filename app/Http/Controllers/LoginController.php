<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function handleLogin(LoginUserRequest $loginUserRequest){
        try{
            $credentials = $loginUserRequest->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->route('products')->with('success', 'Login successful!');
            }
            return redirect()->back()->with('error', 'Invalid credentials');
        }catch(Exception $e){
            return redirect()->back()->with('error', "Error: {$e->getMessage()}");
        }
    }
}

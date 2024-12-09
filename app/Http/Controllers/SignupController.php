<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function showSignupForm(){
        return view('auth.signup');
    }

    public function handleSignup(StoreUserRequest $storeUserRequest){
        try{
            $validated = $storeUserRequest->validated();

            $validated['password'] = bcrypt($validated['password']);

            $user = User::create($validated);

            $user->assignRole('customer');
            
            return redirect()->route('login')
                ->with('success', 'Registration successful! You can now log in.');
        }catch(Exception $e){
            return redirect()->back()->with('error', "Error while registering: {$e->getMessage()}");
        }
    }
}

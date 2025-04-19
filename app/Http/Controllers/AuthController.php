<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();
            if($user->role === "super_admin"){
                return redirect('/dashboard');
            }elseif($user->role === "admin"){
                return redirect('/dashboard');
            }elseif($user->role === "staff"){
                return redirect('/dashboard');
            }else{
                return redirect('/login');
            }
        dd('login gagal', $request->all());
            return redirect()->back()->with('error', 'failed to login');
        }
        dd('login gagal', $request->all());

        return redirect()->back()->with('error', 'failed to login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

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
                return redirect('/users');
            }elseif($user->role === "admin"){
                return redirect('/incoming-stocks');
            }elseif($user->role === "staff"){
                return redirect('/pos-system');
            }else{
                return redirect('/login');
            }
            return redirect('/login')->with('error', 'failed to login');
        }
        dd('login gagal', $request->all());

        return redirect('/login')->with('error', 'failed to login');
    }
}

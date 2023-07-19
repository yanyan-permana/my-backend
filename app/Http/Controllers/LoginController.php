<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usr_login' => ['required'],
            'usr_password' => ['required'],
        ]);

        $credentials = $request->only('usr_login', 'usr_password');
        $credentials = [
            'usr_login' => $credentials['usr_login'],
            'password' => $credentials['usr_password'],
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Maaf, data login tidak ditemukan!',
        ])->onlyInput('email');
    }
}

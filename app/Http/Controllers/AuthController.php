<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember'); // Cek apakah user centang "Remember Me"

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // $user = Auth::user();

            // if ($user->role === 'admin') {
            //     return redirect()->route('admin.dashboard');
            // } elseif ($user->role === 'user') {
            //     return redirect()->route('user.dashboard');
            // }

            return redirect('/');
        }

        return back()->withErrors([
            'username' => 'Username or password is incorrect.',
        ])->onlyInput('username');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

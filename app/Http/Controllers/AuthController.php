<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
   

 public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // ✅ important

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin/blocks');
        } elseif ($user->role === 'user') {
            return redirect('/client'); // client dashboard
        } else {
            Auth::logout();
            return back()->with('error', 'Unauthorized role');
        }
    }

    return back()->with('error', 'Invalid credentials');
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/'); // back to login
}
}


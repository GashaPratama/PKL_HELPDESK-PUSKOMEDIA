<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    // Ambil user berdasarkan email
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);

        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('dashboard.superadmin');
            case 'customer_service':
                return redirect()->route('dashboard.customerservice');
            case 'teknisi':
                return redirect()->route('dashboard.teknisi');
            case 'customer':
                return redirect()->route('dashboard.customer');
            default:
                Auth::logout();
                return redirect('/')->withErrors(['msg' => 'Role tidak dikenali']);
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password tidak sesuai.',
    ])->withInput();
}


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

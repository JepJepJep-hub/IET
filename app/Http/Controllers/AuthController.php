<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('name', 'password');

    if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
        // Authentication passed
        return redirect('/dashboard')->with('login_success', true);
    }

    return back()->withErrors([
        'name' => 'Invalid credentials.',
    ]);
    
}
}

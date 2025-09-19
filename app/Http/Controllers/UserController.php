<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        $incomingFields = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        User::create($incomingFields);

        return 'Registered';
    }
}

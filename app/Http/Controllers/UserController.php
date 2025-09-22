<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:15' , Rule::unique('users', 'name')],
            'password' => 'required'
        ]);
        
        User::create
        ([
            'name' => $incomingFields['name'],
            'password' => bcrypt($incomingFields['password']),
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function showDashboard()
        {
            $expenses = Expense::all();
            return view('dashboard', compact('expenses'));
        }
}

<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
        {
            $expenses = Expense::all();
            $incomes = Income::all();
            return view('dashboard', compact('expenses', 'incomes')); 
        }
}

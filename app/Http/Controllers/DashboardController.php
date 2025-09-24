<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function showDashboard()
        {

            // Expenses
            $expenses = Expense::where('employee_id', Auth::id())->get();
            $expenseData = $expenses->groupBy('category')->map(fn($row) => $row->sum('amount'));

            // Incomes
            $incomes = Income::where('employee_id', Auth::id())->get();
            $incomeData = $incomes->groupBy('category')->map(fn($row) => $row->sum('amount'));

            // Use the union of categories so both datasets align
            $allCategories = $expenseData->keys()->merge($incomeData->keys())->unique();

            $expenseValues = $allCategories->map(fn($cat) => $expenseData->get($cat, 0));
            $incomeValues  = $allCategories->map(fn($cat) => $incomeData->get($cat, 0));

            return view('dashboard', [
                'labels' => $allCategories,
                'expenseValues' => $expenseValues,
                'incomeValues' => $incomeValues,
                'expenses' => $expenses,
                'incomes' => $incomes,
            ]);
            
            $expenses = Expense::all();
            $incomes = Income::all();
            return view('dashboard', compact('expenses', 'incomes', 'labels', 'data')); 
        }

        
}

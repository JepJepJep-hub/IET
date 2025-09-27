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

            if (!Auth::check()) 
            {
            return redirect()->route('homepage'); // make sure you have a route named homepage
            }

            // user is logged in, continue as normal
            $user = Auth::user();
            
            // Incomes
            $incomes = Income::where('employee_id', Auth::id())->get();
            $incomeData = $incomes->groupBy('category')->map(fn($row) => $row->sum('amount'));

            // Expenses
            $expenses = Expense::where('employee_id', Auth::id())->get();
            $expenseData = $expenses->groupBy('category')->map(fn($row) => $row->sum('amount'));

            // Use the union of categories so both datasets align
            $allCategories = $incomeData->keys()->merge($expenseData->keys())->unique();

            $incomeValues  = $allCategories->map(fn($cat) => $incomeData->get($cat, 0));
            $expenseValues = $allCategories->map(fn($cat) => $expenseData->get($cat, 0));

            $totalExpense = $expenses->sum('amount');
            $totalIncome  = $incomes->sum('amount');
            $totalRevenue = $totalIncome - $totalExpense;

            return view('dashboard', [
                'labels' => $allCategories,
                'expenseValues' => $expenseValues,
                'incomeValues' => $incomeValues,
                'expenses' => $expenses,
                'incomes' => $incomes,
                'totalExpense' => $totalExpense,
                'totalIncome'  => $totalIncome,
                'totalRevenue' => $totalRevenue,
            ]);
            
            $expenses = Expense::all();
            $incomes = Income::all();



            return view('dashboard', compact('user', 'expenses', 'incomes', 'labels', 'data', 'totalExpense', 'totalIncome', 'totalRevenue')); 
        }        
}

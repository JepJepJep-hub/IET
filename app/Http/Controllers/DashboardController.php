<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
        {

            // ✅ Make sure we actually fetch data from DB
            $expenses = Expense::where('employee_id', auth()->id())->get();

            // If no expenses yet, avoid error
            if ($expenses->isEmpty()) {
                $labels = [];
                $data   = [];
            } else {
                // Group by category and sum
                $expenseData = $expenses->groupBy('category')->map(function ($row) {
                    return $row->sum('amount');
                });

                $labels = $expenseData->keys();
                $data   = $expenseData->values();
            }

            $expenses = Expense::all();
            $incomes = Income::all();
            return view('dashboard', compact('expenses', 'incomes', 'labels', 'data')); 
        }

        
}

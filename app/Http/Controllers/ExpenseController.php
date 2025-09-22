<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{

    public function AddExpense(Request $request)
    {
        $incomingFields = $request->validate([
            'category' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'category' => $incomingFields['category'],
            'amount' => $incomingFields['amount'],
            'description' => $incomingFields['description'] ?? null,
            'employee_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Expense added successfully!');
    }
}

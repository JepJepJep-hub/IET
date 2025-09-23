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

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        // Optional: prevent users from deleting others’ data
        if ($expense->employee_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Expense deleted successfully!');
    }

    public function edit($id)
    {
    $expense = Expense::findOrFail($id);

    // Optional: restrict access
    if ($expense->employee_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense->employee_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:500',
        ]);

        $expense->update([
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense updated successfully!');
    }
}

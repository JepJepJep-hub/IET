<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function AddIncome(Request $request)
    {
        $incomingFields = $request->validate([
            'category' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Income::create([
            'category' => $incomingFields['category'],
            'amount' => $incomingFields['amount'],
            'description' => $incomingFields['description'] ?? null,
            'employee_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Income added successfully!');
    }

    public function destroy($id)
    {
    $incomes = Income::findOrFail($id);

    // Optional: prevent users from deleting others’ data
    if ($incomes->employee_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $incomes->delete();

    return redirect()->back()->with('success', 'Income deleted successfully!');
    }
}

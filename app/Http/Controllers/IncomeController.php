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
}

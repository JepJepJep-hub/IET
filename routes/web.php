<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;

Route::get('/', function () {
    return view('HomePage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
}); 

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'showDashboard']);

Route::post('/expenses/add', [ExpenseController::class, 'AddExpense'])->name('expenses.add');

Route::post('/income/add', [IncomeController::class, 'AddIncome'])->name('income.add');

//For Expense Edit and Delete
Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');

//For Income Edit and Delete
Route::delete('/income/{id}', [IncomeController::class, 'destroy'])->name('income.destroy');
Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
Route::put('/income/{id}', [IncomeController::class, 'update'])->name('income.update');
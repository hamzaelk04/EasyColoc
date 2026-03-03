<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareExpenseController extends Controller
{
    public function myExpenses()
    {
        $user = auth()->user();

        $expenses = $user->expenseShares()->with('payer')->get();

        return view('colocation', compact('expenses'));
    }
}

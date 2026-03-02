<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = auth()->user();
        $colocation = $user->colocation()->first();

        $expense = Expense::create([
            'colocation_id' => $colocation->id,
            'payer_id' => $user->id,
            'title' => $request->title,
            'amount' => $request->amount,
        ]);

        $users = $colocation->users;

        $share = $request->amount / $users->count();

        foreach ($users as $member) {
            $expense->users()->attach($member->id, [
                'amount' => $share
            ]);
        }

        return back()->with('success', 'Expense added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

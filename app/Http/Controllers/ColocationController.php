<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Invitation;
use App\Mail\ColocationInvitationMail;

class ColocationController extends Controller
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
        $name = $request->name;
        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $user = auth()->user();
        $user->colocations()->attach(
            $colocation->id,
            ['role' => 'owner']
        );

        return redirect()->route('colocation.show', $colocation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $user = auth()->user();

        $belongs = $colocation->users()->where('user_id', '=', $user->id)->exists();

        if (!$belongs) {
            abort(403);
        }

        $users = $colocation->users()->get();
        $expenses = $user->expensesShared()->with('payer')->get();

        return view('colocation', [
            'colocation' => $colocation,
            'expenses' => $expenses,
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        //
    }

    public function invite(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Only owner can invite
        // if (!auth()->user()->isOwner()) {
        //     abort(403);
        // }

        $token = Str::random(64);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => $token,
            'expires_at' => now()->addHours(24),
        ]);

        $inviteUrl = route('colocation.accept', $token);

        Mail::to($request->email)
            ->send(new ColocationInvitationMail($colocation, $inviteUrl));

        return back()->with('success', 'Invitation sent!');
    }
}

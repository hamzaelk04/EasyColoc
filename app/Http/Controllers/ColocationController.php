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
            'email' => 'required|email',
        ]);

        $user = auth()->user();

        // Only owner can invite
        if ($colocation->users()->where('user_id', $user->id)->wherePivot('role', 'Owner')->doesntExist()) {
            abort(403, 'Only the owner can invite members.');
        }

        $token = Str::random(30);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => $token,
        ]);

        $inviteUrl = route('colocation.accept', $token);

        Mail::to($request->email)->send(new ColocationInvitationMail($colocation, $inviteUrl));

        return back()->with('success', 'Invitation envoyée !');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->accepted) {
            abort(403, 'Invitation already used.');
        }

        if (!auth()->check()) {
            session(['invitation_token' => $token]);
            return redirect()->route('register');
        }

        return $this->processInvitation($invitation);
    }

    public function myColocation()
    {
        $user = auth()->user();

        // Get the colocation of the user (assuming one colocation per user)
        $colocation = $user->colocations()->first();

        if (!$colocation) {
            return redirect('/user')->with('info', 'Vous n’avez pas de colocation.');
        }

        $users = $colocation->users()->get();
        $expenses = $user->expensesShared()->with('payer')->get();

        return view('colocation', compact('colocation', 'users', 'expenses'));
    }

    protected function processInvitation($invitation)
    {
        $user = auth()->user();

        if ($user->email !== $invitation->email) {
            abort(403, 'This invitation is not for your email.');
        }

        if ($user->colocations()->exists()) {
            abort(403, 'You already belong to a colocation.');
        }

        $invitation->colocation->users()->attach($user->id, [
            'role' => 'member'
        ]);

        $invitation->update([
            'status' => 'accepted'
        ]);

        return redirect()->route('colocation.show', $invitation->colocation->id)
            ->with('success', 'You joined the colocation!');
    }
}

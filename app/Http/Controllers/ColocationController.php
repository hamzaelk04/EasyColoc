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
            ['role' => 'Owner']
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
        $expenses = $colocation->expenses()->with(['users', 'payer'])->orderBy('date', 'desc')->get();

        $role = $colocation->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot
            ->role;

        $balances = [];

        foreach ($users as $u) {
            $balances[$u->id] = 0;
        }

        foreach ($expenses as $expense) {

            $userCount = $users->count(); // all users in colocation
            if ($userCount === 0)
                continue; // safety

            $share = $expense->amount / $userCount;

            foreach ($users as $participant) { // use colocation users
                if ($participant->id == $expense->paid_by) {
                    $balances[$participant->id] += ($expense->amount - $share);
                } else {
                    $balances[$participant->id] -= $share;
                }
            }
        }

        // ----------------------------------

        $debtors = [];
        $creditors = [];
        $transactions = [];

        foreach ($balances as $userId => $amount) {
            if ($amount < 0) {
                $debtors[$userId] = abs($amount);
            } elseif ($amount > 0) {
                $creditors[$userId] = $amount;
            }
        }

        foreach ($debtors as $debtorId => $debt) {

            foreach ($creditors as $creditorId => $credit) {

                if ($debt == 0)
                    break;

                $payAmount = min($debt, $credit);

                $transactions[] = [
                    'from' => $debtorId,
                    'to' => $creditorId,
                    'amount' => round($payAmount, 2)
                ];

                $debt -= $payAmount;
                $creditors[$creditorId] -= $payAmount;
            }
        }

        return view('colocation', [
            'colocation' => $colocation,
            'expenses' => $expenses,
            'users' => $users,
            'role' => $role,
            'transactions' => $transactions
        ]);
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

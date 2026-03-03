<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'colocation_id',
        'payer_id',
        'date',
        'title',
        'amount',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
}

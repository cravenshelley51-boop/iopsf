<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function show(WithdrawalRequest $withdrawal)
    {
        // Ensure the user can only view their own withdrawals
        if ($withdrawal->user_id !== auth()->id()) {
            abort(403);
        }

        return view('withdrawals.show', compact('withdrawal'));
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function index(): View
    {
        $transactions = Transaction::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    public function approve(Transaction $transaction): RedirectResponse
    {
        $transaction->update([
            'status' => Transaction::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        $this->auditService->logTransaction('approved', [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user_id,
            'amount' => $transaction->amount,
            'type' => $transaction->type,
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction approved successfully.');
    }

    public function reject(Transaction $transaction): RedirectResponse
    {
        $transaction->update([
            'status' => Transaction::STATUS_REJECTED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        $this->auditService->logTransaction('rejected', [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user_id,
            'amount' => $transaction->amount,
            'type' => $transaction->type,
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction rejected successfully.');
    }
} 
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(
        private readonly AuditService $auditService
    ) {
    }

    public function index(): View
    {



        $transactions = Transaction::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);




        return view('client.transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        return view('client.transactions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'type' => ['required', 'string', 'in:deposit,withdrawal'],
            'payment_method' => ['required', 'string', 'in:bank_transfer,crypto'],
        ]);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        $this->auditService->logTransaction('created', [
            'transaction_id' => $transaction->id,
            'user_id' => auth()->id(),
            'amount' => $transaction->amount,
            'type' => $transaction->type,
        ]);

        return redirect()->route('client.transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction): View
    {
        $this->authorize('view', $transaction);
        return view('client.transactions.show', compact('transaction'));
    }
}
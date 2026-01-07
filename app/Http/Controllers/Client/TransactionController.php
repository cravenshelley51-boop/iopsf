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
    ) {}

    public function index(): View
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'Client/TransactionController.php:18','message'=>'Transactions index method called','data'=>['userId'=>auth()->id()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion
        
        $transactions = Transaction::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'Client/TransactionController.php:24','message'=>'Transactions retrieved','data'=>['count'=>$transactions->count()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

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
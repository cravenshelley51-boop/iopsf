<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalRequestController extends Controller
{
    public function __construct(
        private readonly AuditService $auditService
    ) {
    }

    public function myRequests()
    {
        $user = Auth::user();
        $withdrawalRequests = WithdrawalRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingWithdrawals = $withdrawalRequests->where('status', 'pending')->count();
        $totalWithdrawn = $withdrawalRequests->where('status', 'approved')->sum('amount');

        return view('withdrawal-requests.index', compact('withdrawalRequests', 'pendingWithdrawals', 'totalWithdrawn'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('withdrawal-requests.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . Auth::user()->gold_balance,
            'purpose' => 'nullable|string|max:255',
        ]);

        $withdrawalRequest = WithdrawalRequest::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        $this->auditService->logTransaction('withdrawal_requested', [
            'request_id' => $withdrawalRequest->id,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
        ]);

        return redirect()->route('withdrawal-requests.my')
            ->with('success', 'Withdrawal request submitted successfully.');
    }

    public function index()
    {
        $withdrawalRequests = WithdrawalRequest::with(['user', 'processedBy'])
            ->when(request('status'), function ($query) {
                return $query->where('status', request('status'));
            })
            ->latest()
            ->paginate(10);

        $pendingCount = WithdrawalRequest::where('status', 'pending')->count();
        $approvedCount = WithdrawalRequest::where('status', 'approved')->count();
        $rejectedCount = WithdrawalRequest::where('status', 'rejected')->count();

        return view('admin.withdrawal-requests.index', compact(
            'withdrawalRequests',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function cancel(WithdrawalRequest $withdrawalRequest)
    {
        // Ensure the user owns this request and it's still pending
        if ($withdrawalRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($withdrawalRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending requests can be cancelled.');
        }

        $withdrawalRequest->update(['status' => 'rejected', 'admin_notes' => 'Cancelled by user']);

        $this->auditService->logTransaction('withdrawal_cancelled', [
            'request_id' => $withdrawalRequest->id,
            'amount' => $withdrawalRequest->amount,
        ]);

        return redirect()->route('withdrawal-requests.my')
            ->with('success', 'Withdrawal request cancelled successfully.');
    }

    public function update(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:255',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update the withdrawal request
            $withdrawalRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            // If approved, update the user's gold balance
            if ($request->status === 'approved') {
                $user = $withdrawalRequest->user;
                $user->decrement('gold_balance', $withdrawalRequest->amount);

                // Create a gold transaction record
                $user->goldTransactions()->create([
                    'amount' => $withdrawalRequest->amount,
                    'type' => 'debit',
                    'description' => 'Withdrawal request approved',
                    'balance_after' => $user->gold_balance,
                ]);
            }

            // Commit the transaction
            DB::commit();

            $this->auditService->logTransaction('withdrawal_' . $request->status, [
                'request_id' => $withdrawalRequest->id,
                'amount' => $withdrawalRequest->amount,
                'admin_notes' => $request->admin_notes,
                'processed_by' => Auth::id(),
            ]);

            return redirect()->route('admin.withdrawal-requests.index')
                ->with('success', 'Withdrawal request updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return redirect()->route('admin.withdrawal-requests.index')
                ->with('error', 'Failed to update withdrawal request. Please try again.');
        }
    }
}

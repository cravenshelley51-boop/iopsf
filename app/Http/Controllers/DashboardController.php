<?php

namespace App\Http\Controllers;

use App\Models\GoldTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\WithdrawalRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Check if PIN needs to be changed
        if (!$user->pin_changed) {
            return redirect()->route('profile.edit')->with('warning', 'Please change your PIN code for security reasons.');
        }

        // Get user's gold balance
        $goldBalance = $user->gold_balance;

        // Get pending withdrawals count
        $pendingWithdrawals = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Get total withdrawn amount
        $totalWithdrawn = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        // Get recent activity (combine transactions and withdrawals)
        $recentActivity = collect()
            ->merge(
                GoldTransaction::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($transaction) {
                        return (object)[
                            'created_at' => $transaction->created_at,
                            'type' => 'Transaction',
                            'amount' => $transaction->amount,
                            'status' => 'completed'
                        ];
                    })
            )
            ->merge(
                WithdrawalRequest::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($withdrawal) {
                        return (object)[
                            'created_at' => $withdrawal->created_at,
                            'type' => 'Withdrawal',
                            'amount' => $withdrawal->amount,
                            'status' => $withdrawal->status
                        ];
                    })
            )
            ->sortByDesc('created_at')
            ->take(5);

        // Get all transactions (gold transactions and withdrawal requests)
        $allTransactions = collect();
        
        // Get all gold transactions
        $goldTransactions = auth()->user()->goldTransactions()
            ->latest()
            ->get()
            ->map(function ($transaction) {
                return (object)[
                    'type' => $transaction->type === 'credit' ? 'deposit' : 'withdrawal',
                    'amount' => $transaction->amount,
                    'created_at' => $transaction->created_at,
                    'status' => 'completed',
                    'description' => $transaction->type === 'credit' ? 'Gold deposit' : 'Gold withdrawal'
                ];
            });

        // Get all withdrawal requests
        $withdrawalTransactions = auth()->user()->withdrawalRequests()
            ->latest()
            ->get()
            ->map(function ($request) {
                return (object)[
                    'type' => 'withdrawal_request',
                    'amount' => $request->amount,
                    'created_at' => $request->created_at,
                    'status' => $request->status,
                    'description' => 'Withdrawal request'
                ];
            });

        // Combine all transactions and sort by date
        $allTransactions = $goldTransactions->concat($withdrawalTransactions)
            ->sortByDesc('created_at');

        // Get current page from the url
        $currentPage = request()->get('page', 1);
        
        // Items per page
        $perPage = 10;
        
        // Slice the collection to get the items to display in current page
        $currentPageItems = $allTransactions->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        // Create our paginator and pass it to our view
        $transactions = new LengthAwarePaginator(
            $currentPageItems,
            $allTransactions->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard', compact('goldBalance', 'pendingWithdrawals', 'totalWithdrawn', 'recentActivity', 'transactions'));
    }

    public function toggleBalanceVisibility(Request $request)
    {
        $user = auth()->user();
        
        // If trying to show balance, verify PIN
        if (!$user->balance_visibility) {
            $pin = $request->input('pin_code');
            
            if (!$pin || $pin !== $user->pin_code) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid PIN code'
                ]);
            }
        }
        
        // Toggle visibility
        $user->balance_visibility = !$user->balance_visibility;
        $user->save();
        
        return response()->json([
            'success' => true,
            'balance_visibility' => $user->balance_visibility
        ]);
    }
} 
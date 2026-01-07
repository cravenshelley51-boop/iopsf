<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('last_active_at', '>=', now()->subMinutes(5))->count();
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $totalGoldBalance = User::sum('gold_balance');
        $pendingWithdrawals = WithdrawalRequest::where('status', 'pending')->count();

        $recentActivities = Activity::latest()
            ->take(5)
            ->get();

        $recentWithdrawals = WithdrawalRequest::with('user')
            ->latest()
            ->take(5)
            ->get();

        $totalVaults = \App\Models\Vault::TOTAL_SYSTEM_VAULTS;
        $assignedVaults = \App\Models\Vault::where('status', 'assigned')->count();
        $availableVaults = $totalVaults - $assignedVaults;

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'newUsers' => $newUsers,
            'totalGoldBalance' => $totalGoldBalance,
            'pendingWithdrawals' => $pendingWithdrawals,
            'recentActivities' => $recentActivities,
            'recentWithdrawals' => $recentWithdrawals,
            'totalVaults' => $totalVaults,
            'availableVaults' => $availableVaults,
            'assignedVaults' => $assignedVaults
        ]);
    }
}
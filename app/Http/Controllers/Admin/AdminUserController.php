<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GoldTransaction;
use Illuminate\Http\Request;

use App\Models\Vault;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $totalUsers = User::count();
        $activeSessions = User::where('last_active_at', '>=', now()->subMinutes(5))->count();
        $storageUsed = 'Enterprise';

        return view('admin.users.index', compact('users', 'totalUsers', 'activeSessions', 'storageUsed'));
    }

    public function overview()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('last_active_at', '>=', now()->subMinutes(5))->count();
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $avgSessionTime = '24m'; // Placeholder or implement logic

        // Mock growth data for the chart
        $growthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $growthData = [10, 25, 45, 60, 85, $totalUsers];

        $recentActivities = \App\Models\Activity::with('user')->latest()->take(10)->get();

        return view('admin.users.overview', compact(
            'totalUsers',
            'activeUsers',
            'newUsers',
            'avgSessionTime',
            'growthLabels',
            'growthData',
            'recentActivities'
        ));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gold_balance' => 'required|numeric|min:0',
            'role' => 'required|in:admin,client'
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'gold_balance' => $validated['gold_balance'],
            'email_verified_at' => now(), // Auto verify admin-created accounts
        ]);

        // Assign role
        $role = \App\Models\Role::where('name', $validated['role'])->first();
        $user->roles()->attach($role);
        $user->clearCache(); // Clear cache after role assignment

        // Create initial gold transaction if balance > 0
        if ($validated['gold_balance'] > 0) {
            GoldTransaction::create([
                'user_id' => $user->id,
                'amount' => $validated['gold_balance'],
                'type' => 'credit',
                'description' => 'Initial balance',
                'balance_after' => $validated['gold_balance']
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'gold_balance' => 'required|numeric|min:0',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->gold_balance = $validated['gold_balance'];

        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Implement user deletion logic
    }

    public function deposit(User $user)
    {
        return view('admin.users.deposit', compact('user'));
    }

    public function processDeposit(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'date' => 'nullable|date',
        ]);

        // Calculate new balance
        $newBalance = $user->gold_balance + $validated['amount'];

        // Determine transaction date
        $transactionDate = $validated['date'] ?? now();

        // Create the gold transaction
        $transaction = GoldTransaction::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'type' => 'credit',
            'description' => $validated['description'],
            'balance_after' => $newBalance,
            'created_at' => $transactionDate,
            'updated_at' => $transactionDate,
        ]);

        // Update user's gold balance
        $user->increment('gold_balance', $validated['amount']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Gold deposit successful!');
    }

    /**
     * Assign vaults to a specific user.
     */
    public function assignVault(Request $request, User $user)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $quantity = $validated['quantity'];

        $availableVaults = Vault::where('status', 'available')->take($quantity)->get();

        if ($availableVaults->count() < $quantity) {
            return back()->with('error', 'Not enough available vaults. Requested: ' . $quantity . ', Available: ' . $availableVaults->count());
        }

        foreach ($availableVaults as $vault) {
            $vault->update([
                'user_id' => $user->id,
                'status' => 'assigned'
            ]);
        }

        return back()->with('success', "Successfully assigned $quantity vault(s) to user.");
    }

    /**
     * Assign a vault to all users who don't have one.
     */
    public function assignVaultToAll()
    {
        // Get all clients who don't have any vaults
        // Note: This only assigns 1 vault to users who have 0.
        // It does not top up users who already have some.
        $usersWithoutVaults = User::whereHas('roles', function ($q) {
            $q->where('name', User::ROLE_CLIENT);
        })->doesntHave('vaults')->get();

        $assignedCount = 0;

        foreach ($usersWithoutVaults as $user) {
            $vault = Vault::where('status', 'available')->first();

            if (!$vault) {
                break; // Stop if we run out of vaults
            }

            $vault->update([
                'user_id' => $user->id,
                'status' => 'assigned'
            ]);

            $assignedCount++;
        }

        if ($assignedCount === 0 && $usersWithoutVaults->count() === 0) {
            return back()->with('info', 'All clients already have vaults.');
        }

        return back()->with('success', "Assigned 1 vault each to $assignedCount users.");
    }
    /**
     * Unassign a vault from a user.
     */
    public function unassignVault(User $user, \App\Models\Vault $vault)
    {
        if ($vault->user_id !== $user->id) {
            return back()->with('error', 'This vault is not assigned to this user.');
        }

        $vault->update([
            'user_id' => null,
            'status' => 'available'
        ]);

        return back()->with('success', 'Vault successfully unassigned.');
    }
}
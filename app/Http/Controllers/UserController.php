<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(): View
    {
        $users = User::with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', Role::CLIENT);
            })
            ->latest()
            ->paginate(10);

        $totalUsers = User::whereHas('roles', function ($query) {
            $query->where('name', Role::CLIENT);
        })->count();

        $activeSessions = DB::table('sessions')->count();
        $storageUsed = $this->calculateStorageUsed();
        $recentActivities = $this->getRecentActivities();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeSessions',
            'storageUsed',
            'recentActivities'
        ));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function calculateStorageUsed()
    {
        // This is a placeholder - implement actual storage calculation
        return '25%';
    }

    private function getRecentActivities()
    {
        // This is a placeholder - implement actual activity logging
        return collect([
            (object)[
                'description' => 'System update completed',
                'created_at' => now()
            ],
            (object)[
                'description' => 'New user registered',
                'created_at' => now()->subMinutes(30)
            ]
        ]);
    }
} 
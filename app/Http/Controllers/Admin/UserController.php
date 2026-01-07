<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);
        $totalUsers = User::count();
        $activeUsers = User::where('last_login_at', '>=', now()->subDay())->count();
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $activeSessions = DB::table('sessions')->count();
        $storageUsed = '25%'; // This is a placeholder - implement actual storage calculation
        $recentActivities = \App\Models\Activity::latest()->take(5)->get();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'newUsers',
            'activeSessions',
            'storageUsed',
            'recentActivities'
        ));
    }

    public function overview(): View
    {
        $totalUsers = User::count();
        $activeUsers = User::where('last_login_at', '>=', now()->subDay())->count();
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        
        // Calculate average session time (placeholder - implement your actual session tracking)
        $avgSessionTime = '5m 30s';
        
        // Get user growth data for the last 30 days
        $growthData = [];
        $growthLabels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $growthLabels[] = $date->format('M d');
            $growthData[] = User::whereDate('created_at', $date)->count();
        }
        
        $recentActivities = \App\Models\Activity::latest()->take(5)->get();

        return view('admin.users.overview', compact(
            'totalUsers',
            'activeUsers',
            'newUsers',
            'avgSessionTime',
            'growthData',
            'growthLabels',
            'recentActivities'
        ));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:USER,ADMIN'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Attach the role to the user
        $role = Role::where('name', strtolower($validated['role']))->first();
        if ($role) {
            $user->roles()->attach($role->id);
            $user->clearCache(); // Clear cache after role assignment
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:USER,ADMIN'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
} 
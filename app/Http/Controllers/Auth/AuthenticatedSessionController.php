<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {



        $request->authenticate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            abort(500, 'User not found after authentication');
        }




        // Update last_login_at timestamp
        $user->last_login_at = now();
        $user->save();




        // Clear user cache to ensure fresh data
        Cache::forget("user.{$user->id}.roles");
        Cache::forget("user.{$user->id}.data");




        $request->session()->regenerate();




        if ($user->isAdmin()) {


            return redirect()->intended(route('admin.dashboard', absolute: false));
        }







        return redirect()->intended(route('client.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Clear user cache on logout
        if ($user) {
            Cache::forget("user.{$user->id}.roles");
            Cache::forget("user.{$user->id}.data");
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

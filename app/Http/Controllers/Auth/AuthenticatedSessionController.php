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
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'C','location'=>'AuthenticatedSessionController.php:27','message'=>'Login attempt started','data'=>['email'=>$request->input('email')],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion
        
        $request->authenticate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user) {
            abort(500, 'User not found after authentication');
        }
        
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'C','location'=>'AuthenticatedSessionController.php:36','message'=>'Authentication successful, before session regenerate','data'=>['userId'=>$user->id,'hasLastLoginAt'=>!is_null($user->last_login_at)],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        // Update last_login_at timestamp
        $user->last_login_at = now();
        $user->save();
        
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'C','location'=>'AuthenticatedSessionController.php:38','message'=>'last_login_at updated','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        // Clear user cache to ensure fresh data
        Cache::forget("user.{$user->id}.roles");
        Cache::forget("user.{$user->id}.data");
        
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'D','location'=>'AuthenticatedSessionController.php:42','message'=>'User cache cleared after login','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        $request->session()->regenerate();

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AuthenticatedSessionController.php:47','message'=>'Before isAdmin check','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        if ($user->isAdmin()) {
            // #region agent log
            file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AuthenticatedSessionController.php:50','message'=>'isAdmin check completed, user is admin','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
            // #endregion
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AuthenticatedSessionController.php:55','message'=>'isAdmin check completed, user is not admin','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'F','location'=>'AuthenticatedSessionController.php:59','message'=>'Redirecting non-admin user to client.dashboard','data'=>['intendedUrl'=>$request->session()->get('url.intended'),'redirectingTo'=>'client.dashboard'],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

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

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AdminMiddleware.php:14','message'=>'AdminMiddleware check started','data'=>['userId'=>Auth::id()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion
        
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            // #region agent log
            file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AdminMiddleware.php:16','message'=>'AdminMiddleware check failed','data'=>['isAuthenticated'=>Auth::check()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
            // #endregion
            abort(403, 'Unauthorized action. Admin access required.');
        }

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'AdminMiddleware.php:19','message'=>'AdminMiddleware check passed','data'=>['userId'=>Auth::id()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        return $next($request);
    }
} 
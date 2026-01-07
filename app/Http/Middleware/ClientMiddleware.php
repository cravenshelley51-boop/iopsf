<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'ClientMiddleware.php:13','message'=>'ClientMiddleware check started','data'=>['userId'=>$request->user()?->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion
        
        $user = $request->user();
        
        // If user is not authenticated, redirect to login instead of aborting
        if (!$user) {
            // #region agent log
            file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'ClientMiddleware.php:15','message'=>'ClientMiddleware check failed - no user','data'=>['hasUser'=>false],'timestamp'=>time()*1000])."\n", FILE_APPEND);
            // #endregion
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            
            return redirect()->route('login');
        }
        
        // Check if user is a client
        if (!$user->isClient()) {
            // #region agent log
            file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'ClientMiddleware.php:25','message'=>'ClientMiddleware check failed - not a client','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
            // #endregion
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized action. Client access required.'], 403);
            }
            
            abort(403, 'Unauthorized action. Client access required.');
        }

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A','location'=>'ClientMiddleware.php:35','message'=>'ClientMiddleware check passed','data'=>['userId'=>$user->id],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        return $next($request);
    }
} 
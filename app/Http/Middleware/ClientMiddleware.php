<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {



        $user = $request->user();

        // If user is not authenticated, redirect to login instead of aborting
        if (!$user) {



            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        // Check if user is a client
        if (!$user->isClient()) {



            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized action. Client access required.'], 403);
            }

            abort(403, 'Unauthorized action. Client access required.');
        }




        return $next($request);
    }
}
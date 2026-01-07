<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If the request expects JSON, return null to allow proper JSON error response
        if ($request->expectsJson()) {
            return null;
        }
        
        // For web requests, redirect to login
        // Store the intended URL so user can be redirected back after login
        if (!$request->session()->has('url.intended')) {
            $request->session()->put('url.intended', $request->fullUrl());
        }
        
        return route('login');
    }
} 
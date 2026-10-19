<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'supir' => redirect()->route('supir.dashboard'),
                'petinggi' => redirect()->route('petinggi.dashboard'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
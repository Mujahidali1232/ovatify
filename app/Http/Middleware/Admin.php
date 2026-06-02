<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Access denied. Admin account required.'], 403);
        }

        return redirect('/')->with('error', 'You do not have permission to access the admin panel.');
    }
}

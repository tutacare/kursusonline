<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class MergeCartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && session()->has('cart')) {
            $sessionCart = session()->get('cart');
            foreach ($sessionCart as $courseId) {
                Cart::firstOrCreate([
                    'user_id' => Auth::id(),
                    'course_id' => $courseId,
                ]);
            }
            session()->forget('cart');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class VacationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current date and time
        $currentDateTime = Carbon::now('America/New_York'); // Adjust for EDT

        // Get the vacation record
        $vacation = Vacation::where('start_date', '<=', $currentDateTime)
            ->where('end_date', '>=', $currentDateTime)
            ->first();

        // Allow access to the vacation page for everyone
        if ($request->route()->getName() == 'vacation') {
            return $next($request);
        }

        // If vacation mode is active
        if ($vacation) {
            // If the user is not authenticated or is not an admin, redirect to vacation page
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return redirect()->route('vacation');
            }
        } else {
            // If vacation is not active (end time has passed), allow access
            return $next($request);
        }

        // Proceed with the request for admin users or when vacation mode is inactive
        return $next($request);

    }
}

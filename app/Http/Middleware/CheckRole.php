<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login.show')->with('error', 'Please login first.');
        }

        $userRole = Auth::user()->role;

        //  STEP 2A: Define admin-only routes (leave approval actions)
        $adminOnlyRoutes = [
            'admin.leave.approve',
            'admin.leave.reject',
            'admin.leave.cancel-approved',
        ];

        // STEP 2B: Check if current route is admin-only
        if (in_array($request->route()->getName(), $adminOnlyRoutes)) {
            // Only ADMIN can access these routes
            if ($userRole !== 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Only Admin can approve/reject leave applications. Superadmin does not have this permission.');
            }
            return $next($request);
        }

        //  STEP 2C: For other routes, superadmin can bypass
        if ($userRole === 'superadmin') {
            return $next($request);
        }

        // Check if user has the required role
        if (!in_array($userRole, $roles)) {
            // Redirect based on user's actual role
            return match ($userRole) {
                'admin'      => redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.'),
                'staff'      => redirect()->route('staff.dashboard')->with('error', 'Unauthorized access.'),
                'part_time'  => redirect()->route('staff.dashboard')->with('error', 'Unauthorized access.'),
                'staff_ge'   => redirect()->route('staff.dashboard')->with('error', 'Unauthorized access.'),
                'intern'     => redirect()->route('intern.dashboard')->with('error', 'Unauthorized access.'),
                default      => redirect()->route('login.show')->with('error', 'Unauthorized access.'),
            };
        }

        return $next($request);
    }
}

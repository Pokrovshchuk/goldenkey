<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $userRole = $request->user()->role()->first();

        if ($userRole) {
            // Set scope as admin/moderator based on user role
            $request->request->add([
                'admin' => $userRole->role
            ]);
        }

        return $next($request);
    }

//    public function handle(Request $request, Closure $next, $role)
//    {
//        $userRole = $request->user()->hasRole($role);
//
//        if ($userRole) {
//            // Set scope as admin/moderator based on user role
//            $request->request->add([
//                'admin' => $userRole->role
//            ]);
//        }
//
//        return $next($request);
//    }
}

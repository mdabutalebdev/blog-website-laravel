<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $isAdmin = false;
        if (!empty($_SESSION['user_id'])) {
            $userModel = \App\Models\User::findById($_SESSION['user_id']);
            if ($userModel && !empty($userModel['is_admin'])) {
                $isAdmin = true;
            }
        }

        if (!$isAdmin) {
            return redirect('/');
        }

        return $next($request);
    }
}

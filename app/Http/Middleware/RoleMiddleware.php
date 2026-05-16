<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles)) {
            return $this->redirectByRole($request->user()->role);
        }

        return $next($request);
    }

    private function redirectByRole(string $role): Response
    {
        return match ($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'enseignant' => redirect()->route('enseignant.dashboard'),
            default      => redirect()->route('home'),
        };
    }
}

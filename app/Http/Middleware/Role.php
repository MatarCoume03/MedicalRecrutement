<?php

// App/Http/Middleware/Role.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role  // Supprimez "extends Middleware"
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        
        if (empty($roles) || in_array($user->type, $roles)) {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden'], 403);
    }
}

/*namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\Role as Middleware;

class Role extends Middleware
{*/
    /**
     * Vérifie que l'utilisateur a le bon rôle
     */
    /*public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // If user is not authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
    
        $user = auth()->user();
    
        // If no roles specified or user has the required role
        if (empty($roles) || in_array($user->type, $roles)) {
            return $next($request);
        }
    
        // Custom error messages per role
        $message = match($user->type) {
            'admin' => 'Réservé aux administrateurs',
            'recruteur' => 'Réservé aux recruteurs',
            default => 'Réservé aux candidats'
        };
    
        return redirect()->back()->with('error', $message);
    }
}*/
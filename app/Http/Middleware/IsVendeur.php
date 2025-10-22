<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsVendeur
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        $user = Auth::user();
        
        if (!$user || $user->role !== 'vendeur') {
            return redirect()->route('login')->with('error', 'Accès non autorisé.');
        }
        
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:utilisateurs,email'],
            'motDePasse' => ['required', 'min:6'],
            'role' => ['required', Rule::in(['client', 'vendeur'])],
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'motDePasse' => Hash::make($request->motDePasse),
            'role' => $request->role,
        ]);

        // Si c’est un vendeur → créer une entrée vendeur vide
        if ($request->role === 'vendeur') {
            Vendeur::create(['id' => $user->id]);
        }

        event(new Registered($user));
        Auth::login($user);

        // Redirection selon le rôle
        if ($user->role === 'vendeur') {
            return redirect()->route('vendeur.verification');
        }

        return redirect()->route('dashboard');
    }
}

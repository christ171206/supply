<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🔹 Affiche le formulaire d’inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // 🔹 Enregistre un nouvel utilisateur
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email',
            'motDePasse' => 'required|min:6',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'motDePasse' => Hash::make($request->motDePasse),
            'role' => 'client',
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // 🔹 Affiche le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🔹 Connecte un utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'motDePasse' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['motDePasse'], $user->motDePasse)) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    // 🔹 Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

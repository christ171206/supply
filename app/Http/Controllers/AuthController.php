<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\PasswordReset;

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
            'role' => 'required|in:client,vendeur',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'motDePasse' => Hash::make($request->motDePasse),
            'role' => $request->role,
        ]);

        Auth::login($user);

        // Rediriger vers la page de vérification si c'est un vendeur
        if ($request->role === 'vendeur') {
            return redirect()->route('vendeur.verification')
                           ->with('info', 'Veuillez compléter la vérification de votre identité pour accéder à votre compte vendeur.');
        }

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

    // Affiche le formulaire "Mot de passe oublié"
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Envoie le lien de réinitialisation
    public function sendResetLink(Request $request)
    {
        Log::info('Demande de code reçue', ['email' => $request->email]);

        try {
            $request->validate([
                'email' => 'required|email|exists:utilisateurs,email',
            ]);

            // Générer un code à 6 chiffres
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            Log::info('Code généré', ['code' => $code]);

            // Supprimer les anciens codes pour cet email
            DB::table('reset_codes')
                ->where('email', $request->email)
                ->delete();

            // Enregistrer le code avec une expiration de 15 minutes
            DB::table('reset_codes')->insert([
                'email' => $request->email,
                'code' => $code,
                'created_at' => now(),
                'expires_at' => now()->addMinutes(15),
            ]);

            Log::info('Code enregistré en base de données');

            session()->flash('email', $request->email);

            // Pour un projet académique, on affiche directement le code et stocke l'email
            session(['email' => $request->email]);
            
            return back()
                ->with('reset_code', $code)
                ->with('status', 'Voici votre code de réinitialisation (valable 15 minutes) :');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la réinitialisation', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->withErrors(['email' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }

    // Affiche le formulaire de réinitialisation
    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

        // Réinitialise le mot de passe
    public function resetPassword(Request $request)
    {
        // Validation des champs
        $request->validate([
            'code' => 'required|digits:6',
            'email' => 'required|email|exists:utilisateurs,email',
            'motDePasse' => 'required|min:6|confirmed',
        ]);

        // Vérifier le code
        $resetCode = DB::table('reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        // Si le code est invalide ou expiré
        if (!$resetCode) {
            return back()
                ->withInput($request->only('email'))
                ->with('reset_code', true) // Pour garder le formulaire de réinitialisation ouvert
                ->withErrors(['code' => 'Code invalide. Vérifiez le code et réessayez.']);
        }

        try {
            DB::beginTransaction();

            // Trouver et mettre à jour l'utilisateur
            $user = User::where('email', $request->email)->firstOrFail();
            $user->update(['motDePasse' => Hash::make($request->motDePasse)]);

            // Supprimer tous les codes de réinitialisation pour cet email
            DB::table('reset_codes')->where('email', $request->email)->delete();

            DB::commit();

            // Connecter l'utilisateur
            Auth::login($user);

            // Rediriger vers la page de succès
            return view('auth.reset-success');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('password.request')
                ->withErrors(['email' => 'Une erreur est survenue lors de la réinitialisation. Veuillez réessayer.'])
                ->withInput($request->only('email'));
        }
}
}

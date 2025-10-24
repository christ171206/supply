<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function show()
    {
        return view('vendeur.profil');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telephone' => ['required', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:1024'], // Max 1MB
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Vérifier le mot de passe actuel si un nouveau mot de passe est fourni
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.'
                ]);
            }
        }

        // Mise à jour des informations de base
        $user->nom = $validated['nom'];
        $user->email = $validated['email'];
        $user->telephone = $validated['telephone'];

        // Mise à jour du mot de passe si fourni
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // Enregistrer le nouvel avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'avatar' => $user->avatar ? Storage::url($user->avatar) : null
        ]);
    }
}
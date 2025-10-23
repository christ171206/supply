<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendeur;

class ProfileController extends Controller
{
    public function quickUpdate(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'boutique' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'telephone' => $request->telephone
        ]);

        // Mettre à jour le nom de la boutique
        $vendeur->update([
            'nom_boutique' => $request->boutique
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informations mises à jour avec succès'
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;
        
        return view('vendeur.profile', compact('vendeur'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'langue' => 'required|in:fr,en',
            'nom_boutique' => 'required|string|max:255',
            'registre_commerce' => 'nullable|string|max:50',
            'description_boutique' => 'nullable|string|max:500'
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse
        ]);

        // Mettre à jour les informations du vendeur
        $vendeur = $user->vendeur;
        $vendeur->update([
            'nom_boutique' => $request->nom_boutique,
            'registre_commerce' => $request->registre_commerce,
            'description' => $request->description_boutique
        ]);

        // Mettre à jour les paramètres
        $settings = json_decode($vendeur->settings ?? '{}', true);
        $settings['langue'] = $request->langue;
        $vendeur->settings = json_encode($settings);
        $vendeur->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();
        
        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar_path) {
            Storage::delete($user->avatar_path);
        }

        // Sauvegarder le nouvel avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update([
            'avatar_path' => $path,
            'avatar_url' => Storage::url($path)
        ]);

        return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->motDePasse)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'motDePasse' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function updateCNI(Request $request)
    {
        $request->validate([
            'cni' => 'required|image|mimes:jpeg,png,jpg|max:5120' // 5MB max
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;

        // Supprimer l'ancienne CNI s'il existe
        if ($vendeur->cni_path) {
            Storage::delete($vendeur->cni_path);
        }

        // Sauvegarder la nouvelle CNI
        $path = $request->file('cni')->store('cni', 'private');
        
        $vendeur->update([
            'cni_path' => $path,
            'statut_verification' => 'en_attente'
        ]);

        return redirect()->back()->with('success', 'CNI mise à jour avec succès. Notre équipe vérifiera votre document sous peu.');
    }

    public function deactivateAccount(Request $request)
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;

        $vendeur->update([
            'statut' => 'suspendu',
            'date_suspension' => now()
        ]);

        return redirect()->route('vendeur.dashboard')->with('success', 'Votre boutique a été temporairement suspendue.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Supprimer les fichiers
        if ($user->avatar_path) {
            Storage::delete($user->avatar_path);
        }

        if ($user->vendeur->cni_path) {
            Storage::delete($user->vendeur->cni_path);
        }

        // Supprimer le vendeur et l'utilisateur
        $user->vendeur->delete();
        $user->delete();

        Auth::logout();
        
        return redirect()->route('login')->with('success', 'Votre compte a été définitivement supprimé.');
    }

    public function logoutAllDevices(Request $request)
    {
        Auth::logoutOtherDevices($request->password);
        
        return redirect()->back()->with('success', 'Vous avez été déconnecté de tous les autres appareils.');
    }
}
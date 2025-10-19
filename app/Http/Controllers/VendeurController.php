<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VendeurController extends Controller
{
    /**
     * Affiche la page de vérification d'identité
     */
    public function showVerificationPage(): View
    {
        return view('vendeur.verification');
    }

    /**
     * Gère l'upload de la CNI
     */
    public function uploadCni(Request $request): RedirectResponse
    {
        $request->validate([
            'cni' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $path = $request->file('cni')->store('cni', 'public');

        // Mettre à jour le statut du vendeur si nécessaire
        $user = auth()->user();
        if ($user->role === 'vendeur') {
            // Logique de mise à jour du statut
        }

        // Retourner vers la même page avec un message de confirmation
        return back()->with('success', 'Votre CNI a été envoyée et sera vérifiée par l\'administrateur.');
    }
}
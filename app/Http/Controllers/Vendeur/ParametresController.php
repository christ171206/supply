<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Models\Vendeur;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ParametresController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;

        if (!$vendeur) {
            // Créer automatiquement un profil vendeur s'il n'existe pas
            $vendeur = new Vendeur();
            $vendeur->id = $user->id;
            $vendeur->settings = json_encode($vendeur->getDefaultSettings());
            $vendeur->boutique_settings = json_encode($vendeur->getDefaultBoutiqueSettings());
            $vendeur->paiements_settings = json_encode($vendeur->getDefaultPaiementsSettings());
            $vendeur->save();
        }

        $settings = json_decode($vendeur->settings ?? '{}', true) ?: $vendeur->getDefaultSettings();
        $boutique = json_decode($vendeur->boutique_settings ?? '{}', true) ?: $vendeur->getDefaultBoutiqueSettings();
        $paiements = json_decode($vendeur->paiements_settings ?? '{}', true) ?: $vendeur->getDefaultPaiementsSettings();
        
        // Récupérer les 5 derniers paiements
        $paiements_recents = Paiement::where('vendeur_id', $vendeur->id)
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();

        return view('vendeur.parametres', compact(
            'settings',
            'boutique',
            'paiements',
            'paiements_recents'
        ));
    }

    /**
     * Mettre à jour les paramètres généraux
     */
    public function updateGeneral(Request $request)
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;

        if (!$vendeur) {
            abort(404, 'Profil vendeur non trouvé');
        }
        
        $settings = [
            'langue' => $request->input('langue', 'fr'),
            'theme' => $request->input('theme', 'light'),
            'timezone' => $request->input('timezone', 'Africa/Douala'),
            'notifications' => $request->input('notifications', [])
        ];

        $vendeur->settings = json_encode($settings);
        $vendeur->save();

        return redirect()->back()->with('success', 'Paramètres généraux mis à jour avec succès.');
    }

    /**
     * Mettre à jour les paramètres de la boutique
     */
    public function updateBoutique(Request $request)
    {
        $request->validate([
            'nom_public' => 'required|string|max:255',
            'message_bienvenue' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;

        if (!$vendeur) {
            abort(404, 'Profil vendeur non trouvé');
        }
        
        $boutique = json_decode($vendeur->boutique_settings ?? '{}', true);
        $boutique = array_merge($boutique, [
            'nom_public' => $request->nom_public,
            'message_bienvenue' => $request->message_bienvenue,
            'visible' => $request->boolean('visible')
        ]);

        $vendeur->boutique_settings = json_encode($boutique);
        $vendeur->save();

        return redirect()->back()->with('success', 'Paramètres de la boutique mis à jour avec succès.');
    }

    /**
     * Mettre à jour le logo de la boutique
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;

        if (!$vendeur) {
            abort(404, 'Profil vendeur non trouvé');
        }
        $boutique = json_decode($vendeur->boutique_settings ?? '{}', true);

        // Supprimer l'ancien logo s'il existe
        if (isset($boutique['logo_path'])) {
            Storage::delete($boutique['logo_path']);
        }

        // Sauvegarder le nouveau logo
        $path = $request->file('logo')->store('boutiques/logos', 'public');
        
        $boutique['logo_path'] = $path;
        $boutique['logo_url'] = Storage::url($path);
        
        $vendeur->boutique_settings = json_encode($boutique);
        $vendeur->save();

        return redirect()->back()->with('success', 'Logo de la boutique mis à jour avec succès.');
    }

    /**
     * Mettre à jour les paramètres de paiement
     */
    public function updatePaiement(Request $request)
    {
        $request->validate([
            'moyens_paiement' => 'required|array',
            'moyens_paiement.*' => 'in:mtn,orange,cash',
            'numero_mtn' => 'nullable|string|regex:/^6[5-9][0-9]{7}$/',
            'numero_orange' => 'nullable|string|regex:/^69[0-9]{7}$/'
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;

        if (!$vendeur) {
            abort(404, 'Profil vendeur non trouvé');
        }
        
        $paiements = [
            'moyens' => $request->moyens_paiement,
            'numeros' => [
                'mtn' => $request->numero_mtn,
                'orange' => $request->numero_orange
            ]
        ];

        $vendeur->paiements_settings = json_encode($paiements);
        $vendeur->save();

        return redirect()->back()->with('success', 'Paramètres de paiement mis à jour avec succès.');
    }
}
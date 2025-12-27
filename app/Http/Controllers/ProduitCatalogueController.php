<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitCatalogueController extends Controller
{
    /**
     * Afficher tous les produits (catalogue)
     */
    public function index(Request $request)
    {
        $query = Produit::where('stock', '>', 0)
            ->with(['categorie', 'vendeur', 'images']);

        // Filtrage par catégorie
        if ($request->filled('categorie')) {
            $query->where('idCategorie', $request->categorie);
        }

        // Recherche par nom ou description
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Tri
        $tri = $request->get('tri', 'recent');
        switch($tri) {
            case 'prix-asc':
                $query->orderBy('prix');
                break;
            case 'prix-desc':
                $query->orderByDesc('prix');
                break;
            case 'ventes':
                $query->withCount('lignesCommandes')
                      ->orderByDesc('lignes_commandes_count');
                break;
            case 'note':
                // Note moyenne
                $query->withAvg('avis', 'note')
                      ->orderByDesc('avis_avg_note');
                break;
            default: // recent
                $query->orderByDesc('created_at');
        }

        $produits = $query->paginate(12);
        $categories = Categorie::all();

        return view('catalogue.index', compact('produits', 'categories'));
    }

    /**
     * Afficher les détails d'un produit
     */
    public function show($slug)
    {
        $produit = Produit::where('slug', $slug)
            ->with(['categorie', 'vendeur', 'images', 'avis.utilisateur'])
            ->firstOrFail();

        // Avis relatifs
        $avis = $produit->avis()->paginate(5);
        
        // Produits similaires
        $produitsSimilaires = Produit::where('idCategorie', $produit->idCategorie)
            ->where('idProduit', '!=', $produit->idProduit)
            ->with('images')
            ->limit(4)
            ->get();

        return view('catalogue.show', compact('produit', 'avis', 'produitsSimilaires'));
    }

    /**
     * Ajouter un avis sur un produit
     */
    public function ajouterAvis(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'note' => 'required|integer|between:1,5',
            'titre' => 'required|string|max:100',
            'contenu' => 'required|string|max:1000',
        ]);

        $produit = Produit::findOrFail($id);

        Avis::create([
            'idProduit' => $produit->idProduit,
            'idUtilisateur' => Auth::id(),
            'note' => $request->note,
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'dateAvis' => now(),
        ]);

        return back()->with('success', 'Votre avis a été ajouté avec succès!');
    }

    /**
     * Recherche AJAX
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $produits = Produit::where('stock', '>', 0)
            ->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('reference', 'like', "%$search%");
            })
            ->select('idProduit', 'nom', 'prix', 'slug')
            ->limit(10)
            ->get();

        return response()->json($produits);
    }
}

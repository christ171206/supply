<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // 🟢 Afficher tous les produits
    public function index()
    {
        $produits = Produit::with('categorie', 'vendeur')->get();
        return view('produits.index', compact('produits'));
    }

    // 🟡 Formulaire d’ajout
    public function create()
    {
        $categories = Categorie::all();
        return view('produits.create', compact('categories'));
    }

    // 🔵 Enregistrer un nouveau produit
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'idCategorie' => 'required|integer'
        ]);

        Produit::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
            'idCategorie' => $request->idCategorie,
            'idVendeur' => auth()->id() // si un vendeur est connecté
        ]);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès');
    }

    // 🔍 Afficher un produit
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produits.show', compact('produit'));
    }

    // ✏️ Formulaire d’édition
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('produits.edit', compact('produit', 'categories'));
    }

    // 🧱 Mettre à jour un produit
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->update($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit mis à jour');
    }

    // ❌ Supprimer un produit
    public function destroy($id)
    {
        Produit::destroy($id);
        return redirect()->route('produits.index')->with('success', 'Produit supprimé');
    }
}

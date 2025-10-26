<?php

namespace App\Http\Controllers\Vendeur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendeur\ProduitRequest;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::where('idVendeur', auth()->id());

        // Filtrage par catégorie
        if ($request->filled('categorie')) {
            $query->where('idCategorie', $request->categorie);
        }

        // Filtrage par statut de stock
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'rupture':
                    $query->where('stock', 0);
                    break;
                case 'faible':
                    $query->where('stock', '>', 0)
                          ->where('stock', '<=', DB::raw('COALESCE(seuil_alerte_stock, 5)'));
                    break;
                case 'normal':
                    $query->where('stock', '>', DB::raw('COALESCE(seuil_alerte_stock, 5)'));
                    break;
            }
        }

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrage par promotion
        if ($request->filled('promotion')) {
            $now = Carbon::now();
            if ($request->promotion === 'active') {
                $query->where('prix_promo', '>', 0)
                      ->where('date_debut_promo', '<=', $now)
                      ->where('date_fin_promo', '>=', $now);
            } elseif ($request->promotion === 'inactive') {
                $query->where(function($q) use ($now) {
                    $q->whereNull('prix_promo')
                      ->orWhere('date_debut_promo', '>', $now)
                      ->orWhere('date_fin_promo', '<', $now);
                });
            }
        }

        // Recherche par nom ou référence
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Tri
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        $allowedSortFields = ['nom', 'prix', 'stock', 'created_at', 'updated_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        // Pagination avec conservation des paramètres de requête
        $produits = $query->with(['categorie', 'avis'])
                         ->withCount('avis')
                         ->withAvg('avis', 'note')
                         ->paginate(12)
                         ->withQueryString();

        // Si page vide, rediriger vers la première page
        if ($produits->isEmpty() && $request->page > 1) {
            return redirect()->route('vendeur.produits');
        }

        // Statistiques
        $stats = [
            'total' => $query->count(),
            'en_rupture' => $query->where('stock', 0)->count(),
            'stock_faible' => $query->where('stock', '>', 0)
                                  ->where('stock', '<=', DB::raw('COALESCE(seuil_alerte_stock, 5)'))
                                  ->count(),
            'en_promotion' => $query->where('prix_promo', '>', 0)
                                  ->where('date_debut_promo', '<=', now())
                                  ->where('date_fin_promo', '>=', now())
                                  ->count()
        ];

        $categories = Categorie::orderBy('nom')->get();

        return view('vendeur.produits.index', compact('produits', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('vendeur.produits.create', compact('categories'));
    }

    public function store(ProduitRequest $request)
    {
        try {
            DB::beginTransaction();

            $produit = new Produit($request->validated());
            $produit->idVendeur = auth()->id();
            $produit->reference = $request->reference ?? 'PROD-' . Str::random(8);
            
            // Traitement de l'image principale
            if ($request->hasFile('image')) {
                $produit->image = $request->file('image')->store('produits', 'public');
            }

            $produit->save();

            // Traitement des images supplémentaires
            if ($request->hasFile('images_supplementaires')) {
                foreach ($request->file('images_supplementaires') as $image) {
                    $path = $image->store('produits', 'public');
                    $produit->images()->create(['chemin' => $path]);
                }
            }

            // Log d'activité
            activity()
                ->performedOn($produit)
                ->causedBy(auth()->user())
                ->withProperties(['action' => 'create'])
                ->log('Nouveau produit créé');

            DB::commit();

            return redirect()
                ->route('vendeur.produits.show', $produit)
                ->with('success', 'Produit créé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du produit: ' . $e->getMessage());
        }
    }

    public function show(Produit $produit)
    {
        $this->authorize('view', $produit);

        $produit->load([
            'categorie',
            'avis.client',
            'images',
            'ligneCommandes.commande' => function($query) {
                $query->latest()->take(5);
            }
        ]);

        // Statistiques du produit
        $stats = [
            'total_ventes' => $produit->ligneCommandes->sum('quantite'),
            'chiffre_affaires' => $produit->ligneCommandes->sum(function($ligne) {
                return $ligne->quantite * $ligne->prix_unitaire;
            }),
            'note_moyenne' => $produit->avis->avg('note') ?? 0,
            'nombre_avis' => $produit->avis->count(),
            'ventes_30_jours' => $produit->ligneCommandes
                ->where('created_at', '>=', now()->subDays(30))
                ->sum('quantite')
        ];

        return view('vendeur.produits.show', compact('produit', 'stats'));
    }

    public function edit(Produit $produit)
    {
        $this->authorize('update', $produit);

        $categories = Categorie::orderBy('nom')->get();
        $produit->load('images');

        return view('vendeur.produits.edit', compact('produit', 'categories'));
    }

    public function update(ProduitRequest $request, Produit $produit)
    {
        $this->authorize('update', $produit);

        try {
            DB::beginTransaction();

            $oldImage = $produit->image;
            
            // Mise à jour des champs
            $produit->fill($request->validated());

            // Traitement de l'image principale si nouvelle
            if ($request->hasFile('image')) {
                $produit->image = $request->file('image')->store('produits', 'public');
                // Suppression de l'ancienne image
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $produit->save();

            // Traitement des images supplémentaires
            if ($request->hasFile('images_supplementaires')) {
                foreach ($request->file('images_supplementaires') as $image) {
                    $path = $image->store('produits', 'public');
                    $produit->images()->create(['chemin' => $path]);
                }
            }

            // Suppression des images sélectionnées
            if ($request->has('images_a_supprimer')) {
                $produit->images()
                    ->whereIn('id', $request->images_a_supprimer)
                    ->get()
                    ->each(function($image) {
                        Storage::disk('public')->delete($image->chemin);
                        $image->delete();
                    });
            }

            // Log d'activité
            activity()
                ->performedOn($produit)
                ->causedBy(auth()->user())
                ->withProperties(['action' => 'update'])
                ->log('Produit mis à jour');

            DB::commit();

            return redirect()
                ->route('vendeur.produits.show', $produit)
                ->with('success', 'Produit mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour du produit: ' . $e->getMessage());
        }
    }

    public function destroy(Produit $produit)
    {
        $this->authorize('delete', $produit);

        try {
            DB::beginTransaction();

            // Vérifier si le produit a des commandes en cours
            if ($produit->ligneCommandes()
                ->whereHas('commande', function($query) {
                    $query->whereIn('statut', ['en_attente', 'en_cours', 'validee']);
                })
                ->exists()) {
                throw new \Exception('Impossible de supprimer un produit ayant des commandes en cours');
            }

            // Supprimer l'image principale
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }

            // Supprimer les images supplémentaires
            $produit->images->each(function($image) {
                Storage::disk('public')->delete($image->chemin);
                $image->delete();
            });

            // Log avant suppression
            activity()
                ->performedOn($produit)
                ->causedBy(auth()->user())
                ->withProperties(['action' => 'delete'])
                ->log('Produit supprimé');

            $produit->delete();

            DB::commit();

            return redirect()
                ->route('vendeur.produits')
                ->with('success', 'Produit supprimé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStock(Request $request, Produit $produit)
    {
        $this->authorize('update', $produit);

        $request->validate([
            'quantite' => 'required|integer',
            'type' => 'required|in:ajout,retrait',
            'motif' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $ancienStock = $produit->stock;
            
            if ($request->type === 'ajout') {
                $produit->stock += $request->quantite;
            } else {
                if ($produit->stock < $request->quantite) {
                    throw new \Exception('Stock insuffisant pour ce retrait');
                }
                $produit->stock -= $request->quantite;
            }

            $produit->save();

            // Enregistrer le mouvement de stock
            $produit->mouvementsStock()->create([
                'type' => $request->type,
                'quantite' => $request->quantite,
                'stock_avant' => $ancienStock,
                'stock_apres' => $produit->stock,
                'motif' => $request->motif,
                'utilisateur_id' => auth()->id()
            ]);

            DB::commit();

            return back()->with('success', 'Stock mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportProduits(Request $request)
    {
        $produits = Produit::where('idVendeur', auth()->id())
            ->with(['categorie'])
            ->get()
            ->map(function($produit) {
                return [
                    'Référence' => $produit->reference,
                    'Nom' => $produit->nom,
                    'Catégorie' => $produit->categorie->nom,
                    'Prix' => $produit->prix,
                    'Stock' => $produit->stock,
                    'Statut' => $produit->statut,
                    'Date création' => $produit->created_at->format('d/m/Y'),
                    'Dernière modification' => $produit->updated_at->format('d/m/Y')
                ];
            });

        return response()->streamDownload(function() use ($produits) {
            $csv = fopen('php://output', 'w');
            // BOM UTF-8
            fprintf($csv, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // En-têtes
            fputcsv($csv, array_keys($produits->first() ?? []));
            
            // Données
            foreach ($produits as $produit) {
                fputcsv($csv, $produit);
            }
            
            fclose($csv);
        }, 'produits-' . now()->format('Y-m-d') . '.csv');
    }
}
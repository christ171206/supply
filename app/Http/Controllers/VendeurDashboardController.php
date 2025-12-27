<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VendeurDashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendeur = Auth::user();

        // Gestion des périodes pour les statistiques
        $periode = $request->input('statsPeriode', 'today');
        $startDate = match($periode) {
            'today' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfDay(),
        };

        // Récupérer les statistiques
        $stats = [
            'chiffre_affaires' => $this->getChiffreAffaires($startDate),
            'total_commandes' => $this->getTotalCommandes($startDate),
            'total_produits' => $this->getTotalProduits(),
            'produits_rupture' => $this->getProduitsEnRupture()
        ];

        // Récupérer les messages récents
        $messages_recents = \App\Models\Message::whereHas('conversation', function($query) use ($vendeur) {
            $query->whereHas('vendeur', function($q) use ($vendeur) {
                $q->where('id', $vendeur->id);
            });
        })
        ->with(['expediteur', 'conversation'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        // Récupérer les dernières commandes
        $dernieres_commandes = Commande::where('idVendeur', $vendeur->id)
            ->with(['client', 'lignes.produit'])
            ->orderBy('dateCommande', 'desc')
            ->take(5)
            ->get();

        // Récupérer les produits en rupture de stock
        $produits_rupture = Produit::where('vendeur_id', $vendeur->id)
            ->where('stock', '<', 5)
            ->get();

        // Récupérer les meilleures ventes
        $meilleures_ventes = $this->getMeilleuresVentes();

        // Données pour les graphiques
    $salesChart = $this->getSalesChartData(now()->subDays(7), now());

    return view('vendeur.dashboard', compact(
            'stats',
            'dernieres_commandes',
            'produits_rupture',
            'meilleures_ventes',
            'messages_recents',
            'salesChart'
        ));
    }

    private function getChiffreAffaires($startDate = null)
    {
        $query = Paiement::whereHas('commande', function($query) {
            $query->where('idVendeur', Auth::id());
        });

        if ($startDate) {
            $query->where('datePaiement', '>=', $startDate);
        }

        return $query->sum('montant');
    }

    private function getTotalCommandes($startDate = null)
    {
        $query = Commande::where('idVendeur', Auth::id());

        if ($startDate) {
            $query->where('dateCommande', '>=', $startDate);
        }

        return $query->count();
    }

    private function getTotalProduits()
    {
        return Produit::where('vendeur_id', Auth::id())->count();
    }

    private function getProduitsEnRupture()
    {
        return Produit::where('vendeur_id', Auth::id())
            ->where('stock', '<', 5)
            ->count();
    }

    private function getMeilleuresVentes()
    {
        return LigneCommande::with('produit')
            ->whereHas('commande', function($query) {
                $query->where('idVendeur', Auth::id());
            })
            ->selectRaw('idProduit, SUM(quantite) as total_vendu')
            ->groupBy('idProduit')
            ->orderByDesc('total_vendu')
            ->take(3)
            ->get();
    }

    public function produits(Request $request)
    {
        $query = Produit::where('vendeur_id', Auth::id())->with('categorie');

        // Filtrage par catégorie
        if ($request->filled('categorie')) {
            $query->where('idCategorie', $request->categorie);
        }

        // Filtrage par stock
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'rupture':
                    $query->where('stock', 0);
                    break;
                case 'faible':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'normal':
                    $query->where('stock', '>', 5);
                    break;
            }
        }

        // Recherche par nom ou référence
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%');
            });
        }

        // Tri
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        
        switch ($sortField) {
            case 'nom':
            case 'prix':
            case 'stock':
                $query->orderBy($sortField, $sortDirection);
                break;
            case 'dateAjout':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        // Limiter à 10 produits par page et préserver les paramètres de requête
        $produits = $query->paginate(10)->withQueryString();
        
        // Récupérer toutes les catégories pour le filtre
        $categories = \App\Models\Categorie::all();

        // Statistiques des produits
        $stats = [
            'total' => Produit::where('vendeur_id', Auth::id())->count(),
            'en_rupture' => Produit::where('vendeur_id', Auth::id())->where('stock', 0)->count(),
            'stock_faible' => Produit::where('vendeur_id', Auth::id())->where('stock', '>', 0)->where('stock', '<=', 5)->count(),
        ];

        // Si aucun produit n'est trouvé, réinitialiser la pagination à la page 1
        if ($produits->isEmpty() && $request->page > 1) {
            return redirect()->route('vendeur.produits');
        }

        return view('vendeur.produits', compact('produits', 'categories', 'stats'));
    }

    public function createProduit()
    {
        $categories = \App\Models\Categorie::orderBy('nom')->get();
        return view('vendeur.produits.create', compact('categories'));
    }

    public function storeProduit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'idCategorie' => 'required|exists:categories,idCategorie',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reference' => 'nullable|string|unique:produits,reference',
            'poids' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'slug' => 'nullable|string|unique:produits,slug'
        ], [
            'nom.required' => 'Le nom du produit est requis',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'description.required' => 'La description est requise',
            'prix.required' => 'Le prix est requis',
            'prix.numeric' => 'Le prix doit être un nombre',
            'prix.min' => 'Le prix doit être positif',
            'stock.required' => 'Le stock est requis',
            'stock.integer' => 'Le stock doit être un nombre entier',
            'stock.min' => 'Le stock doit être positif',
            'idCategorie.required' => 'La catégorie est requise',
            'idCategorie.exists' => 'Cette catégorie n\'existe pas',
            'image.required' => 'L\'image est requise',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou GIF',
            'image.max' => 'L\'image ne doit pas dépasser 2MB',
            'reference.unique' => 'Cette référence existe déjà',
            'poids.numeric' => 'Le poids doit être un nombre',
            'poids.min' => 'Le poids doit être positif'
        ]);

        // Traiter l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        // Ajouter l'ID du vendeur et autres champs nécessaires
        $validated['vendeur_id'] = Auth::id();
        
        // Générer un slug unique
        $baseSlug = Str::slug($validated['nom']);
        $counter = 1;
        $slug = $baseSlug;
        
        while (Produit::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        
        if (empty($validated['reference'])) {
            $validated['reference'] = 'PROD-' . uniqid();
        }

        // Créer le produit
        $produit = Produit::create($validated);

        return redirect()
            ->route('vendeur.produits.show', $produit)
            ->with('success', 'Produit créé avec succès');
    }

    public function showProduit(Produit $produit)
    {
        $this->authorizeProduct($produit);

        // Charger les relations nécessaires
        $produit->load(['categorie', 'avis', 'lignes.commande']);

        // Calculer les statistiques
        $stats = [
            'total_ventes' => $produit->lignes->sum('quantite'),
            'chiffre_affaires' => $produit->lignes->sum(function($ligne) {
                return $ligne->quantite * $ligne->prixUnitaire;
            }),
            'note_moyenne' => $produit->avis->avg('note') ?? 0,
            'nombre_avis' => $produit->avis->count()
        ];

        return view('vendeur.produits.show', compact('produit', 'stats'));
    }

    public function editProduit(Produit $produit)
    {
        $this->authorizeProduct($produit);
        $categories = \App\Models\Categorie::all();
        return view('vendeur.produits.edit', compact('produit', 'categories'));
    }

    public function updateProduit(Request $request, Produit $produit)
    {
        $this->authorizeProduct($produit);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'idCategorie' => 'required|exists:categories,idCategorie',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'reference' => 'nullable|string|unique:produits,reference,' . $produit->idProduit . ',idProduit',
            'poids' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'caracteristiques' => 'nullable|array'
        ]);

        // Traiter la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $validated['image'] = $request->file('image')->store('produits', 'public');
        }

        // Mettre à jour le produit
        $produit->update($validated);

        return redirect()
            ->route('vendeur.produits.show', $produit)
            ->with('success', 'Produit mis à jour avec succès');
    }

    public function deleteProduit(Produit $produit)
    {
        $this->authorizeProduct($produit);

        // Vérifier si le produit a des commandes en cours
        if ($produit->lignes()->whereHas('commande', function($query) {
            $query->whereIn('statut', ['en_cours', 'en_preparation']);
        })->exists()) {
            return back()->with('error', 'Impossible de supprimer un produit ayant des commandes en cours');
        }

        // Supprimer l'image
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()
            ->route('vendeur.produits')
            ->with('success', 'Produit supprimé avec succès');
    }

    private function authorizeProduct(Produit $produit)
    {
        if ($produit->vendeur_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à ce produit');
        }
    }

    public function commandes()
    {
        $commandes = Commande::where('idVendeur', Auth::id())
            ->with(['client', 'lignes.produit'])
            ->orderBy('dateCommande', 'desc')
            ->paginate(10);

        return view('vendeur.commandes', compact('commandes'));
    }

    // Gestion des stocks
    public function stock()
    {
        $produits = Produit::where('vendeur_id', Auth::id())
            ->orderBy('stock')
            ->paginate(10);

        $categories = \App\Models\Categorie::all();

        return view('vendeur.stock', compact('produits', 'categories'));
    }

    public function ajusterStock(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite' => 'required|integer',
            'type' => 'required|in:entree,sortie'
        ]);

        $ancien_stock = $produit->stock;

        if ($request->type === 'entree') {
            $produit->stock += $request->quantite;
        } else {
            if ($produit->stock < $request->quantite) {
                return back()->with('error', 'Stock insuffisant');
            }
            $produit->stock -= $request->quantite;
        }

        $produit->save();

        return back()->with('success', 'Stock ajusté avec succès');
    }

    // Gestion des fournisseurs
    public function fournisseurs()
    {
        return view('vendeur.fournisseurs');
    }

    // Gestion des paiements
    public function paiements()
    {
        $paiements = Paiement::whereHas('commande', function($query) {
            $query->where('idVendeur', Auth::id());
        })->paginate(10);

        return view('vendeur.paiements', compact('paiements'));
    }

    // Profil vendeur
    public function profile()
    {
        return view('vendeur.profile');
    }

    // Paramètres
    public function parametres()
    {
        return view('vendeur.parametres');
    }

    public function updateParametres(Request $request)
    {
        $request->validate([
            'notifications' => 'array',
            'seuil_stock' => 'required|integer|min:1',
            'devise' => 'required|in:EUR,USD,GBP',
            'langue' => 'required|in:fr,en'
        ]);

        $user = Auth::user();

        // Mise à jour des paramètres
        $user->settings = array_merge($user->settings ?? [], [
            'notifications' => $request->notifications ?? [],
            'seuil_stock' => $request->seuil_stock,
            'devise' => $request->devise,
            'langue' => $request->langue
        ]);

        $user->save();

        return back()->with('success', 'Paramètres mis à jour avec succès');
    }

    // Page des rapports
    private function getStartDate($periode, $dateDebut = null, $dateFin = null)
    {
        return match($periode) {
            'last7' => now()->subDays(7)->startOfDay(),
            'last30' => now()->subDays(30)->startOfDay(),
            'last90' => now()->subDays(90)->startOfDay(),
            'thisYear' => now()->startOfYear(),
            'lastYear' => now()->subYear()->startOfYear(),
            'custom' => $dateDebut ? Carbon::parse($dateDebut)->startOfDay() : now()->subDays(30)->startOfDay(),
            default => now()->subDays(30)->startOfDay(),
        };
    }

    private function getEndDate($periode, $dateDebut = null, $dateFin = null)
    {
        return match($periode) {
            'custom' => $dateFin ? Carbon::parse($dateFin)->endOfDay() : now(),
            'lastYear' => now()->subYear()->endOfYear(),
            default => now(),
        };
    }

    public function rapports(Request $request)
    {
        $startDate = $this->getStartDate(
            $request->input('periode', 'last30'),
            $request->input('date_debut'),
            $request->input('date_fin')
        );

        $endDate = $this->getEndDate(
            $request->input('periode', 'last30'),
            $request->input('date_debut'),
            $request->input('date_fin')
        );

        $chiffreAffaires = $this->getChiffreAffairesPeriode($startDate, $endDate);
        $nombreCommandes = $this->getNombreCommandesPeriode($startDate, $endDate);
        $produitsVendus = $this->getProduitsVendusPeriode($startDate, $endDate);
        $panierMoyen = $nombreCommandes > 0 ? $chiffreAffaires / $nombreCommandes : 0;

        // Données pour les graphiques
        $salesChart = $this->getSalesChartData($startDate, $endDate);
        $categoriesChart = $this->getCategoriesChartData($startDate, $endDate);

        // Meilleurs vendeurs
        $meilleursVendeurs = $this->getMeilleursVendeurs($startDate);

        // Récupérer toutes les catégories pour le filtre
        $categories = \App\Models\Categorie::all();

        return view('vendeur.rapports', compact(
            'chiffreAffaires',
            'nombreCommandes',
            'produitsVendus',
            'panierMoyen',
            'salesChart',
            'categoriesChart',
            'meilleursVendeurs',
            'categories'
        ));
    }

    private function getChiffreAffairesPeriode($startDate, $endDate)
    {
        return Paiement::whereHas('commande', function($query) {
                $query->where('idVendeur', Auth::id());
            })
            ->whereBetween('datePaiement', [$startDate, $endDate])
            ->sum('montant');
    }

    private function getNombreCommandesPeriode($startDate, $endDate)
    {
        return Commande::where('idVendeur', Auth::id())
            ->whereBetween('dateCommande', [$startDate, $endDate])
            ->count();
    }

    private function getProduitsVendusPeriode($startDate, $endDate)
    {
        return LigneCommande::whereHas('commande', function($query) use ($startDate, $endDate) {
                $query->where('idVendeur', Auth::id())
                    ->whereBetween('dateCommande', [$startDate, $endDate]);
            })
            ->sum('quantite');
    }

    private function getSalesChartData($startDate, $endDate)
    {
        // Validation des dates
        if (!$startDate) {
            $startDate = now()->subDays(30);
        }
        if (!$endDate) {
            $endDate = now();
        }

        $ventes = Commande::where('idVendeur', Auth::id())
            ->where('dateCommande', '>=', $startDate)
            ->where('dateCommande', '<=', $endDate)
            ->selectRaw('DATE(dateCommande) as date, COUNT(*) as total, SUM(total) as montant')
            ->groupBy('date')
            ->get();

        $dates = collect();
        for($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        // Préparer les données pour le graphique
        return [
            'labels' => $dates->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray(),
            'data' => $dates->map(function($date) use ($ventes) {
                $vente = $ventes->firstWhere('date', $date);
                return $vente ? ($vente->montant ?? 0) : 0;
            })->toArray()
        ];
    }

    private function getCategoriesChartData($startDate, $endDate = null)
    {
        if (!$endDate) {
            $endDate = now();
        }
        $ventes_categories = LigneCommande::whereHas('commande', function($query) use ($startDate) {
                $query->where('idVendeur', Auth::id())
                    ->where('dateCommande', '>=', $startDate);
            })
            ->whereHas('produit.categorie')
            ->with('produit.categorie')
            ->get()
            ->groupBy('produit.categorie.nom')
            ->map(function($ventes) {
                return $ventes->sum('prix_total');
            });

        return [
            'labels' => $ventes_categories->keys()->toArray(),
            'data' => $ventes_categories->values()->toArray()
        ];
    }

    private function getMeilleursVendeurs($startDate)
    {
        return Produit::from('produits')
            ->where('produits.vendeur_id', Auth::id())
            ->join('ligne_commandes', function($join) {
                $join->on('produits.idProduit', '=', 'ligne_commandes.idProduit');
            })
            ->join('commandes', function($join) {
                $join->on('ligne_commandes.idCommande', '=', 'commandes.idCommande');
            })
            ->where('commandes.dateCommande', '>=', $startDate)
            ->with('categorie')
            ->groupBy('produits.idProduit')
            ->selectRaw('produits.*,
                COUNT(ligne_commandes.idProduit) as total_ventes,
                SUM(ligne_commandes.quantite * ligne_commandes.prixUnitaire) as chiffre_affaires
            ')
            ->orderByRaw('COUNT(ligne_commandes.idProduit) DESC')
            ->take(10)
            ->get()
            ->map(function($produit) {
                $produit->evolution = rand(-20, 50); // Simulation de l'évolution
                return $produit;
            });
    }
}

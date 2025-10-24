<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VendeurDashboardController extends Controller
{
    public function index()
    {
        $vendeur = Auth::user();

        // Récupérer les statistiques
        $stats = [
            'chiffre_affaires' => $this->getChiffreAffaires(),
            'total_commandes' => $this->getTotalCommandes(),
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
        $produits_rupture = Produit::where('idVendeur', $vendeur->id)
            ->where('stock', '<', 5)
            ->get();

        // Récupérer les meilleures ventes
        $meilleures_ventes = $this->getMeilleuresVentes();

        return view('vendeur.dashboard', compact(
            'stats',
            'dernieres_commandes',
            'produits_rupture',
            'meilleures_ventes',
            'messages_recents'
        ));
    }

    private function getChiffreAffaires()
    {
        $debut_mois = Carbon::now()->startOfMonth();
        return Paiement::whereHas('commande', function($query) {
            $query->where('idVendeur', Auth::id());
        })
        ->where('datePaiement', '>=', $debut_mois)
        ->sum('montant');
    }

    private function getTotalCommandes()
    {
        return Commande::where('idVendeur', Auth::id())
            ->where('dateCommande', '>=', Carbon::now()->startOfMonth())
            ->count();
    }

    private function getTotalProduits()
    {
        return Produit::where('idVendeur', Auth::id())->count();
    }

    private function getProduitsEnRupture()
    {
        return Produit::where('idVendeur', Auth::id())
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
        $query = Produit::where('idVendeur', Auth::id());

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
        $sortField = $request->input('sort', 'dateAjout');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $produits = $query->paginate(10)->withQueryString();
        $categories = \App\Models\Categorie::all();

        return view('vendeur.produits', compact('produits', 'categories'));
    }

    public function createProduit()
    {
        $categories = \App\Models\Categorie::all();
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
            'caracteristiques' => 'nullable|array'
        ]);

        // Générer une référence unique si non fournie
        if (empty($validated['reference'])) {
            $validated['reference'] = 'PROD-' . uniqid();
        }

        // Traiter l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        // Ajouter l'ID du vendeur
        $validated['idVendeur'] = Auth::id();
        $validated['dateAjout'] = now();

        // Créer le produit
        $produit = Produit::create($validated);

        // Logger l'activité
        activity()
            ->performedOn($produit)
            ->causedBy(Auth::user())
            ->withProperties(['action' => 'create'])
            ->log('Nouveau produit créé');

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

        // Logger l'activité
        activity()
            ->performedOn($produit)
            ->causedBy(Auth::user())
            ->withProperties(['action' => 'update'])
            ->log('Produit mis à jour');

        return redirect()
            ->route('vendeur.produits.show', $produit)
            ->with('success', 'Produit mis à jour avec succès');
    }

    public function deleteProduit(Produit $produit)
    {
        $this->authorizeProduct($produit);

        // Vérifier si le produit a des commandes en cours
        if ($produit->lignes()->whereHas('commande', function($query) {
            $query->whereIn('status', ['en_cours', 'en_preparation']);
        })->exists()) {
            return back()->with('error', 'Impossible de supprimer un produit ayant des commandes en cours');
        }

        // Supprimer l'image
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        // Logger l'activité avant la suppression
        activity()
            ->performedOn($produit)
            ->causedBy(Auth::user())
            ->withProperties(['action' => 'delete'])
            ->log('Produit supprimé');

        $produit->delete();

        return redirect()
            ->route('vendeur.produits')
            ->with('success', 'Produit supprimé avec succès');
    }

    private function authorizeProduct(Produit $produit)
    {
        if ($produit->idVendeur !== Auth::id()) {
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
        $produits = Produit::where('idVendeur', Auth::id())
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

    private function getSalesChartData()
    {
        $startDate = now()->subDays(30);
        $endDate = now();

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

    private function getCategoriesChartData($startDate)
    {
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
            ->where('produits.idVendeur', Auth::id())
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

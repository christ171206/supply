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
            'meilleures_ventes'
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

    public function produits()
    {
        $produits = Produit::where('idVendeur', Auth::id())
            ->orderBy('dateAjout', 'desc')
            ->paginate(10);
            
        return view('vendeur.produits', compact('produits'));
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
    public function rapports()
    {
        return view('vendeur.rapports');
    }
}

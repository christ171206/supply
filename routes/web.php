<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController as AdminDash;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\VendeurDashboardController;


Route::get('/', function () {
    if (Auth::check()) {
        $redirectRoute = match(Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'vendeur' => 'vendeur.dashboard',
            'client' => 'client.dashboard',
            default => 'login'
        };
        return redirect()->route($redirectRoute);
    }
    return view('welcome');
});

// ✅ Auth personnalisée (publiques)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes de réinitialisation de mot de passe
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/reset-password-success', function () {
    return view('auth.reset-success');
})->name('password.reset.success');

// ✅ Zone protégée
Route::middleware('auth')->group(function () {
    // Rediriger /dashboard vers le bon dashboard selon le rôle
    Route::get('/dashboard', function () {
        $redirectRoute = match(Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'vendeur' => 'vendeur.dashboard',
            'client' => 'client.dashboard',
            default => 'login'
        };
        return redirect()->route($redirectRoute);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/verification-identite', [VendeurController::class, 'showVerificationPage'])->name('vendeur.verification');
    Route::post('/verification-identite', [VendeurController::class, 'uploadCni'])->name('vendeur.cni.upload');
});

// Routes Client
// Routes Client
Route::group(['middleware' => ['web', 'auth', \App\Http\Middleware\IsClient::class]], function() {
    Route::prefix('client')->group(function() {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
        Route::get('/commandes', [ClientDashboardController::class, 'commandes'])->name('client.commandes');
        Route::get('/panier', [ClientDashboardController::class, 'panier'])->name('client.panier');
        
        // Messagerie
        Route::prefix('messagerie')->group(function () {
            Route::get('/', [MessagerieController::class, 'index'])->name('client.messages');
            Route::post('/messages', [MessagerieController::class, 'store'])->name('client.messages.store');
            Route::post('/messages/lu', [MessagerieController::class, 'marquerCommeLu'])->name('client.messages.lu');
            Route::post('/conversations', [MessagerieController::class, 'nouvelleConversation'])->name('client.conversations.nouvelle');
        });
    });
});

// Routes Vendeur
Route::group(['middleware' => ['web', 'auth', \App\Http\Middleware\IsVendeur::class]], function() {
    Route::prefix('vendeur')->group(function() {
        // Dashboard
        Route::get('/dashboard', [VendeurDashboardController::class, 'index'])->name('vendeur.dashboard');
        Route::get('/stats', [VendeurDashboardController::class, 'getStats'])->name('vendeur.stats');
        Route::get('/chart-data', [VendeurDashboardController::class, 'getChartData'])->name('vendeur.chart-data');
        
        // Gestion des produits
        Route::get('/produits', [VendeurDashboardController::class, 'produits'])->name('vendeur.produits');
        Route::get('/produits/create', [VendeurDashboardController::class, 'createProduit'])->name('vendeur.produits.create');
        Route::post('/produits', [VendeurDashboardController::class, 'storeProduit'])->name('vendeur.produits.store');
        Route::get('/produits/{produit}', [VendeurDashboardController::class, 'showProduit'])->name('vendeur.produits.show');
        Route::get('/produits/{produit}/edit', [VendeurDashboardController::class, 'editProduit'])->name('vendeur.produits.edit');
        Route::put('/produits/{produit}', [VendeurDashboardController::class, 'updateProduit'])->name('vendeur.produits.update');
        Route::delete('/produits/{produit}', [VendeurDashboardController::class, 'deleteProduit'])->name('vendeur.produits.destroy');
        
        // Gestion du stock
        Route::get('/stock', [VendeurDashboardController::class, 'stock'])->name('vendeur.stock');
        Route::post('/stock/ajuster', [VendeurDashboardController::class, 'ajusterStock'])->name('vendeur.stock.ajuster');
        Route::get('/stock/historique', [VendeurDashboardController::class, 'stockHistorique'])->name('vendeur.stock.historique');
        Route::get('/stock/export', [VendeurDashboardController::class, 'exportStock'])->name('vendeur.stock.export');
        
        // Gestion des fournisseurs
        Route::get('/fournisseurs', [VendeurDashboardController::class, 'fournisseurs'])->name('vendeur.fournisseurs');
        Route::get('/fournisseurs/create', [VendeurDashboardController::class, 'createFournisseur'])->name('vendeur.fournisseurs.create');
        Route::post('/fournisseurs', [VendeurDashboardController::class, 'storeFournisseur'])->name('vendeur.fournisseurs.store');
        Route::get('/fournisseurs/{fournisseur}', [VendeurDashboardController::class, 'showFournisseur'])->name('vendeur.fournisseurs.show');
        Route::get('/fournisseurs/{fournisseur}/edit', [VendeurDashboardController::class, 'editFournisseur'])->name('vendeur.fournisseurs.edit');
        Route::put('/fournisseurs/{fournisseur}', [VendeurDashboardController::class, 'updateFournisseur'])->name('vendeur.fournisseurs.update');
        Route::delete('/fournisseurs/{fournisseur}', [VendeurDashboardController::class, 'deleteFournisseur'])->name('vendeur.fournisseurs.delete');
        
        // Gestion des commandes
        Route::get('/commandes', [VendeurDashboardController::class, 'commandes'])->name('vendeur.commandes');
        Route::get('/commandes/{commande}', [VendeurDashboardController::class, 'showCommande'])->name('vendeur.commandes.show');
        Route::put('/commandes/{commande}/status', [VendeurDashboardController::class, 'updateCommandeStatus'])->name('vendeur.commandes.update-status');
        Route::get('/commandes/{commande}/facture', [VendeurDashboardController::class, 'generateFacture'])->name('vendeur.commandes.facture');
        
        // Paiements et revenus
        Route::get('/paiements', [VendeurDashboardController::class, 'paiements'])->name('vendeur.paiements');
        Route::get('/paiements/export', [VendeurDashboardController::class, 'exportPaiements'])->name('vendeur.paiements.export');
        
        // Profil vendeur
        Route::prefix('profile')->group(function () {
            Route::get('/', [App\Http\Controllers\Vendeur\ProfilController::class, 'show'])->name('vendeur.profil');
            Route::put('/', [App\Http\Controllers\Vendeur\ProfilController::class, 'update'])->name('vendeur.profil.update');
        });
        
        // Paramètres
        Route::prefix('parametres')->group(function () {
            Route::get('/', [App\Http\Controllers\Vendeur\ParametresController::class, 'index'])->name('vendeur.parametres');
            Route::put('/general', [App\Http\Controllers\Vendeur\ParametresController::class, 'updateGeneral'])->name('vendeur.parametres.general');
            Route::put('/boutique', [App\Http\Controllers\Vendeur\ParametresController::class, 'updateBoutique'])->name('vendeur.parametres.boutique');
            Route::put('/paiement', [App\Http\Controllers\Vendeur\ParametresController::class, 'updatePaiement'])->name('vendeur.parametres.paiement');
            Route::post('/boutique/logo', [App\Http\Controllers\Vendeur\ParametresController::class, 'updateLogo'])->name('vendeur.parametres.logo');
        });

        // Messagerie
        Route::prefix('messagerie')->group(function () {
            Route::get('/', [App\Http\Controllers\Vendeur\MessagerieController::class, 'index'])->name('vendeur.messagerie');
            Route::post('/envoyer', [App\Http\Controllers\Vendeur\MessagerieController::class, 'sendMessage'])->name('vendeur.messagerie.send');
            Route::post('/upload', [App\Http\Controllers\Vendeur\MessagerieController::class, 'uploadFile'])->name('vendeur.messagerie.upload');
            Route::post('/lu', [App\Http\Controllers\Vendeur\MessagerieController::class, 'markAsRead'])->name('vendeur.messagerie.mark-read');
            Route::post('/resoudre', [App\Http\Controllers\Vendeur\MessagerieController::class, 'resolveConversation'])->name('vendeur.messagerie.resolve');
            Route::post('/bloquer', [App\Http\Controllers\Vendeur\MessagerieController::class, 'blockUser'])->name('vendeur.messagerie.block');
            Route::get('/non-lu', [App\Http\Controllers\Vendeur\MessagerieController::class, 'getUnreadCount'])->name('vendeur.messagerie.unread-count');
        });
        
        // Rapports et statistiques
        Route::get('/rapports', [VendeurDashboardController::class, 'rapports'])->name('vendeur.rapports');
        Route::get('/rapports/ventes', [VendeurDashboardController::class, 'rapportVentes'])->name('vendeur.rapports.ventes');
        Route::get('/rapports/produits', [VendeurDashboardController::class, 'rapportProduits'])->name('vendeur.rapports.produits');
        Route::get('/rapports/export', [VendeurDashboardController::class, 'exportRapport'])->name('vendeur.rapports.export');
    });
});

// Routes Admin
Route::middleware(['auth', 'admin'])->group(function() {
    Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminDash::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminDash::class, 'users'])->name('admin.users');
    Route::get('/produits', [AdminDash::class, 'produits'])->name('admin.produits');
    });
});

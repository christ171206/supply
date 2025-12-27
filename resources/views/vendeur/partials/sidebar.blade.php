<div class="position-sticky pt-3">
    <!-- Profil rapide -->
    <div class="px-3 py-2 mb-3 bg-light rounded">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-user-circle fa-2x text-primary"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">{{ auth()->user()->nom }}</h6>
                <small class="text-muted">Vendeur</small>
            </div>
        </div>
    </div>

    <!-- Menu principal -->
    <div class="mb-4">
        <h6 class="sidebar-heading px-3 mb-2 text-muted text-uppercase">
            <span>Menu principal</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('vendeur.dashboard') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.dashboard') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('vendeur.produits') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.produits*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-box me-2"></i>
                    <span>Catalogue produits</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Ventes et Commandes -->
    <div class="mb-4">
        <h6 class="sidebar-heading px-3 mb-2 text-muted text-uppercase">
            <span>Ventes et Commandes</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('vendeur.commandes') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.commandes*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i>
                    <span>Commandes</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('vendeur.stock') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.stock*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-warehouse me-2"></i>
                    <span>Stock</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('vendeur.paiements') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.paiements*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    <span>Paiements</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Configuration -->
    <div class="mb-4">
        <h6 class="sidebar-heading px-3 mb-2 text-muted text-uppercase">
            <span>Configuration</span>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('vendeur.fournisseurs') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.fournisseurs*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-truck me-2"></i>
                    <span>Fournisseurs</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('vendeur.parametres') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('vendeur.parametres*') ? 'active fw-bold' : '' }}">
                    <i class="fas fa-cog me-2"></i>
                    <span>Paramètres</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Statistiques rapides -->
    <div class="mt-4">
        <h6 class="sidebar-heading px-3 mb-3 text-muted text-uppercase">
            <span>Statistiques rapides</span>
        </h6>
        
        <div class="px-3">
            <div class="card bg-primary text-white mb-2">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>Commandes aujourd'hui</small>
                            <h5 class="mb-0">{{ $stats['commandes_aujourdhui'] ?? 0 }}</h5>
                        </div>
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </div>

            <div class="card bg-warning text-dark mb-2">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>Produits en rupture</small>
                            <h5 class="mb-0">{{ $stats['produits_rupture'] ?? 0 }}</h5>
                        </div>
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>

            <div class="card bg-success text-white">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small>CA du mois</small>
                            <h5 class="mb-0">{{ number_format($stats['ca_mois'] ?? 0, 2, ',', ' ') }} €</h5>
                        </div>
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
    padding: .5rem 1rem;
    border-radius: .25rem;
    margin: 0 .5rem;
}

.sidebar .nav-link:hover {
    color: #0d6efd;
    background-color: rgba(13, 110, 253, .1);
}

.sidebar .nav-link.active {
    color: #0d6efd;
    background-color: rgba(13, 110, 253, .1);
}

.sidebar-heading {
    font-size: .75rem;
}

.nav-item {
    margin-bottom: .25rem;
}

.card {
    transition: transform .2s;
}

.card:hover {
    transform: translateY(-2px);
}
</style>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
}

.sidebar .nav-link.active {
    color: #2470dc;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
}
</style>
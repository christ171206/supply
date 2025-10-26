<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <i class="fas fa-box-open me-2"></i>
            Supply
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                @auth
                    @if(auth()->user()->role === 'vendeur')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendeur.dashboard') }}">
                                <i class="fas fa-home me-1"></i> Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendeur.produits.create') }}">
                                <i class="fas fa-plus me-1"></i> Nouveau produit
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav">
                @auth
                    <!-- Notifications -->
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                                <span class="visually-hidden">notifications non lues</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                            <h6 class="dropdown-header">Notifications</h6>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-shopping-cart text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0">Nouvelle commande #123</p>
                                        <small class="text-muted">Il y a 5 minutes</small>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">Voir toutes les notifications</a>
                        </div>
                    </li>

                    <!-- Quick Actions -->
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link" href="#" id="quickActionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="quickActionsDropdown">
                            <h6 class="dropdown-header">Actions rapides</h6>
                            <a class="dropdown-item" href="{{ route('vendeur.produits.create') }}">
                                <i class="fas fa-box me-2"></i> Nouveau produit
                            </a>
                            <a class="dropdown-item" href="{{ route('vendeur.stock') }}">
                                <i class="fas fa-warehouse me-2"></i> Ajuster le stock
                            </a>
                        </div>
                    </li>

                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            <span>{{ auth()->user()->nom }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <div class="dropdown-item-text">
                                    <small class="text-muted">Connecté en tant que</small>
                                    <div class="fw-bold">{{ auth()->user()->nom }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('vendeur.profil') }}">
                                    <i class="fas fa-user me-2"></i> Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('vendeur.parametres') }}">
                                    <i class="fas fa-cog me-2"></i> Paramètres
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Inscription
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Offcanvas Sidebar pour Mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @auth
            @if(auth()->user()->role === 'vendeur')
                @include('vendeur.partials.sidebar')
            @endif
        @endauth
    </div>
</div>

<style>
.navbar {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}

.navbar-brand {
    font-size: 1.25rem;
    font-weight: 600;
}

.dropdown-item-text {
    padding: .5rem 1rem;
}

.nav-link {
    position: relative;
}

.badge {
    font-size: 0.65rem;
    padding: 0.25em 0.5em;
    margin-left: -0.5em;
}
</style>
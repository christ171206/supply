@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('vendeur.dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Mon profil</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Colonne de gauche - Photo et informations principales -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="position-relative mb-4 mx-auto" style="width: 150px;">
                        <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}" 
                             alt="Photo de profil" 
                             class="rounded-circle img-thumbnail" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                                style="width: 32px; height: 32px;"
                                data-bs-toggle="modal" 
                                data-bs-target="#avatarModal">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h5 class="mb-1">{{ auth()->user()->nom }}</h5>
                    <p class="text-muted mb-3">Vendeur {{ auth()->user()->vendeur->statut_verification === 'verifie' ? '✓' : '⏳' }}</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#cniModal">
                            <i class="fas fa-id-card me-2"></i>Mettre à jour CNI
                        </button>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Membre depuis {{ \Carbon\Carbon::parse(auth()->user()->dateInscription)->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>

        <!-- Colonne de droite - Formulaires -->
        <div class="col-md-8">
            <!-- Informations personnelles -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">🧍 Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendeur.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom complet</label>
                                <input type="text" class="form-control" name="nom" value="{{ auth()->user()->nom }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="telephone" value="{{ auth()->user()->telephone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Langue préférée</label>
                                <select class="form-select" name="langue">
                                    <option value="fr" {{ auth()->user()->settings['langue'] ?? 'fr' === 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ auth()->user()->settings['langue'] ?? 'fr' === 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea class="form-control" name="adresse" rows="2">{{ auth()->user()->adresse }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations professionnelles -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">🏪 Informations professionnelles</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendeur.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom de la boutique</label>
                                <input type="text" class="form-control" name="nom_boutique" value="{{ auth()->user()->vendeur->nom_boutique ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro de registre de commerce</label>
                                <input type="text" class="form-control" name="registre_commerce" value="{{ auth()->user()->vendeur->registre_commerce ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description de la boutique</label>
                            <textarea class="form-control" name="description_boutique" rows="3">{{ auth()->user()->vendeur->description ?? '' }}</textarea>
                            <div class="form-text">Décrivez votre boutique, vos produits et services en quelques phrases.</div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">🔐 Sécurité</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendeur.profile.password') }}" method="POST" class="mb-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mot de passe actuel</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>Changer le mot de passe
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('vendeur.profile.logout-all') }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter de tous les appareils
                        </button>
                    </form>
                </div>
            </div>

            <!-- Zone critique -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">🚮 Zone critique</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Suspendre temporairement la boutique</h6>
                        <p class="text-muted">Votre boutique ne sera plus visible par les clients, mais vous conserverez vos données.</p>
                        <form action="{{ route('vendeur.profile.deactivate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Êtes-vous sûr de vouloir suspendre votre boutique ?')">
                                <i class="fas fa-pause me-2"></i>Suspendre ma boutique
                            </button>
                        </form>
                    </div>

                    <hr>

                    <div>
                        <h6 class="text-danger">Supprimer le compte vendeur</h6>
                        <p class="text-muted">Cette action est irréversible. Toutes vos données seront définitivement supprimées.</p>
                        <form action="{{ route('vendeur.profile.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Cette action est irréversible. Êtes-vous sûr de vouloir supprimer votre compte ?')">
                                <i class="fas fa-trash-alt me-2"></i>Supprimer mon compte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour la photo de profil -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Changer la photo de profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vendeur.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sélectionner une nouvelle photo</label>
                        <input type="file" class="form-control" name="avatar" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour la CNI -->
<div class="modal fade" id="cniModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mettre à jour la CNI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vendeur.profile.cni') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Photo de votre CNI (recto-verso)</label>
                        <input type="file" class="form-control" name="cni" accept="image/*" required>
                        <div class="form-text">
                            Format accepté : JPG, PNG. Taille maximale : 5 MB.
                            Assurez-vous que les informations sont clairement lisibles.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer pour vérification</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.btn-outline-warning:hover {
    color: #fff;
}
</style>
@endpush
@endsection
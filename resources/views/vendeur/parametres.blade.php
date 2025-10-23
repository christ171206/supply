@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('vendeur.dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
            </ol>
        </nav>
        <a href="{{ route('vendeur.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Menu latéral des paramètres -->
        <div class="col-md-3">
            <div class="list-group mb-4">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general">
                    <i class="fas fa-cog me-2"></i>Paramètres généraux
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#boutique">
                    <i class="fas fa-store me-2"></i>Paramètres boutique
                </a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#paiements">
                    <i class="fas fa-money-bill me-2"></i>Paramètres de paiement
                </a>
            </div>
        </div>

        <!-- Contenu des paramètres -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Paramètres généraux -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">⚙️ Paramètres généraux</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendeur.parametres.general') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Langue d'affichage</label>
                                        <select class="form-select" name="langue">
                                            <option value="fr" {{ ($settings['langue'] ?? 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                                            <option value="en" {{ ($settings['langue'] ?? 'fr') === 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Thème</label>
                                        <select class="form-select" name="theme">
                                            <option value="light" {{ ($settings['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Clair</option>
                                            <option value="dark" {{ ($settings['theme'] ?? 'light') === 'dark' ? 'selected' : '' }}>Sombre</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Fuseau horaire</label>
                                        <select class="form-select" name="timezone">
                                            <option value="Africa/Abidjan" {{ ($settings['timezone'] ?? 'Africa/Abidjan') === 'Africa/Abidjan' ? 'selected' : '' }}>Côte d'Ivoire (UTC+0)</option>
                                            <option value="Europe/Paris" {{ ($settings['timezone'] ?? 'Africa/Abidjan') === 'Europe/Paris' ? 'selected' : '' }}>France (UTC+1)</option>
                                        </select>
                                    </div>
                                </div>

                                <h6 class="mb-3">Préférences de notification</h6>
                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="notif_email" name="notifications[email]" value="1" {{ isset($settings['notifications']['email']) && $settings['notifications']['email'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notif_email">Notifications par email</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="notif_sms" name="notifications[sms]" value="1" {{ isset($settings['notifications']['sms']) && $settings['notifications']['sms'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notif_sms">Notifications par SMS</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="notif_dashboard" name="notifications[dashboard]" value="1" {{ isset($settings['notifications']['dashboard']) && $settings['notifications']['dashboard'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notif_dashboard">Notifications sur le tableau de bord</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Paramètres boutique -->
                <div class="tab-pane fade" id="boutique">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">🏷️ Paramètres boutique</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendeur.parametres.boutique') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <img src="{{ $boutique->logo_url ?? asset('images/default-shop.png') }}"
                                                 alt="Logo boutique"
                                                 class="img-fluid rounded mb-2"
                                                 style="max-width: 150px;">
                                            <div class="d-grid">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#logoModal">
                                                    <i class="fas fa-upload me-2"></i>Changer le logo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label">Nom public de la boutique</label>
                                            <input type="text" class="form-control" name="nom_public" value="{{ $boutique->nom_public ?? '' }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Message de bienvenue</label>
                                            <textarea class="form-control" name="message_bienvenue" rows="2">{{ $boutique->message_bienvenue ?? '' }}</textarea>
                                            <div class="form-text">Ce message sera affiché en haut de votre page boutique.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="boutique_visible" name="visible" value="1" {{ $boutique->visible ?? false ? 'checked' : '' }}>
                                    <label class="form-check-label" for="boutique_visible">Boutique visible pour les clients</label>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Paramètres de paiement -->
                <div class="tab-pane fade" id="paiements">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">💸 Paramètres de paiement</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendeur.parametres.paiement') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <h6 class="mb-3">Moyens de paiement acceptés</h6>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="paiement_mtn" name="moyens_paiement[]" value="mtn" {{ in_array('mtn', $paiements['moyens'] ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paiement_mtn">MTN Mobile Money</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="paiement_orange" name="moyens_paiement[]" value="orange" {{ in_array('orange', $paiements['moyens'] ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paiement_orange">Orange Money</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="paiement_cash" name="moyens_paiement[]" value="cash" {{ in_array('cash', $paiements['moyens'] ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paiement_cash">Paiement à la livraison</label>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mb-3">Numéros de paiement mobile</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Numéro MTN MoMo</label>
                                        <input type="text" class="form-control" name="numero_mtn" value="{{ $paiements['numeros']['mtn'] ?? '' }}" placeholder="Ex: 650000000">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Numéro Orange Money</label>
                                        <input type="text" class="form-control" name="numero_orange" value="{{ $paiements['numeros']['orange'] ?? '' }}" placeholder="Ex: 690000000">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </form>

                            <hr>

                            <h6 class="mb-3">Historique des paiements</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th>Méthode</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paiements_recents ?? [] as $paiement)
                                            <tr>
                                                <td>{{ $paiement->date->format('d/m/Y H:i') }}</td>
                                                <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                                <td>{{ $paiement->methode }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $paiement->statut === 'success' ? 'success' : 'warning' }}">
                                                        {{ $paiement->statut }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Aucun paiement récent</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour le logo -->
<div class="modal fade" id="logoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Changer le logo de la boutique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vendeur.parametres.logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sélectionner un nouveau logo</label>
                        <input type="file" class="form-control" name="logo" accept="image/*" required>
                        <div class="form-text">
                            Format recommandé : 500x500px, JPG ou PNG.<br>
                            Taille maximale : 2 MB
                        </div>
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

@push('styles')
<style>
.list-group-item {
    border: none;
    border-radius: 0.25rem;
    margin-bottom: 0.25rem;
}

.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.list-group-item:not(.active):hover {
    background-color: #f8f9fa;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
@endpush
@endsection

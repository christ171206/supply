@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('vendeur.dashboard') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paramètres du compte</h1>
        <a href="{{ route('vendeur.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
                    <form action="{{ route('vendeur.parametres.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="notification_email" class="form-label">Notifications par email</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notification_nouvelle_commande" name="notifications[nouvelle_commande]" value="1" {{ optional(auth()->user()->settings)['notifications']['nouvelle_commande'] ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_nouvelle_commande">
                                    Nouvelles commandes
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notification_stock_faible" name="notifications[stock_faible]" value="1" {{ optional(auth()->user()->settings)['notifications']['stock_faible'] ?? true ? 'checked' : '' }}>
                                <label class="form-check-label" for="notification_stock_faible">
                                    Alerte stock faible
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="seuil_stock" class="form-label">Seuil d'alerte stock faible</label>
                            <input type="number" class="form-control" id="seuil_stock" name="seuil_stock" value="{{ auth()->user()->settings['seuil_stock'] ?? 5 }}" min="1">
                            <div class="form-text">Vous serez alerté lorsque le stock d'un produit passe sous ce seuil.</div>
                        </div>

                        <div class="mb-3">
                            <label for="devise" class="form-label">Devise</label>
                            <select class="form-select" id="devise" name="devise">
                                <option value="EUR" {{ (auth()->user()->settings['devise'] ?? 'EUR') === 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                                <option value="USD" {{ (auth()->user()->settings['devise'] ?? 'EUR') === 'USD' ? 'selected' : '' }}>Dollar US ($)</option>
                                <option value="GBP" {{ (auth()->user()->settings['devise'] ?? 'EUR') === 'GBP' ? 'selected' : '' }}>Livre Sterling (£)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="langue" class="form-label">Langue</label>
                            <select class="form-select" id="langue" name="langue">
                                <option value="fr" {{ (auth()->user()->settings['langue'] ?? 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ (auth()->user()->settings['langue'] ?? 'fr') === 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
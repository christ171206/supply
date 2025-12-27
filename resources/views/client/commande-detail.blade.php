@extends('layouts.client')

@section('title', 'Commande #' . $commande->id)

@section('content')
<!-- En-tête -->
<div class="mb-8">
    <a href="{{ route('client.dashboard') }}" class="inline-flex items-center gap-2 text-primary-700 hover:text-primary-800 font-semibold mb-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Retour au tableau de bord
    </a>
    <h1 class="text-4xl font-bold text-gray-900">Commande #{{ $commande->id }}</h1>
    <p class="text-gray-600 mt-2">{{ $commande->dateCommande ? $commande->dateCommande->format('d M Y à H:i') : 'Date non disponible' }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Contenu principal (2/3) -->
    <div class="lg:col-span-2">
        <!-- Barre de progression -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Suivi de votre commande</h2>

            <div class="relative">
                <!-- Ligne de progression -->
                <div class="absolute top-5 left-0 w-full h-1 bg-gray-200">
                    @php
                        $progress = match($commande->statut) {
                            'en_attente' => 25,
                            'en_cours' => 50,
                            'expediee' => 75,
                            'livrée' => 100,
                            default => 0
                        };
                    @endphp
                    <div class="h-full bg-primary-700 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>

                <!-- Étapes -->
                <div class="grid grid-cols-4 gap-4 relative z-10">
                    <!-- Commandée -->
                    <div class="text-center">
                        <div class="flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-primary-700 flex items-center justify-center text-white font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">Commandée</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $commande->dateCommande ? $commande->dateCommande->format('d M') : '' }}</p>
                    </div>

                    <!-- En préparation -->
                    <div class="text-center">
                        <div class="flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-full {{ in_array($commande->statut, ['en_cours', 'expediee', 'livrée']) ? 'bg-primary-700 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold transition">
                                {{ in_array($commande->statut, ['en_cours', 'expediee', 'livrée']) ? '✓' : '2' }}
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">En préparation</p>
                        <p class="text-xs text-gray-500 mt-1">~48h</p>
                    </div>

                    <!-- Expédiée -->
                    <div class="text-center">
                        <div class="flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-full {{ in_array($commande->statut, ['expediee', 'livrée']) ? 'bg-primary-700 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold transition">
                                {{ in_array($commande->statut, ['expediee', 'livrée']) ? '✓' : '3' }}
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">Expédiée</p>
                        <p class="text-xs text-gray-500 mt-1">~3-5j</p>
                    </div>

                    <!-- Livrée -->
                    <div class="text-center">
                        <div class="flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-full {{ $commande->statut === 'livrée' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center font-bold transition">
                                {{ $commande->statut === 'livrée' ? '✓' : '4' }}
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">Livrée</p>
                        <p class="text-xs text-gray-500 mt-1">À venir</p>
                    </div>
                </div>
            </div>

            <!-- Statut actuel -->
            <div class="mt-8 p-4 bg-primary-50 border border-primary-200 rounded-lg">
                <p class="text-sm text-gray-600">Statut actuel:</p>
                <div class="flex items-center gap-2 mt-2">
                    @if($commande->statut === 'en_attente')
                        <span class="w-2 h-2 bg-yellow-600 rounded-full"></span>
                        <p class="font-semibold text-gray-900">En attente de confirmation</p>
                    @elseif($commande->statut === 'en_cours')
                        <span class="w-2 h-2 bg-primary-700 rounded-full animate-pulse"></span>
                        <p class="font-semibold text-gray-900">En cours de préparation</p>
                    @elseif($commande->statut === 'expediee')
                        <span class="w-2 h-2 bg-purple-600 rounded-full"></span>
                        <p class="font-semibold text-gray-900">Expédiée - En route vers vous</p>
                    @elseif($commande->statut === 'livrée')
                        <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                        <p class="font-semibold text-gray-900">Livrée ✓</p>
                    @else
                        <span class="w-2 h-2 bg-red-600 rounded-full"></span>
                        <p class="font-semibold text-gray-900">Annulée</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Produits de la commande -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-bold text-gray-900">Articles commandés</h2>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($commande->lignes as $ligne)
                <div class="px-6 py-4">
                    <div class="flex items-start gap-4">
                        @if($ligne->produit && $ligne->produit->image)
                            <img src="{{ asset('storage/produits/' . $ligne->produit->image) }}" alt="{{ $ligne->produit->nom }}" class="w-20 h-20 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $ligne->produit->nom ?? 'Produit supprimé' }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Quantité: {{ $ligne->quantite }}</p>
                            <p class="text-sm text-gray-600">Prix unitaire: {{ number_format($ligne->prixUnitaire, 0) }} F</p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ number_format($ligne->prixUnitaire * $ligne->quantite, 0) }} F</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar (1/3) -->
    <div class="lg:col-span-1">
        <!-- Résumé du paiement -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm sticky top-24">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Résumé</h2>

            <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Sous-total</span>
                    <span class="font-semibold text-gray-900">{{ number_format($commande->total, 0) }} F</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Livraison</span>
                    <span class="font-semibold text-gray-900">Gratuite</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <span class="text-lg font-semibold text-gray-900">Total</span>
                <span class="text-2xl font-bold text-primary-700">{{ number_format($commande->total, 0) }} F</span>
            </div>

            <!-- Informations de livraison -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-xs font-semibold text-gray-700 uppercase mb-3">Adresse de livraison</p>
                <p class="text-sm text-gray-900">{{ $commande->adresseLivraison ?? 'Non spécifiée' }}</p>
            </div>

            <!-- Vendeur -->
            @if($commande->vendeur)
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-700 uppercase mb-3">Vendeur</p>
                <p class="text-sm font-semibold text-gray-900">{{ $commande->vendeur->nom ?? 'Non spécifié' }}</p>
                <p class="text-xs text-gray-600 mt-1">Moyen de paiement: {{ $commande->moyenPaiement ?? 'Non spécifié' }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="mt-6 space-y-3">
                <button type="button" class="w-full px-4 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition font-semibold">
                    Contacter le vendeur
                </button>
                <a href="{{ route('client.dashboard') }}" class="block w-full px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

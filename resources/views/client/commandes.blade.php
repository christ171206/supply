@extends('layouts.client')

@section('title', 'Mes commandes')

@section('content')
<!-- En-tête -->
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Mes commandes</h1>
    <p class="text-gray-600 mt-2">Retrouvez l'historique de toutes vos commandes</p>
</div>

<!-- Filtres -->
<div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm mb-8">
    <form method="GET" action="{{ route('client.commandes') }}" class="flex flex-wrap gap-4 items-end">
        <!-- Recherche -->
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Rechercher</label>
            <input
                type="text"
                id="search"
                name="search"
                placeholder="N° de commande ou produit..."
                value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
        </div>

        <!-- Filtre par statut -->
        <div class="min-w-[150px]">
            <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
            <select
                id="statut"
                name="statut"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="expediee" {{ request('statut') === 'expediee' ? 'selected' : '' }}>Expédiée</option>
                <option value="livrée" {{ request('statut') === 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="annulée" {{ request('statut') === 'annulée' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="flex gap-2">
            <button
                type="submit"
                class="px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition font-semibold"
            >
                Filtrer
            </button>
            <a
                href="{{ route('client.commandes') }}"
                class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold"
            >
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Cartes de statistiques rapides -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">Commandes totales</p>
    </div>
    <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
        <p class="text-2xl font-bold text-amber-600">{{ $stats['en_attente'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">En attente</p>
    </div>
    <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
        <p class="text-2xl font-bold text-primary-700">{{ $stats['en_cours'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">En cours</p>
    </div>
    <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $stats['livrées'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">Livrées</p>
    </div>
</div>

<!-- Liste des commandes -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    @if($commandes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">N° Commande</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Vendeur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Articles</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Montant</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($commandes as $commande)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">#{{ $commande->id }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $commande->dateCommande ? $commande->dateCommande->format('d M Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $commande->vendeur->nom ?? 'Non spécifié' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $commande->lignes->count() }} article(s)
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ number_format($commande->total, 0) }} F
                        </td>
                        <td class="px-6 py-4">
                            @if($commande->statut === 'en_attente')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 bg-yellow-600 rounded-full"></span> En attente
                                </span>
                            @elseif($commande->statut === 'en_cours')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-800">
                                    <span class="w-2 h-2 bg-primary-700 rounded-full animate-pulse"></span> En cours
                                </span>
                            @elseif($commande->statut === 'expediee')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                    <span class="w-2 h-2 bg-purple-600 rounded-full"></span> Expédiée
                                </span>
                            @elseif($commande->statut === 'livrée')
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-600 rounded-full"></span> Livrée
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-600 rounded-full"></span> Annulée
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('client.commande.show', $commande->id) }}" class="text-primary-700 hover:text-primary-800 font-semibold text-sm">
                                Voir →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $commandes->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune commande</h3>
            <p class="text-gray-600 mb-6">Aucune commande trouvée avec les critères de recherche</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('client.commandes') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Réinitialiser
                </a>
                <a href="{{ route('catalogue.index') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Commencer vos achats
                </a>
            </div>
        </div>
    @endif
</div>

@endsection

@extends('layouts.vendeur')

@section('title', 'Rapports et Statistiques')

@section('content')
<div class="space-y-6">
    <!-- En-tête de la page -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Rapports et Statistiques</h1>
            <p class="mt-1 text-sm text-gray-500">Analysez les performances de votre boutique</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter
            </button>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrer
                </button>
                <div x-show="open" @click.away="open = false" 
                     class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="p-4">
                        <div class="space-y-4">
                            <div x-data="{ periode: 'last30', dateDebut: '', dateFin: '', periodeCustom: false }">
                                <label class="block text-sm font-medium text-gray-700">Période</label>
                                <select x-model="periode" 
                                        @change="periodeCustom = (periode === 'custom')"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="last7">7 derniers jours</option>
                                    <option value="last30">30 derniers jours</option>
                                    <option value="last90">90 derniers jours</option>
                                    <option value="thisYear">Cette année</option>
                                    <option value="lastYear">Année précédente</option>
                                    <option value="custom">Période personnalisée</option>
                                </select>
                                
                                <!-- Champs de date personnalisés -->
                                <div x-show="periodeCustom" class="mt-3 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date de début</label>
                                        <input type="date" x-model="dateDebut"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                                        <input type="date" x-model="dateFin"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" class="btn btn-primary text-sm">Appliquer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Chiffre d'affaires -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-emerald-100 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">CA Total</span>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-emerald-500 text-sm">+12.5%</span>
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($chiffreAffaires, 0, ',', ' ') }} €</span>
                <p class="text-sm text-gray-500 mt-1">Depuis le début du mois</p>
            </div>
        </div>

        <!-- Commandes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Commandes</span>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-blue-500 text-sm">+8.2%</span>
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ $nombreCommandes }}</span>
                <p class="text-sm text-gray-500 mt-1">Depuis le début du mois</p>
            </div>
        </div>

        <!-- Produits vendus -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Produits vendus</span>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-purple-500 text-sm">+15.3%</span>
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ $produitsVendus }}</span>
                <p class="text-sm text-gray-500 mt-1">Depuis le début du mois</p>
            </div>
        </div>

        <!-- Panier moyen -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Panier moyen</span>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-amber-500 text-sm">+4.8%</span>
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($panierMoyen, 2, ',', ' ') }} €</span>
                <p class="text-sm text-gray-500 mt-1">Depuis le début du mois</p>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Évolution des ventes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Évolution des ventes</h3>
            <div class="mt-4">
                <canvas id="salesChart" class="w-full" height="300"></canvas>
            </div>
        </div>

        <!-- Répartition des ventes par catégorie -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Ventes par catégorie</h3>
            <div class="mt-4">
                <canvas id="categoriesChart" class="w-full" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Meilleurs produits -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900">Meilleurs produits</h3>
            <div class="mt-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ventes</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Chiffre d'aff.</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Évolution</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($meilleursVendeurs as $produit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ $produit->image_url }}" alt="{{ $produit->nom }}">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $produit->nom }}</div>
                                            <div class="text-sm text-gray-500">#{{ $produit->reference }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $produit->categorie->nom }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ $produit->total_ventes }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                    {{ number_format($produit->chiffre_affaires, 2, ',', ' ') }} €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end">
                                        @if($produit->evolution > 0)
                                            <span class="text-emerald-500 text-sm">+{{ $produit->evolution }}%</span>
                                            <svg class="w-4 h-4 ml-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            </svg>
                                        @else
                                            <span class="text-red-500 text-sm">{{ $produit->evolution }}%</span>
                                            <svg class="w-4 h-4 ml-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des graphiques
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');

    // Données pour le graphique des ventes
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesChart['labels']) !!},
            datasets: [{
                label: 'Chiffre d\'affaires',
                data: {!! json_encode($salesChart['data']) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Chiffre d\'affaires (€)'
                    },
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Données pour le graphique des catégories
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoriesChart['labels']) !!},
            datasets: [{
                data: {!! json_encode($categoriesChart['data']) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
@endsection
@extends('layouts.vendeur')

@section('title', 'Tableau de bord')

@section('content')
<!-- Bannière de bienvenue -->
<div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg mb-6 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-white text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->nom }} ! 👋</h2>
            <p class="text-blue-100">Voici un aperçu de votre activité aujourd'hui</p>
        </div>
        <div class="hidden md:block">
            <img src="{{ asset('images/dashboard-welcome.svg') }}" alt="Welcome" class="h-24">
        </div>
    </div>
</div>

<!-- Filtres de période -->
<div class="flex items-center space-x-4 mb-6">
    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Aujourd'hui
    </button>
    <button class="bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Cette semaine
    </button>
    <button class="bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Ce mois
    </button>
    <button class="bg-white text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Cette année
    </button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Statistiques des ventes -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Chiffre d'affaires</h3>
            <span class="bg-green-200 rounded-full p-2">
                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['chiffre_affaires'], 0, ',', ' ') }} FCFA</p>
        <div class="flex items-center mt-2">
            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <p class="text-sm text-green-600">Ce mois-ci</p>
        </div>
    </div>

    <!-- Commandes -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Commandes</h3>
            <span class="bg-blue-200 rounded-full p-2">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_commandes'] }}</p>
        <div class="flex items-center mt-2">
            <span class="w-2 h-2 rounded-full bg-yellow-400 mr-2"></span>
            <p class="text-sm text-gray-600">Ce mois-ci</p>
        </div>
    </div>

    <!-- Produits -->
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Produits</h3>
            <span class="bg-purple-200 rounded-full p-2">
                <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_produits'] }}</p>
        <div class="flex items-center mt-2">
            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
            <p class="text-sm text-gray-600">{{ $stats['produits_rupture'] }} en rupture de stock</p>
        </div>
    </div>
</div>

<!-- Graphiques et statistiques détaillées -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Graphique des ventes -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Évolution des ventes</h3>
            <select class="text-sm border-gray-300 rounded-md">
                <option>7 derniers jours</option>
                <option>30 derniers jours</option>
                <option>Cette année</option>
            </select>
        </div>
        <div class="relative h-[300px]">
            <canvas id="salesChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Meilleures ventes -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Meilleures ventes</h3>
            <select class="text-sm border-gray-300 rounded-md">
                <option>Ce mois</option>
                <option>Cette année</option>
                <option>Tout le temps</option>
            </select>
        </div>
        <div class="space-y-4">
            @foreach($meilleures_ventes as $vente)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <img src="{{ $vente->produit->image ?? 'https://via.placeholder.com/50' }}" 
                         alt="{{ $vente->produit->nom }}" 
                         class="w-12 h-12 rounded-lg object-cover">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $vente->produit->nom }}</h4>
                        <p class="text-sm text-gray-500">{{ $vente->total_vendu }} vendus</p>
                    </div>
                </div>
                <p class="font-medium text-gray-900">{{ number_format($vente->produit->prix, 0, ',', ' ') }} FCFA</p>
            </div>
            @endforeach

            @if($meilleures_ventes->isEmpty())
            <div class="p-4 text-center text-gray-500">
                Aucune vente enregistrée pour le moment
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Dernières commandes -->
<div class="bg-white rounded-lg shadow">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Dernières commandes</h2>
        <a href="{{ route('vendeur.commandes') }}" class="text-blue-500 hover:text-blue-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produits</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dernieres_commandes as $commande)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $commande->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($commande->client->nom) }}" 
                                     alt="{{ $commande->client->nom }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $commande->client->nom }}</div>
                                <div class="text-sm text-gray-500">{{ $commande->client->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $commande->ligneCommandes->sum('quantite') }} articles
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusClasses = [
                                'en_attente' => 'bg-yellow-100 text-yellow-800',
                                'validee' => 'bg-blue-100 text-blue-800',
                                'livree' => 'bg-green-100 text-green-800',
                                'annulee' => 'bg-red-100 text-red-800'
                            ];
                            $statusTexts = [
                                'en_attente' => 'En attente',
                                'validee' => 'Validée',
                                'livree' => 'Livrée',
                                'annulee' => 'Annulée'
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$commande->statut] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusTexts[$commande->statut] ?? 'Inconnu' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $commande->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucune commande récente
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuration du graphique des ventes
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Ventes',
                data: [150000, 300000, 250000, 450000, 300000, 550000, 400000],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
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
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' FCFA';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
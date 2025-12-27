@extends('layouts.app')

@section('title', 'Tableau de bord Vendeur')

@section('content')
<div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 min-h-screen">
    <!-- Header Premium -->
    <div class="sticky top-0 z-50 bg-gradient-to-r from-slate-900/95 to-slate-800/95 backdrop-blur-md border-b border-slate-700/50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-400 to-cyan-400 bg-clip-text text-transparent">Tableau de Bord</h1>
                    <p class="text-slate-400 mt-2">{{ Auth::user()->nom }} • {{ now()->translatedFormat('l j F Y') }}</p>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-4xl font-bold text-white">{{ number_format($stats['chiffre_affaires'] ?? 0, 0) }}</p>
                    <p class="text-sm text-slate-400">FCFA (Chiffre d'affaires)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filtres de Période -->
        <div class="flex flex-wrap gap-3 mb-12">
            @foreach(['today' => '📅 Aujourd\'hui', 'week' => '📊 Cette semaine', 'month' => '📈 Ce mois', 'year' => '📆 Cette année'] as $period => $label)
            <a href="{{ route('vendeur.dashboard', ['statsPeriode' => $period]) }}"
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ request('statsPeriode', 'today') == $period ? 'bg-gradient-to-r from-primary-700 to-cyan-600 text-white shadow-2xl shadow-primary-500/50 scale-105' : 'bg-slate-800/50 text-slate-300 hover:bg-slate-700/50 border border-slate-700/50' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        <!-- Cartes KPI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Chiffre d'affaires -->
            <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl shadow-xl p-6 text-white overflow-hidden group hover:shadow-2xl transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-primary-100 font-medium">Chiffre d'affaires</span>
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M8.16 2.75a.75.75 0 00-1.08 0l-5.5 5.5a.75.75 0 000 1.06l5.5 5.5a.75.75 0 101.06-1.06L4.31 8.75H15a.75.75 0 000-1.5H4.31l3.85-3.85a.75.75 0 000-1.06zM9.84 15a.75.75 0 001.08 0l5.5-5.5a.75.75 0 000-1.06l-5.5-5.5a.75.75 0 10-1.06 1.06l3.85 3.85H5a.75.75 0 000 1.5h10.69l-3.85 3.85a.75.75 0 000 1.06z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mb-2">{{ number_format($stats['chiffre_affaires'] ?? 0, 0) }} FCFA</p>
                    <p class="text-primary-100 text-sm">+12% par rapport à la période précédente</p>
                </div>
            </div>

            <!-- Commandes -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-xl p-6 text-white overflow-hidden group hover:shadow-2xl transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-emerald-100 font-medium">Commandes</span>
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1 4.5 4.5 0 11-4.814 6.947A4.001 4.001 0 015.5 13z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mb-2">{{ $stats['total_commandes'] ?? 0 }}</p>
                    <p class="text-emerald-100 text-sm">Commandes à traiter</p>
                </div>
            </div>

            <!-- Produits -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-xl p-6 text-white overflow-hidden group hover:shadow-2xl transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-purple-100 font-medium">Produits</span>
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 2a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mb-2">{{ $stats['total_produits'] ?? 0 }}</p>
                    <p class="text-purple-100 text-sm"><span class="font-semibold">{{ $stats['produits_rupture'] ?? 0 }}</span> en rupture</p>
                </div>
            </div>

            <!-- Stock -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-xl p-6 text-white overflow-hidden group hover:shadow-2xl transition-all">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-orange-100 font-medium">Stock Faible</span>
                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 15.572 13m0 0a4 4 0 11-8 0m8 0l2.89 2.89m-2.89-2.89L21 21m0-4v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold mb-2">{{ $stats['produits_rupture'] ?? 0 }}</p>
                    <p class="text-orange-100 text-sm">Produits à réapprovisionner</p>
                </div>
            </div>
        </div>

        <!-- Graphique et Dernières commandes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Graphique des ventes -->
            <div class="lg:col-span-2 bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white">Ventes sur 7 jours</h2>
                    <select class="bg-slate-700 border border-slate-600 text-white px-3 py-1 rounded-lg text-sm">
                        <option>7 jours</option>
                        <option>30 jours</option>
                        <option>90 jours</option>
                    </select>
                </div>
                <div class="h-80 bg-gradient-to-b from-slate-700/10 to-slate-900/50 rounded-lg p-4">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Dernières commandes -->
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Dernières Commandes</h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @if($dernieres_commandes->count() > 0)
                        @foreach($dernieres_commandes->take(5) as $cmd)
                        <a href="{{ route('vendeur.commandes.show', ['commande' => $cmd->idCommande]) }}" class="block p-3 bg-slate-700/30 hover:bg-slate-600/50 rounded-lg transition-colors border border-slate-600/50">
                            <div class="flex items-start justify-between mb-2">
                                <span class="font-semibold text-white text-sm">#{{ str_pad($cmd->idCommande, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $cmd->statut == 'en_attente' ? 'bg-yellow-500/20 text-yellow-400' :
                                       $cmd->statut == 'en_cours' ? 'bg-primary-500/20 text-primary-400' :
                                       $cmd->statut == 'livree' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ ucfirst($cmd->statut) }}
                                </span>
                            </div>
                            <p class="text-slate-400 text-sm mb-2">{{ $cmd->client->nom ?? 'N/A' }}</p>
                            <p class="text-emerald-400 font-bold">{{ number_format($cmd->total, 0) }} FCFA</p>
                        </a>
                        @endforeach
                    @else
                        <p class="text-slate-400 text-center py-8">Aucune commande</p>
                    @endif
                </div>
                <a href="{{ route('vendeur.commandes') }}" class="block mt-4 text-center bg-primary-700 hover:bg-primary-800 text-white py-2 rounded-lg font-medium transition-colors">
                    Voir toutes les commandes
                </a>
            </div>
        </div>

        <!-- Produits et Statistiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Meilleures ventes -->
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white">Meilleures Ventes</h2>
                    <a href="{{ route('vendeur.produits') }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium">Voir tout →</a>
                </div>
                <div class="space-y-3">
                    @if($meilleures_ventes->count() > 0)
                        @foreach($meilleures_ventes->take(5) as $vente)
                        <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/50 transition-colors">
                            @if($vente->images->count() > 0)
                            <img src="{{ asset('storage/' . $vente->images->first()->chemin) }}" alt="{{ $vente->nom }}" class="w-12 h-12 rounded object-cover">
                            @else
                            <div class="w-12 h-12 bg-slate-600 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $vente->nom }}</p>
                                <p class="text-slate-400 text-sm">{{ $vente->total_vendu ?? 0 }} ventes</p>
                            </div>
                            <p class="text-emerald-400 font-bold whitespace-nowrap">{{ number_format($vente->chiffre_affaires ?? 0, 0) }} FCFA</p>
                        </div>
                        @endforeach
                    @else
                        <p class="text-slate-400 text-center py-8">Aucune vente</p>
                    @endif
                </div>
            </div>

            <!-- Produits en rupture -->
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white">Stock Critique ⚠️</h2>
                    <a href="{{ route('vendeur.stock') }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium">Gérer →</a>
                </div>
                <div class="space-y-3">
                    @if($produits_rupture->count() > 0)
                        @foreach($produits_rupture->take(5) as $prod)
                        <div class="flex items-center gap-3 p-3 bg-red-500/10 border border-red-500/20 rounded-lg hover:bg-red-500/20 transition-colors">
                            <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full"></div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $prod->nom }}</p>
                                <p class="text-slate-400 text-sm">Stock: <span class="text-red-400 font-bold">{{ $prod->stock }}</span></p>
                            </div>
                            <a href="{{ route('vendeur.stock') }}" class="px-2 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded text-xs font-medium transition-colors">
                                Réapprovisionner
                            </a>
                        </div>
                        @endforeach
                    @else
                        <p class="text-slate-400 text-center py-8">Aucun produit en rupture</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('vendeur.produits.create') }}" class="bg-gradient-to-br from-primary-500 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-lg p-4 font-medium transition-all transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.5 1.5H9.25A1.25 1.25 0 008 2.75v16.5a1.25 1.25 0 001.25 1.25h1.25a1.25 1.25 0 001.25-1.25V2.75A1.25 1.25 0 0010.5 1.5z"></path></svg>
                Ajouter un produit
            </a>
            <a href="{{ route('vendeur.commandes') }}" class="bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-lg p-4 font-medium transition-all transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
                Commandes
            </a>
            <a href="{{ route('vendeur.stock') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg p-4 font-medium transition-all transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3.586a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H4a2 2 0 01-2-2V4z"></path></svg>
                Gérer le stock
            </a>
            <a href="{{ route('vendeur.rapports') }}" class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg p-4 font-medium transition-all transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                Rapports
            </a>
        </div>
    </div>
</div>

<!-- Chart.js script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const ctx = document.getElementById('salesChart');
    if (ctx) {
        const salesData = @json($salesChart ?? ['labels' => [], 'data' => []]);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.labels || [],
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: salesData.data || [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#1e293b',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
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
                        grid: {
                            color: 'rgba(100, 116, 139, 0.1)'
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    }
</script>
@endsection

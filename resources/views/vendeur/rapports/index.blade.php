@extends('layouts.app')

@section('title', 'Rapports & Analytiques')

@section('content')
<div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 border-b border-slate-700 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Rapports & Analytiques</h1>
                <p class="text-slate-400 mt-1">Analysez votre performance et vos statistiques</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Sélection de période -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6 mb-8">
            <div class="flex flex-wrap gap-3">
                <a href="?periode=last7" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('periode', 'last30') == 'last7' ? 'bg-primary-700 text-white' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50' }}">
                    7 derniers jours
                </a>
                <a href="?periode=last30" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('periode', 'last30') == 'last30' ? 'bg-primary-700 text-white' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50' }}">
                    30 derniers jours
                </a>
                <a href="?periode=last90" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('periode', 'last30') == 'last90' ? 'bg-primary-700 text-white' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50' }}">
                    90 derniers jours
                </a>
                <a href="?periode=thisYear" class="px-4 py-2 rounded-lg font-medium transition-all {{ request('periode', 'last30') == 'thisYear' ? 'bg-primary-700 text-white' : 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/50' }}">
                    Cette année
                </a>
            </div>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 font-medium">Chiffre d'affaires</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($stats['chiffre_affaires'] ?? 0, 0) }}</p>
                        <p class="text-primary-100 text-sm mt-1">FCFA</p>
                    </div>
                    <svg class="w-12 h-12 text-primary-200 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 font-medium">Commandes</p>
                        <p class="text-3xl font-bold mt-2">{{ $stats['total_commandes'] ?? 0 }}</p>
                        <p class="text-emerald-100 text-sm mt-1">Transactions</p>
                    </div>
                    <svg class="w-12 h-12 text-emerald-200 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 font-medium">Panier moyen</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format(($stats['chiffre_affaires'] ?? 0) / max($stats['total_commandes'] ?? 1, 1), 0) }}</p>
                        <p class="text-purple-100 text-sm mt-1">FCFA</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-200 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M8.16 2.75a.75.75 0 00-1.08 0l-5.5 5.5a.75.75 0 000 1.06l5.5 5.5a.75.75 0 101.06-1.06L4.31 8.75H15a.75.75 0 000-1.5H4.31l3.85-3.85a.75.75 0 000-1.06z"></path></svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 font-medium">Taux de conversion</p>
                        <p class="text-3xl font-bold mt-2">{{ $conversionRate }}%</p>
                        <p class="text-orange-100 text-sm mt-1">Clients actifs</p>
                    </div>
                    <svg class="w-12 h-12 text-orange-200 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414-1.414L13.586 7H12z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Graphique Ventes -->
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Ventes par jour</h2>
                <div class="h-80 bg-gradient-to-b from-slate-700/10 to-slate-900/50 rounded-lg p-4">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Graphique Catégories -->
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Ventes par catégorie</h2>
                <div class="h-80 bg-gradient-to-b from-slate-700/10 to-slate-900/50 rounded-lg p-4">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Meilleurs produits -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">🔥 Meilleurs produits</h2>
                <div class="space-y-3">
                    @if($meilleuresProduits->count() > 0)
                        @foreach($meilleuresProduits->take(5) as $produit)
                        <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/50 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $produit->nom }}</p>
                                <p class="text-sm text-slate-400">{{ $produit->total_vendu ?? 0 }} vendus</p>
                            </div>
                            <p class="text-emerald-400 font-bold whitespace-nowrap">{{ number_format($produit->chiffre_affaires ?? 0, 0) }} FCFA</p>
                        </div>
                        @endforeach
                    @else
                        <p class="text-slate-400 text-center py-8">Aucune donnée</p>
                    @endif
                </div>
            </div>

            <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">⭐ Produits top-notés</h2>
                <div class="space-y-3">
                    @if($produitsNotation->count() > 0)
                        @foreach($produitsNotation->take(5) as $produit)
                        <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/50 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $produit->nom }}</p>
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < round($produit->note_moyenne ?? 0))
                                        <span>★</span>
                                        @else
                                        <span class="text-slate-600">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-slate-300 font-bold whitespace-nowrap">{{ round($produit->note_moyenne ?? 0, 1) }}/5</p>
                        </div>
                        @endforeach
                    @else
                        <p class="text-slate-400 text-center py-8">Aucune donnée</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tableau détaillé -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6">
            <h2 class="text-xl font-bold text-white mb-4">📊 Synthèse détaillée</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-700">
                            <th class="text-left py-3 px-4 font-semibold text-slate-300">Métrique</th>
                            <th class="text-right py-3 px-4 font-semibold text-slate-300">Valeur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-4 text-slate-300">Commandes complètes</td>
                            <td class="text-right py-3 px-4 text-white font-medium">{{ $stats['commandes_completes'] ?? 0 }}</td>
                        </tr>
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-4 text-slate-300">Commandes en cours</td>
                            <td class="text-right py-3 px-4 text-white font-medium">{{ $stats['commandes_en_cours'] ?? 0 }}</td>
                        </tr>
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-4 text-slate-300">Produits actifs</td>
                            <td class="text-right py-3 px-4 text-white font-medium">{{ $stats['produits_actifs'] ?? 0 }}</td>
                        </tr>
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-4 text-slate-300">Clients uniques</td>
                            <td class="text-right py-3 px-4 text-white font-medium">{{ $stats['clients_uniques'] ?? 0 }}</td>
                        </tr>
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="py-3 px-4 text-slate-300">Taux de satisfaction moyen</td>
                            <td class="text-right py-3 px-4 text-white font-medium">{{ round($stats['satisfaction_moyenne'] ?? 0, 1) }}/5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    const salesData = @json($salesChart ?? ['labels' => [], 'data' => []]);
    const categoriesData = @json($categoriesChart ?? ['labels' => [], 'data' => []]);

    // Graphique des ventes
    const ctx1 = document.getElementById('salesChart');
    if (ctx1) {
        new Chart(ctx1, {
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
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(100, 116, 139, 0.1)' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });
    }

    // Graphique des catégories
    const ctx2 = document.getElementById('categoriesChart');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: categoriesData.labels || [],
                datasets: [{
                    data: categoriesData.data || [],
                    backgroundColor: [
                        '#3b82f6',
                        '#8b5cf6',
                        '#ec4899',
                        '#f59e0b',
                        '#10b981',
                        '#06b6d4'
                    ],
                    borderColor: '#1e293b'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8' }
                    }
                }
            }
        });
    }
</script>
@endsection

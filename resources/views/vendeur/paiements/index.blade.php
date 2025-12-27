@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('content')
<div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 border-b border-slate-700 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Gestion des Paiements</h1>
                <p class="text-slate-400 mt-1">Consultez le statut des paiements de vos commandes</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg p-4 text-white">
                <p class="text-emerald-100 text-sm font-medium mb-1">Paiements reçus</p>
                <p class="text-2xl font-bold">{{ number_format($totalRecu, 0) }} FCFA</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                <p class="text-yellow-100 text-sm font-medium mb-1">En attente</p>
                <p class="text-2xl font-bold">{{ number_format($totalEnAttente, 0) }} FCFA</p>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4 text-white">
                <p class="text-red-100 text-sm font-medium mb-1">Échoués</p>
                <p class="text-2xl font-bold">{{ $paiements->where('statut', 'echec')->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg p-4 text-white">
                <p class="text-primary-100 text-sm font-medium mb-1">Taux de réussite</p>
                <p class="text-2xl font-bold">{{ $tauxReussite }}%</p>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Recherche -->
                <div>
                    <input type="text" 
                           placeholder="Rechercher par commande..." 
                           class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                </div>

                <!-- Statut -->
                <select class="bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Tous les statuts</option>
                    <option value="reussi">Reçu</option>
                    <option value="en_attente">En attente</option>
                    <option value="echec">Échoué</option>
                </select>

                <!-- Période -->
                <select class="bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Toutes les périodes</option>
                    <option value="today">Aujourd'hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month">Ce mois</option>
                    <option value="year">Cette année</option>
                </select>
            </div>
        </div>

        <!-- Tableau des paiements -->
        @if($paiements->count() > 0)
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-700 bg-slate-900/50">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">N° Commande</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Client</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Montant</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Méthode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Date</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Statut</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($paiements as $paiement)
                        <tr class="hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-white">#{{ str_pad($paiement->commande->idCommande ?? 'N/A', 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <p class="font-medium text-white">{{ $paiement->commande->client->nom ?? 'N/A' }}</p>
                                    <p class="text-sm text-slate-400">{{ $paiement->commande->client->email ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="font-bold text-emerald-400">{{ number_format($paiement->montant, 0) }} FCFA</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ ucfirst(str_replace('_', ' ', $paiement->methode ?? 'N/A')) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $paiement->dateTransaction?->format('d/m/Y H:i') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $paiement->statut == 'reussi' ? 'bg-green-500/20 text-green-400' : ($paiement->statut == 'en_attente' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                    {{ ucfirst($paiement->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="#" class="px-3 py-1 bg-primary-700/20 hover:bg-primary-700/30 text-primary-400 rounded-lg text-sm font-medium transition-colors">
                                    Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($paiements->hasPages())
            <div class="px-6 py-4 border-t border-slate-700 bg-slate-900/50">
                {{ $paiements->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-12 text-center">
            <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155.03.299.076.4.136.101-.06.245-.106.4-.136a9.901 9.901 0 01-.8 0c.155.03.299.076.4.136.101-.06.245-.106.4-.136zm0 0a10.122 10.122 0 00-1.917-.867 6.5 6.5 0 10-5.098 5.6c.169.555.456 1.074.814 1.529m0 0a10.02 10.02 0 003.658 1.74m0 0l-.468-.468a9.968 9.968 0 00-2.992-2.83"></path></svg>
            <h3 class="text-xl font-bold text-white mb-2">Aucun paiement</h3>
            <p class="text-slate-400">Vous n'avez pas encore reçu de paiement.</p>
        </div>
        @endif
    </div>
</div>
@endsection

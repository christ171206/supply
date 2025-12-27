@extends('layouts.app')

@section('title', 'Gestion des Commandes')

@section('content')
<div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 border-b border-slate-700 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Gestion des Commandes</h1>
                <p class="text-slate-400 mt-1">Consultez et gérez toutes vos commandes</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="md:col-span-2">
                    <input type="text" 
                           placeholder="Rechercher par numéro ou client..." 
                           class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                </div>

                <!-- Statut -->
                <select class="bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="en_cours">En cours</option>
                    <option value="livree">Livrée</option>
                    <option value="annulee">Annulée</option>
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

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                <p class="text-slate-400 text-sm font-medium mb-1">Commandes totales</p>
                <p class="text-2xl font-bold text-white">{{ $commandes->count() }}</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                <p class="text-slate-400 text-sm font-medium mb-1">En attente</p>
                <p class="text-2xl font-bold text-yellow-400">{{ $commandes->where('statut', 'en_attente')->count() }}</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                <p class="text-slate-400 text-sm font-medium mb-1">En cours</p>
                <p class="text-2xl font-bold text-primary-400">{{ $commandes->where('statut', 'en_cours')->count() }}</p>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                <p class="text-slate-400 text-sm font-medium mb-1">Livrées</p>
                <p class="text-2xl font-bold text-green-400">{{ $commandes->where('statut', 'livree')->count() }}</p>
            </div>
        </div>

        <!-- Tableau des commandes -->
        @if($commandes->count() > 0)
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-700 bg-slate-900/50">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">N° Commande</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Client</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Date</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Montant</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Statut</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($commandes as $cmd)
                        <tr class="hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-white">#{{ str_pad($cmd->idCommande, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <p class="font-medium text-white">{{ $cmd->client->nom ?? 'N/A' }}</p>
                                    <p class="text-sm text-slate-400">{{ $cmd->client->email ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $cmd->dateCommande->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="font-bold text-emerald-400">{{ number_format($cmd->total, 0) }} FCFA</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $cmd->statut == 'en_attente' ? 'bg-yellow-500/20 text-yellow-400' : ($cmd->statut == 'en_cours' ? 'bg-primary-500/20 text-primary-400' : ($cmd->statut == 'livree' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $cmd->statut)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('vendeur.commandes.show', $cmd->idCommande) }}" 
                                       class="px-3 py-1 bg-primary-700/20 hover:bg-primary-700/30 text-primary-400 rounded-lg text-sm font-medium transition-colors">
                                        Voir
                                    </a>
                                    @if($cmd->statut != 'livree' && $cmd->statut != 'annulee')
                                    <select onchange="updateStatut({{ $cmd->idCommande }}, this.value)" 
                                            class="px-2 py-1 bg-slate-700 border border-slate-600 text-white rounded text-sm font-medium focus:outline-none">
                                        <option value="">Changement...</option>
                                        <option value="en_attente" @if($cmd->statut == 'en_attente') disabled @endif>En attente</option>
                                        <option value="en_cours" @if($cmd->statut == 'en_cours') disabled @endif>En cours</option>
                                        <option value="livree" @if($cmd->statut == 'livree') disabled @endif>Livrée</option>
                                        <option value="annulee">Annuler</option>
                                    </select>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($commandes->hasPages())
            <div class="px-6 py-4 border-t border-slate-700 bg-slate-900/50">
                {{ $commandes->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-12 text-center">
            <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path></svg>
            <h3 class="text-xl font-bold text-white mb-2">Aucune commande</h3>
            <p class="text-slate-400">Vous n'avez pas encore reçu de commande.</p>
        </div>
        @endif
    </div>
</div>

<script>
function updateStatut(commandeId, newStatut) {
    if (!newStatut) return;
    
    fetch(`/vendeur/commandes/${commandeId}/statut`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ statut: newStatut })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Impossible de mettre à jour'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
}
</script>
@endsection

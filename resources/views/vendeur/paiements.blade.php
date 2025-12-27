@extends('layouts.vendeur')

@section('title', 'Gestion des paiements')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des paiements</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                onclick="window.location.href='{{ route('vendeur.paiements.export') }}'">
            Exporter les données
        </button>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4">
            <form action="{{ route('vendeur.paiements') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="periode" class="block text-sm font-medium text-gray-700">Période</label>
                    <select name="periode" id="periode" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="tous">Toutes les périodes</option>
                        <option value="aujourd'hui">Aujourd'hui</option>
                        <option value="semaine">Cette semaine</option>
                        <option value="mois">Ce mois</option>
                        <option value="annee">Cette année</option>
                    </select>
                </div>
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="reussi">Réussi</option>
                        <option value="en_attente">En attente</option>
                        <option value="echoue">Échoué</option>
                    </select>
                </div>
                <div>
                    <label for="montant_min" class="block text-sm font-medium text-gray-700">Montant minimum</label>
                    <input type="number" name="montant_min" id="montant_min" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="0">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total des paiements -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total des paiements</h3>
            <p class="text-3xl font-bold text-blue-600">
                {{ number_format($total_paiements ?? 0, 0, ',', ' ') }} FCFA
            </p>
            <p class="text-sm text-gray-500 mt-2">Sur la période sélectionnée</p>
        </div>

        <!-- Nombre de transactions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Nombre de transactions</h3>
            <p class="text-3xl font-bold text-green-600">
                {{ $nombre_transactions ?? 0 }}
            </p>
            <p class="text-sm text-gray-500 mt-2">Transactions réussies</p>
        </div>

        <!-- Taux de réussite -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Taux de réussite</h3>
            <p class="text-3xl font-bold text-purple-600">
                {{ $taux_reussite ?? 0 }}%
            </p>
            <p class="text-sm text-gray-500 mt-2">Des transactions</p>
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Référence
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mode
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paiements ?? [] as $paiement)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $paiement->reference }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($paiement->commande->client->nom) }}" 
                                         alt="{{ $paiement->commande->client->nom }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $paiement->commande->client->nom }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $paiement->commande->client->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $paiement->mode }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'reussi' => 'bg-green-100 text-green-800',
                                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                                    'echoue' => 'bg-red-100 text-red-800'
                                ];
                                $statusTexts = [
                                    'reussi' => 'Réussi',
                                    'en_attente' => 'En attente',
                                    'echoue' => 'Échoué'
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$paiement->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusTexts[$paiement->statut] ?? 'Inconnu' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $paiement->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="window.location.href='{{ route('vendeur.commandes.show', $paiement->commande_id) }}'"
                                    class="text-blue-600 hover:text-blue-900">
                                Voir commande
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Aucun paiement trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($paiements) && method_exists($paiements, 'links'))
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $paiements->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
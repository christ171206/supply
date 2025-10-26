<!-- Modal de détails de commande -->
<div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
    <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-xl font-semibold text-gray-900">
            Détails de la commande #{{ $commande->reference }}
        </h3>
        <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="mt-4 space-y-6">
        <!-- En-tête avec statut et date -->
        <div class="flex justify-between items-start">
            <div>
                <span class="px-2 py-1 text-sm font-semibold rounded-full
                    @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                    @elseif($commande->statut === 'en_cours') bg-blue-100 text-blue-800
                    @elseif($commande->statut === 'livree') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                </span>
                <p class="mt-1 text-sm text-gray-500">
                    Commandé le {{ $commande->dateCommande->format('d/m/Y à H:i') }}
                </p>
            </div>
            @if($commande->paiement)
            <div class="text-right">
                <span class="px-2 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                    Payé
                </span>
                <p class="mt-1 text-sm text-gray-500">
                    le {{ $commande->paiement->datePaiement->format('d/m/Y') }}
                </p>
            </div>
            @endif
        </div>

        <!-- Informations client -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-lg font-medium text-gray-900 mb-3">Informations client</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nom complet</p>
                    <p class="mt-1">{{ $commande->client->nom }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1">{{ $commande->client->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                    <p class="mt-1">{{ $commande->client->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Adresse de livraison</p>
                    <p class="mt-1">{{ $commande->adresseLivraison ?? 'Non renseignée' }}</p>
                </div>
            </div>
        </div>

        <!-- Articles commandés -->
        <div>
            <h4 class="text-lg font-medium text-gray-900 mb-3">Articles commandés</h4>
            <div class="bg-white shadow overflow-hidden rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produit
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix unitaire
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantité
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($commande->lignes as $ligne)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($ligne->produit->image)
                                    <img class="h-10 w-10 rounded-lg object-cover"
                                         src="{{ Storage::url($ligne->produit->image) }}"
                                         alt="{{ $ligne->produit->nom }}">
                                    @else
                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ligne->produit->nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Réf: {{ $ligne->produit->reference }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ number_format($ligne->prixUnitaire, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ $ligne->quantite }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{ number_format($ligne->prixUnitaire * $ligne->quantite, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Total</td>
                            <td class="px-6 py-4 text-right text-lg font-bold">
                                {{ number_format($commande->total, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Historique de la commande -->
        @if($commande->historique && $commande->historique->count() > 0)
        <div>
            <h4 class="text-lg font-medium text-gray-900 mb-3">Historique de la commande</h4>
            <div class="space-y-4">
                @foreach($commande->historique->sortByDesc('created_at') as $event)
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $event->description }}</p>
                        <p class="text-sm text-gray-500">{{ $event->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-end space-x-3 border-t pt-4">
            <button onclick="closeOrderDetails()" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Fermer
            </button>
            
            @if($commande->statut === 'en_attente')
            <button onclick="updateOrderStatus('{{ $commande->idCommande }}', 'en_cours')"
                    class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Valider la commande
            </button>
            @elseif($commande->statut === 'en_cours')
            <button onclick="updateOrderStatus('{{ $commande->idCommande }}', 'livree')"
                    class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Marquer comme livrée
            </button>
            @endif
        </div>
    </div>
</div>
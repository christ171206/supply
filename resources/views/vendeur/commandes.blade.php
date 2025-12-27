@extends('layouts.vendeur')

@section('title', 'Commandes')

@section('content')
<div class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre des commandes -->
        <div class="col-span-3 bg-white rounded-lg shadow-sm p-4">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('vendeur.commandes') }}"
                   class="px-4 py-2 {{ !request('statut') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }} rounded-lg hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Toutes ({{ $stats['total'] ?? 0 }})
                </a>
                <a href="{{ route('vendeur.commandes', ['statut' => 'en_attente']) }}"
                   class="px-4 py-2 {{ request('statut') === 'en_attente' ? 'bg-yellow-600 text-white' : 'bg-white text-gray-700' }} rounded-lg hover:bg-yellow-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                    En attente ({{ $stats['en_attente'] ?? 0 }})
                </a>
                <a href="{{ route('vendeur.commandes', ['statut' => 'en_cours']) }}"
                   class="px-4 py-2 {{ request('statut') === 'en_cours' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700' }} rounded-lg hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    En cours ({{ $stats['en_cours'] ?? 0 }})
                </a>
                <a href="{{ route('vendeur.commandes', ['statut' => 'livree']) }}"
                   class="px-4 py-2 {{ request('statut') === 'livree' ? 'bg-green-600 text-white' : 'bg-white text-gray-700' }} rounded-lg hover:bg-green-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Livrées ({{ $stats['livrees'] ?? 0 }})
                </a>
            </div>
        </div>

        <!-- Recherche -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="relative">
                <input type="text" placeholder="Rechercher une commande..." class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-10">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Liste des commandes -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commande</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($commandes as $commande)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">#{{ $commande->reference }}</div>
                        <div class="text-sm text-gray-500">{{ $commande->lignes->count() }} article(s)</div>
                    </td>
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $commande->dateCommande->format('d M. Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $commande->dateCommande->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($commande->statut === 'en_attente') bg-yellow-100 text-yellow-800
                            @elseif($commande->statut === 'en_cours') bg-blue-100 text-blue-800
                            @elseif($commande->statut === 'livree') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <button onclick="showOrderDetails('{{ $commande->idCommande }}')"
                                class="text-blue-600 hover:text-blue-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        @if($commande->statut === 'en_attente')
                        <button onclick="updateOrderStatus('{{ $commande->idCommande }}', 'en_cours')"
                                class="text-green-600 hover:text-green-900"
                                title="Valider la commande">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                        @endif
                        @if($commande->statut === 'en_cours')
                        <button onclick="updateOrderStatus('{{ $commande->idCommande }}', 'livree')"
                                class="text-indigo-600 hover:text-indigo-900"
                                title="Marquer comme livrée">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7m-4 4v10H5V7h10m4-4v4m0 0h4m-4 0H7"/>
                            </svg>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucune commande trouvée
                    </td>
                </tr>
                @endforelse

                <!-- Plus de commandes peuvent être ajoutées ici -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Précédent
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Suivant
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">45</span> résultats
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Précédent</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            1
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            2
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            3
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-50 text-sm font-medium text-gray-700">
                            ...
                        </span>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            8
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Suivant</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails Commande -->
<div id="orderDetailsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-xl font-semibold">Détails de la commande #CMD-001</h3>
            <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

       

            <!-- Articles commandés -->
            <div class="mb-6">
                <h4 class="text-lg font-medium mb-2">Articles commandés</h4>
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix unitaire</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-lg object-cover" src="https://via.placeholder.com/150" alt="">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">iPhone 12 Pro</div>
                                            <div class="text-sm text-gray-500">Smartphone Apple</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">25,000 FCFA</td>
                                <td class="px-6 py-4 text-sm text-gray-900">2</td>
                                <td class="px-6 py-4 text-sm text-gray-900">50,000 FCFA</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-medium">Total</td>
                                <td class="px-6 py-4 text-lg font-bold text-gray-900">75,000 FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Historique de la commande -->
            <div class="mb-6">
                <h4 class="text-lg font-medium mb-2">Historique de la commande</h4>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h6 class="text-sm font-medium text-gray-900">Commande reçue</h6>
                            <p class="text-sm text-gray-500">22 Oct. 2025, 14:30</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <button onclick="closeOrderDetails()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Fermer</button>
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg">Valider la commande</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function showOrderDetails(orderId) {
        try {
            const response = await fetch(`/vendeur/commandes/${orderId}`);
            const data = await response.json();

            if (data.html) {
                const modalContent = document.getElementById('orderDetailsModal');
                modalContent.innerHTML = data.html;
                modalContent.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Erreur lors du chargement des détails:', error);
            alert('Une erreur est survenue lors du chargement des détails de la commande.');
        }
    }

    function closeOrderDetails() {
        document.getElementById('orderDetailsModal').classList.add('hidden');
    }

    async function updateOrderStatus(orderId, newStatus) {
        if (!confirm('Êtes-vous sûr de vouloir modifier le statut de cette commande ?')) {
            return;
        }

        try {
            const response = await fetch(`/vendeur/commandes/${orderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ statut: newStatus })
            });

            const data = await response.json();

            if (response.ok) {
                // Recharger la page pour montrer le nouveau statut
                window.location.reload();
            } else {
                alert(data.message || 'Une erreur est survenue lors de la mise à jour du statut.');
            }
        } catch (error) {
            console.error('Erreur lors de la mise à jour du statut:', error);
            alert('Une erreur est survenue lors de la mise à jour du statut.');
        }
    }

    // Fermer le modal quand on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('orderDetailsModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }

    // Recherche en temps réel
    const searchInput = document.querySelector('input[type="text"]');
    let timeoutId;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            const searchParams = new URLSearchParams(window.location.search);
            searchParams.set('search', this.value);
            window.location.search = searchParams.toString();
        }, 500);
    });
</script>
@endpush

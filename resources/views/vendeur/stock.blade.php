@extends('layouts.vendeur')

@section('title', 'Gestion des stocks')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des stocks</h1>
        <a href="{{ route('vendeur.produits.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Ajouter un produit
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4">
            <form action="{{ route('vendeur.stock') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Rechercher</label>
                    <input type="text" name="search" id="search" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Nom du produit...">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="category" id="category" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->idCategorie }}">{{ $category->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Niveau de stock</label>
                    <select name="stock" id="stock" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous les niveaux</option>
                        <option value="rupture">En rupture</option>
                        <option value="faible">Stock faible</option>
                        <option value="normal">Stock normal</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Produit
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Catégorie
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock actuel
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock minimum
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dernière mise à jour
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($produits as $produit)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-lg object-cover" 
                                     src="{{ $produit->image ?? asset('images/default-product.png') }}" 
                                     alt="{{ $produit->nom }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $produit->nom }}</div>
                                <div class="text-sm text-gray-500">Réf: {{ $produit->reference }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $produit->categorie->nom ?? 'Non catégorisé' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($produit->quantite <= 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Rupture
                            </span>
                        @elseif($produit->quantite < 5)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ $produit->quantite }} unités
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $produit->quantite }} unités
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $produit->stock_minimum }} unités
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $produit->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openAdjustStockModal({{ $produit->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                            Ajuster
                        </button>
                        <a href="{{ route('vendeur.produits.edit', $produit) }}" class="text-green-600 hover:text-green-900">
                            Modifier
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucun produit trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $produits->links() }}
        </div>
    </div>
</div>

<!-- Modal d'ajustement de stock -->
<div id="adjustStockModal" class="fixed z-10 inset-0 overflow-y-auto hidden" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="adjustStockForm" method="POST" action="">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Ajuster le stock
                            </h3>
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Type d'ajustement</label>
                                <select name="type" id="type" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="entree">Entrée de stock</option>
                                    <option value="sortie">Sortie de stock</option>
                                </select>
                            </div>
                            <div>
                                <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                                <input type="number" name="quantite" id="quantite" required min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Valider
                    </button>
                    <button type="button" onclick="closeAdjustStockModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAdjustStockModal(productId) {
    const modal = document.getElementById('adjustStockModal');
    const form = document.getElementById('adjustStockForm');
    form.action = `/vendeur/stock/ajuster/${productId}`;
    modal.classList.remove('hidden');
}

function closeAdjustStockModal() {
    const modal = document.getElementById('adjustStockModal');
    modal.classList.add('hidden');
}

// Fermer le modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('adjustStockModal');
    if (event.target == modal) {
        closeAdjustStockModal();
    }
}
</script>
@endpush
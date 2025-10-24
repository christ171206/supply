@extends('layouts.vendeur')

@section('title', 'Gestion des stocks')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Gestion des stocks</h1>
    </div>

    <!-- Résumé des stocks -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg shadow-sm p-6 hover:from-slate-100 hover:to-slate-200 transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-700">Stock total</h3>
                <span class="bg-sky-100 rounded-full p-2">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $totalStock ?? 0 }}</p>
            <p class="text-sm text-slate-600 mt-2">Produits en stock</p>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg shadow-sm p-6 hover:from-slate-100 hover:to-slate-200 transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-700">En rupture</h3>
                <span class="bg-red-100 rounded-full p-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stockRupture ?? 0 }}</p>
            <p class="text-sm text-slate-600 mt-2">Produits en rupture</p>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg shadow-sm p-6 hover:from-slate-100 hover:to-slate-200 transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-700">Stock faible</h3>
                <span class="bg-yellow-100 rounded-full p-2">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stockFaible ?? 0 }}</p>
            <p class="text-sm text-slate-600 mt-2">Produits à réapprovisionner</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4">
            <form action="{{ route('vendeur.stock') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700">Rechercher</label>
                    <input type="text" name="search" id="search" 
                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                           placeholder="Nom du produit...">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700">Catégorie</label>
                    <select name="category" id="category" 
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->idCategorie }}">{{ $category->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-slate-700">Niveau de stock</label>
                    <select name="stock" id="stock" 
                            class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="">Tous les niveaux</option>
                        <option value="rupture">En rupture</option>
                        <option value="faible">Stock faible</option>
                        <option value="normal">Stock normal</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-sky-100 text-sky-700 px-4 py-2 rounded-lg hover:bg-sky-200 transition-colors">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Produit
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Catégorie
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Stock actuel
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Stock minimum
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Dernière mise à jour
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($produits as $produit)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-lg object-cover shadow-sm" 
                                     src="{{ $produit->image ?? asset('images/default-product.png') }}" 
                                     alt="{{ $produit->nom }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-900">{{ $produit->nom }}</div>
                                <div class="text-sm text-slate-500">Réf: {{ $produit->reference }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-slate-900">{{ $produit->categorie->nom ?? 'Non catégorisé' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($produit->quantite <= 0)
                            <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Rupture
                            </span>
                        @elseif($produit->quantite < 5)
                            <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $produit->quantite }} unités
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $produit->quantite }} unités
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        {{ $produit->stock_minimum }} unités
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        {{ $produit->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex space-x-3">
                            <button onclick="openAdjustStockModal({{ $produit->id }})" 
                                    class="flex items-center px-3 py-1 rounded-md bg-sky-100 text-sky-700 hover:bg-sky-200 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Ajuster
                            </button>
                            <a href="{{ route('vendeur.produits.edit', $produit) }}" 
                               class="flex items-center px-3 py-1 rounded-md bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Modifier
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-slate-500">
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
                            <h3 class="text-lg leading-6 font-medium text-slate-900 mb-4" id="modal-title">
                                Ajuster le stock
                            </h3>
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-slate-700">Type d'ajustement</label>
                                <select name="type" id="type" required 
                                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                    <option value="entree">Entrée de stock</option>
                                    <option value="sortie">Sortie de stock</option>
                                </select>
                            </div>
                            <div>
                                <label for="quantite" class="block text-sm font-medium text-slate-700">Quantité</label>
                                <input type="number" name="quantite" id="quantite" required min="1"
                                       class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-200">
                    <button type="submit" class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Valider
                    </button>
                    <button type="button" onclick="closeAdjustStockModal()" class="mt-3 w-full inline-flex justify-center items-center rounded-md border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
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
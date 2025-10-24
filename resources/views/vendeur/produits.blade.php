@extends('layouts.vendeur')

@section('title', 'Mes Produits')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-slate-800">Mes Produits</h1>
    <button onclick="document.getElementById('addProductModal').classList.remove('hidden')" 
            class="bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 flex items-center shadow-sm transition-all duration-200 group">
        <span class="bg-sky-600/50 rounded-md p-1 mr-2 group-hover:bg-sky-700/50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
        Ajouter un produit
    </button>
</div>

<!-- Filtres et recherche -->
<div class="mb-6 bg-white rounded-lg shadow-sm p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="relative">
            <input type="text" 
                   placeholder="Rechercher un produit..." 
                   class="w-full px-4 py-2 border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 pl-10 transition-colors">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <div>
            <select class="w-full px-4 py-2 border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-600 transition-colors">
                <option value="">Toutes les catégories</option>
                <option value="electronique">Électronique</option>
                <option value="vetements">Vêtements</option>
                <option value="alimentation">Alimentation</option>
            </select>
        </div>
        <div>
            <select class="w-full px-4 py-2 border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-600 transition-colors">
                <option value="">Tous les statuts</option>
                <option value="en_stock">En stock</option>
                <option value="rupture">Rupture de stock</option>
            </select>
        </div>
        <div>
            <select class="w-full px-4 py-2 border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-600 transition-colors">
                <option value="recent">Plus récents</option>
                <option value="ancien">Plus anciens</option>
                <option value="prix_croissant">Prix croissant</option>
                <option value="prix_decroissant">Prix décroissant</option>
            </select>
        </div>
    </div>
</div>

<!-- Liste des produits -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Produit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Catégorie</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Prix</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                            <img class="h-10 w-10 rounded-lg object-cover" src="https://via.placeholder.com/150" alt="Product image">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">iPhone 12 Pro</div>
                            <div class="text-sm text-gray-500">Smartphone Apple</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">Électronique</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">899,000 FCFA</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">15</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        En stock
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-3">
                        <button class="text-sky-600 hover:text-sky-800 transition-colors">Modifier</button>
                        <button class="text-rose-600 hover:text-rose-800 transition-colors">Supprimer</button>
                    </div>
                </td>
            </tr>
            <!-- Plus de lignes de produits peuvent être ajoutées ici -->
        </tbody>
    </table>

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
                        Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">97</span> résultats
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
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            9
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            10
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

<!-- Modal Ajouter Produit -->
<div id="addProductModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border border-slate-200 w-[500px] shadow-xl rounded-lg bg-white">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-xl font-semibold text-slate-900 flex items-center">
                <span class="bg-sky-100 rounded-md p-1.5 mr-3">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </span>
                Ajouter un produit
            </h3>
            <button onclick="document.getElementById('addProductModal').classList.add('hidden')" 
                    class="text-slate-400 hover:text-slate-500 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form>
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="name">
                            Nom du produit
                        </label>
                        <input class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                               id="name" 
                               type="text" 
                               placeholder="Nom du produit">
                    </div>

                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="category">
                            Catégorie
                        </label>
                        <select class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                                id="category">
                            <option>Sélectionnez une catégorie</option>
                            <option>Électronique</option>
                            <option>Vêtements</option>
                            <option>Alimentation</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="price">
                            Prix
                        </label>
                        <div class="relative">
                            <input class="w-full py-2 px-3 pl-16 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                                   id="price" 
                                   type="number" 
                                   placeholder="0">
                            <div class="absolute inset-y-0 left-0 px-3 flex items-center pointer-events-none text-slate-500 border-r border-slate-300">
                                FCFA
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="stock">
                            Stock initial
                        </label>
                        <input class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                               id="stock" 
                               type="number" 
                               placeholder="Quantité en stock">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2" for="description">
                        Description
                    </label>
                    <textarea class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                              id="description" 
                              rows="3" 
                              placeholder="Description du produit"></textarea>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2" for="image">
                        Image du produit
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-sky-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600">
                                <label for="image" class="relative cursor-pointer rounded-md font-medium text-sky-600 hover:text-sky-500">
                                    <span>Télécharger une image</span>
                                    <input id="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-slate-500">
                                PNG, JPG jusqu'à 10MB
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <button onclick="document.getElementById('addProductModal').classList.add('hidden')" 
                        type="button" 
                        class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors shadow-sm inline-flex items-center">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Ajouter le produit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Gestionnaire pour ouvrir/fermer le modal
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    // Fermer le modal quand on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('addProductModal');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endpush
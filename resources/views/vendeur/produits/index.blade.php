@extends('layouts.vendeur')

@section('title', 'Gestion des Produits')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Produits</h1>
            <p class="mt-1 text-sm text-gray-500">Gérez votre catalogue de produits</p>
        </div>
        <a href="{{ route('vendeur.produits.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Ajouter un produit
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('vendeur.produits') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Rechercher</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" name="search" id="search"
                               value="{{ request('search') }}"
                               class="form-input block w-full sm:text-sm"
                               placeholder="Nom ou référence du produit">
                    </div>
                </div>

                <!-- Filtrage par catégorie -->
                <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="categorie" id="categorie" class="mt-1 form-select block w-full sm:text-sm">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->idCategorie }}" 
                                {{ request('categorie') == $categorie->idCategorie ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtrage par stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">État du stock</label>
                    <select name="stock" id="stock" class="mt-1 form-select block w-full sm:text-sm">
                        <option value="">Tous les niveaux</option>
                        <option value="rupture" {{ request('stock') === 'rupture' ? 'selected' : '' }}>En rupture</option>
                        <option value="faible" {{ request('stock') === 'faible' ? 'selected' : '' }}>Stock faible</option>
                        <option value="normal" {{ request('stock') === 'normal' ? 'selected' : '' }}>Stock normal</option>
                    </select>
                </div>
            </div>

            <!-- Tri -->
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <select name="sort" class="form-select text-sm">
                        <option value="dateAjout" {{ request('sort') === 'dateAjout' ? 'selected' : '' }}>Date d'ajout</option>
                        <option value="nom" {{ request('sort') === 'nom' ? 'selected' : '' }}>Nom</option>
                        <option value="prix" {{ request('sort') === 'prix' ? 'selected' : '' }}>Prix</option>
                        <option value="stock" {{ request('sort') === 'stock' ? 'selected' : '' }}>Stock</option>
                    </select>
                    <select name="direction" class="form-select text-sm">
                        <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                        <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Croissant</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des produits -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($produits as $produit)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($produit->image)
                                    <img class="h-10 w-10 rounded-lg object-cover" 
                                         src="{{ Storage::url($produit->image) }}" 
                                         alt="{{ $produit->nom }}">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $produit->nom }}</div>
                                    <div class="text-sm text-gray-500">Réf: {{ $produit->reference }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $produit->categorie->nom }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                            {{ number_format($produit->prix, 2, ',', ' ') }} €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            @if($produit->stock === 0)
                                <span class="text-red-600 font-medium">Rupture</span>
                            @elseif($produit->stock <= 5)
                                <span class="text-yellow-600 font-medium">{{ $produit->stock }}</span>
                            @else
                                <span class="text-green-600 font-medium">{{ $produit->stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('vendeur.produits.show', $produit) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('vendeur.produits.edit', $produit) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('vendeur.produits.delete', $produit) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucun produit trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $produits->links() }}
        </div>
    </div>
</div>
@endsection
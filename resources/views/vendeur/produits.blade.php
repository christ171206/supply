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
        <form action="{{ route('vendeur.produits') }}" method="GET" class="flex-1">
            <div>
                <select name="categorie" onchange="this.form.submit()" class="w-full px-4 py-2 border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-600 transition-colors">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->idCategorie }}" {{ request('categorie') == $categorie->idCategorie ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
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
            @forelse ($produits as $produit)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-lg object-cover" 
                                 src="{{ $produit->image ? Storage::url($produit->image) : asset('images/default-product.png') }}" 
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
                    <div class="text-sm text-gray-900">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $produit->stock }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($produit->stock > 10)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            En stock
                        </span>
                    @elseif($produit->stock > 0)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                            Stock faible
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                            Rupture
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-3">
                        <a href="{{ route('vendeur.produits.edit', $produit) }}" 
                           class="text-sky-600 hover:text-sky-800 transition-colors">
                            Modifier
                        </a>
                        <form action="{{ route('vendeur.produits.destroy', $produit) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center">
                    <div class="flex flex-col items-center justify-center text-slate-500">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-lg font-medium">Aucun produit trouvé</p>
                        <p class="mt-1">Commencez par ajouter votre premier produit</p>
                    </div>
                </td>
            </tr>
            @endforelse
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
                        Affichage de <span class="font-medium">{{ $produits->firstItem() }}</span> à <span class="font-medium">{{ $produits->lastItem() }}</span> sur <span class="font-medium">{{ $produits->total() }}</span> résultats
                    </p>
                </div>
                <div>
                    {{ $produits->links() }}
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

        <form action="{{ route('vendeur.produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="nom">
                            Nom du produit *
                        </label>
                        <input class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                               id="nom" 
                               name="nom"
                               type="text" 
                               value="{{ old('nom') }}"
                               required
                               placeholder="Nom du produit">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="idCategorie">
                            Catégorie *
                        </label>
                        <select class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                                id="idCategorie"
                                name="idCategorie"
                                required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->idCategorie }}" {{ old('idCategorie') == $categorie->idCategorie ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('idCategorie')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="prix">
                            Prix *
                        </label>
                        <div class="relative">
                            <input class="w-full py-2 px-3 pl-16 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                                   id="prix" 
                                   name="prix"
                                   type="number"
                                   min="0"
                                   step="0.01"
                                   value="{{ old('prix') }}"
                                   required
                                   placeholder="0">
                            <div class="absolute inset-y-0 left-0 px-3 flex items-center pointer-events-none text-slate-500 border-r border-slate-300">
                                FCFA
                            </div>
                        </div>
                        @error('prix')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-slate-700 text-sm font-medium mb-2" for="stock">
                            Stock initial *
                        </label>
                        <input class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                               id="stock" 
                               name="stock"
                               type="number"
                               min="0"
                               value="{{ old('stock', 0) }}"
                               required
                               placeholder="Quantité en stock">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2" for="description">
                        Description *
                    </label>
                    <textarea class="w-full py-2 px-3 border border-slate-300 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-slate-700 transition-colors" 
                              id="description"
                              name="description"
                              rows="3"
                              required
                              placeholder="Description du produit">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-medium mb-2" for="image">
                        Image du produit *
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-sky-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <div id="preview-container" class="hidden mb-4">
                                <img id="preview" src="#" alt="Aperçu de l'image" class="mx-auto h-32 w-32 object-cover rounded-lg">
                            </div>
                            <div id="upload-icon">
                                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="image" class="relative cursor-pointer rounded-md font-medium text-sky-600 hover:text-sky-500">
                                    <span>Télécharger une image</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/png,image/jpeg,image/gif" required onchange="previewImage(this)">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-slate-500">
                                PNG, JPG, GIF jusqu'à 2MB
                            </p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
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

    // Prévisualisation de l'image
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('preview-container');
        const uploadIcon = document.getElementById('upload-icon');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadIcon.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            previewContainer.classList.add('hidden');
            uploadIcon.classList.remove('hidden');
        }
    }

    // Support du glisser-déposer
    const dropZone = document.querySelector('.border-dashed');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-sky-500');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-sky-500');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const input = document.getElementById('image');
        
        input.files = files;
        previewImage(input);
    }
</script>
@endpush
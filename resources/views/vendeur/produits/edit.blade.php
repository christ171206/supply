@extends('layouts.vendeur')

@section('title', 'Modifier le Produit')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- En-tête -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier le Produit</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $produit->nom }}</p>
            </div>
            <a href="{{ route('vendeur.produits') }}" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('vendeur.produits.update', $produit) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded-lg p-6 space-y-6">
                <!-- Informations de base -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom du produit *</label>
                        <input type="text" name="nom" id="nom" required
                               value="{{ old('nom', $produit->nom) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reference" class="block text-sm font-medium text-gray-700">Référence</label>
                        <input type="text" name="reference" id="reference"
                               value="{{ old('reference', $produit->reference) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('reference')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prix" class="block text-sm font-medium text-gray-700">Prix *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="prix" id="prix" required
                                   step="0.01" min="0"
                                   value="{{ old('prix', $produit->prix) }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-3 pr-12">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">€</span>
                            </div>
                        </div>
                        @error('prix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock *</label>
                        <input type="number" name="stock" id="stock" required
                               min="0" step="1"
                               value="{{ old('stock', $produit->stock) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="idCategorie" class="block text-sm font-medium text-gray-700">Catégorie *</label>
                    <select name="idCategorie" id="idCategorie" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->idCategorie }}" 
                                {{ old('idCategorie', $produit->idCategorie) == $categorie->idCategorie ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idCategorie')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $produit->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image du produit</label>
                    
                    <!-- Image actuelle -->
                    @if($produit->image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($produit->image) }}" 
                                 alt="{{ $produit->nom }}"
                                 class="h-32 w-32 object-cover rounded-lg">
                        </div>
                    @endif
                    
                    <!-- Upload nouvelle image -->
                    <div class="mt-2">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Changer l'image</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">ou glisser-déposer</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Caractéristiques additionnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="poids" class="block text-sm font-medium text-gray-700">Poids (kg)</label>
                        <input type="number" name="poids" id="poids"
                               step="0.01" min="0"
                               value="{{ old('poids', $produit->poids) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('poids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700">Dimensions (L x l x H)</label>
                        <input type="text" name="dimensions" id="dimensions"
                               value="{{ old('dimensions', $produit->dimensions) }}"
                               placeholder="Ex: 20 x 15 x 10 cm"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('dimensions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Caractéristiques dynamiques -->
                <div x-data="{ caracteristiques: {{ json_encode(old('caracteristiques', $produit->caracteristiques ?? [])) }} }">
                    <label class="block text-sm font-medium text-gray-700">Caractéristiques supplémentaires</label>
                    
                    <div class="mt-2 space-y-2">
                        <template x-for="(carac, index) in caracteristiques" :key="index">
                            <div class="flex space-x-2">
                                <input type="text" x-model="carac.nom"
                                       :name="'caracteristiques[' + index + '][nom]'"
                                       class="block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Nom">
                                <input type="text" x-model="carac.valeur"
                                       :name="'caracteristiques[' + index + '][valeur]'"
                                       class="block w-1/2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Valeur">
                                <button type="button" @click="caracteristiques.splice(index, 1)"
                                        class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        
                        <button type="button" @click="caracteristiques.push({nom: '', valeur: ''})"
                                class="mt-2 btn btn-secondary text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Ajouter une caractéristique
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('vendeur.produits') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
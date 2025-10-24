@extends('layouts.vendeur')

@section('title', $produit->nom)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $produit->nom }}</h1>
            <p class="mt-1 text-sm text-gray-500">Référence : {{ $produit->reference }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('vendeur.produits.edit', $produit) }}" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
            <a href="{{ route('vendeur.produits') }}" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="md:col-span-2 space-y-6">
            <!-- Image et détails -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="aspect-w-16 aspect-h-9 mb-6">
                        @if($produit->image)
                            <img src="{{ Storage::url($produit->image) }}" 
                                 alt="{{ $produit->nom }}"
                                 class="object-cover rounded-lg">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Prix</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">
                                {{ number_format($produit->prix, 2, ',', ' ') }} €
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Stock</h3>
                            <p class="mt-1 text-lg font-semibold {{ $produit->stock === 0 ? 'text-red-600' : ($produit->stock <= 5 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ $produit->stock }} unités
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Catégorie</h3>
                            <p class="mt-1 text-gray-900">{{ $produit->categorie->nom }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Date d'ajout</h3>
                            <p class="mt-1 text-gray-900">{{ $produit->dateAjout ? $produit->dateAjout->format('d/m/Y') : 'Non définie' }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <div class="mt-2 prose prose-sm text-gray-900">
                            {{ $produit->description }}
                        </div>
                    </div>

                    @if($produit->caracteristiques)
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-500">Caractéristiques</h3>
                            <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                @foreach($produit->caracteristiques as $caracteristique)
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ $caracteristique['nom'] }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $caracteristique['valeur'] }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique des ventes -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Historique des ventes</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($produit->lignes->sortByDesc('commande.dateCommande')->take(5) as $ligne)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                Commande #{{ $ligne->commande->idCommande }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $ligne->commande->dateCommande->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $ligne->quantite }} unités
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ number_format($ligne->prixUnitaire * $ligne->quantite, 2, ',', ' ') }} €
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-gray-500">
                                    Aucune vente enregistrée
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-base font-medium text-gray-900">Statistiques</h2>
                    <dl class="mt-5 grid grid-cols-1 gap-5">
                        <div class="px-4 py-5 bg-gray-50 rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total des ventes</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_ventes'] }}</dd>
                        </div>

                        <div class="px-4 py-5 bg-gray-50 rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Chiffre d'affaires</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ number_format($stats['chiffre_affaires'], 2, ',', ' ') }} €
                            </dd>
                        </div>

                        <div class="px-4 py-5 bg-gray-50 rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">Note moyenne</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['note_moyenne'], 1) }}/5</dd>
                            <p class="mt-1 text-sm text-gray-500">{{ $stats['nombre_avis'] }} avis</p>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Avis récents -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Derniers avis</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flow-root">
                        <ul class="-my-4 divide-y divide-gray-200">
                            @forelse($produit->avis->sortByDesc('created_at')->take(3) as $avis)
                                <li class="py-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm font-medium text-gray-900">
                                                    Client #{{ $avis->idClient }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $avis->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="mt-1 flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="h-5 w-5 {{ $i <= $avis->note ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <div class="mt-2 text-sm text-gray-700">
                                                {{ $avis->commentaire }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-gray-500">
                                    Aucun avis pour le moment
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
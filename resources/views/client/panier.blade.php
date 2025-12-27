@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h1>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Articles du panier -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @foreach($articles as $article)
                        <div class="border-b p-6 flex items-center gap-6 hover:bg-gray-50 transition">
                            <!-- Image -->
                            <div class="w-24 h-24 bg-gray-200 rounded flex-shrink-0">
                                @if($article->produit->images->count() > 0)
                                    <img src="{{ asset('storage/' . $article->produit->images->first()->chemin) }}" 
                                         alt="{{ $article->produit->nom }}" class="w-full h-full object-cover rounded">
                                @endif
                            </div>

                            <!-- Détails -->
                            <div class="flex-1">
                                <a href="{{ route('catalogue.show', ['slug' => $article->produit->slug]) }}" 
                                   class="font-semibold text-gray-900 hover:text-primary-700">
                                    {{ $article->produit->nom }}
                                </a>
                                <p class="text-sm text-gray-600">Vendeur: {{ $article->produit->vendeur->nom ?? 'N/A' }}</p>
                                <p class="text-lg font-bold text-gray-900 mt-2">{{ number_format($article->produit->prix, 0) }} FCFA</p>
                            </div>

                            <!-- Quantité -->
                            <div class="flex items-center gap-2">
                                <form action="{{ route('client.panier.quantite', ['id' => $article->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center border border-gray-300 rounded">
                                        <input type="number" name="quantite" value="{{ $article->quantite }}" min="1" max="{{ $article->produit->stock }}"
                                               class="w-16 px-2 py-2 text-center border-none">
                                        <button type="submit" class="px-2 bg-primary-100 text-primary-700 hover:bg-primary-200">
                                            Mettre à jour
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sous-total -->
                            <div class="text-right min-w-max">
                                <p class="font-bold text-gray-900">{{ number_format($article->produit->prix * $article->quantite, 0) }} FCFA</p>
                                <p class="text-xs text-gray-500">({{ $article->quantite }} × {{ number_format($article->produit->prix, 0) }})</p>
                            </div>

                            <!-- Supprimer -->
                            <form action="{{ route('client.panier.retirer', ['id' => $article->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold"
                                        onclick="return confirm('Êtes-vous sûr?')">
                                    ✕
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Résumé -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Résumé</h2>
                        
                        <div class="space-y-3 mb-6 pb-6 border-b">
                            <div class="flex justify-between text-gray-700">
                                <span>Sous-total</span>
                                <span>{{ number_format($total, 0) }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Livraison</span>
                                <span id="frais-livraison">À calculer</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Taxe (20%)</span>
                                <span>{{ number_format($total * 0.2, 0) }} FCFA</span>
                            </div>
                        </div>

                        <div class="flex justify-between mb-6 text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>{{ number_format($total * 1.2, 0) }} FCFA</span>
                        </div>

                        <form action="{{ route('client.panier.valider') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block font-semibold text-gray-700 mb-2">Adresse de livraison</label>
                                <textarea name="adresse" required rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                          placeholder="Entrez votre adresse complète..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 mb-2">
                                Valider le panier
                            </button>
                            <a href="{{ route('catalogue.index') }}" class="block text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">
                                Continuer le shopping
                            </a>
                        </form>

                        <!-- Garanties -->
                        <div class="mt-6 pt-6 border-t space-y-2 text-sm text-gray-600">
                            <div class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Livraison sécurisée</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Garantie client</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span>✓</span>
                                <span>Support 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
                <p class="text-gray-600 mb-6">Découvrez nos produits et commencez vos achats</p>
                <a href="{{ route('catalogue.index') }}" class="inline-block bg-primary-700 text-white px-6 py-3 rounded-lg hover:bg-primary-800">
                    Voir le catalogue
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

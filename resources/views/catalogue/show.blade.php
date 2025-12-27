@extends('layouts.app')

@section('title', $produit->nom . ' - Supply')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-gray-600">
            <a href="{{ route('catalogue.index') }}" class="text-primary-700 hover:underline">Catalogue</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalogue.index', ['categorie' => $produit->idCategorie]) }}" class="text-primary-700 hover:underline">
                {{ $produit->categorie->nom ?? 'Catégorie' }}
            </a>
            <span class="mx-2">/</span>
            <span>{{ $produit->nom }}</span>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Images -->
                <div>
                    <div class="bg-gray-100 rounded-lg mb-4 h-96 flex items-center justify-center">
                        @if($produit->images->count() > 0)
                            <img id="mainImage" src="{{ asset('storage/' . $produit->images->first()->chemin) }}" 
                                 alt="{{ $produit->nom }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-gray-400">Image non disponible</span>
                        @endif
                    </div>
                    
                    <!-- Galerie -->
                    @if($produit->images->count() > 1)
                    <div class="flex gap-2">
                        @foreach($produit->images as $image)
                        <img src="{{ asset('storage/' . $image->chemin) }}" alt="{{ $produit->nom }}"
                             class="w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-primary-700"
                             onclick="changeImage('{{ asset('storage/' . $image->chemin) }}')">
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Détails produit -->
                <div>
                    <!-- Catégorie et vendeur -->
                    <div class="flex items-center gap-4 mb-4">
                        <span class="px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded">
                            {{ $produit->categorie->nom ?? 'Sans catégorie' }}
                        </span>
                        <span class="text-sm text-gray-600">
                            Vendu par <strong>{{ $produit->vendeur->nom ?? 'Vendeur' }}</strong>
                        </span>
                    </div>

                    <!-- Titre -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $produit->nom }}</h1>

                    <!-- Note et avis -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex">
                            @php
                            $noteAvy = $produit->avis_avg_note ?? 0;
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= round($noteAvy)) {
                                    echo '<span class="text-yellow-400 text-xl">★</span>';
                                } else {
                                    echo '<span class="text-gray-300 text-xl">★</span>';
                                }
                            }
                            @endphp
                        </div>
                        <span class="text-gray-600">{{ $produit->avis_count ?? 0 }} avis</span>
                    </div>

                    <!-- Prix -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-gray-900">{{ number_format($produit->prix, 0) }} FCFA</span>
                            @if($produit->prix_promo)
                            <span class="text-xl text-gray-500 line-through">{{ number_format($produit->prix_promo, 0) }} FCFA</span>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded text-sm font-semibold">
                                -{{ round((1 - $produit->prix / $produit->prix_promo) * 100) }}%
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Disponibilité -->
                    <div class="mb-6 pb-6 border-b">
                        @if($produit->stock > 0)
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-green-600 font-semibold">En stock ({{ $produit->stock }} disponibles)</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                <span class="text-red-600 font-semibold">Rupture de stock</span>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $produit->description }}</p>
                    </div>

                    <!-- Caractéristiques -->
                    @if($produit->caracteristiques)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Caractéristiques</h3>
                        <table class="w-full text-sm">
                            @foreach(json_decode($produit->caracteristiques, true) ?? [] as $cle => $valeur)
                            <tr class="border-b">
                                <td class="py-2 text-gray-600">{{ $cle }}</td>
                                <td class="py-2 font-semibold text-gray-900">{{ $valeur }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    <!-- Ajouter au panier -->
                    <div class="mb-6">
                        <form id="addToCartForm" onsubmit="ajouterAuPanier(event)" class="flex gap-4">
                            <input type="number" id="quantite" name="quantite" value="1" min="1" max="{{ $produit->stock }}"
                                   class="w-20 px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <button type="submit" {{ $produit->stock <= 0 ? 'disabled' : '' }}
                                    class="flex-1 {{ $produit->stock > 0 ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed' }} text-white py-3 rounded-lg font-semibold transition">
                                {{ $produit->stock > 0 ? 'Ajouter au panier' : 'Rupture de stock' }}
                            </button>
                        </form>
                    </div>

                    <!-- Infos supplémentaires -->
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <p class="font-semibold text-gray-900">Référence</p>
                            <p>{{ $produit->reference ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Poids</p>
                            <p>{{ $produit->poids ?? 'N/A' }} kg</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Dimensions</p>
                            <p>{{ $produit->dimensions ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avis -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Avis des clients</h2>

                @auth
                <!-- Formulaire avis -->
                <form action="{{ route('produit.avis.store', ['id' => $produit->idProduit]) }}" method="POST" class="mb-8 pb-8 border-b">
                    @csrf
                    <h3 class="font-semibold text-gray-900 mb-4">Donner votre avis</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Note</label>
                            <select name="note" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Sélectionner une note</option>
                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                <option value="4">⭐⭐⭐⭐ Très bon</option>
                                <option value="3">⭐⭐⭐ Bon</option>
                                <option value="2">⭐⭐ Acceptable</option>
                                <option value="1">⭐ Mauvais</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Titre</label>
                            <input type="text" name="titre" required maxlength="100"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block font-semibold text-gray-700 mb-2">Contenu</label>
                        <textarea name="contenu" required maxlength="1000" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>

                    <button type="submit" class="mt-4 bg-primary-700 text-white px-6 py-2 rounded-lg hover:bg-primary-800">
                        Publier mon avis
                    </button>
                </form>
                @else
                <p class="mb-8 text-gray-600">
                    <a href="{{ route('login') }}" class="text-primary-700 hover:underline">Connectez-vous</a> pour donner votre avis.
                </p>
                @endauth

                <!-- Liste des avis -->
                <div class="space-y-4">
                    @if($avis->count() > 0)
                        @foreach($avis as $comment)
                        <div class="border-b pb-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $comment->utilisateur->nom ?? 'Anonyme' }}</p>
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $comment->note ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <span>{{ $comment->dateAvis?->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 font-semibold text-gray-900">{{ $comment->titre }}</p>
                            <p class="mt-1 text-gray-700">{{ $comment->contenu }}</p>
                        </div>
                        @endforeach

                        <!-- Pagination avis -->
                        <div class="mt-6">
                            {{ $avis->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">Aucun avis pour ce produit.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Produits similaires -->
        @if($produitsSimilaires->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Produits similaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($produitsSimilaires as $similar)
                <a href="{{ route('catalogue.show', ['slug' => $similar->slug]) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="bg-gray-200 h-40 flex items-center justify-center">
                        @if($similar->images->count() > 0)
                            <img src="{{ asset('storage/' . $similar->images->first()->chemin) }}" alt="{{ $similar->nom }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-gray-900 truncate">{{ $similar->nom }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ number_format($similar->prix, 0) }} FCFA</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}

function ajouterAuPanier(event) {
    event.preventDefault();
    
    const quantite = document.getElementById('quantite').value;
    
    fetch('{{ route("client.panier.ajouter") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            idProduit: {{ $produit->idProduit }},
            quantite: parseInt(quantite)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById('quantite').value = '1';
            // Mettre à jour le badge du panier
            document.querySelector('[data-cart-count]').textContent = data.count;
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
}
</script>
@endsection

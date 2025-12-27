@extends('layouts.app')

@section('title', 'Catalogue - Supply')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Catalogue de Produits</h1>
            <p class="mt-2 text-gray-600">Découvrez notre sélection de produits de qualité</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filtres (Sidebar) -->
            <div class="lg:w-1/4">
                <form method="GET" class="bg-white p-6 rounded-lg shadow">
                    <!-- Catégories -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Catégories</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="categorie" value="" class="mr-2" 
                                    {{ !request('categorie') ? 'checked' : '' }}>
                                <span class="text-gray-700">Toutes</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center">
                                <input type="checkbox" name="categorie" value="{{ $cat->idCategorie }}" class="mr-2"
                                    {{ request('categorie') == $cat->idCategorie ? 'checked' : '' }}>
                                <span class="text-gray-700">{{ $cat->nom }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tri -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Trier par</h3>
                        <select name="tri" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="recent" {{ request('tri') == 'recent' ? 'selected' : '' }}>Plus récents</option>
                            <option value="prix-asc" {{ request('tri') == 'prix-asc' ? 'selected' : '' }}>Prix: bas à haut</option>
                            <option value="prix-desc" {{ request('tri') == 'prix-desc' ? 'selected' : '' }}>Prix: haut à bas</option>
                            <option value="ventes" {{ request('tri') == 'ventes' ? 'selected' : '' }}>Plus vendus</option>
                            <option value="note" {{ request('tri') == 'note' ? 'selected' : '' }}>Mieux notés</option>
                        </select>
                    </div>

                    <!-- Recherche -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Recherche</h3>
                        <input type="text" name="q" placeholder="Rechercher..." value="{{ request('q') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <button type="submit" class="w-full bg-primary-700 text-white py-2 rounded-lg hover:bg-primary-800">
                        Appliquer les filtres
                    </button>
                </form>
            </div>

            <!-- Produits -->
            <div class="lg:w-3/4">
                @if($produits->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($produits as $produit)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <!-- Image -->
                            <div class="relative bg-gray-200 h-48">
                                @if($produit->images->count() > 0)
                                    <img src="{{ asset('storage/' . $produit->images->first()->chemin) }}" 
                                         alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <span>Image non disponible</span>
                                    </div>
                                @endif
                                
                                <!-- Badge stock -->
                                @if($produit->stock < 5)
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    Stock faible
                                </span>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $produit->nom }}</h3>
                                
                                <!-- Catégorie -->
                                <p class="text-sm text-gray-500">{{ $produit->categorie->nom ?? 'Sans catégorie' }}</p>
                                
                                <!-- Vendeur -->
                                <p class="text-xs text-gray-400">par {{ $produit->vendeur->nom ?? 'Vendeur' }}</p>
                                
                                <!-- Prix -->
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($produit->prix, 0) }} FCFA</span>
                                    @if($produit->prix_promo)
                                    <span class="text-sm text-gray-500 line-through">{{ number_format($produit->prix_promo, 0) }} FCFA</span>
                                    @endif
                                </div>

                                <!-- Étoiles (note moyenne) -->
                                <div class="mt-2 flex items-center gap-1">
                                    @php
                                    $noteAvy = $produit->avis_avg_note ?? 0;
                                    for($i = 1; $i <= 5; $i++) {
                                        if($i <= round($noteAvy)) {
                                            echo '<span class="text-yellow-400">★</span>';
                                        } else {
                                            echo '<span class="text-gray-300">★</span>';
                                        }
                                    }
                                    @endphp
                                    <span class="text-xs text-gray-500">({{ $produit->avis_count ?? 0 }})</span>
                                </div>

                                <!-- Boutons -->
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('catalogue.show', ['slug' => $produit->slug]) }}" 
                                       class="flex-1 bg-primary-100 text-primary-700 py-2 rounded text-center text-sm hover:bg-primary-200">
                                        Voir détails
                                    </a>
                                    <button onclick="ajouterPanier({{ $produit->idProduit }})"
                                            class="flex-1 bg-green-600 text-white py-2 rounded text-sm hover:bg-green-700">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $produits->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg p-12 text-center">
                        <p class="text-gray-500">Aucun produit trouvé. Essayez avec d'autres filtres.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function ajouterPanier(produitId) {
    const quantite = prompt('Quantité:', '1');
    if (!quantite || quantite < 1) return;

    fetch('{{ route("client.panier.ajouter") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            idProduit: produitId,
            quantite: parseInt(quantite)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
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

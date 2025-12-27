@extends('layouts.app')

@section('title', 'Gestion du Stock')

@section('content')
<div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 min-h-screen">
    <!-- Header Premium -->
    <div class="sticky top-0 z-50 bg-gradient-to-r from-slate-900/95 to-slate-800/95 backdrop-blur-md border-b border-slate-700/50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-primary-400 to-cyan-400 bg-clip-text text-transparent">📊 Gestion des Stocks</h1>
                    <p class="text-slate-400 mt-2">Contrôlez votre inventaire en temps réel</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div class="md:col-span-2">
                    <input type="text" 
                           placeholder="Rechercher un produit..." 
                           class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                </div>

                <!-- État du stock -->
                <select class="bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Tous les états</option>
                    <option value="rupture">En rupture</option>
                    <option value="faible">Stock faible</option>
                    <option value="normal">Stock normal</option>
                </select>

                <!-- Catégorie -->
                <select class="bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->idCategorie }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Statistiques Stock -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg p-4 text-white">
                <p class="text-emerald-100 text-sm font-medium mb-1">Produits en stock</p>
                <p class="text-2xl font-bold">{{ $produits->where('stock', '>', 0)->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                <p class="text-yellow-100 text-sm font-medium mb-1">Stock faible</p>
                <p class="text-2xl font-bold">{{ $produits->where('stock', '>', 0)->where('stock', '<', 5)->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4 text-white">
                <p class="text-red-100 text-sm font-medium mb-1">En rupture</p>
                <p class="text-2xl font-bold">{{ $produits->where('stock', '<=', 0)->count() }}</p>
            </div>
            <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg p-4 text-white">
                <p class="text-primary-100 text-sm font-medium mb-1">Valeur stock</p>
                <p class="text-xl font-bold">{{ number_format($produits->sum('stock'), 0) }}</p>
            </div>
        </div>

        <!-- Tableau des produits -->
        @if($produits->count() > 0)
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-700 bg-slate-900/50">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Produit</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Référence</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Catégorie</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">Stock actuel</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Prix unit.</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Valeur</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-300">État</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($produits as $produit)
                        <tr class="hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($produit->images->count() > 0)
                                    <img src="{{ asset('storage/' . $produit->images->first()->chemin) }}" 
                                         alt="{{ $produit->nom }}" 
                                         class="w-10 h-10 rounded object-cover">
                                    @else
                                    <div class="w-10 h-10 bg-slate-600 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-white line-clamp-1">{{ $produit->nom }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $produit->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $produit->categorie->nom ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="font-bold text-white">{{ $produit->stock }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-slate-400">
                                {{ number_format($produit->prix, 0) }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-emerald-400">
                                {{ number_format($produit->prix * $produit->stock, 0) }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $produit->stock == 0 ? 'bg-red-500/20 text-red-400' : ($produit->stock < 5 ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }}">
                                    {{ $produit->stock == 0 ? 'Rupture' : ($produit->stock < 5 ? 'Faible' : 'OK') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button onclick="openAdjustModal({{ $produit->idProduit }}, '{{ $produit->nom }}', {{ $produit->stock }})"
                                        class="px-3 py-1 bg-primary-700/20 hover:bg-primary-700/30 text-primary-400 rounded-lg text-sm font-medium transition-colors">
                                    Ajuster
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($produits->hasPages())
            <div class="px-6 py-4 border-t border-slate-700 bg-slate-900/50">
                {{ $produits->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-12 text-center">
            <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3.586a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H4a2 2 0 01-2-2V4z"></path></svg>
            <h3 class="text-xl font-bold text-white mb-2">Aucun produit</h3>
            <p class="text-slate-400">Vous n'avez pas encore créé de produit.</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal d'ajustement du stock -->
<div id="adjustModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-xl p-8 max-w-md mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Ajuster le stock</h3>
        
        <div class="mb-4">
            <p class="text-slate-300 text-sm mb-2">Produit: <span id="productName" class="font-bold text-white"></span></p>
            <p class="text-slate-300 text-sm">Stock actuel: <span id="currentStock" class="font-bold text-white"></span></p>
        </div>

        <form id="adjustForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nouvelle quantité</label>
                <input type="number" 
                       id="newStock"
                       min="0"
                       class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Raison de l'ajustement</label>
                <select id="reason" class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                    <option value="">Sélectionner...</option>
                    <option value="approvisionnement">Approvisionnement</option>
                    <option value="correction_inventaire">Correction d'inventaire</option>
                    <option value="pertes">Pertes/Dommages</option>
                    <option value="ajustement">Ajustement</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Notes (optionnel)</label>
                <textarea id="notes"
                         class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                         rows="2" placeholder="Détails supplémentaires..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeAdjustModal()"
                        class="flex-1 bg-slate-700 hover:bg-slate-600 text-white py-2 rounded-lg font-medium transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        class="flex-1 bg-primary-700 hover:bg-primary-800 text-white py-2 rounded-lg font-medium transition-colors">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentProductId = null;

function openAdjustModal(productId, productName, currentStock) {
    currentProductId = productId;
    document.getElementById('productName').textContent = productName;
    document.getElementById('currentStock').textContent = currentStock;
    document.getElementById('newStock').value = currentStock;
    document.getElementById('reason').value = '';
    document.getElementById('notes').value = '';
    document.getElementById('adjustModal').classList.remove('hidden');
}

function closeAdjustModal() {
    document.getElementById('adjustModal').classList.add('hidden');
}

document.getElementById('adjustForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newStock = document.getElementById('newStock').value;
    const reason = document.getElementById('reason').value;
    const notes = document.getElementById('notes').value;

    if (!reason) {
        alert('Veuillez sélectionner une raison');
        return;
    }

    fetch(`/vendeur/stock/${currentProductId}/ajuster`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            stock: newStock,
            raison: reason,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Impossible de mettre à jour'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
});

// Fermer le modal si on clique en dehors
document.getElementById('adjustModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAdjustModal();
});
</script>
@endsection

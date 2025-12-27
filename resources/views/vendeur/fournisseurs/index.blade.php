@extends('layouts.vendeur')

@section('title', 'Gestion des Fournisseurs')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Fournisseurs</h1>
            <p class="mt-1 text-sm text-gray-500">Gérez vos partenaires commerciaux</p>
        </div>
        <button onclick="openFormModal()" class="px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 font-medium transition-colors inline-flex items-center shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter Fournisseur
        </button>
    </div>

    <!-- Grille des fournisseurs -->
    <div class="mb-8">
        <div class="card overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Fournisseur</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Contact</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Adresse</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Produits</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($fournisseurs ?? [] as $fourn)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $fourn->nom }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $fourn->description ?? 'Aucune description' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-900">{{ $fourn->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-gray-900">{{ $fourn->telephone ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="text-gray-900">{{ $fourn->adresse ?? 'Non renseignée' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-3">
                                @php
                                    $produits = $fourn->produits ?? [];
                                @endphp
                                @forelse($produits as $produit)
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center mb-1">
                                            @if($produit->image)
                                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-xs font-medium text-gray-900 text-center truncate max-w-[80px]" title="{{ $produit->nom }}">{{ Str::limit($produit->nom, 12) }}</span>
                                    </div>
                                @empty
                                    <span class="text-sm text-gray-500">Aucun produit</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="editFournisseur({{ $fourn->id ?? 0 }})" class="px-3 py-1.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition-colors">
                                    Modifier
                                </button>
                                <button class="px-3 py-1.5 text-red-600 border border-red-300 rounded-lg hover:bg-red-50 font-medium text-sm transition-colors">
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4 0h1m-1-4h1"/>
                                </svg>
                                <p class="text-gray-500 text-lg mb-4">Aucun fournisseur enregistré</p>
                                <button onclick="openFormModal()" class="px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 font-medium transition-colors inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Ajouter votre premier fournisseur
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ajout/Édition -->
<div id="formModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="if(event.target === this) closeFormModal()">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- En-tête -->
        <div class="sticky top-0 bg-white border-b flex justify-between items-center px-6 py-4">
            <h3 class="text-xl font-bold text-gray-900">Ajouter un fournisseur</h3>
            <button type="button" onclick="closeFormModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Contenu -->
        <div class="p-6 space-y-6">
            <form id="fournisseurForm" method="POST" action="{{ route('vendeur.fournisseurs.store') }}" class="space-y-6">
                @csrf
                <!-- Fournisseur -->
                <div>
                    <h4 class="text-base font-bold text-gray-900 mb-3">Informations du fournisseur</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du fournisseur *</label>
                            <input type="text" name="nom" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact (Téléphone) *</label>
                                <input type="tel" name="telephone" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div class="border-t pt-6">
                    <h4 class="text-base font-bold text-gray-900 mb-3">Localisation</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                            <input type="text" name="adresse" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="ville"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="pays"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produits -->
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-base font-bold text-gray-900">Produits fournis</h4>
                        <button type="button" onclick="ajouterProduit()" class="px-3 py-1.5 bg-primary-700 text-white text-sm rounded-lg hover:bg-primary-800 transition-colors inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajouter
                        </button>
                    </div>

                    <div id="produitsContainer" class="space-y-4">
                        <!-- Les produits seront ajoutés ici dynamiquement -->
                    </div>

                    <div id="produitsVides" class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-sm">Aucun produit ajouté. Cliquez sur "Ajouter" pour en ajouter.</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="border-t pt-6">
                    <h4 class="text-base font-bold text-gray-900 mb-3">Description</h4>
                    <textarea rows="3" name="notes" placeholder="Notes ou informations supplémentaires..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors"></textarea>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 border-t pt-6">
                    <button type="button" onclick="closeFormModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 font-medium transition-colors inline-flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer
                    </button>
                </div>
        </div>
    </div>
</div>

<script>
let compteurProduits = 0;

function openFormModal() {
    const modal = document.getElementById('formModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    compteurProduits = 0;
    document.getElementById('produitsContainer').innerHTML = '';
    document.getElementById('produitsVides').style.display = 'block';
}

function closeFormModal() {
    const modal = document.getElementById('formModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
}

function ajouterProduit() {
    const container = document.getElementById('produitsContainer');
    const vides = document.getElementById('produitsVides');

    const produitId = compteurProduits++;
    const html = `
        <div class="produit-item border rounded-lg p-4 bg-gray-50" id="produit-${produitId}">
            <div class="flex justify-between items-start mb-3">
                <h5 class="font-medium text-gray-900">Produit ${produitId + 1}</h5>
                <button type="button" onclick="supprimerProduit(${produitId})" class="text-red-600 hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit *</label>
                    <input type="text" name="produits_nom[]" placeholder="Ex: Ciment Portland..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 transition-colors"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo du produit (optionnel)</label>
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <input type="file" name="produits_photo[]" accept="image/*"
                                   onchange="previewProduitImage(this, ${produitId})"
                                   class="block w-full text-sm text-gray-500 file:px-4 file:py-2 file:border file:border-gray-300 file:rounded-lg file:bg-gray-50 file:text-gray-700 file:cursor-pointer hover:file:bg-gray-100">
                        </div>
                        <div id="preview-${produitId}" class="w-16 h-16 rounded-lg border border-gray-300 bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    vides.style.display = container.children.length === 0 ? 'block' : 'none';
}

function supprimerProduit(produitId) {
    const element = document.getElementById(`produit-${produitId}`);
    const container = document.getElementById('produitsContainer');
    const vides = document.getElementById('produitsVides');

    if (element) {
        element.remove();
    }

    vides.style.display = container.children.length === 0 ? 'block' : 'none';
}

function previewProduitImage(input, produitId) {
    const preview = document.getElementById(`preview-${produitId}`);

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" alt="Produit ${produitId + 1}">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function editFournisseur(id) {
    openFormModal();
}
</script>
@endsection

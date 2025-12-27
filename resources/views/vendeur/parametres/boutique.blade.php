<!-- Composant des paramètres de la boutique -->
<div x-show="active === 'boutique'" x-cloak class="animate-fade-in">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                </svg>
                Configuration de la boutique
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Personnalisez votre boutique et gérez son apparence
            </p>
        </div>

        <div class="px-6 py-4">
            <form action="{{ route('vendeur.parametres.boutique') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div class="lg:col-span-1">
                        <div class="space-y-4">
                            <div class="aspect-w-1 aspect-h-1 bg-slate-100 rounded-lg overflow-hidden">
                                <img src="{{ $boutique->logo_url ?? asset('images/default-shop.png') }}"
                                     alt="Logo boutique"
                                     class="object-cover">
                            </div>
                            <div class="flex justify-center">
                                <button type="button" 
                                        class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#logoModal">
                                    <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Changer le logo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3 space-y-6">
                        <div>
                            <label for="nom_boutique" class="block text-sm font-medium text-slate-700">Nom de la boutique</label>
                            <input type="text" 
                                   id="nom_boutique" 
                                   name="nom_boutique" 
                                   value="{{ $boutique->nom ?? '' }}"
                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                   required>
                            <p class="mt-2 text-sm text-slate-500">
                                Ce nom sera visible par tous vos clients
                            </p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700">Description</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">{{ $boutique->description ?? '' }}</textarea>
                            <p class="mt-2 text-sm text-slate-500">
                                Décrivez votre boutique en quelques phrases
                            </p>
                        </div>

                        <div>
                            <label for="adresse" class="block text-sm font-medium text-slate-700">Adresse</label>
                            <input type="text" 
                                   id="adresse" 
                                   name="adresse" 
                                   value="{{ $boutique->adresse ?? '' }}"
                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ville" class="block text-sm font-medium text-slate-700">Ville</label>
                                <input type="text" 
                                       id="ville" 
                                       name="ville" 
                                       value="{{ $boutique->ville ?? '' }}"
                                       class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="pays" class="block text-sm font-medium text-slate-700">Pays</label>
                                <select id="pays" 
                                        name="pays" 
                                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                                    <option value="CM" {{ ($boutique->pays ?? 'CM') === 'CM' ? 'selected' : '' }}>Cameroun</option>
                                    <option value="FR" {{ ($boutique->pays ?? 'CM') === 'FR' ? 'selected' : '' }}>France</option>
                                </select>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="boutique_active" 
                                       name="active" 
                                       value="1" 
                                       {{ $boutique->active ?? false ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="boutique_active" class="font-medium text-slate-700">Boutique active</label>
                                <p class="text-slate-500">
                                    Activez ou désactivez temporairement votre boutique
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
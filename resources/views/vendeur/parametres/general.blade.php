<!-- Composant des paramètres généraux -->
<div x-show="active === 'general'" x-cloak class="animate-fade-in">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.608-.996.07-2.296-1.065-2.572-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configuration générale
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Paramètres de base de votre compte vendeur
            </p>
        </div>
        <div class="px-6 py-4">
            <form action="{{ route('vendeur.parametres.general') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="nom" class="block text-sm font-medium text-slate-700">Nom complet</label>
                        <input type="text" 
                               id="nom" 
                               name="nom" 
                               value="{{ $vendeur->nom ?? '' }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                               required>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-slate-700">Adresse email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ $vendeur->email ?? '' }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                               required>
                    </div>

                    <div class="space-y-2">
                        <label for="telephone" class="block text-sm font-medium text-slate-700">Numéro de téléphone</label>
                        <input type="tel" 
                               id="telephone" 
                               name="telephone" 
                               value="{{ $vendeur->telephone ?? '' }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                               required>
                    </div>

                    <div class="space-y-2">
                        <label for="langue" class="block text-sm font-medium text-slate-700">Langue d'affichage</label>
                        <select id="langue" 
                                name="langue" 
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            <option value="fr" {{ ($settings['langue'] ?? 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ ($settings['langue'] ?? 'fr') === 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6">
                    <h3 class="text-base font-medium text-slate-900 mb-4">Sécurité</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700">Mot de passe actuel</label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password"
                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
                                <input type="password" 
                                       id="new_password" 
                                       name="new_password"
                                       class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700">Confirmer le mot de passe</label>
                                <input type="password" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
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
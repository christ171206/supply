<!-- Composant des paramètres de paiement -->
<div x-show="active === 'paiements'" x-cloak class="animate-fade-in">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Configuration des paiements
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Gérez vos méthodes de paiement et vos informations bancaires
            </p>
        </div>

        <div class="px-6 py-4">
            <form action="{{ route('vendeur.parametres.paiement') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Méthodes de paiement acceptées</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="paiement_mtn" 
                                       name="methodes_paiement[]" 
                                       value="mtn" 
                                       {{ in_array('mtn', $methodes_paiement ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="paiement_mtn" class="text-sm font-medium text-slate-700">MTN Mobile Money</label>
                                <p class="text-sm text-slate-500">Acceptez les paiements via MTN MoMo</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="paiement_orange" 
                                       name="methodes_paiement[]" 
                                       value="orange" 
                                       {{ in_array('orange', $methodes_paiement ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="paiement_orange" class="text-sm font-medium text-slate-700">Orange Money</label>
                                <p class="text-sm text-slate-500">Acceptez les paiements via Orange Money</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="paiement_especes" 
                                       name="methodes_paiement[]" 
                                       value="especes" 
                                       {{ in_array('especes', $methodes_paiement ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="paiement_especes" class="text-sm font-medium text-slate-700">Paiement en espèces</label>
                                <p class="text-sm text-slate-500">Acceptez les paiements à la livraison</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Informations de paiement mobile</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="numero_mtn" class="block text-sm font-medium text-slate-700">Numéro MTN MoMo</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">+237</span>
                                </div>
                                <input type="text" 
                                       id="numero_mtn" 
                                       name="numero_mtn" 
                                       value="{{ $infos_paiement['mtn'] ?? '' }}"
                                       placeholder="650000000"
                                       class="pl-16 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="numero_orange" class="block text-sm font-medium text-slate-700">Numéro Orange Money</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">+237</span>
                                </div>
                                <input type="text" 
                                       id="numero_orange" 
                                       name="numero_orange" 
                                       value="{{ $infos_paiement['orange'] ?? '' }}"
                                       placeholder="690000000"
                                       class="pl-16 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Configuration des commissions</h3>
                    <div class="space-y-4">
                        <div class="rounded-md bg-sky-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-sky-800">Informations sur les commissions</h3>
                                    <div class="mt-2 text-sm text-sky-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>MTN Money : 0.5% du montant de la transaction</li>
                                            <li>Orange Money : 0.5% du montant de la transaction</li>
                                            <li>Commission plateforme : 3% du montant de la transaction</li>
                                        </ul>
                                    </div>
                                </div>
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
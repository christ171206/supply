<!-- Composant des paramètres de notification -->
<div x-show="active === 'notifications'" x-cloak class="animate-fade-in">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Configuration des notifications
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Gérez vos préférences de notification et vos alertes
            </p>
        </div>

        <div class="px-6 py-4">
            <form action="{{ route('vendeur.parametres.notifications') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Notifications par email</h3>
                    <div class="space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="email_commandes" 
                                       name="notifications[email][]" 
                                       value="commandes" 
                                       {{ in_array('commandes', $notifications['email'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="email_commandes" class="text-sm font-medium text-slate-700">Nouvelles commandes</label>
                                <p class="text-sm text-slate-500">Recevez un email pour chaque nouvelle commande</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="email_messages" 
                                       name="notifications[email][]" 
                                       value="messages" 
                                       {{ in_array('messages', $notifications['email'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="email_messages" class="text-sm font-medium text-slate-700">Nouveaux messages</label>
                                <p class="text-sm text-slate-500">Recevez un email quand un client vous envoie un message</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="email_promotions" 
                                       name="notifications[email][]" 
                                       value="promotions" 
                                       {{ in_array('promotions', $notifications['email'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="email_promotions" class="text-sm font-medium text-slate-700">Promotions</label>
                                <p class="text-sm text-slate-500">Recevez des emails sur les nouvelles fonctionnalités et promotions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Notifications par SMS</h3>
                    <div class="space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="sms_commandes" 
                                       name="notifications[sms][]" 
                                       value="commandes" 
                                       {{ in_array('commandes', $notifications['sms'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="sms_commandes" class="text-sm font-medium text-slate-700">Nouvelles commandes</label>
                                <p class="text-sm text-slate-500">Recevez un SMS pour chaque nouvelle commande</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="sms_messages" 
                                       name="notifications[sms][]" 
                                       value="messages" 
                                       {{ in_array('messages', $notifications['sms'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="sms_messages" class="text-sm font-medium text-slate-700">Nouveaux messages</label>
                                <p class="text-sm text-slate-500">Recevez un SMS quand un client vous envoie un message</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-medium text-slate-900 mb-4">Notifications sur le tableau de bord</h3>
                    <div class="space-y-4">
                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="dashboard_commandes" 
                                       name="notifications[dashboard][]" 
                                       value="commandes" 
                                       {{ in_array('commandes', $notifications['dashboard'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="dashboard_commandes" class="text-sm font-medium text-slate-700">Notifications de commandes</label>
                                <p class="text-sm text-slate-500">Affichez les notifications de commandes dans votre tableau de bord</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="dashboard_messages" 
                                       name="notifications[dashboard][]" 
                                       value="messages" 
                                       {{ in_array('messages', $notifications['dashboard'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="dashboard_messages" class="text-sm font-medium text-slate-700">Notifications de messages</label>
                                <p class="text-sm text-slate-500">Affichez les notifications de messages dans votre tableau de bord</p>
                            </div>
                        </div>

                        <div class="relative flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" 
                                       id="dashboard_alertes" 
                                       name="notifications[dashboard][]" 
                                       value="alertes" 
                                       {{ in_array('alertes', $notifications['dashboard'] ?? []) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </div>
                            <div class="ml-3">
                                <label for="dashboard_alertes" class="text-sm font-medium text-slate-700">Alertes système</label>
                                <p class="text-sm text-slate-500">Affichez les alertes système dans votre tableau de bord</p>
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
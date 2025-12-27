@extends('layouts.app')

@section('title', 'Paramètres du Compte')

@section('content')
<div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 border-b border-slate-700 sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Paramètres du Compte</h1>
                <p class="text-slate-400 mt-1">Gérez votre profil et vos préférences</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        <!-- Profil Vendeur -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                Profil vendeur
            </h2>

            <form action="{{ route('vendeur.parametres.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom du commerce -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nom de votre commerce</label>
                        <input type="text" 
                               name="nom_commerce" 
                               value="{{ $vendeur->nom_commerce ?? '' }}"
                               class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                               placeholder="Nom du commerce">
                    </div>

                    <!-- Email professionnel -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email professionnel</label>
                        <input type="email" 
                               name="email_professionnel"
                               value="{{ $vendeur->email_professionnel ?? '' }}"
                               class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                               placeholder="email@commerce.com">
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label>
                        <input type="tel" 
                               name="telephone"
                               value="{{ $vendeur->telephone ?? '' }}"
                               class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                               placeholder="+243 ...">
                    </div>

                    <!-- Adresse -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Adresse</label>
                        <input type="text" 
                               name="adresse"
                               value="{{ $vendeur->adresse ?? '' }}"
                               class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                               placeholder="Adresse complète">
                    </div>

                    <!-- Ville -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Ville</label>
                        <input type="text" 
                               name="ville"
                               value="{{ $vendeur->ville ?? '' }}"
                               class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                               placeholder="Ville">
                    </div>

                    <!-- Pays -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Pays</label>
                        <select name="pays" class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors">
                            <option value="">Sélectionner...</option>
                            <option value="cd" @selected($vendeur->pays == 'cd')>République Démocratique du Congo</option>
                            <option value="cg" @selected($vendeur->pays == 'cg')>Congo</option>
                            <option value="cm" @selected($vendeur->pays == 'cm')>Cameroun</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Description du commerce</label>
                    <textarea name="description" 
                             rows="4"
                             class="w-full bg-slate-700 border border-slate-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                             placeholder="Décrivez votre commerce, vos produits...">{{ $vendeur->description ?? '' }}</textarea>
                </div>

                <!-- Logo/Bannière -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Logo du commerce</label>
                        <div class="border-2 border-dashed border-slate-600 rounded-lg p-6 text-center hover:border-primary-500 transition-colors">
                            <input type="file" 
                                   name="logo" 
                                   accept="image/*"
                                   class="hidden"
                                   id="logoInput">
                            <label for="logoInput" class="cursor-pointer">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <p class="text-slate-300 text-sm">Cliquez pour télécharger</p>
                                <p class="text-slate-500 text-xs">PNG, JPG jusqu'à 5MB</p>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Bannière</label>
                        <div class="border-2 border-dashed border-slate-600 rounded-lg p-6 text-center hover:border-primary-500 transition-colors">
                            <input type="file" 
                                   name="banniere" 
                                   accept="image/*"
                                   class="hidden"
                                   id="banniereInput">
                            <label for="banniereInput" class="cursor-pointer">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <p class="text-slate-300 text-sm">Cliquez pour télécharger</p>
                                <p class="text-slate-500 text-xs">PNG, JPG jusqu'à 10MB</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-primary-700 hover:bg-primary-800 text-white rounded-lg font-medium transition-colors">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('vendeur.dashboard') }}" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Préférences de notification -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>
                Notifications
            </h2>

            <form action="{{ route('vendeur.parametres.notifications') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/30 transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="notif_nouvelle_commande" 
                               @checked($notificationSettings?->notif_nouvelle_commande ?? true)
                               class="w-4 h-4 bg-slate-600 border border-slate-500 rounded focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-white">Nouvelles commandes</p>
                            <p class="text-slate-400 text-sm">Recevez une notification à chaque nouvelle commande</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/30 transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="notif_paiement_recu" 
                               @checked($notificationSettings?->notif_paiement_recu ?? true)
                               class="w-4 h-4 bg-slate-600 border border-slate-500 rounded focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-white">Paiements reçus</p>
                            <p class="text-slate-400 text-sm">Notifications pour les paiements confirmés</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/30 transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="notif_stock_bas" 
                               @checked($notificationSettings?->notif_stock_bas ?? true)
                               class="w-4 h-4 bg-slate-600 border border-slate-500 rounded focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-white">Stock faible</p>
                            <p class="text-slate-400 text-sm">Alertes pour les produits en rupture ou stock faible</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/30 transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="notif_avis_client" 
                               @checked($notificationSettings?->notif_avis_client ?? true)
                               class="w-4 h-4 bg-slate-600 border border-slate-500 rounded focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-white">Avis clients</p>
                            <p class="text-slate-400 text-sm">Notifications pour les nouveaux avis et commentaires</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg hover:bg-slate-600/30 transition-colors cursor-pointer">
                        <input type="checkbox" 
                               name="notif_email" 
                               @checked($notificationSettings?->notif_email ?? true)
                               class="w-4 h-4 bg-slate-600 border border-slate-500 rounded focus:ring-primary-500">
                        <div>
                            <p class="font-medium text-white">Notifications par email</p>
                            <p class="text-slate-400 text-sm">Recevez les notifications importantes par email</p>
                        </div>
                    </label>
                </div>

                <button type="submit" class="px-6 py-2 bg-primary-700 hover:bg-primary-800 text-white rounded-lg font-medium transition-colors mt-6">
                    Enregistrer les préférences
                </button>
            </form>
        </div>

        <!-- Sécurité -->
        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Sécurité
            </h2>

            <div class="space-y-4">
                <a href="{{ route('password.change') }}" class="block p-4 bg-slate-700/30 hover:bg-slate-600/30 rounded-lg transition-colors">
                    <p class="font-medium text-white">Changer le mot de passe</p>
                    <p class="text-slate-400 text-sm">Mettez à jour votre mot de passe pour sécuriser votre compte</p>
                </a>

                <a href="#" class="block p-4 bg-slate-700/30 hover:bg-slate-600/30 rounded-lg transition-colors">
                    <p class="font-medium text-white">Authentification à deux facteurs</p>
                    <p class="text-slate-400 text-sm">Activez l'authentification 2FA pour une sécurité renforcée</p>
                </a>

                <a href="#" class="block p-4 bg-slate-700/30 hover:bg-slate-600/30 rounded-lg transition-colors">
                    <p class="font-medium text-white">Sessions actives</p>
                    <p class="text-slate-400 text-sm">Consultez et fermez vos sessions actives</p>
                </a>
            </div>
        </div>

        <!-- Zone de danger -->
        <div class="bg-red-900/20 border border-red-700/50 rounded-xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-red-400 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                Zone de danger
            </h2>

            <p class="text-red-300 mb-4">Les actions suivantes sont irréversibles.</p>

            <button class="px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg font-medium transition-colors border border-red-600/50">
                Supprimer le compte
            </button>
        </div>
    </div>
</div>
@endsection

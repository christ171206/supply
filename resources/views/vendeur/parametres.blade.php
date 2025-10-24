@extends('layouts.vendeur')

@section('title', 'Paramètres')
@section('subtitle', 'Configurez votre compte et votre boutique')

@section('content')
    <!-- En-tête de la page -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 text-sm text-slate-500">
                <a href="{{ route('vendeur.dashboard') }}" class="hover:text-slate-600">Tableau de bord</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-slate-600">Paramètres</span>
            </div>
            <a href="{{ route('vendeur.dashboard') }}" 
               class="inline-flex items-center px-3 py-2 bg-white text-sm text-slate-600 rounded-lg border border-slate-200 hover:bg-slate-50 hover:text-slate-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour au tableau de bord
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Conteneur principal -->
    <div x-data="{ active: 'general' }" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Menu latéral -->
        <div class="lg:col-span-1">
            <nav class="space-y-1">
                <!-- Onglet Paramètres généraux -->
                <a href="#" 
                   @click.prevent="active = 'general'"
                   :class="{'bg-sky-500/10 border-r-4 border-sky-500 text-sky-600': active === 'general',
                           'text-slate-600 hover:bg-slate-50': active !== 'general'}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <div class="mr-3 p-2 rounded-lg" :class="active === 'general' ? 'bg-sky-500/10' : 'bg-slate-100'">
                        <svg class="w-5 h-5" :class="active === 'general' ? 'text-sky-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.608-.996.07-2.296-1.065-2.572-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span>Paramètres généraux</span>
                </a>

                <!-- Onglet Paramètres boutique -->
                <a href="#" 
                   @click.prevent="active = 'boutique'"
                   :class="{'bg-sky-500/10 border-r-4 border-sky-500 text-sky-600': active === 'boutique',
                           'text-slate-600 hover:bg-slate-50': active !== 'boutique'}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <div class="mr-3 p-2 rounded-lg" :class="active === 'boutique' ? 'bg-sky-500/10' : 'bg-slate-100'">
                        <svg class="w-5 h-5" :class="active === 'boutique' ? 'text-sky-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <span>Configuration boutique</span>
                </a>

                <!-- Onglet Paramètres paiement -->
                <a href="#" 
                   @click.prevent="active = 'paiements'"
                   :class="{'bg-sky-500/10 border-r-4 border-sky-500 text-sky-600': active === 'paiements',
                           'text-slate-600 hover:bg-slate-50': active !== 'paiements'}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <div class="mr-3 p-2 rounded-lg" :class="active === 'paiements' ? 'bg-sky-500/10' : 'bg-slate-100'">
                        <svg class="w-5 h-5" :class="active === 'paiements' ? 'text-sky-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span>Moyens de paiement</span>
                </a>

                <!-- Onglet Notifications -->
                <a href="#" 
                   @click.prevent="active = 'notifications'"
                   :class="{'bg-sky-500/10 border-r-4 border-sky-500 text-sky-600': active === 'notifications',
                           'text-slate-600 hover:bg-slate-50': active !== 'notifications'}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200">
                    <div class="mr-3 p-2 rounded-lg" :class="active === 'notifications' ? 'bg-sky-500/10' : 'bg-slate-100'">
                        <svg class="w-5 h-5" :class="active === 'notifications' ? 'text-sky-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <span>Notifications</span>
                </a>
            </nav>
        </div>

        <!-- Contenu des paramètres -->
        <div class="lg:col-span-3">
            <div x-show="active === 'general'">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h2 class="text-lg font-medium text-slate-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.608-.996.07-2.296-1.065-2.572-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Paramètres généraux
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Configurez vos préférences générales et personnalisez votre expérience
                        </p>
                    </div>
                    <div class="px-6 py-4">
                            <form action="{{ route('vendeur.parametres.general') }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="langue" class="block text-sm font-medium text-slate-700">Langue d'affichage</label>
                                        <select id="langue" name="langue" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-md">
                                            <option value="fr" {{ ($settings['langue'] ?? 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                                            <option value="en" {{ ($settings['langue'] ?? 'fr') === 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="theme" class="block text-sm font-medium text-slate-700">Thème</label>
                                        <select id="theme" name="theme" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-md">
                                            <option value="light" {{ ($settings['theme'] ?? 'light') === 'light' ? 'selected' : '' }}>Clair</option>
                                            <option value="dark" {{ ($settings['theme'] ?? 'light') === 'dark' ? 'selected' : '' }}>Sombre</option>
                                        </select>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="timezone" class="block text-sm font-medium text-slate-700">Fuseau horaire</label>
                                        <select id="timezone" name="timezone" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-md">
                                            <option value="Africa/Abidjan" {{ ($settings['timezone'] ?? 'Africa/Abidjan') === 'Africa/Abidjan' ? 'selected' : '' }}>Côte d'Ivoire (UTC+0)</option>
                                            <option value="Europe/Paris" {{ ($settings['timezone'] ?? 'Africa/Abidjan') === 'Europe/Paris' ? 'selected' : '' }}>France (UTC+1)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <h3 class="text-lg font-medium text-slate-900 mb-4">Préférences de notification</h3>
                                    <div class="space-y-3">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" id="notif_email" name="notifications[email]" value="1" 
                                                    {{ isset($settings['notifications']['email']) && $settings['notifications']['email'] ? 'checked' : '' }}
                                                    class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="notif_email" class="font-medium text-slate-700">Notifications par email</label>
                                                <p class="text-slate-500">Recevez les mises à jour importantes par email</p>
                                            </div>
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" id="notif_sms" name="notifications[sms]" value="1" 
                                                    {{ isset($settings['notifications']['sms']) && $settings['notifications']['sms'] ? 'checked' : '' }}
                                                    class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="notif_sms" class="font-medium text-slate-700">Notifications par SMS</label>
                                                <p class="text-slate-500">Recevez les alertes urgentes par SMS</p>
                                            </div>
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" id="notif_dashboard" name="notifications[dashboard]" value="1" 
                                                    {{ isset($settings['notifications']['dashboard']) && $settings['notifications']['dashboard'] ? 'checked' : '' }}
                                                    class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="notif_dashboard" class="font-medium text-slate-700">Notifications sur le tableau de bord</label>
                                                <p class="text-slate-500">Affichez les notifications dans votre interface</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
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

                <!-- Paramètres boutique -->
                <div x-show="active === 'boutique'" x-cloak>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                </svg>
                                Paramètres boutique
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Personnalisez l'apparence et les informations de votre boutique
                            </p>
                        </div>
                        
                        <div class="px-6 py-4">
                            <form action="{{ route('vendeur.parametres.boutique') }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                    <div class="lg:col-span-1">
                                        <div class="text-center">
                                            <div class="relative inline-block">
                                                <img src="{{ $boutique->logo_url ?? asset('images/default-shop.png') }}"
                                                     alt="Logo boutique"
                                                     class="w-32 h-32 rounded-lg object-cover shadow-sm">
                                                <button type="button" 
                                                        class="absolute bottom-2 right-2 p-2 bg-white rounded-full shadow-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#logoModal">
                                                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="lg:col-span-3 space-y-6">
                                        <div>
                                            <label for="nom_public" class="block text-sm font-medium text-slate-700">
                                                Nom public de la boutique
                                            </label>
                                            <input type="text" 
                                                   id="nom_public"
                                                   name="nom_public" 
                                                   value="{{ $boutique->nom_public ?? '' }}" 
                                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                                   required>
                                        </div>

                                        <div>
                                            <label for="message_bienvenue" class="block text-sm font-medium text-slate-700">
                                                Message de bienvenue
                                            </label>
                                            <textarea id="message_bienvenue"
                                                      name="message_bienvenue" 
                                                      rows="3" 
                                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">{{ $boutique->message_bienvenue ?? '' }}</textarea>
                                            <p class="mt-2 text-sm text-slate-500">
                                                Ce message sera affiché en haut de votre page boutique
                                            </p>
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="checkbox" 
                                                       id="boutique_visible" 
                                                       name="visible" 
                                                       value="1" 
                                                       {{ $boutique->visible ?? false ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="boutique_visible" class="font-medium text-slate-700">
                                                    Boutique visible pour les clients
                                                </label>
                                                <p class="text-slate-500">
                                                    Activer cette option rendra votre boutique visible pour tous les clients
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 flex justify-end">
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

                <!-- Paramètres de paiement -->
                <div x-show="active === 'paiements'" x-cloak>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-medium text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Paramètres de paiement
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Configurez vos méthodes et informations de paiement
                            </p>
                        </div>
                        
                        <div class="px-6 py-4">
                            <form action="{{ route('vendeur.parametres.paiement') }}" method="POST" class="space-y-8">
                                @csrf
                                @method('PUT')

                                <div>
                                    <h3 class="text-base font-medium text-slate-900 mb-4">Moyens de paiement acceptés</h3>
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="checkbox" 
                                                       id="paiement_mtn" 
                                                       name="moyens_paiement[]" 
                                                       value="mtn" 
                                                       {{ in_array('mtn', $paiements['moyens'] ?? []) ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="paiement_mtn" class="font-medium text-slate-700">MTN Mobile Money</label>
                                                <p class="text-slate-500">Paiements via MTN MoMo</p>
                                            </div>
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="checkbox" 
                                                       id="paiement_orange" 
                                                       name="moyens_paiement[]" 
                                                       value="orange" 
                                                       {{ in_array('orange', $paiements['moyens'] ?? []) ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="paiement_orange" class="font-medium text-slate-700">Orange Money</label>
                                                <p class="text-slate-500">Paiements via Orange Money</p>
                                            </div>
                                        </div>

                                        <div class="relative flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input type="checkbox" 
                                                       id="paiement_cash" 
                                                       name="moyens_paiement[]" 
                                                       value="cash" 
                                                       {{ in_array('cash', $paiements['moyens'] ?? []) ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="paiement_cash" class="font-medium text-slate-700">Paiement à la livraison</label>
                                                <p class="text-slate-500">Paiement en espèces</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-base font-medium text-slate-900 mb-4">Numéros de paiement mobile</h3>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Numéro MTN MoMo</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 sm:text-sm">+237</span>
                                                </div>
                                                <input type="text" 
                                                       name="numero_mtn" 
                                                       value="{{ $paiements['numeros']['mtn'] ?? '' }}" 
                                                       placeholder="650000000"
                                                       class="pl-16 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Numéro Orange Money</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 sm:text-sm">+237</span>
                                                </div>
                                                <input type="text" 
                                                       name="numero_orange" 
                                                       value="{{ $paiements['numeros']['orange'] ?? '' }}" 
                                                       placeholder="690000000"
                                                       class="pl-16 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
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

                            <div class="mt-8 pt-8 border-t border-slate-200">
                                <h3 class="text-base font-medium text-slate-900 mb-4">Historique des paiements</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-slate-200">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Montant</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Méthode</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-slate-200">
                                            @forelse($paiements_recents ?? [] as $paiement)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900">
                                                        {{ $paiement->date->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900 font-medium">
                                                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">
                                                        {{ $paiement->methode }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paiement->statut === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                            {{ $paiement->statut }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="px-4 py-8 text-sm text-center text-slate-500">
                                                        Aucun paiement récent
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour le logo -->
<div class="modal fade" id="logoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog max-w-lg mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-slate-600">
                <h3 class="text-xl font-semibold text-slate-900">
                    Changer le logo de la boutique
                </h3>
                <button type="button" 
                        class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" 
                        data-bs-dismiss="modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('vendeur.parametres.logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="logo_upload" class="flex flex-col items-center justify-center w-full h-64 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-slate-500">
                                        <span class="font-semibold">Cliquez pour télécharger</span> ou glissez et déposez
                                    </p>
                                    <p class="text-xs text-slate-500">SVG, PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <input id="logo_upload" 
                                       name="logo" 
                                       type="file" 
                                       class="hidden" 
                                       accept="image/*"
                                       required />
                            </label>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-slate-900 mb-1">Recommandations</h4>
                            <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                                <li>Dimensions recommandées : 500x500 pixels</li>
                                <li>Formats acceptés : PNG, JPG, SVG</li>
                                <li>Taille maximale : 2 MB</li>
                                <li>Privilégiez une image carrée</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b">
                    <button type="button" 
                            class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500" 
                            data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-sky-600 border border-transparent rounded-md shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        Enregistrer le logo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/vendeur/parametres.js') }}" defer></script>
@endpush

@push('styles')
<style>
[x-cloak] { 
    display: none !important; 
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}

/* Styles pour l'upload de fichiers */
.drop-zone {
    transition: all 0.3s ease;
}

.drop-zone:hover {
    border-color: #0ea5e9;
}

.drop-zone.dragging {
    border-color: #0ea5e9;
    background-color: rgba(14, 165, 233, 0.05);
}

/* Styles pour les badges de statut */
.status-badge {
    transition: all 0.2s ease;
}

.status-badge:hover {
    transform: translateY(-1px);
}

/* Style pour les onglets */
.tab-indicator {
    transition: all 0.3s ease;
}

/* Style pour les boutons */
.btn-hover-effect {
    transition: all 0.2s ease;
}

.btn-hover-effect:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Style pour le modal */
.modal-backdrop {
    background-color: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(4px);
}

/* Animation du switch */
.form-switch {
    transition: background-position .15s ease-in-out;
}

/* Style pour les inputs */
.form-control:focus, 
.form-select:focus {
    box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.25);
}
</style>
@endpush
@endsection

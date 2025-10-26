<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Interface Vendeur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Transitions douces globales */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Styles des cartes */
        .card {
            @apply bg-white rounded-xl shadow-sm border border-slate-200/60;
        }

        .card-header {
            @apply px-6 py-4 border-b border-slate-200/60;
        }

        .card-body {
            @apply p-6;
        }

        /* Styles des boutons */
        .btn {
            @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 inline-flex items-center justify-center;
        }

        .btn-primary {
            @apply bg-sky-500 text-white hover:bg-sky-600 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2;
        }

        .btn-secondary {
            @apply bg-slate-100 text-slate-700 hover:bg-slate-200 focus:ring-2 focus:ring-slate-500 focus:ring-offset-2;
        }

        /* Améliorations des formulaires */
        .form-input, .form-select, .form-textarea {
            @apply rounded-lg border-slate-300 focus:border-sky-500 focus:ring focus:ring-sky-500/20;
        }

        /* Badges */
        .badge {
            @apply px-2 py-1 text-xs font-medium rounded-full;
        }

        .badge-success {
            @apply bg-emerald-100 text-emerald-700;
        }

        .badge-warning {
            @apply bg-amber-100 text-amber-700;
        }

        .badge-danger {
            @apply bg-rose-100 text-rose-700;
        }

        /* Effets de survol améliorés */
        .hover-lift {
            @apply transition-transform duration-200 hover:-translate-y-0.5;
        }

        /* Animation de chargement */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Effet de brillance sur les boutons */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }
            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        /* Animation de gradient en arrière-plan */
        .bg-gradient-animate {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Classes utilitaires personnalisées */
        .backdrop-blur { backdrop-filter: blur(8px); }
        
        .shadow-top { box-shadow: 0 -1px 3px 0 rgb(0 0 0 / 0.1), 0 -1px 2px -1px rgb(0 0 0 / 0.1); }
        
        .mask-fade-bottom {
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
        }

        /* Animation pour les notifications */
        @keyframes notification-pulse {
            0% { transform: scale(0.95); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.5; }
        }

        .notification-badge {
            animation: notification-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Style des boutons */
        .btn-primary {
            @apply inline-flex items-center px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all duration-200;
        }

        .btn-secondary {
            @apply inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-all duration-200;
        }

        .btn-danger {
            @apply inline-flex items-center px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-all duration-200;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased">
    <div class="flex h-full bg-slate-50">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-white flex items-center group">
                    <div class="w-10 h-10 mr-3 bg-sky-500/10 rounded-lg flex items-center justify-center transform group-hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-white">Supply</span>
                </h1>
            </div>
            <nav class="mt-4 space-y-1">
                <!-- Tableau de bord -->
                <a href="{{ route('vendeur.dashboard') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.dashboard') ? 'bg-sky-500/15 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/40 hover:text-white hover:border-r-4 hover:border-slate-400' }} transition-all duration-200">
                    <div class="mr-3 p-1 rounded-lg {{ request()->routeIs('vendeur.dashboard') ? 'bg-sky-500/10' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="font-medium">Tableau de bord</span>
                </a>

                <!-- Produits -->
                <a href="{{ route('vendeur.produits') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.produits*') ? 'bg-sky-500/15 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/40 hover:text-white hover:border-r-4 hover:border-slate-400' }} transition-all duration-200">
                    <div class="mr-3 p-1 rounded-lg {{ request()->routeIs('vendeur.produits*') ? 'bg-sky-500/10' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="font-medium">Produits</span>
                </a>

                <!-- Stock -->
                <a href="{{ route('vendeur.stock') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.stock*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    <span class="font-medium">Gestion du stock</span>
                </a>

                <!-- Fournisseurs -->
                <a href="{{ route('vendeur.fournisseurs') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.fournisseurs*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-medium">Fournisseurs</span>
                </a>

                <!-- Commandes -->
                <a href="{{ route('vendeur.commandes') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.commandes*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="font-medium">Commandes</span>
                </a>

                <!-- Messagerie -->
                <a href="{{ route('vendeur.messagerie') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.messagerie*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span class="font-medium">Messagerie</span>
                    @php
                        $unreadCount = \App\Models\Message::whereHas('conversation', function($query) {
                            $query->whereHas('vendeur', function($q) {
                                $q->where('id', Auth::id());
                            });
                        })
                        ->where('lu', false)
                        ->where('expediteur_id', '!=', Auth::id())
                        ->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-2 bg-sky-500/20 text-sky-500 text-xs px-2 py-1 rounded-full font-medium">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Paiements -->
                <a href="{{ route('vendeur.paiements') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.paiements*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">Paiements</span>
                </a>

                <!-- Rapports -->
                <a href="{{ route('vendeur.rapports') }}"
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.rapports*') ? 'bg-sky-500/10 text-sky-500 border-r-4 border-sky-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }} transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium">Rapports</span>
                </a>

                <!-- Paramètres -->
                <div x-data="{ open: {{ request()->routeIs('vendeur.parametres*') ? 'true' : 'false' }} }" 
                     class="relative">
                    <button @click="open = !open" 
                            class="group flex items-center justify-between w-full px-4 py-3 {{ request()->routeIs('vendeur.parametres*') ? 'bg-sky-500/20 text-sky-500' : 'text-slate-300 hover:bg-slate-700/30' }} rounded-lg transition-all duration-300">
                        <div class="flex items-center">
                            <div class="mr-3 p-1.5 rounded-lg {{ request()->routeIs('vendeur.parametres*') ? 'bg-sky-500/10' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium">Paramètres</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-300" 
                             :class="{'rotate-180': open}"
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                         class="mt-3 ml-4 relative">
                        
                        <!-- Ligne verticale de connexion -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-sky-500/20 via-slate-700 to-slate-700/50"></div>

                        <!-- Menu des paramètres -->
                        <div class="relative space-y-0.5 pl-8">
                            <a href="{{ route('vendeur.parametres') }}?section=profil" 
                               class="group flex items-center py-2.5 pr-3 rounded-r-lg relative {{ request()->query('section') == 'profil' ? 'bg-sky-500/10' : 'hover:bg-slate-700/20' }} transition-all duration-300">
                                <!-- Point de connexion -->
                                <div class="absolute -left-8 top-1/2 transform -translate-y-1/2 w-4 h-0.5 bg-slate-700 group-hover:bg-sky-500/50 transition-colors"></div>
                                <!-- Icône dans un cercle -->
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ request()->query('section') == 'profil' ? 'bg-sky-500/20 text-sky-500' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }} transition-all duration-300 mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ request()->query('section') == 'profil' ? 'text-sky-500' : 'text-slate-300 group-hover:text-white' }} transition-colors">Profil</span>
                                    <span class="text-xs {{ request()->query('section') == 'profil' ? 'text-sky-500/70' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors">Gérez vos informations personnelles</span>
                                </div>
                            </a>

                            <a href="{{ route('vendeur.parametres') }}?section=boutique" 
                               class="group flex items-center py-2.5 pr-3 rounded-r-lg relative {{ request()->query('section') == 'boutique' ? 'bg-sky-500/10' : 'hover:bg-slate-700/20' }} transition-all duration-300">
                                <div class="absolute -left-8 top-1/2 transform -translate-y-1/2 w-4 h-0.5 bg-slate-700 group-hover:bg-sky-500/50 transition-colors"></div>
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ request()->query('section') == 'boutique' ? 'bg-sky-500/20 text-sky-500' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }} transition-all duration-300 mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3zM12 8v8m-4-4h8"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ request()->query('section') == 'boutique' ? 'text-sky-500' : 'text-slate-300 group-hover:text-white' }} transition-colors">Boutique</span>
                                    <span class="text-xs {{ request()->query('section') == 'boutique' ? 'text-sky-500/70' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors">Personnalisez votre espace de vente</span>
                                </div>
                            </a>

                            <a href="{{ route('vendeur.parametres') }}?section=paiement" 
                               class="group flex items-center py-2.5 pr-3 rounded-r-lg relative {{ request()->query('section') == 'paiement' ? 'bg-sky-500/10' : 'hover:bg-slate-700/20' }} transition-all duration-300">
                                <div class="absolute -left-8 top-1/2 transform -translate-y-1/2 w-4 h-0.5 bg-slate-700 group-hover:bg-sky-500/50 transition-colors"></div>
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ request()->query('section') == 'paiement' ? 'bg-sky-500/20 text-sky-500' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }} transition-all duration-300 mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ request()->query('section') == 'paiement' ? 'text-sky-500' : 'text-slate-300 group-hover:text-white' }} transition-colors">Paiement</span>
                                    <span class="text-xs {{ request()->query('section') == 'paiement' ? 'text-sky-500/70' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors">Configurez vos options de paiement</span>
                                </div>
                            </a>

                            <a href="{{ route('vendeur.parametres') }}?section=notifications" 
                               class="group flex items-center py-2.5 pr-3 rounded-r-lg relative {{ request()->query('section') == 'notifications' ? 'bg-sky-500/10' : 'hover:bg-slate-700/20' }} transition-all duration-300">
                                <div class="absolute -left-8 top-1/2 transform -translate-y-1/2 w-4 h-0.5 bg-slate-700 group-hover:bg-sky-500/50 transition-colors"></div>
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ request()->query('section') == 'notifications' ? 'bg-sky-500/20 text-sky-500' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }} transition-all duration-300 mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ request()->query('section') == 'notifications' ? 'text-sky-500' : 'text-slate-300 group-hover:text-white' }} transition-colors">Notifications</span>
                                    <span class="text-xs {{ request()->query('section') == 'notifications' ? 'text-sky-500/70' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors">Gérez vos préférences d'alertes</span>
                                </div>
                            </a>

                            <a href="{{ route('vendeur.parametres') }}?section=securite" 
                               class="group flex items-center py-2.5 pr-3 rounded-r-lg relative {{ request()->query('section') == 'securite' ? 'bg-sky-500/10' : 'hover:bg-slate-700/20' }} transition-all duration-300">
                                <div class="absolute -left-8 top-1/2 transform -translate-y-1/2 w-4 h-0.5 bg-slate-700 group-hover:bg-sky-500/50 transition-colors"></div>
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ request()->query('section') == 'securite' ? 'bg-sky-500/20 text-sky-500' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }} transition-all duration-300 mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium {{ request()->query('section') == 'securite' ? 'text-sky-500' : 'text-slate-300 group-hover:text-white' }} transition-colors">Sécurité</span>
                                    <span class="text-xs {{ request()->query('section') == 'securite' ? 'text-sky-500/70' : 'text-slate-500 group-hover:text-slate-400' }} transition-colors">Protégez votre compte</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-10 border-b border-slate-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="md:hidden hover:bg-slate-100 rounded-lg p-2 transition-all duration-200">
                            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-slate-800 ml-2">@yield('title')</h2>
                        @if(View::hasSection('subtitle'))
                            <span class="ml-3 text-sm text-slate-500">@yield('subtitle')</span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200 group">
                            <svg class="w-6 h-6 group-hover:text-sky-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-sky-500 rounded-full ring-2 ring-white"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click.stop="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-indigo-50 transition-all duration-200 group">
                                <div class="relative">
                                    <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nom) }}"
                                         alt="Profile"
                                         class="w-10 h-10 rounded-full ring-2 ring-indigo-500/50 group-hover:ring-indigo-500 transition-all duration-200">
                                    @if(auth()->user()->vendeur && auth()->user()->vendeur->statut_verification === 'verifie')
                                        <div class="absolute -bottom-1 -right-1 bg-emerald-500 text-white rounded-full p-1 shadow-lg shadow-emerald-500/50">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-gray-700">{{ Auth::user()->nom }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->vendeur ? Auth::user()->vendeur->nom_boutique : 'Ma Boutique' }}</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-cloak
                                 @click.away="open = false"
                                 class="fixed right-6 top-16 w-72 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl shadow-purple-500/20 py-2 border border-purple-100"
                                 style="z-index: 9999;"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2">

                                <!-- En-tête du dropdown avec édition rapide -->
                                <div x-data="{ editMode: false, tempData: {} }" class="relative">
                                    <!-- Mode affichage -->
                                    <div x-show="!editMode" class="px-4 py-3 border-b">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-700">{{ Auth::user()->email }}</div>
                                                <div class="text-xs text-gray-500">Membre depuis {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('M Y') }}</div>
                                            </div>
                                            <button @click="editMode = true; tempData = {
                                                nom: '{{ Auth::user()->nom }}',
                                                telephone: '{{ Auth::user()->telephone }}',
                                                boutique: '{{ Auth::user()->vendeur->nom_boutique ?? '' }}'
                                            }" class="p-1 text-gray-400 hover:text-blue-500 rounded-full hover:bg-blue-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Mode édition -->
                                    <div x-show="editMode" class="px-4 py-3 border-b">
                                        <form @submit.prevent="
                                            fetch('{{ route('vendeur.profil.update') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify(tempData)
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if(data.success) {
                                                    window.location.reload();
                                                }
                                            });
                                        ">
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="text-xs text-gray-500">Nom complet</label>
                                                    <input type="text"
                                                           x-model="tempData.nom"
                                                           class="w-full mt-1 text-sm border rounded px-2 py-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Téléphone</label>
                                                    <input type="tel"
                                                           x-model="tempData.telephone"
                                                           class="w-full mt-1 text-sm border rounded px-2 py-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-gray-500">Nom de la boutique</label>
                                                    <input type="text"
                                                           x-model="tempData.boutique"
                                                           class="w-full mt-1 text-sm border rounded px-2 py-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                </div>
                                                <div class="flex justify-end space-x-2 pt-2">
                                                    <button type="button"
                                                            @click="editMode = false"
                                                            class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">
                                                        Annuler
                                                    </button>
                                                    <button type="submit"
                                                            class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                                        Enregistrer
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Liens rapides -->
                                <div class="px-2 py-2 border-b">
                                    <a href="{{ route('vendeur.profil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Mon profil complet
                                    </a>
                                    <a href="{{ route('vendeur.parametres') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Paramètres
                                    </a>
                                    <a href="{{ route('vendeur.messagerie') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Messages
                                        @if($unreadCount > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                                {{ $unreadCount }}
                                            </span>
                                        @endif
                                    </a>
                                </div>

                                <!-- Statut de la boutique -->
                                @if(Auth::user()->vendeur)
                                <div class="px-4 py-2 border-b">
                                    <div class="flex items-center text-sm">
                                        <div class="w-3 h-3 rounded-full {{ Auth::user()->vendeur->statut === 'actif' ? 'bg-green-500' : 'bg-yellow-500' }} mr-2"></div>
                                        <span class="text-gray-600">Boutique {{ Auth::user()->vendeur->statut === 'actif' ? 'active' : 'en pause' }}</span>
                                    </div>
                                </div>
                                @else
                                <div class="px-4 py-2 border-b">
                                    <div class="flex items-center text-sm">
                                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                                        <span class="text-gray-600">Boutique non configurée</span>
                                    </div>
                                </div>
                                @endif

                                <!-- Actions -->
                                <div class="px-2 py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Se déconnecter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

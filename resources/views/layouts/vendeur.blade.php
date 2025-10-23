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
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h1 class="text-2xl font-bold text-gray-800">Supply</h1>
            </div>
            <nav class="mt-4">
                <!-- Tableau de bord -->
                <a href="{{ route('vendeur.dashboard') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>

                <!-- Produits -->
                <a href="{{ route('vendeur.produits') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.produits*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produits
                </a>

                <!-- Stock -->
                <a href="{{ route('vendeur.stock') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.stock*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Gestion du stock
                </a>

                <!-- Fournisseurs -->
                <a href="{{ route('vendeur.fournisseurs') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.fournisseurs*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Fournisseurs
                </a>

                <!-- Commandes -->
                <a href="{{ route('vendeur.commandes') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.commandes*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Commandes
                </a>

                <!-- Messagerie -->
                <a href="{{ route('vendeur.messagerie') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.messagerie*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Messagerie
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
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Paiements -->
                <a href="{{ route('vendeur.paiements') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.paiements*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Paiements
                </a>

                <!-- Rapports -->
                <a href="{{ route('vendeur.rapports') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.rapports*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Rapports
                </a>

                <!-- Paramètres -->
                <a href="{{ route('vendeur.parametres') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('vendeur.parametres*') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Paramètres
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800 ml-2">@yield('title')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-full hover:bg-gray-100">
                                <div class="relative">
                                    <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nom) }}" 
                                         alt="Profile" 
                                         class="w-10 h-10 rounded-full border-2 border-blue-500">
                                    @if(auth()->user()->vendeur->statut_verification === 'verifie')
                                        <div class="absolute -bottom-1 -right-1 bg-green-500 text-white rounded-full p-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-gray-700">{{ Auth::user()->nom }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->vendeur->nom_boutique ?? 'Ma Boutique' }}</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-cloak
                                 @click.away="open = false" 
                                 class="fixed right-0 mt-2 w-72 bg-white rounded-lg shadow-xl py-2"
                                 style="margin-right: 1rem; z-index: 9999; position: absolute; top: 100%;"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                
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
                                            fetch('{{ route('vendeur.profile.quick-update') }}', {
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
                                    <a href="{{ route('vendeur.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
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
                                <div class="px-4 py-2 border-b">
                                    <div class="flex items-center text-sm">
                                        <div class="w-3 h-3 rounded-full {{ Auth::user()->vendeur->statut === 'actif' ? 'bg-green-500' : 'bg-yellow-500' }} mr-2"></div>
                                        <span class="text-gray-600">Boutique {{ Auth::user()->vendeur->statut === 'actif' ? 'active' : 'en pause' }}</span>
                                    </div>
                                </div>

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
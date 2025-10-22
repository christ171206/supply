<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Supply</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 font-sans flex items-center justify-center py-12">

    <div class="w-full max-w-3xl mx-4 bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-gray-100">

        <!-- Colonne gauche (branding) -->
        <div class="hidden md:flex flex-col justify-center items-center bg-gray-100 text-gray-700 p-10 w-1/2">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Supply" class="w-16 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Bienvenue sur Supply</h2>
            <p class="text-sm text-gray-600 mt-3 text-center leading-relaxed">
                Gérez vos produits, commandes et clients facilement depuis votre espace personnel.
            </p>
            <img src="{{ asset('images/shopping.svg') }}" alt="illustration" class="w-40 mt-8 opacity-80">
        </div>

        <!-- Colonne droite (formulaire) -->
        <div class="flex-1 px-6 py-8 md:px-8 md:py-10 bg-white">
            <div class="max-w-xs sm:max-w-sm mx-auto">
                <!-- Logo et bouton de connexion -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.svg') }}" alt="Supply" class="w-10 h-10">
                        <span class="text-lg font-bold text-gray-800">Supply</span>
                    </div>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-700">
                        Se connecter
                    </a>
                </div>

                <!-- Titre -->
                <div class="text-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Créer un compte</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Inscrivez-vous pour accéder à votre tableau de bord Supply
                    </p>
                </div>

                <!-- Messages d’erreur -->
                @if ($errors->any())
                    <div aria-live="assertive" role="alert"
                         class="mb-4 p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulaire d’inscription -->
                <form id="registerForm" action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.121 17.804z" />
                                </svg>
                            </div>
                            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                   class="mt-1 w-full pl-10 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none focus:shadow-md transition">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16 12v1m-8-1v1m-2 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="mt-1 w-full pl-10 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none focus:shadow-md transition">
                        </div>
                    </div>

                    <div>
                        <label for="motDePasse" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M17 11V9a5 5 0 00-10 0v2" />
                                </svg>
                            </div>
                            <input type="password" id="motDePasse" name="motDePasse" required
                                   class="w-full pl-10 pr-10 border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none focus:shadow-md transition">
                            <button type="button" id="togglePasswordReg" aria-pressed="false"
                                    aria-label="Afficher le mot de passe"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg id="regEyeOpen" xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="regEyeClosed" xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9.88 9.88A3 3 0 0114.12 14.12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">S’inscrire en tant que</label>
                        <select id="role" name="role" required
                                class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-green-500 focus:outline-none">
                            <option value="client" selected>Client</option>
                            <option value="vendeur">Vendeur</option>
                        </select>
                    </div>
                </form>

                <!-- Bouton principal -->
                <div class="mt-8 mb-4">
                    <button form="registerForm" type="submit"
                            class="relative w-full bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white text-lg font-bold rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all duration-200">
                        <div class="px-8 py-4 flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Créer mon compte</span>
                        </div>
                    </button>
                </div>

                <!-- Réseaux sociaux -->
                <div class="mt-6">
                    <div class="flex items-center justify-center gap-2">
                        <hr class="flex-1 border-gray-200">
                        <span class="text-xs text-gray-400">ou</span>
                        <hr class="flex-1 border-gray-200">
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button
                            class="flex items-center justify-center gap-3 border border-gray-300 py-2 rounded-lg hover:bg-gray-50 transition">
                            <img src="{{ asset('images/google.svg') }}" class="w-5 h-5" alt="Google">
                            <span class="text-gray-700 text-sm">Continuer avec Google</span>
                        </button>
                        <button
                            class="flex items-center justify-center gap-3 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            <img src="{{ asset('images/facebook.svg') }}" class="w-5 h-5" alt="Facebook">
                            <span class="text-sm">Continuer avec Facebook</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const pw = document.getElementById('motDePasse');
            const btn = document.getElementById('togglePasswordReg');
            const eyeOpen = document.getElementById('regEyeOpen');
            const eyeClosed = document.getElementById('regEyeClosed');
            if (btn && pw){
                btn.addEventListener('click', function(){
                    const show = pw.type === 'password';
                    pw.type = show ? 'text' : 'password';
                    eyeOpen.classList.toggle('hidden', show);
                    eyeClosed.classList.toggle('hidden', !show);
                });
            }
        })();
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Supply</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 min-h-screen flex items-center justify-center font-sans">

    <!-- Carte centrée -->
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl px-6 py-8 border border-gray-100">
        <!-- Logo + titre -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/ChatGPT Image 31 juil. 2025, 00_39_29.png') }}" alt="Logo Supply" class="w-14 h-14 mb-3">
            <h2 class="text-2xl font-bold text-gray-900">Connexion</h2>
            <p class="text-sm text-gray-500 mt-1">Accédez à votre compte pour gérer vos activités</p>
        </div>

        <!-- Lien vers inscription -->
        <div class="text-center mb-6">
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-700 transition">
                Pas encore de compte ? <span class="text-green-600 font-semibold">Créer un compte</span>
            </a>
        </div>

        <!-- Messages d’erreur -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <div class="relative mt-1">
                    <input type="password" id="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 bg-white text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent focus:outline-none">
                    <button type="button" id="togglePassword" aria-label="Afficher ou masquer le mot de passe"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9.88 9.88A3 3 0 0114.12 14.12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-between items-center text-sm text-gray-600">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded text-green-600 focus:ring-green-600">
                    <span>Se souvenir de moi</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">Mot de passe oublié ?</a>
            </div>

            <button type="submit"
                class="w-full mt-2 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white py-2.5 rounded-lg font-semibold shadow-md transition-all duration-200">
                Se connecter
            </button>
        </form>

        <!-- Séparateur -->
        <div class="flex items-center justify-center mt-6">
            <div class="w-1/4 border-t border-gray-200"></div>
            <span class="mx-3 text-gray-400 text-sm">ou</span>
            <div class="w-1/4 border-t border-gray-200"></div>
        </div>

        <!-- Connexion sociale -->
        <div class="mt-4 space-y-3">
            <button
                class="flex items-center justify-center gap-3 w-full py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <img src="{{ asset('images/google.svg') }}" class="w-5 h-5" alt="Google">
                <span class="text-gray-700 text-sm font-medium">Continuer avec Google</span>
            </button>

            <button
                class="flex items-center justify-center gap-3 w-full py-2 border border-gray-300 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                <img src="{{ asset('images/facebook.svg') }}" class="w-5 h-5" alt="Facebook">
                <span class="text-sm font-medium">Continuer avec Facebook</span>
            </button>
        </div>
    </div>

    <script>
        // Afficher / masquer le mot de passe
        (function(){
            const pw = document.getElementById('password');
            const btn = document.getElementById('togglePassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            if (!pw || !btn) return;
            btn.addEventListener('click', function(){
                const show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                eyeOpen.classList.toggle('hidden', show);
                eyeClosed.classList.toggle('hidden', !show);
            });
        })();
    </script>

</body>
</html>

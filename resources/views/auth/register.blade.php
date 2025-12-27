<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Supply</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-primary-50 to-blue-50 font-sans min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden border border-primary-100">
        <div class="flex flex-col md:flex-row">

            <!-- Colonne gauche (branding) - Hidden on mobile -->
            <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-b from-primary-700 to-primary-800 text-white p-12 w-1/3">
                <div class="w-20 h-20 bg-white/10 rounded-lg flex items-center justify-center mb-6">
                    <img src="{{ asset('assets/branding/supply_logo.svg') }}" alt="Logo Supply" class="w-12 h-12">
                </div>
                <h2 class="text-2xl font-bold text-center">Bienvenue sur Supply</h2>
                <p class="text-sm text-primary-100 mt-4 text-center leading-relaxed">
                    Rejoignez notre plateforme et gérez facilement vos produits, commandes et clients.
                </p>
                <div class="mt-8 w-full h-32 bg-white/10 rounded-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-primary-200 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>

            <!-- Colonne droite (formulaire) -->
            <div class="flex-1 px-6 py-10 md:px-8 w-full md:w-2/3">
                <div class="max-w-md mx-auto">

                    <!-- Titre mobile -->
                    <div class="md:hidden flex flex-col items-center mb-8">
                        <div class="w-14 h-14 bg-primary-700 rounded-lg flex items-center justify-center mb-4">
                            <img src="{{ asset('assets/branding/supply_logo.svg') }}" alt="Logo Supply" class="w-8 h-8">
                        </div>
                        <h1 class="text-2xl font-bold text-slate-900">Créer un compte</h1>
                    </div>

                    <!-- Titre desktop -->
                    <div class="hidden md:block mb-8">
                        <h1 class="text-3xl font-bold text-slate-900">Créer un compte</h1>
                        <p class="text-sm text-slate-600 mt-2">Rejoignez Supply dès aujourd'hui</p>
                    </div>

                    <!-- Formulaire -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Nom complet -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-slate-700 mb-1.5">Nom complet</label>
                            <input type="text" name="nom" id="nom" 
                                   value="{{ old('nom') }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('nom') border-red-500 @enderror"
                                   placeholder="Jean Dupont" required>
                            @error('nom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email" id="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                   placeholder="votre@email.com" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="motDePasse" class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
                            <div class="relative">
                                <input type="password" name="motDePasse" id="motDePasse"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('motDePasse') border-red-500 @enderror"
                                       placeholder="••••••••" required>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 transition"
                                        onclick="togglePassword('motDePasse')">
                                    <svg id="motDePasse-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('motDePasse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-700 mb-1.5">Je suis</label>
                            <select name="role" id="role" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('role') border-red-500 @enderror"
                                    required>
                                <option value="">-- Sélectionner --</option>
                                <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="vendeur" {{ old('role') === 'vendeur' ? 'selected' : '' }}>Vendeur</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conditions -->
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms"
                                   class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500 border-slate-300 mt-0.5"
                                   required>
                            <label for="terms" class="ml-2 text-xs text-slate-600">
                                J'accepte les <a href="#" class="text-primary-700 hover:text-primary-800 font-semibold">conditions d'utilisation</a>
                            </label>
                        </div>

                        <!-- Bouton inscription -->
                        <button type="submit"
                                class="w-full bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-md hover:shadow-lg mt-6">
                            Créer un compte
                        </button>
                    </form>

                    <!-- Lien connexion -->
                    <div class="text-center mt-6 text-sm text-slate-600">
                        Vous avez déjà un compte?
                        <a href="{{ route('login') }}"
                           class="text-primary-700 hover:text-primary-800 font-semibold transition">
                            Se connecter
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-2.391m5.005-2.905A9.005 9.005 0 0112 5c4.478 0 8.268 2.943 9.543 7a9.97 9.97 0 01-1.563 2.391m0 0A9.025 9.025 0 0112 12.75a9.026 9.026 0 01.378-1.863m0 0a9.026 9.026 0 00-.378 1.863m0 0H21m-8.958 6A1.998 1.998 0 0110.5 15H9m11.857 1.175A4 4 0 0021 12a4 4 0 00-9-4H6a4 4 0 000 8h.857a4 4 0 003.857 3.175z"/>';
            } else {
                input.type = 'password';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</body>
</html>

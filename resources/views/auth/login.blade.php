<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Supply</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-primary-50 to-blue-50 min-h-screen flex items-center justify-center font-sans">

    <!-- Carte centrée -->
    <div class="w-full max-w-sm bg-white rounded-xl shadow-2xl px-8 py-10 border border-primary-100">
        
        <!-- Logo + titre -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 mb-4 bg-primary-700 rounded-lg shadow-lg flex items-center justify-center">
                <img src="{{ asset('assets/branding/supply_logo.svg') }}" alt="Logo Supply" class="w-10 h-10">
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Connexion</h1>
            <p class="text-sm text-slate-600 mt-2">Accédez à votre compte Supply</p>
        </div>

        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                       placeholder="votre@email.com" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Mot de passe</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                           placeholder="••••••••" required>
                    <button type="button" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 transition"
                            onclick="togglePassword('password')">
                        <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" 
                       class="w-4 h-4 text-primary-600 bg-slate-100 border-slate-300 rounded focus:ring-primary-500 transition">
                <label for="remember" class="ml-2 text-sm text-slate-700">Se souvenir de moi</label>
            </div>

            <!-- Bouton connexion -->
            <button type="submit"
                    class="w-full bg-primary-700 hover:bg-primary-800 text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                Se connecter
            </button>
        </form>

        <!-- Liens -->
        <div class="mt-6 space-y-3">
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-primary-700 hover:text-primary-800 font-medium transition">
                        Mot de passe oublié?
                    </a>
                </div>
            @endif

            <div class="text-center text-sm text-slate-600">
                Pas encore de compte?
                <a href="{{ route('register') }}"
                   class="text-primary-700 hover:text-primary-800 font-semibold transition">
                    Créer un compte
                </a>
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

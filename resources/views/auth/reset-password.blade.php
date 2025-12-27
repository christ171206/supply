<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Supply</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-4 text-center">Réinitialisation du mot de passe</h2>
        
        @if (session('reset_code'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <p class="text-sm mb-1">Votre code de réinitialisation :</p>
                <p class="text-center text-xl font-bold">{{ session('reset_code') }}</p>
            </div>
        @endif

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', session('email')) }}" 
                       required
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code de réinitialisation (6 chiffres)</label>
                <input type="text" 
                       id="code" 
                       name="code" 
                       value="{{ old('code', session('code')) }}"
                       required
                       pattern="[0-9]{6}"
                       maxlength="6"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Entrez le code à 6 chiffres">
                <p class="text-sm text-gray-500 mt-1">Entrez le code à 6 chiffres affiché ci-dessus</p>
            </div>

            <div>
                <label for="motDePasse" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                <input type="password" 
                       id="motDePasse" 
                       name="motDePasse" 
                       required
                       minlength="6"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="motDePasse_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input type="password" 
                       id="motDePasse_confirmation" 
                       name="motDePasse_confirmation" 
                       required
                       minlength="6"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-2 px-4 rounded-md hover:bg-blue-800 transition">
                Réinitialiser le mot de passe
            </button>

            <p class="text-sm text-center mt-4">
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline">
                    Retour à la connexion
                </a>
            </p>
        </form>
    </div>
</body>
</html>

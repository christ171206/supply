<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe réinitialisé - Supply</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-sm mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <!-- Logo et succès -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/ChatGPT Image 31 juil. 2025, 00_39_29.png') }}" alt="Logo Supply" class="w-16 h-16 mx-auto mb-4">
                
                <div class="flex flex-col items-center justify-center mb-6">
                    <div class="rounded-full bg-green-100 p-3 mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Mot de passe réinitialisé !</h2>
                    <p class="text-sm text-gray-600 mt-2">
                        Votre mot de passe a été réinitialisé avec succès.
                        Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.
                    </p>
                </div>
            </div>

            <!-- Bouton de connexion -->
            <div>
                <a href="{{ route('login') }}" 
                   class="block w-full py-3 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white font-semibold rounded-lg shadow-lg text-center transition duration-200">
                    Se connecter
                </a>
            </div>
        </div>
    </div>
</body>
</html>
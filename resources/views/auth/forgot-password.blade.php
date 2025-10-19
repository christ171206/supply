<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Supply</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-sm mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/ChatGPT Image 31 juil. 2025, 00_39_29.png') }}" alt="Logo Supply" class="w-16 h-16 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Mot de passe oublié ?</h2>
                <p class="text-sm text-gray-500 mt-2">
                    @if(!session('reset_code'))
                        Entrez votre adresse e-mail pour recevoir un code de réinitialisation.
                    @else
                        Un code de réinitialisation a été généré pour votre compte.
                    @endif
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                    <div class="flex flex-col items-center text-center">
                        <svg class="h-12 w-12 text-green-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-medium text-green-700 mb-2">
                            {{ session('status') }}
                        </p>
                        @if(session('reset_code'))
                            <div class="mt-2 bg-gray-100 py-3 px-6 rounded-lg">
                                <span class="text-2xl font-mono font-bold tracking-wider text-gray-800">{{ session('reset_code') }}</span>
                            </div>
                            <p class="mt-4 text-sm text-gray-600">
                                Utilisez ce code pour réinitialiser votre mot de passe ci-dessous.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            @if(!session('reset_code'))
                <!-- Formulaire pour demander le code -->
                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-gray-900 placeholder-gray-500"
                                placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white font-semibold rounded-lg shadow-lg transform transition-all duration-200">
                        Recevoir le code de réinitialisation
                    </button>
                </form>
            @else
                <!-- Formulaire pour entrer le code et le nouveau mot de passe -->
                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email', old('email')) }}">

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Code de réinitialisation</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                </svg>
                            </div>
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   required
                                   pattern="[0-9]{6}"
                                   maxlength="6"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-gray-900 placeholder-gray-500"
                                   placeholder="Entrez le code à 6 chiffres">
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="motDePasse" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" 
                                   id="motDePasse" 
                                   name="motDePasse" 
                                   required
                                   minlength="6"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Minimum 6 caractères">
                        </div>
                        @error('motDePasse')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="motDePasse_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" 
                                   id="motDePasse_confirmation" 
                                   name="motDePasse_confirmation" 
                                   required
                                   minlength="6"
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="Confirmez votre mot de passe">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white font-semibold rounded-lg shadow-lg transform transition-all duration-200">
                        Réinitialiser le mot de passe
                    </button>
                </form>
            @endif

            <!-- Lien de retour -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-600 hover:underline font-medium">
                    Retour à la connexion
                </a>
            </div>
        </div>
    </div>
</body>
</html>

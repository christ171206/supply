@extends('layouts.client')

@section('title', 'Profil & sécurité')

@section('content')
<!-- En-tête -->
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Profil & sécurité</h1>
    <p class="text-gray-600 mt-2">Gérez vos informations personnelles et vos paramètres de sécurité</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Contenu principal -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Informations de profil -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Informations de profil</h2>

            <form action="{{ route('client.profil.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
                        <input
                            type="text"
                            id="nom"
                            name="nom"
                            value="{{ Auth::user()->nom }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                        @error('nom')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ Auth::user()->email }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                        <input
                            type="tel"
                            id="telephone"
                            name="telephone"
                            value="{{ Auth::user()->telephone ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Entreprise -->
                    <div>
                        <label for="entreprise" class="block text-sm font-semibold text-gray-700 mb-2">Entreprise</label>
                        <input
                            type="text"
                            id="entreprise"
                            name="entreprise"
                            value="{{ Auth::user()->entreprise ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-2">Adresse</label>
                    <input
                        type="text"
                        id="adresse"
                        name="adresse"
                        value="{{ Auth::user()->adresse ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <button
                        type="button"
                        onclick="window.history.back()"
                        class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition font-semibold"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition font-semibold"
                    >
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <!-- Sécurité -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Sécurité</h2>

            <!-- Changement de mot de passe -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Modifier votre mot de passe</h3>

                <form action="{{ route('client.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe actuel</label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                        @error('current_password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Nouveau mot de passe</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-600 mt-2">Au minimum 8 caractères avec majuscules, minuscules et chiffres</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                    </div>

                    <div class="flex justify-end pt-2">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-primary-700 text-white rounded-lg hover:bg-primary-800 transition font-semibold"
                        >
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sessions actives -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sessions actives</h3>

                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900">Navigateur actuel</p>
                        <p class="text-sm text-gray-600 mt-1">{{ Request::header('User-Agent') ? 'Windows / Chrome' : 'Inconnu' }}</p>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                        <span class="w-2 h-2 bg-green-600 rounded-full"></span> Actif
                    </span>
                </div>

                <p class="text-xs text-gray-600 mt-4">
                    Pour des raisons de sécurité, déconnectez-vous sur tous les autres appareils depuis lesquels vous avez accès à votre compte.
                </p>
            </div>

            <!-- Zone de danger -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">Zone de danger</h3>

                <p class="text-sm text-red-800 mb-4">
                    La suppression de votre compte est permanente et irréversible. Toutes vos données seront supprimées.
                </p>

                <form action="{{ route('client.account.delete') }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer votre compte? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
                    >
                        Supprimer mon compte
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar info -->
    <div class="lg:col-span-1">
        <!-- Infos sécurité -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm sticky top-24">
            <h3 class="font-bold text-gray-900 mb-4">Conseils de sécurité</h3>

            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Mot de passe fort</p>
                        <p class="text-xs text-gray-600 mt-1">Utilisez un mot de passe unique et complexe</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Email vérifiée</p>
                        <p class="text-xs text-gray-600 mt-1">Gardez votre email à jour</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">Déconnexion régulière</p>
                        <p class="text-xs text-gray-600 mt-1">Déconnectez-vous après chaque session</p>
                    </div>
                </div>
            </div>

            <!-- Besoin d'aide -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm font-semibold text-gray-900 mb-3">Besoin d'aide?</p>
                <a href="#" class="text-primary-700 hover:text-primary-800 text-sm font-semibold block mb-2">
                    Contacter le support
                </a>
                <a href="#" class="text-primary-700 hover:text-primary-800 text-sm font-semibold block">
                    Centre d'aide
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @auth
                        <h1 class="text-2xl font-bold mb-4">Bienvenue, {{ auth()->user()->nom }} !</h1>
                        @if(auth()->user()->role === 'vendeur')
                            <p>Vous êtes connecté en tant que vendeur.</p>
                            <a href="{{ route('vendeur.dashboard') }}" class="text-green-600 hover:underline">Accéder à votre tableau de bord vendeur</a>
                        @elseif(auth()->user()->role === 'client')
                            <p>Vous êtes connecté en tant que client.</p>
                            <a href="{{ route('client.dashboard') }}" class="text-green-600 hover:underline">Accéder à votre espace client</a>
                        @elseif(auth()->user()->role === 'admin')
                            <p>Vous êtes connecté en tant qu'administrateur.</p>
                            <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:underline">Accéder à l'administration</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection

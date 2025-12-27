@extends('layouts.app')

@section('title', 'Tableau de bord Client')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Mon espace client</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Mes informations</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-gray-600">Nom :</span>
                    <span class="font-medium">{{ auth()->user()->nom }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Email :</span>
                    <span class="font-medium">{{ auth()->user()->email }}</span>
                </div>
            </div>
        </div>

        <!-- Résumé des commandes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Mes commandes</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">En cours</span>
                    <span class="font-bold">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Terminées</span>
                    <span class="font-bold">0</span>
                </div>
            </div>
            <a href="#" class="mt-4 block text-center bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition">
                Voir toutes mes commandes
            </a>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
            <div class="space-y-3">
                <a href="#" class="block text-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                    Voir mon panier
                </a>
                <a href="#" class="block text-center bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition">
                    Parcourir les produits
                </a>
                <a href="#" class="block text-center bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition">
                    Gérer mon profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
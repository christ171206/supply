@extends('layouts.app')

@section('title', 'Dashboard Administrateur')

@section('content')
<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Tableau de bord — Administrateur</h1>

  <div class="bg-white shadow rounded-lg p-6">
    <p class="mb-4">Bonjour {{ Auth::user()->nom }}, bienvenue dans l'interface d'administration</p>

    <!-- Cartes statistiques -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Utilisateurs</h3>
        <p class="text-3xl font-bold text-blue-600">0</p>
        <p class="text-gray-600 mt-1">Utilisateurs inscrits</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Gérer →</a>
      </div>
      
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Vendeurs</h3>
        <p class="text-3xl font-bold text-green-600">0</p>
        <p class="text-gray-600 mt-1">Vendeurs actifs</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Gérer →</a>
      </div>
      
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Produits</h3>
        <p class="text-3xl font-bold text-purple-600">0</p>
        <p class="text-gray-600 mt-1">Produits en ligne</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Voir →</a>
      </div>

      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Commandes</h3>
        <p class="text-3xl font-bold text-yellow-600">0</p>
        <p class="text-gray-600 mt-1">Commandes du jour</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Détails →</a>
      </div>
    </div>

    <!-- Section des validations en attente -->
    <div class="mt-8">
      <h2 class="text-xl font-semibold mb-4">Validations en attente</h2>
      <div class="bg-white rounded-lg border">
        <div class="p-4 border-b">
          <h3 class="font-semibold">CNI Vendeurs à valider</h3>
          <p class="text-gray-600 mt-2">Aucune validation en attente</p>
        </div>
        <div class="p-4">
          <h3 class="font-semibold">Signalements récents</h3>
          <p class="text-gray-600 mt-2">Aucun signalement à traiter</p>
        </div>
      </div>
    </div>

    <!-- Section des actions rapides -->
    <div class="mt-8">
      <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <button class="p-3 border rounded-lg hover:bg-gray-50">
          Ajouter un utilisateur
        </button>
        <button class="p-3 border rounded-lg hover:bg-gray-50">
          Gérer les catégories
        </button>
        <button class="p-3 border rounded-lg hover:bg-gray-50">
          Voir les statistiques
        </button>
        <button class="p-3 border rounded-lg hover:bg-gray-50">
          Configuration
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard Client')

@section('content')
<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Tableau de bord — Client</h1>

  <div class="bg-white shadow rounded-lg p-6">
    <p class="mb-4">Bonjour {{ Auth::user()->nom }}, bienvenue dans votre espace client</p>

    <!-- Cartes résumé -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Mes Commandes</h3>
        <p class="text-gray-600">Suivez vos commandes en cours</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Voir les commandes →</a>
      </div>
      
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Mon Panier</h3>
        <p class="text-gray-600">Gérez votre panier d'achats</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Voir le panier →</a>
      </div>
      
      <div class="p-6 border rounded-lg bg-white shadow hover:shadow-md transition">
        <h3 class="text-lg font-semibold mb-2">Messages</h3>
        <p class="text-gray-600">Vos conversations avec les vendeurs</p>
        <a href="#" class="mt-3 inline-block text-blue-600 hover:text-blue-800">Voir les messages →</a>
      </div>
    </div>

    <!-- Section des produits favoris -->
    <div class="mt-8">
      <h2 class="text-xl font-semibold mb-4">Produits récemment consultés</h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- À remplir dynamiquement avec les produits -->
        <p class="text-gray-600 col-span-full">Aucun produit consulté récemment</p>
      </div>
    </div>
  </div>
</div>
@endsection
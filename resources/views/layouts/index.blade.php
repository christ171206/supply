@extends('layouts.app')

@section('title','Dashboard Vendeur')

@section('content')
<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Tableau de bord — Vendeur</h1>

  <div class="bg-white shadow rounded-lg p-6">
    <p>Bonjour {{ Auth::user()->nom }}, votre statut CNI :
      @php $vendeur = Auth::user()->vendeur ?? null; @endphp
      @if($vendeur && $vendeur->cni)
        <span class="text-green-600 font-semibold">CNI envoyée (en attente de validation)</span>
      @else
        <span class="text-yellow-600 font-semibold">CNI non fournie</span>
      @endif
    </p>

    <!-- Kartes résumé, liens vers produits, commandes etc -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-4 border rounded">Produits</div>
      <div class="p-4 border rounded">Commandes</div>
      <div class="p-4 border rounded">Messages</div>
    </div>
  </div>
</div>
@endsection

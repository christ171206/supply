<?php

namespace App\Policies;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProduitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'vendeur';
    }

    public function view(User $user, Produit $produit)
    {
        return $user->id === $produit->idVendeur;
    }

    public function create(User $user)
    {
        return $user->role === 'vendeur';
    }

    public function update(User $user, Produit $produit)
    {
        return $user->id === $produit->idVendeur;
    }

    public function delete(User $user, Produit $produit)
    {
        return $user->id === $produit->idVendeur;
    }
}
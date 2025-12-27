<?php

namespace App\Http\Requests\Vendeur;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Déjà géré par le middleware vendeur
    }

    public function rules()
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'idCategorie' => ['required', 'exists:categories,idCategorie'],
            'reference' => ['nullable', 'string', 'unique:produits,reference,' . ($this->produit?->idProduit ?? null) . ',idProduit'],
            'poids' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string'],
            'caracteristiques' => ['nullable', 'array'],
            'caracteristiques.*' => ['string'],
            'image' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],
            'images_supplementaires.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'prix_promo' => ['nullable', 'numeric', 'lt:prix'],
            'date_debut_promo' => ['nullable', 'required_with:prix_promo', 'date', 'after_or_equal:today'],
            'date_fin_promo' => ['nullable', 'required_with:prix_promo', 'date', 'after:date_debut_promo'],
            'seuil_alerte_stock' => ['nullable', 'integer', 'min:1'],
            'statut' => ['required', 'in:actif,inactif,archive']
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom du produit est obligatoire',
            'description.required' => 'La description est obligatoire',
            'description.min' => 'La description doit faire au moins :min caractères',
            'prix.required' => 'Le prix est obligatoire',
            'prix.min' => 'Le prix doit être positif',
            'stock.required' => 'Le stock est obligatoire',
            'stock.min' => 'Le stock ne peut pas être négatif',
            'idCategorie.required' => 'La catégorie est obligatoire',
            'idCategorie.exists' => 'Cette catégorie n\'existe pas',
            'reference.unique' => 'Cette référence est déjà utilisée',
            'image.required' => 'L\'image principale est obligatoire',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou WebP',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo',
            'prix_promo.lt' => 'Le prix promotionnel doit être inférieur au prix normal',
            'date_debut_promo.after_or_equal' => 'La date de début doit être aujourd\'hui ou après',
            'date_fin_promo.after' => 'La date de fin doit être après la date de début',
            'statut.required' => 'Le statut est obligatoire',
            'statut.in' => 'Le statut doit être actif, inactif ou archivé'
        ];
    }
}
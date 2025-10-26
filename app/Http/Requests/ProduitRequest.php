<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'vendeur';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'idCategorie' => ['required', 'exists:categories,idCategorie'],
            'reference' => ['nullable', 'string', 'unique:produits,reference'],
            'poids' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:50'],
            'caracteristiques' => ['nullable', 'array'],
            'caracteristiques.*.nom' => ['required_with:caracteristiques', 'string', 'max:50'],
            'caracteristiques.*.valeur' => ['required_with:caracteristiques', 'string', 'max:255'],
        ];

        // Ajouter la validation de l'image uniquement lors de la création
        if ($this->isMethod('POST')) {
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        } else {
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
            // Exclure le produit actuel de la validation d'unicité de la référence
            $rules['reference'] = ['nullable', 'string', 'unique:produits,reference,' . $this->route('produit')->idProduit . ',idProduit'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du produit est requis',
            'nom.max' => 'Le nom du produit ne doit pas dépasser :max caractères',
            'description.required' => 'La description du produit est requise',
            'prix.required' => 'Le prix du produit est requis',
            'prix.numeric' => 'Le prix doit être un nombre',
            'prix.min' => 'Le prix doit être supérieur ou égal à :min',
            'stock.required' => 'Le stock est requis',
            'stock.integer' => 'Le stock doit être un nombre entier',
            'stock.min' => 'Le stock ne peut pas être négatif',
            'idCategorie.required' => 'La catégorie est requise',
            'idCategorie.exists' => 'La catégorie sélectionnée n\'existe pas',
            'reference.unique' => 'Cette référence est déjà utilisée',
            'poids.numeric' => 'Le poids doit être un nombre',
            'poids.min' => 'Le poids doit être supérieur ou égal à :min',
            'dimensions.max' => 'Les dimensions ne doivent pas dépasser :max caractères',
            'image.required' => 'L\'image du produit est requise',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être de type : :values',
            'image.max' => 'L\'image ne doit pas dépasser :max kilo-octets',
            'caracteristiques.*.nom.required_with' => 'Le nom de la caractéristique est requis',
            'caracteristiques.*.nom.max' => 'Le nom de la caractéristique ne doit pas dépasser :max caractères',
            'caracteristiques.*.valeur.required_with' => 'La valeur de la caractéristique est requise',
            'caracteristiques.*.valeur.max' => 'La valeur de la caractéristique ne doit pas dépasser :max caractères',
        ];
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nom' => 'Électronique',
            ],
            [
                'nom' => 'Mode',
            ],
            [
                'nom' => 'Maison & Décoration',
            ],
            [
                'nom' => 'Sports & Loisirs',
            ],
            [
                'nom' => 'Santé & Beauté',
            ],
            [
                'nom' => 'Alimentation',
            ],
            [
                'nom' => 'Livres & Médias',
            ],
            [
                'nom' => 'Auto & Moto',
            ],
            [
                'nom' => 'Jardin & Bricolage',
            ],
            [
                'nom' => 'Jouets & Enfants',
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }
    }
}
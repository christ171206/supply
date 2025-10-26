<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';
    protected $primaryKey = 'idProduit';

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'stock',
        'idCategorie',
        'vendeur_id',
        'image',
        'reference',
        'slug',
        'statut',
        'seuil_alerte_stock',
        'prix_promo',
        'date_debut_promo',
        'date_fin_promo',
        'dimensions',
        'poids',
        'meta_title',
        'meta_description',
        'caracteristiques',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_promo' => 'decimal:2',
        'poids' => 'decimal:2',
        'caracteristiques' => 'array',
        'dateAjout' => 'datetime',
        'date_debut_promo' => 'datetime',
        'date_fin_promo' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Générer le slug avant la sauvegarde
        static::creating(function ($produit) {
            if (empty($produit->slug)) {
                // Génère un slug de base à partir du nom
                $baseSlug = Str::slug($produit->nom);
                
                // Vérifie si le slug existe déjà
                $counter = 1;
                $slug = $baseSlug;
                
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $produit->slug = $slug;
            }
            
            if (empty($produit->reference)) {
                $produit->reference = 'PROD-' . Str::random(8);
            }
        });
    }

    // Activity Log options temporairement désactivées

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'idCategorie');
    }

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'idProduit');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'idProduit');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'idProduit');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class, 'idProduit', 'idProduit');
    }

    public function images()
    {
        return $this->hasMany(ProduitImage::class);
    }

    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class);
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeEnPromotion($query)
    {
        $now = now();
        return $query->where('prix_promo', '>', 0)
                    ->where('date_debut_promo', '<=', $now)
                    ->where('date_fin_promo', '>=', $now);
    }

    public function scopeEnRupture($query)
    {
        return $query->where('stock', 0);
    }

    public function scopeStockFaible($query)
    {
        return $query->where('stock', '>', 0)
                    ->where('stock', '<=', DB::raw('COALESCE(seuil_alerte_stock, 5)'));
    }

    // Accesseurs et mutateurs
    public function getPrixActuelAttribute()
    {
        if ($this->enPromotion()) {
            return $this->prix_promo;
        }
        return $this->prix;
    }

    public function getReductionPourcentageAttribute()
    {
        if ($this->prix_promo && $this->prix > 0) {
            return round((1 - ($this->prix_promo / $this->prix)) * 100);
        }
        return 0;
    }

    // Méthodes
    public function enPromotion()
    {
        $now = now();
        return $this->prix_promo
            && $this->date_debut_promo
            && $this->date_fin_promo
            && $now->between($this->date_debut_promo, $this->date_fin_promo);
    }

    public function estEnRupture()
    {
        return $this->stock === 0;
    }

    public function aStockFaible()
    {
        return $this->stock > 0 && $this->stock <= ($this->seuil_alerte_stock ?? 5);
    }
}

# 🌐 URLs d'Accès - Dashboard Vendeur Moderne

## 📍 Points d'Entrée du Dashboard

### Principal
```
http://localhost/supply-master/public/vendeur/dashboard
```
**Nom de la route**: `vendeur.dashboard`
**Middleware**: `web`, `auth`, `IsVendeur`

---

## 📌 Toutes les URLs Vendeur

### Dashboard & Statistiques
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Dashboard | `/vendeur/dashboard` | `vendeur.dashboard` | Page d'accueil avec KPIs |
| Statistiques | `/vendeur/stats` | `vendeur.stats` | API statistiques JSON |
| Graphiques | `/vendeur/chart-data` | `vendeur.chart-data` | Données Chart.js |

### Produits
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Liste | `/vendeur/produits` | `vendeur.produits` | Tous les produits |
| Créer | `/vendeur/produits/create` | `vendeur.produits.create` | Formulaire création |
| Voir | `/vendeur/produits/{id}` | `vendeur.produits.show` | Détails produit |
| Éditer | `/vendeur/produits/{id}/edit` | `vendeur.produits.edit` | Modification |

### Stock
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Gestion | `/vendeur/stock` | `vendeur.stock` | Inventaire complet |
| Ajustement | `/vendeur/stock/ajuster` | `vendeur.stock.ajuster` | Modif quantités |
| Historique | `/vendeur/stock/historique` | `vendeur.stock.historique` | Mouvements |
| Export | `/vendeur/stock/export` | `vendeur.stock.export` | Téléchargement |

### Fournisseurs
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Liste | `/vendeur/fournisseurs` | `vendeur.fournisseurs` | Tous fournisseurs |
| Créer | `/vendeur/fournisseurs/create` | `vendeur.fournisseurs.create` | Ajouter fournisseur |
| Voir | `/vendeur/fournisseurs/{id}` | `vendeur.fournisseurs.show` | Détails |
| Éditer | `/vendeur/fournisseurs/{id}/edit` | `vendeur.fournisseurs.edit` | Modification |

### Commandes
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Liste | `/vendeur/commandes` | `vendeur.commandes` | Toutes commandes |
| Détails | `/vendeur/commandes/{id}` | `vendeur.commandes.show` | Vue détaillée |
| Statut | `/vendeur/commandes/{id}/status` | `vendeur.commandes.update-status` | Maj statut |
| Facture | `/vendeur/commandes/{id}/facture` | `vendeur.commandes.facture` | Générer facture |

### Paiements
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Paiements | `/vendeur/paiements` | `vendeur.paiements` | Suivi paiements |
| Export | `/vendeur/paiements/export` | `vendeur.paiements.export` | Télécharger |

### Messagerie
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Messagerie | `/vendeur/messagerie` | `vendeur.messagerie` | Interface chat |
| Envoyer | `/vendeur/messagerie/envoyer` | `vendeur.messagerie.send` | POST message |
| Upload | `/vendeur/messagerie/upload` | `vendeur.messagerie.upload` | Fichiers |
| Marquer lu | `/vendeur/messagerie/lu` | `vendeur.messagerie.mark-read` | Lire msg |
| Résoudre | `/vendeur/messagerie/resoudre` | `vendeur.messagerie.resolve` | Fermer conv |
| Bloquer | `/vendeur/messagerie/bloquer` | `vendeur.messagerie.block` | Bloquer client |
| Non-lu | `/vendeur/messagerie/non-lu` | `vendeur.messagerie.unread-count` | Compteur |

### Rapports
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Rapports | `/vendeur/rapports` | `vendeur.rapports` | Analytics |
| Ventes | `/vendeur/rapports/ventes` | `vendeur.rapports.ventes` | Rapport ventes |
| Produits | `/vendeur/rapports/produits` | `vendeur.rapports.produits` | Perfs produits |
| Export | `/vendeur/rapports/export` | `vendeur.rapports.export` | Télécharger |

### Profil & Paramètres
| Page | URL | Route | Description |
|------|-----|-------|-------------|
| Profil | `/vendeur/profile` | `vendeur.profil` | Infos vendeur |
| Paramètres | `/vendeur/parametres` | `vendeur.parametres` | Configuration |
| Logo | `/vendeur/parametres/boutique/logo` | `vendeur.parametres.logo` | Changer logo |

---

## 🔐 Authentification Requise

Toutes les routes vendeur nécessitent:
- ✅ Connexion utilisateur (`auth`)
- ✅ Rôle vendeur (`IsVendeur` middleware)
- ✅ Session active

---

## 📱 Liens de Navigation Intégrés

### Depuis le Dashboard
```blade
<!-- Navigation Rapide -->
<a href="{{ route('vendeur.produits.create') }}">Ajouter produit</a>
<a href="{{ route('vendeur.commandes') }}">Voir commandes</a>
<a href="{{ route('vendeur.stock') }}">Gestion stock</a>
<a href="{{ route('vendeur.rapports') }}">Rapports</a>
<a href="{{ route('vendeur.paiements') }}">Paiements</a>
<a href="{{ route('vendeur.messagerie') }}">Messagerie</a>
<a href="{{ route('vendeur.fournisseurs') }}">Fournisseurs</a>
<a href="{{ route('vendeur.parametres') }}">Paramètres</a>
```

---

## 🔗 Appels API JSON

### Récupérer les statistiques
```bash
GET /vendeur/stats
Authorization: Bearer {token}

Retourne:
{
    "chiffre_affaires": 1000000,
    "total_commandes": 45,
    "total_produits": 120,
    "produits_rupture": 5
}
```

### Récupérer les données du graphique
```bash
GET /vendeur/chart-data
Authorization: Bearer {token}

Retourne:
{
    "labels": ["Lun", "Mar", "Mer", ...],
    "data": [15000, 20000, 18000, ...]
}
```

---

## 🧪 Test des Routes

### Avec Artisan Tinker
```php
php artisan tinker

# Test de route
route('vendeur.dashboard')
// Résultat: /vendeur/dashboard

# Test avec paramètre
route('vendeur.produits.show', ['produit' => 1])
// Résultat: /vendeur/produits/1
```

### Avec cURL
```bash
curl -H "Authorization: Bearer {token}" \
     http://localhost/supply-master/public/vendeur/dashboard
```

---

## 📊 Codes de Réponse HTTP

| Code | Signification | Exemple |
|------|---------------|---------|
| 200 | OK - Page chargée | Dashboard affichée |
| 301 | Redirection | Vers login si non auth |
| 403 | Forbidden - Non vendeur | Accès refusé |
| 404 | Not Found | Produit inexistant |
| 500 | Server Error | Erreur application |

---

## 🎯 Points d'Entrée Recommandés

### Pour Tester
1. **Commencer par**: `http://localhost/supply-master/public/vendeur/dashboard`
2. **Ensuite**: Cliquer sur les boutons de navigation
3. **Ou directement**: `/vendeur/[page]`

### Pour Intégrer
```php
// Dans un contrôleur
redirect()->route('vendeur.dashboard');

// Dans une vue
href="{{ route('vendeur.produits') }}"

// Avec paramètres
route('vendeur.produits.show', ['produit' => $id])
```

---

## ⚙️ Configuration des Routes

### Fichier: `routes/web.php`
```php
Route::group(['middleware' => ['web', 'auth', \App\Http\Middleware\IsVendeur::class]], function() {
    Route::prefix('vendeur')->group(function() {
        // Toutes les routes vendeur ici
    });
});
```

### Middleware IsVendeur
Vérifie que l'utilisateur:
- Est authentifié
- Possède le rôle `vendeur`
- N'est pas banni

---

## 🔐 Sécurité des Routes

### CSRF Protection
Toutes les routes POST/PUT/DELETE sont protégées par:
```blade
{{ csrf_field() }}
<!-- Ou -->
@csrf
```

### Authorization
À implémenter dans les contrôleurs:
```php
$this->authorize('update', $produit);
```

---

## 📞 Guide Rapide d'Accès

| Besoin | URL |
|--------|-----|
| Voir dashboard | `/vendeur/dashboard` |
| Gérer produits | `/vendeur/produits` |
| Voir commandes | `/vendeur/commandes` |
| Gérer stock | `/vendeur/stock` |
| Voir rapports | `/vendeur/rapports` |
| Paiements | `/vendeur/paiements` |
| Messagerie | `/vendeur/messagerie` |
| Fournisseurs | `/vendeur/fournisseurs` |
| Paramètres | `/vendeur/parametres` |

---

**Base URL**: `http://localhost/supply-master/public`
**Version**: 2.0 Modern
**Dernière mise à jour**: 2025

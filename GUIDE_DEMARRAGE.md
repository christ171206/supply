# 🚀 Guide de Démarrage - Dashboard Client

## ⚡ Démarrage Rapide

### 1️⃣ Installation & Configuration (30 minutes)

```bash
# Aller au répertoire du projet
cd d:\wamp\www\supply-master

# Installer les dépendances (si nécessaire)
composer install
npm install

# Copier le .env et générer la clé
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=supply
DB_USERNAME=root
DB_PASSWORD=

# Exécuter les migrations
php artisan migrate

# Remplir les données de test (optionnel)
php artisan db:seed
```

### 2️⃣ Démarrer le Serveur (5 minutes)

```bash
# Terminal 1: Serveur Laravel
php artisan serve
# Accès: http://localhost:8000

# Terminal 2: Build Vite (optionnel)
npm run dev
```

### 3️⃣ Se Connecter & Tester (10 minutes)

```
URL: http://localhost:8000/login

Compte Test Client:
Email: client@test.com
Password: password

Ou créer un compte:
http://localhost:8000/register
```

---

## 📂 Structure du Projet

```
supply-master/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── ClientDashboardController.php    ⭐ MAIN
│   │   ├── Middleware/
│   │   │   └── ... (auth middleware)
│   │   └── Requests/
│   │
│   └── Models/
│       ├── User.php
│       ├── Commande.php
│       ├── LigneCommande.php
│       ├── PanierItem.php
│       └── ...
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── client.blade.php               ⭐ MAIN
│       ├── client/
│       │   ├── dashboard.blade.php
│       │   ├── commandes.blade.php
│       │   ├── commande-detail.blade.php
│       │   ├── profil.blade.php
│       │   └── panier.blade.php
│       └── auth/
│           ├── login.blade.php
│           └── register.blade.php
│
├── routes/
│   └── web.php                               ⭐ ROUTES
│
├── database/
│   ├── migrations/
│   │   └── ... (all migrations)
│   └── seeders/
│       └── ... (seeders)
│
└── Documentation/
    ├── SESSION_RESUME_COMPLET.md
    ├── DASHBOARD_CLIENT_MODERNISÉ.md
    ├── GUIDE_TEST_DASHBOARD_CLIENT.md
    └── ARCHITECTURE_DASHBOARD_CLIENT.md
```

---

## 🎯 Flux d'Utilisation Principal

### Pour un Client

```
1. Accueil (Public)
   ↓
2. Se connecter
   ↓
3. Redirect Dashboard Client (/client/dashboard)
   ↓
4. Voir aperçu (stats + commandes récentes)
   ↓
5. Cliquer "Mes commandes" → /client/commandes
   ↓
6. Filtrer/Rechercher → Cliquer "Voir"
   ↓
7. Voir détail commande avec suivi
   ↓
8. Cliquer "Profil & Sécurité" → /client/profil
   ↓
9. Modifier infos ou mot de passe
   ↓
10. Se déconnecter
```

---

## 🧪 Tests Manuels Essentiels

### Quick Test (5 minutes)
```
□ Se connecter
□ Voir dashboard
□ Cliquer "Mes commandes"
□ Voir liste commandes
□ Cliquer une commande
□ Voir détail avec suivi
□ Cliquer "Profil"
□ Se déconnecter
```

### Full Test (30 minutes)
Voir: `GUIDE_TEST_DASHBOARD_CLIENT.md`

---

## ⚙️ Configuration Importante

### .env
```env
APP_NAME=Supply
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=supply
DB_USERNAME=root
DB_PASSWORD=

MAIL_DRIVER=log
```

### config/app.php
```php
'locale' => 'fr',
'timezone' => 'UTC',
```

---

## 🔑 Routes Principales

```
GET  /                         → Welcome (public)
GET  /login                    → Login form
POST /login                    → Login process
GET  /register                 → Register form
POST /register                 → Register process

GET  /client/dashboard         → Dashboard
GET  /client/commandes         → Commandes list
GET  /client/commandes/{id}    → Commande detail
GET  /client/panier            → Panier
GET  /client/profil            → Profil
PUT  /client/profil            → Update profil
PUT  /client/password          → Update password
DELETE /client/account         → Delete account
```

---

## 📊 Modèles de Données

### User
```php
id, nom, email, password, role, telephone, entreprise, adresse
```

### Commande
```php
idCommande, idClient, idVendeur, dateCommande, total, statut, moyenPaiement, adresseLivraison
```

### LigneCommande
```php
idLigneCommande, idCommande, idProduit, quantite, prixUnitaire
```

---

## 🐛 Dépannage Rapide

### Erreur 404
```bash
# Vérifier les routes
php artisan route:list | grep client

# Rafraîchir la cache
php artisan route:clear
```

### Erreur 500
```bash
# Vérifier les logs
tail -f storage/logs/laravel.log

# Vérifier la syntaxe PHP
php -l app/Http/Controllers/ClientDashboardController.php
```

### Css/JS non chargés
```bash
# Compiler assets
npm run dev
# ou
npm run build
```

### Problème DB
```bash
# Vérifier les migrations
php artisan migrate:status

# Rollback si erreur
php artisan migrate:rollback

# Re-migrer
php artisan migrate
```

---

## 🔒 Sécurité

### Vérifications
- [x] Authentification requise
- [x] Authorization vérifiée
- [x] CSRF protection
- [x] Input validation
- [x] Password hashing

### À faire
- [ ] Tests de sécurité
- [ ] Pen testing
- [ ] Audit code
- [ ] Validation d'accessibilité

---

## 📈 Performance

### Optimisations appliquées
- ✅ Eager loading (with)
- ✅ Pagination (10 items)
- ✅ Indexes DB
- ✅ CSS/JS minifiés (build)

### À améliorer
- ❌ Caching (Redis)
- ❌ CDN pour images
- ❌ Compression gzip
- ❌ Lazy loading images

---

## 🎓 Ressources Utiles

### Documentation
- Laravel: https://laravel.com/docs
- Tailwind: https://tailwindcss.com/docs
- Blade: https://laravel.com/docs/blade
- Eloquent: https://laravel.com/docs/eloquent

### Fichiers du Projet
- Architecture: `ARCHITECTURE_DASHBOARD_CLIENT.md`
- Tests: `GUIDE_TEST_DASHBOARD_CLIENT.md`
- Résumé: `DASHBOARD_CLIENT_RESUME.md`
- Complet: `SESSION_RESUME_COMPLET.md`

---

## ✅ Checklist Avant Production

```
□ Tester sur tous les navigateurs
□ Tester sur mobile
□ Vérifier la sécurité
□ Optimiser les requêtes
□ Compresser les images
□ Minifier CSS/JS
□ Mettre en cache
□ Vérifier les logs
□ Documenter les déploiements
□ Créer les backups
□ Mettre en monitoring
```

---

## 🚀 Commandes Utiles

```bash
# Serveur
php artisan serve

# Migrations
php artisan migrate
php artisan migrate:rollback
php artisan make:migration create_table_name

# Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Routes
php artisan route:list

# Models
php artisan make:model ModelName -m

# Controllers
php artisan make:controller ControllerName

# Tests
php artisan test
php artisan test --filter=MethodName

# Seed
php artisan db:seed
php artisan make:seeder SeederName
```

---

## 📞 Support

### En cas de problème

1. **Vérifier les logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Lancer php artisan tinker**
   ```bash
   php artisan tinker
   >>> User::first();
   ```

3. **Tester les routes**
   ```bash
   php artisan route:list
   ```

4. **Consulter la doc**
   - Architecture: `ARCHITECTURE_DASHBOARD_CLIENT.md`
   - Tests: `GUIDE_TEST_DASHBOARD_CLIENT.md`

---

## 🎉 Vous êtes Prêt!

Votre dashboard client est maintenant **installé et opérationnel**. 

Suivez les étapes de démarrage ci-dessus et testez avec le guide fourni.

**Bonne chance!** 🚀


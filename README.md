# 🧾 Supply - Plateforme E-commerce B2B/B2C

> Plateforme de commerce électronique multivendeurs avec gestion avancée des stocks et des commandes  
> Projet tutoré – Université de Technologie et de Télécommunication de Loko (UTT Loko)  
> Réalisé par une équipe d'étudiants de Licence 2 en Informatique

[![Laravel](https://img.shields.io/badge/Laravel-11.0-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0-38b2ac.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---
## 👥 Équipe de Développement

| Nom | Rôle | Responsabilités principales |
|------|------|-----------------------------|
| **Koffi Mougoh Christ** | Chef de groupe & Développeur Full Stack | Coordination, développement backend et frontend |
| **Kodjo Loïc** | Développeur Frontend | Intégration Tailwind CSS, Blade, ergonomie et interface |
| **Konkobo Christ** | Responsable Base de Données & Backend | Conception MySQL, migrations, logique métier |

---
s
## 🎯 Objectif du Projet

Développer une **plateforme e-commerce complète** permettant de :

### 🏪 Côté Vendeur
- Gérer son catalogue de produits
- Suivre les commandes et les stocks
- Gérer les promotions et réservations
- Analyser les performances via un tableau de bord
- Communiquer avec les clients

### 🛒 Côté Client
- Parcourir les produits par catégories
- Gérer son panier d'achats
- Passer et suivre ses commandes
- Communiquer avec les vendeurs
- Recevoir des notifications

### 💼 Fonctionnalités Principales
- Authentification multi-rôles (client/vendeur)
- Gestion avancée des stocks
- Système de messagerie intégré
- Paiements sécurisés
- Notifications en temps réel
- Tableau de bord analytique

---

## 🧰 Stack Technique

### 🔧 Backend
- **Framework:** Laravel 11.x
- **Langage:** PHP 8.2+
- **Base de données:** MySQL 8.0
- **Cache:** Redis
- **API:** RESTful + JSON

### 🎨 Frontend
- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS 3.0
- **JavaScript:** Vanilla JS + AlpineJS
- **Build Tool:** Vite

### 🛠️ DevOps & Outils
- **Environnement:** WAMP / XAMPP
- **Versionning:** Git + GitHub
- **Éditeur:** VS Code + Extensions
- **Testing:** PHPUnit
- **Logging:** Laravel Activity Log

---

## ⚙️ Installation du Projet (Guide pour les membres du groupe)

### 1️⃣ Prérequis

#### Logiciels Requis
- **Git** → [https://git-scm.com/downloads](https://git-scm.com/downloads)  
- **Composer** → [https://getcomposer.org/download/](https://getcomposer.org/download/)  
- **Node.js (LTS)** → [https://nodejs.org/en/download](https://nodejs.org/en/download)  
- **XAMPP** → [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
- **VS Code** → [https://code.visualstudio.com/](https://code.visualstudio.com/)

#### Extensions VS Code Recommandées
- PHP Intelephense
- Laravel Blade Snippets
- Laravel Snippets
- Tailwind CSS IntelliSense
- Alpine.js IntelliSense
- DotENV

#### Versions Requises
- PHP ≥ 8.2
- MySQL ≥ 8.0
- Composer ≥ 2.4
- Node.js ≥ 18.0

---

### 2️⃣ Cloner le dépôt GitHub

```bash

git clone https://github.com/christ171206/supply.git

```

---

### 3️⃣ Installer les dépendances

**a. Dépendances PHP (Laravel)**  
```bash
# Installation des dépendances de base
composer install

# Installation des packages additionnels requis
composer require spatie/laravel-activitylog
composer require spatie/laravel-permission
composer require intervention/image
```

**b. Dépendances Node.js (Tailwind & Vite)**  
```bash
# Installation des dépendances frontend
npm install

# Installation des packages additionnels
npm install alpinejs @alpinejs/persist
npm install chart.js
```

---

### 4️⃣ Configurer l’environnement

Créer le fichier `.env` à partir de l’exemple :
```
copy .env.example .env
```

Configurer la base de données dans `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=supply
DB_USERNAME=root
DB_PASSWORD=
```

Créer la base dans **phpMyAdmin** :
```sql
CREATE DATABASE supply;
```

---

### 5️⃣ Générer la clé d’application

```bash
php artisan key:generate
```

---

### 6️⃣ Préparer la base de données

```bash
# Exécuter les migrations
php artisan migrate

# Créer les rôles et permissions
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder

# Créer les données de test (optionnel)
php artisan db:seed --class=TestDataSeeder
```

### 7️⃣ Configuration du stockage

```bash
# Créer le lien symbolique pour le stockage
php artisan storage:link

# Créer les dossiers nécessaires
mkdir -p storage/app/public/products
mkdir -p storage/app/public/profiles
chmod -R 775 storage/

---

### 7️⃣ Lancer le projet

Dans **deux terminaux séparés** :

**Terminal 1 :** (serveur Laravel)
```bash
php artisan serve
```

**Terminal 2 :** (compilation Tailwind)
```bash
npm run dev
```

Ouvrez ensuite [http://127.0.0.1:8000](http://127.0.0.1:8000) dans le navigateur 🎉

---


## 📁 Architecture du Projet

```bash
supply/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # Logique métier
│   │   ├── Middleware/          # Filtres de requêtes
│   │   └── Requests/           # Validation des formulaires
│   ├── Models/                 # Modèles Eloquent
│   └── Providers/             # Services providers
├── database/
│   ├── migrations/            # Structure de la BDD
│   ├── factories/            # Données de test
│   └── seeders/             # Données initiales
├── resources/
│   ├── views/
│   │   ├── layouts/         # Templates de base
│   │   ├── components/      # Composants réutilisables
│   │   ├── vendeur/        # Interface vendeur
│   │   └── client/         # Interface client
│   ├── css/                # Styles Tailwind
│   └── js/                 # Scripts frontend
├── routes/
│   ├── web.php            # Routes web
│   └── auth.php           # Routes authentification
├── config/               # Configuration
├── storage/             # Uploads et logs
├── tests/              # Tests automatisés
└── vendor/            # Dépendances
```

### 📂 Points Clés
- Architecture MVC
- Séparation claire client/vendeur
- Composants réutilisables
- Tests automatisés
- Documentation intégrée
```

---

## 🧠 Astuce

Si Tailwind ne compile pas correctement, exécute :
```bash
npm run build
```
ou supprime le dossier `node_modules` puis refais :
```bash
npm install
```

---

## 💬 Remarques finales

> Ce guide est destiné aux membres du groupe afin d’assurer une installation identique sur toutes les machines.  
> Toute modification majeure doit être communiquée sur le groupe et validée avant d’être fusionnée sur `main`.

---

🧑‍💻 **Auteur principal :** [Koffi Mougoh Christ](https://github.com/<ton-utilisateur>)  
📅 **Dernière mise à jour :** Octobre 2025  
📦 **Projet : Supply — Application de gestion de stocks et commandes**

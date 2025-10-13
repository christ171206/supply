# 🧾 Application Web de Gestion de Stocks et de Commandes

> Projet tutoré – Université de Technologie et de Télécommunication de Loko (UTT Loko)  
> Réalisé par une équipe d’étudiants de Licence 2 en Informatique  

---

## 👥 Équipe de Développement

| Nom | Rôle | Responsabilités principales |
|------|------|-----------------------------|
| **Koffi Mougoh Christ** | Chef de groupe & Développeur Full Stack | Coordination, développement backend et frontend |
| **Kodjo Loïc** | Développeur Frontend | Intégration Tailwind CSS, Blade, ergonomie et interface |
| **Koné Zakaria** | Responsable Base de Données & Backend | Conception MySQL, migrations, logique métier |

---

## 🎯 Objectif du Projet

Créer une **application web complète** permettant à un vendeur de gérer ses produits, commandes et clients, et à ces derniers de :
- consulter les produits,
- passer commande,
- suivre leurs achats,
- communiquer avec le vendeur via une messagerie intégrée.

---

## 🧰 Technologies utilisées

| Domaine | Outil / Technologie |
|----------|---------------------|
| Langage backend | PHP 8+ |
| Framework backend | Laravel 11 |
| Base de données | MySQL |
| Frontend | Blade + Tailwind CSS |
| Environnement local | XAMPP / Laragon |
| Gestion de versions | Git & GitHub |
| Éditeur recommandé | VS Code |

---

## ⚙️ Installation du Projet (Guide pour les membres du groupe)

### 1️⃣ Prérequis

Avant de commencer, installez :
- **Git** → [https://git-scm.com/downloads](https://git-scm.com/downloads)  
- **Composer** → [https://getcomposer.org/download/](https://getcomposer.org/download/)  
- **Node.js (LTS)** → [https://nodejs.org/en/download](https://nodejs.org/en/download)  
- **XAMPP ou Laragon** → (pour Apache + MySQL)  
- **VS Code** → [https://code.visualstudio.com/](https://code.visualstudio.com/)

---

### 2️⃣ Cloner le dépôt GitHub

```bash

git clone https://github.com/christ171206/supply.git

```

---

### 3️⃣ Installer les dépendances

**a. Dépendances PHP (Laravel)**  
```bash
composer install
```

**b. Dépendances Node.js (Tailwind & Vite)**  
```bash
npm install
```

---

### 4️⃣ Configurer l’environnement

Créer le fichier `.env` à partir de l’exemple :
```bash
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

### 6️⃣ Exécuter les migrations

```bash
php artisan migrate
```

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


## 📁 Structure du projet

```
supply/
├─ app/
│  ├─ Http/
│  └─ Models/
├─ database/
│  ├─ migrations/
│  └─ seeders/
├─ public/
├─ resources/
│  ├─ css/
│  │  └─ app.css
│  ├─ js/
│  ├─ views/
│  │  ├─ layouts/
│  │  ├─ vendeur/
│  │  └─ client/
├─ routes/
│  └─ web.php
├─ tailwind.config.js
├─ postcss.config.js
└─ .env
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

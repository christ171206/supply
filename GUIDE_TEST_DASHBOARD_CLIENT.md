# 🧪 Guide de Test - Dashboard Client

## 🔐 Connexion Initiale

### Prérequis
1. MySQL en cours d'exécution
2. Laravel artisan server en cours d'exécution
3. Base de données migrée
4. Utilisateurs test créés

### Se connecter
```
URL: http://localhost:8000/login
Email: client@test.com
Password: password
```

## 📊 Test du Dashboard (`/client/dashboard`)

### ✅ Éléments à Vérifier

#### 1. Sidebar Navigation
- [ ] Sidebar visible à gauche (w-64)
- [ ] Logo "Supply" avec icône S bleue
- [ ] Onglets: Dashboard, Commandes, Panier, Favoris, Notifications
- [ ] Section Profil & Sécurité visible
- [ ] Lien Déconnexion en rouge
- [ ] État actif du lien "Dashboard" (bleu)

#### 2. En-tête
- [ ] Salutation: "Bienvenue, [nom]! 👋"
- [ ] Sous-titre: "Retrouvez rapidement vos commandes et vos achats"

#### 3. Cartes de Résumé (4 colonnes)
- [ ] Carte 1: "Commandes totales" avec icône bleue (nombre correct)
- [ ] Carte 2: "En cours" avec icône ambre (nombre correct)
- [ ] Carte 3: "Total dépensé" avec icône verte (montant en F)
- [ ] Carte 4: "Favoris" avec icône rouge (0 si vide)

#### 4. Actions Rapides (2 CTA)
- [ ] Gradient bleu à gauche "Continuer le shopping"
- [ ] Gradient émeraude à droite "Mon panier"
- [ ] Hover effects (ombre augmente, texte se décale)
- [ ] Liens fonctionnels vers catalogue/panier

#### 5. Tableau Commandes Récentes
- [ ] Titre: "Vos commandes récentes"
- [ ] Lien "Voir toutes" en haut à droite
- [ ] Colonnes: N° Commande, Date, Statut, Montant, Action
- [ ] Rows avec hover effect gris
- [ ] Statuts avec badges colorés
- [ ] Liens "Voir →" cliquables

#### 6. État Vide (si aucune commande)
- [ ] Icône grande (16x16 gris)
- [ ] Titre: "Aucune commande"
- [ ] Message d'explication
- [ ] CTA "Commencer vos achats"

## 📋 Test Mes Commandes (`/client/commandes`)

### ✅ Éléments à Vérifier

#### 1. Filtres et Recherche
- [ ] Input recherche: "N° de commande ou produit..."
- [ ] Select statut avec 5 options
- [ ] Bouton "Filtrer" bleu
- [ ] Bouton "Réinitialiser" gris
- [ ] La recherche fonctionne (test: chercher N° commande)
- [ ] Les filtres fonctionnent (test: sélectionner "En cours")

#### 2. Cartes Statistiques (4)
- [ ] Commandes totales | En attente | En cours | Livrées
- [ ] Nombres affichés correctement
- [ ] Couleurs: gris, ambre, bleu, vert

#### 3. Tableau Commandes
- [ ] Headers: N°, Date, Vendeur, Articles, Montant, Statut, Action
- [ ] Données correctes (nombre articles, montants, dates)
- [ ] Badges statut avec couleurs:
  - [ ] 🟡 Jaune - En attente
  - [ ] 🔵 Bleu avec pulse - En cours
  - [ ] 🟣 Violet - Expédiée
  - [ ] 🟢 Vert - Livrée
  - [ ] 🔴 Rouge - Annulée

#### 4. Pagination
- [ ] Liens pagination en bas (si > 10 commandes)
- [ ] "1 2 3 ... Suivant" cliquables
- [ ] Navigation fonctionne

#### 5. État Vide
- [ ] Affiche si pas de commandes
- [ ] CTA "Réinitialiser" et "Commencer vos achats"

## 🔍 Test Détail Commande (`/client/commandes/{id}`)

### ✅ Éléments à Vérifier

#### 1. En-tête
- [ ] Lien retour "← Retour au tableau de bord"
- [ ] Titre: "Commande #123"
- [ ] Date/heure de commande

#### 2. Barre de Progression
- [ ] 4 étapes visibles: 1️⃣ Commandée, 2️⃣ Préparation, 3️⃣ Expédiée, 4️⃣ Livrée
- [ ] Ligne de progression blanche (background) avec barre bleue
- [ ] Étapes complétées: numéro → ✓ (checkmark)
- [ ] Étapes restantes: numéro normal
- [ ] Progress % correct selon statut:
  - [ ] En attente: 25%
  - [ ] En cours: 50%
  - [ ] Expédiée: 75%
  - [ ] Livrée: 100% (vert)

#### 3. Statut Actuel
- [ ] Box bleue clair (bg-blue-50)
- [ ] Indicateur point (couleur selon statut)
- [ ] Texte statut correct
- [ ] Pulse animation si "en cours"

#### 4. Articles Commandés
- [ ] Titre: "Articles commandés"
- [ ] Image produit (ou placeholder gris)
- [ ] Nom produit, quantité, prix unitaire
- [ ] Prix total par article
- [ ] Tous les articles listés

#### 5. Sidebar Résumé (Sticky)
- [ ] Sticky: suit le scroll
- [ ] Sous-total correcte
- [ ] Livraison: "Gratuite"
- [ ] Total en bleu gros
- [ ] Box grise: adresse de livraison
- [ ] Box grise: infos vendeur + moyen paiement
- [ ] Boutons: "Contacter le vendeur", "Retour"

## 👤 Test Profil & Sécurité (`/client/profil`)

### ✅ Éléments à Vérifier

#### 1. Informations Profil
- [ ] Inputs: Nom, Email, Téléphone, Entreprise, Adresse
- [ ] Valeurs pré-remplies correctement
- [ ] Boutons: "Annuler", "Enregistrer les modifications"
- [ ] Valider le formulaire (essayer email dupliqué)
- [ ] Sauvegarder et vérifier redirection + message de succès

#### 2. Sécurité - Mot de Passe
- [ ] Inputs: Mot de passe actuel, Nouveau, Confirmation
- [ ] Placeholder correct
- [ ] Texte d'aide: "min 8 char, majuscule, minuscule, chiffre"
- [ ] Tester avec mauvais mot de passe actuel
- [ ] Tester avec mots de passe qui ne match pas
- [ ] Tester avec mot de passe trop faible
- [ ] Sauvegarder avec bon mot de passe
- [ ] Se reconnecter avec nouveau mot de passe

#### 3. Sessions Actives
- [ ] Titre: "Sessions actives"
- [ ] Box grise avec "Navigateur actuel"
- [ ] Indicateur vert "Actif"
- [ ] Message de conseil: déconnexion sur autres appareils

#### 4. Zone Danger
- [ ] Fond rouge pâle (red-50)
- [ ] Titre en rouge sombre
- [ ] Message avertissement
- [ ] Bouton rouge "Supprimer mon compte"
- [ ] Confirmation avant suppression
- [ ] Après suppression: redirection vers home + message

#### 5. Sidebar Conseils
- [ ] 3 conseils affichés (fort, email, déconnexion)
- [ ] Check marks (✅) visibles
- [ ] Liens: Contacter support, Centre d'aide

## 🛒 Test Panier (du sprint précédent)

### ✅ Éléments à Vérifier
- [ ] Route `/client/panier` fonctionne
- [ ] Sidebar link "Mon panier" accessible
- [ ] Articles ajoutés visibles
- [ ] Quantités modifiables
- [ ] Suppression articles fonctionne
- [ ] Montant total correct

## 🔗 Navigation

### ✅ Tests de Navigation

#### Depuis Dashboard
- [ ] "Continuer le shopping" → Catalogue
- [ ] "Mon panier" → Panier
- [ ] "Voir toutes" → Commandes
- [ ] Clic commande → Détail

#### Depuis Commandes
- [ ] "Voir →" → Détail commande
- [ ] Pagination fonctionne
- [ ] Filtre change les résultats
- [ ] Recherche fonctionne

#### Depuis Détail
- [ ] "Retour au tableau de bord" → Dashboard
- [ ] Lien vendeur → Profil vendeur (si implémenté)

#### Sidebar
- [ ] Dashboard → /client/dashboard
- [ ] Commandes → /client/commandes
- [ ] Panier → /client/panier
- [ ] Profil → /client/profil
- [ ] Déconnexion → Logout + Redirect login

## 🎨 Vérification Visuelle

### ✅ Design & UX
- [ ] Couleurs respectent le système (bleu primaire)
- [ ] Espacements cohérents (gap-6)
- [ ] Typo lisible et hiérarchisée
- [ ] Hover effects fluides (transition)
- [ ] États visuels clairs (badges, boutons)
- [ ] Pas de chevauchement d'éléments
- [ ] Responsive (test sur mobile/tablet)

### ✅ Accessibilité
- [ ] Labels associés aux inputs
- [ ] Contraste correct (text vs background)
- [ ] Curseur change (hover buttons)
- [ ] Focus states visibles (keyboard nav)

## 🐛 Dépannage

Si un test échoue:

1. **Vérifier les logs Laravel**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Vérifier les routes**
   ```bash
   php artisan route:list | grep client
   ```

3. **Vérifier le contrôleur**
   ```bash
   php -l app/Http/Controllers/ClientDashboardController.php
   ```

4. **Vérifier les vues**
   - Erreur 500 → Vérifier blade syntax
   - Erreur 404 → Vérifier routes
   - Data missing → Vérifier controller logic

## ✅ Checklist Finale

```
□ Sidebar navigation fonctionne
□ Dashboard affiche correctement
□ Mes commandes affiche la liste
□ Filtre et recherche fonctionnent
□ Détail commande avec suivi affiche
□ Profil peut être édité
□ Mot de passe peut être changé
□ Compte peut être supprimé
□ Navigation complete et fluide
□ Design responsive
□ Pas d'erreurs console
□ Tous les liens fonctionnent
```

**Score de test: 0/12** → À mettre à jour après tests réels


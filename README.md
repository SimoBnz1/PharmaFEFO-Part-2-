# 💊 PharmaFEFO - Application de Gestion de Stock Pharmaceutique


## 📌 Description du projet

**PharmaFEFO** est une application web de gestion intelligente des stocks pharmaceutiques basée sur la méthode **FEFO (First Expired, First Out)**.

L'objectif principal est d'aider les professionnels de pharmacie à gérer efficacement leurs médicaments, réduire les pertes liées aux produits périmés et automatiser la sortie des lots selon leur date d'expiration.

Cette deuxième partie transforme l'application en une architecture moderne **API-Ready et asynchrone**, permettant une interaction dynamique avec l'utilisateur sans rechargement des pages.

---

# 🎯 Objectifs du projet

- Gestion des produits et des lots pharmaceutiques.
- Suivi des dates de péremption.
- Application de la méthode FEFO pour les sorties de stock.
- Communication asynchrone avec Fetch API.
- Exposition d'une API REST sécurisée.
- Gestion des rôles et permissions.
- Séparation claire entre Web Controllers et API Controllers.

---

# 🚀 Fonctionnalités principales

## 📦 Gestion des entrées de stock

- Ajout d'un nouveau lot via formulaire asynchrone.
- Envoi des données avec JavaScript Fetch API.
- Confirmation instantanée sans rechargement.
- Contrôle d'accès pour le rôle **PREPARATEUR**.

---

## 📊 Dashboard dynamique

- Affichage des lots disponibles.
- Filtrage instantané :
  - Tous les lots
  - Alertes rouges (produits proches de la péremption)

- Chargement des données via API JSON.
- Mise à jour dynamique du tableau avec JavaScript.

---

## 🔄 Sortie intelligente FEFO

- Bouton "Délivrer 1 boîte".
- Sélection automatique du lot qui expire le plus tôt.
- Décrémentation automatique de la quantité.
- Mise à jour instantanée de l'interface.

---

## ⚠️ Gestion des pertes

- Marquage des lots expirés.
- Passage automatique du statut à `EXPIRED`.
- Mise à jour dynamique de la quantité.
- Rapport financier accessible uniquement par l'administrateur.

---

# 🏗️ Architecture du projet

Le projet suit une architecture MVC améliorée :

```
pharmafefo/
│
├── config/
│   ├── database.php
│   └── environment.php
│
├── public/
│   ├── css/
│   ├── js/
│   │   ├── app.js
│   │   └── dashboard.js
│   └── index.php
│
├── src/
│   ├── Controller/
│   │   ├── Web/
│   │   └── Api/
│   │
│   ├── Entity/
│   │
│   ├── Enum/
│   │
│   ├── Service/
│   │   ├── AuthService.php
│   │   └── StockService.php
│   │
│   └── Repository/
│
└── templates/
```

---

# 🛠️ Technologies utilisées

- **PHP 8.x** : Backend et logique métier.
- **MySQL** : Gestion de la base de données.
- **JavaScript ES6 (Fetch API)** : Requêtes asynchrones et manipulation du DOM.
- **HTML5 / CSS3** : Interface utilisateur.
- **Git & GitHub** : Gestion de versions.

---

# 🔌 API Endpoints

## Ajouter un lot

```
POST /stock/add
```

Permet au préparateur d'ajouter un nouveau lot.

---

## Récupérer les lots

```
GET /api/v1/batches
```

Exemple :

```
GET /api/v1/batches?criteria=critical
```

Retourne les lots sous format JSON.

---

## Sortie FEFO

```
POST /api/v1/batches/checkout
```

Décrémente automatiquement le stock selon la règle FEFO.

---

## Expirer un lot

```
PATCH /api/v1/batches/{id}/expire
```

Change le statut du lot en :

```
EXPIRED
```

---

# 🔐 Sécurité

Le projet intègre :

- Authentification utilisateur.
- Gestion des rôles :
  - ADMIN
  - PHARMACIEN
  - PREPARATEUR

- Protection des routes selon les permissions.
- Gestion sécurisée des erreurs selon l'environnement.

---

# ⚡ Installation en local

## 1. Cloner le projet

```bash
git clone https://github.com/votre-compte/pharmafefo.git
```

## 2. Installer les dépendances

```bash
composer install
```

## 3. Configurer la base de données

Créer une base MySQL :

```
pharmafefo
```

Modifier les informations dans :

```
config/database.php
```

---

## 4. Lancer le serveur

```bash
php -S localhost:8000 -t public
```

---

# 🌱 Gestion Git

Le workflow utilisé :

```
main
 |
 ├── feature-auth
 |
 ├── feature-api-stock
 |
 └── feature-dashboard
```

La branche `main` contient uniquement une version stable et fonctionnelle.

---

# 📸 Démonstration

Fonctionnalités démontrables :

✅ Connexion utilisateur  
✅ Ajout d'un lot  
✅ Dashboard dynamique  
✅ Filtrage des alertes  
✅ Sortie FEFO  
✅ Gestion des produits expirés  

---

# 👨‍💻 Auteur

**BEN IZZA MOHAMED**  
Développeur Web Full Stack

Projet réalisé dans le cadre de la formation **Développement Digital - Full Stack**.

---

# 📄 Licence

Projet pédagogique réalisé à des fins d'apprentissage.
# 🛒 SymHome - Application E-commerce avec Symfony

## 📌 Description

SymHome est une application web e-commerce développée avec le framework Symfony.
Elle permet aux utilisateurs de consulter, rechercher et acheter des meubles organisés par catégories (salon, chambre, bureau, cuisine).

L’application comprend :

- Une **partie utilisateur** (navigation, panier, commandes)
- Une **partie administrateur** (gestion des produits et des catégories)

---

## 🎯 Objectifs du projet

- Concevoir une application web complète avec Symfony
- Appliquer l’architecture **MVC (Modèle - Vue - Contrôleur)**
- Manipuler une base de données avec **Doctrine ORM**
- Implémenter des fonctionnalités réelles d’un site e-commerce
- Travailler en binôme avec **GitHub (gestion de version)**

---

## 👥 Équipe

- **Louay Houimli**
- **Amine Hayouni**

---

## ⚙️ Technologies utilisées

| Technologie  | Rôle                       |
| ------------ | -------------------------- |
| Symfony 8    | Framework backend          |
| PHP 8        | Langage de programmation   |
| Doctrine ORM | Gestion base de données    |
| MySQL        | Système de base de données |
| Twig         | Moteur de templates        |
| Bootstrap 5  | Interface utilisateur      |
| Git & GitHub | Gestion de version         |

---

## 🧱 Architecture du projet

Le projet suit le modèle **MVC** :

- **Model (Entités)** → Structure des données
- **View (Twig)** → Interface utilisateur
- **Controller** → Logique applicative

Structure du projet :

```text id="frproj1"
src/
 ├── Controller/
 ├── Entity/
 ├── Repository/
templates/
config/
public/
```

---

## 🗄️ Entités

### 🔹 Categorie

- id
- libelle
- description

### 🔹 Meuble

- id
- nom
- prix
- description
- image
- stock
- categorie (relation)

### 🔹 Commande

- id
- date
- total
- user (relation)

### 🔹 LigneCommande

- id
- quantite
- prix
- commande (relation)
- meuble (relation)

### 🔹 User

- id
- email
- password
- roles

---

## 🔗 Relations

- Une **Catégorie** contient plusieurs **Meubles**
- Un **Meuble** appartient à une seule **Catégorie**
- Un **User** possède plusieurs **Commandes**
- Une **Commande** contient plusieurs **LigneCommande**
- Une **LigneCommande** correspond à un seul **Meuble**

---

## 🚀 Installation du projet

### 1. Cloner le dépôt

```bash id="frcmd1"
git clone https://github.com/louayhouimli/SymHome.git
cd SymHome
```

---

### 2. Installer les dépendances

```bash id="frcmd2"
composer install
```

---

### 3. Configurer l’environnement

Créer un fichier `.env.local` :

```env id="frenv1"
DATABASE_URL="mysql://root:@127.0.0.1:3306/symhome?serverVersion=8.0"
```

---

### 4. Créer la base de données

```bash id="frcmd3"
php bin/console doctrine:database:create
```

---

### 5. Exécuter les migrations

```bash id="frcmd4"
php bin/console doctrine:migrations:migrate
```

---

### 6. Lancer le serveur

```bash id="frcmd5"
symfony serve
```

Accès :

```text id="frurl"
http://localhost:8000
```

---

## 🛠️ Fonctionnalités

### 👤 Côté utilisateur

- Consultation des meubles
- Affichage des détails d’un produit
- Recherche par nom ou catégorie
- Ajout au panier
- Passage de commande

### 🛠️ Côté administrateur

- Gestion des catégories (CRUD)
- Gestion des meubles (CRUD)
- Suivi des commandes
- Gestion des utilisateurs

---

## 📊 Avancement du projet

- [x] Initialisation du projet
- [x] Configuration de la base de données
- [x] Création des entités (Categorie, Meuble)
- [x] Création des entités (User, Commande, LigneCommande)
- [ ] CRUD
- [ ] Interface utilisateur
- [ ] Panier
- [ ] Commandes
- [ ] Authentification
- [ ] Paiement

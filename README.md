# SocialApp — Application de gestion des relations sociales

Application web de gestion des relations sociales développée avec **PHP** et **MySQL/MariaDB** dans le cadre d'un mini-projet 2025-2026.

L'application permet aux utilisateurs de créer un compte, gérer leur profil, rechercher d'autres utilisateurs, envoyer et gérer des demandes d'amis, gérer leurs relations et recevoir des notifications.

---

## 📸 Captures d'écran

### 🔐 Connexion

![Login](screenshots/login.PNG)

### 📝 Inscription

![Register](screenshots/register.PNG)

### 👤 Profil

![Profile](screenshots/profile.PNG)

### 🤝 Amis

![Friends](screenshots/friends.PNG)

---

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| Back-end | PHP 8.0+ |
| Programmation | PHP orienté objet (OOP) |
| Accès aux données | PDO |
| Base de données | MySQL 5.7+ / MariaDB |
| Front-end | HTML5, CSS3, Bootstrap 5.3 |
| Icônes | Bootstrap Icons |
| Architecture | MVC avec Front Controller |
| Serveur local | Apache / XAMPP / Laragon |

---

## ✨ Fonctionnalités

### 👤 Gestion des utilisateurs

- ✅ Inscription avec photo de profil optionnelle
- ✅ Connexion / Déconnexion
- ✅ Accès protégé pour les utilisateurs authentifiés
- ✅ Modification du profil
- ✅ Modification du nom et de l'adresse e-mail
- ✅ Modification du mot de passe
- ✅ Modification de la photo de profil
- ✅ Suppression du compte avec confirmation par mot de passe
- ✅ Sécurisation des mots de passe avec `password_hash()` et `password_verify()`

### 🤝 Gestion des demandes d'amis

- ✅ Recherche d'utilisateurs
- ✅ Envoi d'une demande d'ami
- ✅ Annulation d'une demande envoyée
- ✅ Acceptation d'une demande reçue
- ✅ Refus d'une demande reçue
- ✅ Liste des demandes envoyées
- ✅ Affichage du statut des demandes :
  - `EN_ATTENTE`
  - `ACCEPTEE`
  - `REJETEE`
- ✅ Liste des demandes reçues en attente
- ✅ Protection contre l'envoi d'une demande :
  - à soi-même
  - en double
  - à un utilisateur déjà ami

### 👥 Gestion des amitiés

- ✅ Création de l'amitié lors de l'acceptation d'une demande
- ✅ Gestion d'une seule relation par paire d'utilisateurs
- ✅ Comptage dynamique du nombre d'amis
- ✅ Affichage de la liste des amis
- ✅ Recherche parmi les amis
- ✅ Suppression d'un ami
- ✅ Affichage des amis en commun sur le profil

### 🔔 Système de notifications

- ✅ Notification lors de la réception d'une demande d'ami
- ✅ Notification lors de l'acceptation d'une demande
- ✅ Notification lors du refus d'une demande
- ✅ Badge indiquant les notifications non lues
- ✅ Marquage d'une notification comme lue
- ✅ Marquage de toutes les notifications comme lues
- ✅ Indicateur visuel sur la cloche de notifications

### 💡 Suggestions d'amis

- ✅ Suggestions basées sur les relations existantes
- ✅ Affichage du nombre d'amis en commun
- ✅ Découverte de nouvelles connexions

---

## 🔒 Sécurité

Le projet intègre plusieurs mécanismes de sécurité :

| Mesure | Implémentation |
|---|---|
| Mots de passe | `password_hash()` / `password_verify()` |
| Requêtes SQL | PDO avec requêtes préparées |
| Protection XSS | `htmlspecialchars()` |
| CSRF | Token aléatoire vérifié sur les formulaires POST |
| Uploads | Vérification du type MIME avec `finfo` |
| Extensions | Normalisation des extensions de fichiers |
| Sessions | `session_regenerate_id(true)` |
| Contrôle d'accès | Pages protégées pour les utilisateurs authentifiés |

---

## 🏗️ Architecture

Le projet utilise une architecture **MVC avec Front Controller** afin de séparer les différentes responsabilités de l'application.

### Model

Les modèles gèrent principalement :

- Les interactions avec la base de données
- La récupération des données
- La création et la modification des données
- Les utilisateurs
- Les demandes d'amis
- Les relations d'amitié
- Les notifications

### Controller

Les contrôleurs prennent en charge :

- Le traitement des requêtes
- La logique applicative
- L'authentification
- La gestion des utilisateurs
- Les demandes d'amis
- Les amitiés
- Les notifications

### View

Les vues sont responsables de :

- L'affichage HTML
- L'interface utilisateur
- Les formulaires
- La présentation des données

Cette organisation permet de rendre le projet plus structuré, maintenable et évolutif.

---

## 📂 Structure du projet

```text
social-app/
│
├── index.php                  # Front Controller / routeur
│
├── config/
│   └── config.php             # Configuration de la base de données et des uploads
│
├── core/
│   ├── Database.php           # Connexion PDO
│   └── helpers.php            # CSRF, flash, avatar, upload, etc.
│
├── models/
│   ├── User.php
│   ├── FriendRequest.php
│   ├── Friend.php
│   └── Notification.php
│
├── controllers/
│   ├── AuthController.php
│   ├── UserController.php
│   ├── FriendRequestController.php
│   ├── FriendController.php
│   └── NotificationController.php
│
├── views/
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   │
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   │
│   ├── profile/
│   │   ├── view.php
│   │   └── edit.php
│   │
│   ├── search/
│   │   └── index.php
│   │
│   ├── friends/
│   │   ├── list.php
│   │   ├── requests.php
│   │   └── suggestions.php
│   │
│   └── notifications/
│       └── index.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   │
│   └── uploads/
│       └── Photos de profil
│
├── sql/
│   └── schema.sql             # Schéma de la base de données
│
├── screenshots/
│   ├── login.PNG
│   ├── register.PNG
│   ├── profile.PNG
│   └── friends.PNG
│
└── README.md

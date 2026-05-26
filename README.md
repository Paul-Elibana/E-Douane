# 🛃 E-Douane

> Application web de gestion des déclarations douanières — ajout, affichage, recherche et authentification.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![HTML/CSS](https://img.shields.io/badge/HTML%2FCSS-Vanilla-E34F26?logo=html5&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-F7DF1E?logo=javascript&logoColor=black)
![Hébergement](https://img.shields.io/badge/Hébergement-InfinityFree-00BFFF)

---

## 📋 Fonctionnalités

| Fonctionnalité | Description |
|---|---|
| 📄 Liste des déclarations | Affichage paginé avec recherche en temps réel |
| ➕ Ajout | Formulaire de création d'une déclaration |
| 🔍 Recherche | Filtre par numéro, importateur ou statut |
| 🔐 Authentification | Connexion / déconnexion par session PHP |
| 👤 Inscription | Création de compte libre (rôle utilisateur) |
| 🛠️ Admin | Gestion des utilisateurs (créer, modifier, supprimer) |

---

## 🗂️ Structure du projet

```
e-douane/
├── 📄 index.php                  ← Liste + recherche des déclarations
├── 📄 ajouter.php                ← Formulaire d'ajout
├── 📄 traiter_ajout.php          ← Traitement du formulaire (POST)
├── 📄 detail.php                 ← Vue détaillée d'une déclaration
├── 📄 login.php                  ← Page de connexion
├── 📄 inscription.php            ← Page d'inscription
├── 📄 deconnexion.php            ← Destruction de session
├── 📁 admin/
│   ├── utilisateurs.php          ← Liste des utilisateurs (admin)
│   ├── ajouter_utilisateur.php   ← Créer un utilisateur
│   ├── modifier_utilisateur.php  ← Modifier un utilisateur
│   └── supprimer_utilisateur.php ← Supprimer un utilisateur
├── 📁 config/
│   ├── db.php                    ← Connexion PDO (non versionné)
│   └── db.example.php            ← Modèle de connexion
├── 📁 includes/
│   ├── auth.php                  ← Vérification de session
│   ├── header.php                ← En-tête HTML commun
│   └── footer.php                ← Pied de page HTML commun
├── 📁 assets/
│   ├── style.css                 ← CSS minimaliste
│   └── app.js                    ← JS vanilla (live search, alertes)
└── 📁 sql/
    └── schema.sql                ← Script de création des tables
```

---

## ⚙️ Stack technique

- **Backend** : PHP pur avec PDO (prepared statements)
- **Base de données** : MySQL
- **Frontend** : HTML + CSS vanilla (sans framework)
- **JavaScript** : Vanilla JS (live search, confirmations, alertes)
- **Hébergement** : InfinityFree

---

## 🚀 Installation en local

### Prérequis
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)

### Étapes

```bash
# 1. Cloner le dépôt dans htdocs
git clone https://github.com/Paul-Elibana/E-Douane.git C:/xampp/htdocs/e-douane

# 2. Copier le fichier de config
cp config/db.example.php config/db.php
```

```sql
-- 3. Exécuter dans phpMyAdmin (http://localhost/phpmyadmin)
SOURCE sql/schema.sql;
```

```
-- 4. Ouvrir dans le navigateur
http://localhost/e-douane/
```

### Compte admin par défaut
| Champ | Valeur |
|---|---|
| Email | `admin@edouane.com` |
| Mot de passe | `admin123` |

> ⚠️ Pensez à changer ce mot de passe après la première connexion.

---

## 🌐 Déploiement sur InfinityFree

1. Créer un compte sur [infinityfree.com](https://infinityfree.com)
2. Créer une base MySQL depuis le panneau de contrôle
3. Uploader les fichiers via FTP (FileZilla ou script PowerShell)
4. Renseigner les identifiants dans `config/db.php`
5. Exécuter `sql/schema.sql` dans le phpMyAdmin d'InfinityFree

> Le fichier `config/db.php` détecte automatiquement l'environnement (`localhost` → local, sinon → production).

---

## 🔐 Rôles et droits

| Action | Utilisateur | Admin |
|---|---|---|
| Voir les déclarations | ✅ | ✅ |
| Ajouter une déclaration | ✅ | ✅ |
| Voir le détail | ✅ | ✅ |
| Gérer les utilisateurs | ❌ | ✅ |

---

## 📸 Aperçu

| Page | URL |
|---|---|
| Connexion | `/login.php` |
| Inscription | `/inscription.php` |
| Liste des déclarations | `/index.php` |
| Ajouter | `/ajouter.php` |
| Gestion utilisateurs | `/admin/utilisateurs.php` |

---

## 👨‍💻 Auteur

**Paul Elibana** — [GitHub](https://github.com/Paul-Elibana)

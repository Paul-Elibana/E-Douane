# E-Douane

Application de gestion de declarations douanieres (ajout, affichage, recherche).

## Stack technique

- **Backend** : PHP pur avec PDO
- **Base de donnees** : MySQL
- **Frontend** : HTML + CSS (sans framework)
- **Hebergement** : InfinityFree

## Structure du projet

```
e-douane/
├── .htaccess              ← config Apache
├── index.php              ← liste + recherche
├── ajouter.php            ← formulaire d'ajout
├── traiter_ajout.php      ← traitement du formulaire
├── detail.php             ← vue detaillee d'une declaration
├── config/
│   ├── db.php             ← connexion PDO (non versionne, voir .gitignore)
│   └── db.example.php     ← modele de connexion a copier
├── includes/
│   ├── header.php
│   └── footer.php
├── assets/
│   └── style.css
└── sql/
    └── schema.sql         ← script de creation de la table
```

## Installation en local

1. Copier le projet dans `htdocs/e-douane/`
2. Copier `config/db.example.php` en `config/db.php` et renseigner les identifiants
3. Executer `sql/schema.sql` dans phpMyAdmin
4. Ouvrir `http://localhost/e-douane/`

## Deploiement sur InfinityFree

1. Creer un compte sur InfinityFree
2. Creer une base MySQL depuis le panneau de controle
3. Uploader tous les fichiers (sauf `config/db.php`) via FTP
4. Creer `config/db.php` directement sur le serveur avec les identifiants InfinityFree
5. Executer `sql/schema.sql` dans phpMyAdmin d'InfinityFree

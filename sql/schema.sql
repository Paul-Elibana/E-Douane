-- ============================================================
-- E-DOUANE — Script complet de gestion de la base de données
-- A executer dans phpMyAdmin (local ou InfinityFree)
-- ============================================================


-- ============================================================
-- 1. CREATION DE LA BASE
-- ============================================================

CREATE DATABASE IF NOT EXISTS edouane
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE edouane;


-- ============================================================
-- 2. CREATION DES TABLES
-- ============================================================

CREATE TABLE IF NOT EXISTS declarations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    numero      VARCHAR(100)   NOT NULL UNIQUE,
    importateur VARCHAR(150)   NOT NULL,
    montant     DECIMAL(15, 2) NOT NULL,
    statut      VARCHAR(50)    NOT NULL DEFAULT 'en_attente',
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    prenom       VARCHAR(100)  NOT NULL,
    nom          VARCHAR(100)  NOT NULL,
    email        VARCHAR(150)  NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255)  NOT NULL,
    role         ENUM('admin','utilisateur') DEFAULT 'utilisateur',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- ============================================================
-- 3. COMPTE ADMIN PAR DEFAUT (mot de passe : admin123)
-- ============================================================

INSERT IGNORE INTO utilisateurs (prenom, nom, email, mot_de_passe, role)
VALUES (
    'Admin',
    'Principal',
    'admin@edouane.com',
    '$2y$10$CR20.Dt.RqeMNTt8Z7nJruWbWRpkN1v3TkL065QoTch7r78Yv2S.i',
    'admin'
);


-- ============================================================
-- 4. REINITIALISATION (supprime tout et repart de zero)
-- ============================================================

-- DROP TABLE IF EXISTS declarations;
-- DROP TABLE IF EXISTS utilisateurs;
-- DROP DATABASE IF EXISTS edouane;


-- ============================================================
-- 5. GESTION DES DECLARATIONS
-- ============================================================

-- Voir toutes les declarations
-- SELECT * FROM declarations ORDER BY created_at DESC;

-- Voir une declaration par son numero
-- SELECT * FROM declarations WHERE numero = 'DEC-001';

-- Voir les declarations par statut
-- SELECT * FROM declarations WHERE statut = 'en_attente';

-- Rechercher par importateur
-- SELECT * FROM declarations WHERE importateur LIKE '%nom%';

-- Ajouter une declaration manuellement
-- INSERT INTO declarations (numero, importateur, montant, statut)
-- VALUES ('DEC-001', 'Societe XYZ', 1500000.00, 'en_attente');

-- Modifier le statut d'une declaration
-- UPDATE declarations SET statut = 'validee' WHERE id = 1;

-- Modifier une declaration complete
-- UPDATE declarations
-- SET numero = 'DEC-001', importateur = 'Societe XYZ', montant = 2000000.00, statut = 'validee'
-- WHERE id = 1;

-- Supprimer une declaration
-- DELETE FROM declarations WHERE id = 1;

-- Supprimer toutes les declarations (garder la table)
-- TRUNCATE TABLE declarations;


-- ============================================================
-- 6. GESTION DES UTILISATEURS
-- ============================================================

-- Voir tous les utilisateurs
-- SELECT id, prenom, nom, email, role, created_at FROM utilisateurs;

-- Voir uniquement les admins
-- SELECT * FROM utilisateurs WHERE role = 'admin';

-- Ajouter un utilisateur manuellement (mot de passe a hasher via PHP)
-- INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, role)
-- VALUES ('Jean', 'Dupont', 'jean@example.com', 'HASH_ICI', 'utilisateur');

-- Modifier le role d'un utilisateur
-- UPDATE utilisateurs SET role = 'admin' WHERE email = 'jean@example.com';

-- Modifier l'email d'un utilisateur
-- UPDATE utilisateurs SET email = 'nouveau@example.com' WHERE id = 2;

-- Supprimer un utilisateur
-- DELETE FROM utilisateurs WHERE id = 2;

-- Supprimer tous les utilisateurs sauf l'admin
-- DELETE FROM utilisateurs WHERE role != 'admin';


-- ============================================================
-- 7. REQUETES UTILES (statistiques et rapports)
-- ============================================================

-- Nombre total de declarations
-- SELECT COUNT(*) AS total FROM declarations;

-- Total des montants par statut
-- SELECT statut, COUNT(*) AS nombre, SUM(montant) AS total_montant
-- FROM declarations
-- GROUP BY statut;

-- Declarations du mois en cours
-- SELECT * FROM declarations
-- WHERE MONTH(created_at) = MONTH(NOW())
-- AND YEAR(created_at) = YEAR(NOW());

-- Nombre d'utilisateurs par role
-- SELECT role, COUNT(*) AS nombre FROM utilisateurs GROUP BY role;

-- Les 10 declarations les plus recentes
-- SELECT * FROM declarations ORDER BY created_at DESC LIMIT 10;

-- Declaration avec le montant le plus eleve
-- SELECT * FROM declarations ORDER BY montant DESC LIMIT 1;

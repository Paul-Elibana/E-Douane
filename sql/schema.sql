-- Script complet E-Douane
-- A executer dans phpMyAdmin

CREATE DATABASE IF NOT EXISTS edouane
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE edouane;

-- Table des declarations
CREATE TABLE IF NOT EXISTS declarations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    numero      VARCHAR(100)    NOT NULL UNIQUE,
    importateur VARCHAR(150)    NOT NULL,
    montant     DECIMAL(15, 2)  NOT NULL,
    statut      VARCHAR(50)     NOT NULL DEFAULT 'en_attente',
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    prenom       VARCHAR(100)  NOT NULL,
    nom          VARCHAR(100)  NOT NULL,
    email        VARCHAR(150)  NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255)  NOT NULL,
    role         ENUM('admin','utilisateur') DEFAULT 'utilisateur',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Compte admin par defaut (mot de passe : admin123)
INSERT IGNORE INTO utilisateurs (prenom, nom, email, mot_de_passe, role)
VALUES (
    'Admin',
    'Principal',
    'admin@edouane.com',
    '$2y$10$CR20.Dt.RqeMNTt8Z7nJruWbWRpkN1v3TkL065QoTch7r78Yv2S.i',
    'admin'
);

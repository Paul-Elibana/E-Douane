-- Script de creation de la base et de la table pour E-Douane
-- A executer dans phpMyAdmin

CREATE DATABASE IF NOT EXISTS edouane
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE edouane;

DROP TABLE IF EXISTS declarations;

CREATE TABLE declarations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    numero      VARCHAR(100)    NOT NULL UNIQUE,
    importateur VARCHAR(150)    NOT NULL,
    montant     DECIMAL(15, 2)  NOT NULL,
    statut      VARCHAR(50)     NOT NULL DEFAULT 'en_attente',
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

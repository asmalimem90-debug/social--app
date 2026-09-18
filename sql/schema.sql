-- ============================================================
-- Social Relations Management Application - DB Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS social_app
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE social_app;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS amis;
DROP TABLE IF EXISTS demande_amis;
DROP TABLE IF EXISTS utilisateurs;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
-- Table: utilisateurs
-- --------------------------------------------------------
CREATE TABLE utilisateurs (
    id            INT          AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    email         VARCHAR(100) NOT NULL UNIQUE,
    motDePasse    VARCHAR(255) NOT NULL,
    image         VARCHAR(255) DEFAULT NULL,
    dateCreation  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: demande_amis
-- --------------------------------------------------------
CREATE TABLE demande_amis (
    id            INT  AUTO_INCREMENT PRIMARY KEY,
    demandeur_id  INT  NOT NULL,
    recepteur_id  INT  NOT NULL,
    statut        ENUM('EN_ATTENTE','ACCEPTEE','REJETEE') NOT NULL DEFAULT 'EN_ATTENTE',
    dateCreation  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (demandeur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (recepteur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    UNIQUE KEY demandeUnique (demandeur_id, recepteur_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: amis
-- One row per pair, always stored with utilisateur1_id < utilisateur2_id
-- --------------------------------------------------------
CREATE TABLE amis (
    id                INT  AUTO_INCREMENT PRIMARY KEY,
    utilisateur1_id   INT  NOT NULL,
    utilisateur2_id   INT  NOT NULL,
    dateCreation      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur1_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur2_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    UNIQUE KEY amitiéUnique (utilisateur1_id, utilisateur2_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: notifications
-- --------------------------------------------------------
CREATE TABLE notifications (
    id              INT  AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id  INT  NOT NULL,
    type            ENUM('demandeAmitié','demandeAcceptée','demandeRefusée') NOT NULL,
    reference_id    INT  DEFAULT NULL,
    is_read         BOOLEAN NOT NULL DEFAULT FALSE,
    dateCreation    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (reference_id)   REFERENCES demande_amis(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

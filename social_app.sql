-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 sep. 2026 à 13:00
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `social_app`
--

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

CREATE TABLE `amis` (
  `id` int(11) NOT NULL,
  `utilisateur1_id` int(11) NOT NULL,
  `utilisateur2_id` int(11) NOT NULL,
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`id`, `utilisateur1_id`, `utilisateur2_id`, `dateCreation`) VALUES
(5, 6, 7, '2026-04-26 23:18:36'),
(7, 6, 9, '2026-04-26 23:25:43'),
(9, 7, 9, '2026-04-26 23:27:38'),
(10, 7, 10, '2026-04-26 23:29:51'),
(11, 9, 10, '2026-04-26 23:30:11'),
(12, 7, 11, '2026-04-27 11:31:25');

-- --------------------------------------------------------

--
-- Structure de la table `demande_amis`
--

CREATE TABLE `demande_amis` (
  `id` int(11) NOT NULL,
  `demandeur_id` int(11) NOT NULL,
  `recepteur_id` int(11) NOT NULL,
  `statut` enum('EN_ATTENTE','ACCEPTEE','REJETEE') NOT NULL DEFAULT 'EN_ATTENTE',
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demande_amis`
--

INSERT INTO `demande_amis` (`id`, `demandeur_id`, `recepteur_id`, `statut`, `dateCreation`) VALUES
(6, 6, 7, 'ACCEPTEE', '2026-04-26 23:18:00'),
(8, 9, 6, 'ACCEPTEE', '2026-04-26 23:25:19'),
(10, 7, 9, 'ACCEPTEE', '2026-04-26 23:27:09'),
(11, 10, 7, 'ACCEPTEE', '2026-04-26 23:29:17'),
(12, 10, 9, 'ACCEPTEE', '2026-04-26 23:29:29'),
(13, 11, 7, 'ACCEPTEE', '2026-04-27 11:25:18');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `type` enum('demandeAmitié','demandeAcceptée','demandeRefusée') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `utilisateur_id`, `type`, `reference_id`, `is_read`, `dateCreation`) VALUES
(10, 7, 'demandeAmitié', 6, 1, '2026-04-26 23:18:00'),
(12, 6, 'demandeAcceptée', 6, 0, '2026-04-26 23:18:36'),
(14, 6, 'demandeAmitié', 8, 0, '2026-04-26 23:25:20'),
(16, 9, 'demandeAcceptée', 8, 0, '2026-04-26 23:25:43'),
(18, 9, 'demandeAmitié', 10, 0, '2026-04-26 23:27:09'),
(19, 7, 'demandeAcceptée', 10, 0, '2026-04-26 23:27:38'),
(20, 7, 'demandeAmitié', 11, 0, '2026-04-26 23:29:17'),
(21, 9, 'demandeAmitié', 12, 0, '2026-04-26 23:29:29'),
(22, 10, 'demandeAcceptée', 11, 0, '2026-04-26 23:29:51'),
(23, 10, 'demandeAcceptée', 12, 0, '2026-04-26 23:30:11'),
(24, 7, 'demandeAmitié', 13, 0, '2026-04-27 11:25:18'),
(25, 11, 'demandeAcceptée', 13, 0, '2026-04-27 11:31:25');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `dateCreation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `motDePasse`, `image`, `dateCreation`) VALUES
(6, 'Hbiba ghribi', 'hbibaGH@gmil.com', '$2y$10$FqyENIZZ8juK6vXduXLCruRXvQS31mZIoa4pRvbJqP82Ix1KxAIUu', 'f1d51eb839b80313ebf6c5b9bd574282.jpg', '2026-04-26 00:04:17'),
(7, 'Ons jabeur', 'Onsjabeur@gmail.com', '$2y$10$Cv1MoGSd8vTNIMrQyEkjjONmiCJ29gExiq4j4TCHzuorbF.lRdUqa', '4d9cf67d61c62b8068b3c64e1225350b.jpg', '2026-04-26 00:11:01'),
(9, 'Ayoub hafnoui', 'ayoubhafnaoui@gmail.com', '$2y$10$yGSnMSjzAOKNzd186uh4G.XdsudBBnt6iEKlbejLVW.pWYcB.T/NG', '842f63c5fc635b699cd8ccf24dd06274.jpg', '2026-04-26 23:24:45'),
(10, 'Ali maloul', 'alimaloul@gmail.com', '$2y$10$/IeqAQ3V6sOE4ICc5EkrLuovfJyHiCpplqJorqN.mGwttTw4eOpwu', 'faec0e11bc493c385a20de7b5c564f85.png', '2026-04-26 23:29:02'),
(11, 'Raoua Tlili', 'raouatlili@gmail.com', '$2y$10$XKU4uh0H.soeemdfyzPeoO6CnHNatbbRmOnxRhmUrsQjZrAbfW6Fe', 'e94b36c45dae8139be47326f202a8141.jpg', '2026-04-27 11:24:31');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `amis`
--
ALTER TABLE `amis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `amitiéUnique` (`utilisateur1_id`,`utilisateur2_id`),
  ADD KEY `utilisateur2_id` (`utilisateur2_id`);

--
-- Index pour la table `demande_amis`
--
ALTER TABLE `demande_amis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `demandeUnique` (`demandeur_id`,`recepteur_id`),
  ADD KEY `recepteur_id` (`recepteur_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `reference_id` (`reference_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `amis`
--
ALTER TABLE `amis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `demande_amis`
--
ALTER TABLE `demande_amis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`utilisateur1_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`utilisateur2_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demande_amis`
--
ALTER TABLE `demande_amis`
  ADD CONSTRAINT `demande_amis_ibfk_1` FOREIGN KEY (`demandeur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `demande_amis_ibfk_2` FOREIGN KEY (`recepteur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`reference_id`) REFERENCES `demande_amis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

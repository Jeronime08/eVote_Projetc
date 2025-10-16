-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 15 oct. 2025 à 03:33
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
-- Base de données : `evote_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidats`
--

CREATE TABLE `candidats` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `scrutin_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `scrutins`
--

CREATE TABLE `scrutins` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `status` enum('draft','open','closed') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('electeur','admin') NOT NULL DEFAULT 'electeur',
  `npi` varchar(50) DEFAULT NULL,
  `voted` tinyint(1) DEFAULT 0,
  `ville` varchar(50) DEFAULT NULL,
  `departement` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password_hash`, `role`, `npi`, `voted`, `ville`, `departement`, `created_at`, `updated_at`) VALUES
(1, 'TODOFON', 'Jeronime', 'todofonjeronime@gmail.com ', '12345678', 'admin', NULL, 0, 'Calavi', 'Atlantique', '2025-10-15 03:25:45', '0000-00-00 00:00:00'),
(2, 'Doe', 'Alicia', 'alice.doe@gmail.com', 'hash_alice123', 'electeur', NULL, 0, 'Porto-Novo', 'Ouémé', '2025-10-15 03:30:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `candidat_id` int(11) NOT NULL,
  `scrutin_id` int(11) NOT NULL,
  `date_vote` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scrutin_id` (`scrutin_id`);

--
-- Index pour la table `scrutins`
--
ALTER TABLE `scrutins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `npi` (`npi`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`scrutin_id`),
  ADD KEY `candidat_id` (`candidat_id`),
  ADD KEY `scrutin_id` (`scrutin_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `scrutins`
--
ALTER TABLE `scrutins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD CONSTRAINT `candidats_ibfk_1` FOREIGN KEY (`scrutin_id`) REFERENCES `scrutins` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `scrutins`
--
ALTER TABLE `scrutins`
  ADD CONSTRAINT `scrutins_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`candidat_id`) REFERENCES `candidats` (`id`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`scrutin_id`) REFERENCES `scrutins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

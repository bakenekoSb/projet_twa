-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 jan. 2026 à 20:35
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
-- Base de données : `biblio`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id_emprunt` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emprunts`
--

INSERT INTO `emprunts` (`id_emprunt`, `membre_id`, `livre_id`, `date_debut`, `date_fin`) VALUES
(1, 2, 2, '2026-01-22', '2026-02-05');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id_livre` int(11) NOT NULL,
  `titre_livre` text NOT NULL,
  `description_livre` text NOT NULL,
  `auteur_livre` text NOT NULL,
  `etat_livre` enum('libre','emprunte') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id_livre`, `titre_livre`, `description_livre`, `auteur_livre`, `etat_livre`) VALUES
(1, 'Le Petit prince', 'histoire pour enfant', 'Leonard', 'libre'),
(2, 'La Peste', 'maladie', 'kaka', 'emprunte'),
(3, 'Le poisson rouge', 'trondro', 'bla bla', 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `nom_membre` text NOT NULL,
  `prenom_membre` text NOT NULL,
  `email_membre` text NOT NULL,
  `mdp_membre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `nom_membre`, `prenom_membre`, `email_membre`, `mdp_membre`) VALUES
(1, 'Nadia', 'Finaritra', 'finaritra@gmail.com', 'fina'),
(2, 'Zara', 'Fanilo', 'zara@gmail.com', 'zara'),
(3, 'Fanilo', 'Mendrika', 'mendrika@gmail.com', 'mendrika');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id_emprunt`),
  ADD KEY `livre_id` (`livre_id`),
  ADD KEY `membre_id` (`membre_id`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id_livre`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id_emprunt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD CONSTRAINT `emprunts_ibfk_1` FOREIGN KEY (`livre_id`) REFERENCES `livres` (`id_livre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emprunts_ibfk_2` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

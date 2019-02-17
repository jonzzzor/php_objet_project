-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Dim 17 Février 2019 à 17:48
-- Version du serveur :  10.1.37-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `site_multimedia`
--
CREATE DATABASE IF NOT EXISTS `site_multimedia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `site_multimedia`;

-- --------------------------------------------------------

--
-- Structure de la table `datas`
--

DROP TABLE IF EXISTS `datas`;
CREATE TABLE `datas` (
  `id` int(11) NOT NULL,
  `chemin_relatif` varchar(255) NOT NULL,
  `mime_type` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `datas`
--

INSERT INTO `datas` (`id`, `chemin_relatif`, `mime_type`, `description`, `auteur_id`, `date`) VALUES
(1, 'image1.jpg', 'image/jpeg', 'description image jpeg', 1, '2019-02-12 14:10:52'),
(2, 'image2.svg', 'image/svg+xml', 'description image svg+xml', 2, '2019-02-12 14:10:52'),
(3, 'image3.gif', 'image/gif', 'description image gif', 3, '2019-02-12 14:10:52'),
(4, 'image4.png', 'image/png', 'description image png', 4, '2019-02-12 14:23:59'),
(5, 'video1.webm', 'video/webm', 'description video', 1, '2019-02-12 14:10:52'),
(6, 'video2.webm', 'video/webm', 'description video 2', 2, '2019-02-12 14:10:52'),
(7, 'son1.ogg', 'audio/ogg', 'description audio', 3, '2019-02-12 14:10:52'),
(8, 'son2.ogg', 'audio/ogg', 'description audio 2', 4, '2019-02-12 14:10:52');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `passwd`) VALUES
(1, 'jon', 'c112a79f8183f68eb105e3da248cbbb2'),
(2, 'adeline', 'cd34151fc62430bcdd73b31e051c1ec6'),
(3, 'christophe', 'cd34151fc62430bcdd73b31e051c1ec6'),
(4, 'thierry', '16d8cae50b3c760825d5892dd9022b5f');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `datas`
--
ALTER TABLE `datas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id` (`auteur_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `datas`
--
ALTER TABLE `datas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `datas`
--
ALTER TABLE `datas`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

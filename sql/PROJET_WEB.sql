-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 20 déc. 2021 à 20:34
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_web`
--

-- --------------------------------------------------------

--
-- Structure de la table `concerts`
--

CREATE TABLE `concerts` (
  `id_concert` int(3) NOT NULL,
  `groupe` int(3) NOT NULL,
  `lieu` varchar(30) NOT NULL,
  `date` char(10) NOT NULL,
  `prix_place` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `concerts`
--

INSERT INTO `concerts` (`id_concert`, `groupe`, `lieu`, `date`, `prix_place`) VALUES
(1, 1, 'St Denis - Stade de France', '2022-07-09', 56.5),
(2, 3, 'Southampton - Royaume Uni', '2022-02-24', 16.96),
(3, 2, 'Lille - Zenith Arena', '2022-05-15', 68),
(4, 4, 'Paris - Bercy', '2022-02-12', 55);

-- --------------------------------------------------------

--
-- Structure de la table `genremusical`
--

CREATE TABLE `genremusical` (
  `id_genre` int(11) NOT NULL,
  `nomGenre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genremusical`
--

INSERT INTO `genremusical` (`id_genre`, `nomGenre`) VALUES
(1, 'Rock'),
(2, 'Chanson Française');

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id_groupe` int(3) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `genre` int(250) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`id_groupe`, `nom`, `genre`, `image`) VALUES
(1, 'Red hot chili peppers', 1, 'image/groupe/RedHot.jpg'),
(2, 'Scorpion', 1, 'image/groupe/Scorpion.jpg'),
(3, 'AC-DC', 1, 'image/groupe/ACDC.jpg'),
(4, 'Tryo', 2, 'image/groupe/Tryo.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_res` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idConcert` int(11) NOT NULL,
  `nbPlace` int(11) NOT NULL,
  `prixTotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `login`, `pass`, `email`) VALUES
(1, 'admin', '$2y$10$cE7Ee10/a80o5UOZ9aDivuLb6R3AFfC/eV.ugoZT2rSXlCbWRMSMW', ''),
(2, 'mfiquet', '$2y$10$9w.rz/Qw.8Hj9reQPPjdIODNP3bqdYxd/rw0w35bgCvYvkje5iR2i', 'maxime.fiquet@etudiant.univ-lr.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`id_concert`),
  ADD KEY `groupes` (`groupe`);

--
-- Index pour la table `genremusical`
--
ALTER TABLE `genremusical`
  ADD PRIMARY KEY (`id_genre`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id_groupe`),
  ADD KEY `genre` (`genre`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_res`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idConcert` (`idConcert`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id_concert` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `genremusical`
--
ALTER TABLE `genremusical`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id_groupe` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_res` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD CONSTRAINT `concerts_ibfk_1` FOREIGN KEY (`groupe`) REFERENCES `groupes` (`id_groupe`);

--
-- Contraintes pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `groupes_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `genremusical` (`id_genre`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`idConcert`) REFERENCES `concerts` (`id_concert`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

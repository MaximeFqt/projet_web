-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 29 déc. 2021 à 18:17
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
  `idConcert` int(11) NOT NULL,
  `groupe` int(11) NOT NULL,
  `lieu` varchar(30) NOT NULL,
  `date` char(10) NOT NULL,
  `prixPlace` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `concerts`
--

INSERT INTO `concerts` (`idConcert`, `groupe`, `lieu`, `date`, `prixPlace`) VALUES
(1, 1, 'St Denis - Stade de France', '2022-07-09', 56.5),
(2, 3, 'Southampton - Royaume Uni', '2022-02-24', 16.96),
(3, 2, 'Lille - Zenith Arena', '2022-05-15', 68),
(4, 4, 'Paris - Bercy', '2022-02-12', 55),
(5, 5, 'St-Denis - Stade de France', '2022-07-16', 78.5),
(6, 6, 'Esch sur Alzette - Luxembourg', '2022-06-16', 99),
(7, 7, 'San Juan - Poto Rico', '2022-03-28', 90);

-- --------------------------------------------------------

--
-- Structure de la table `genremusical`
--

CREATE TABLE `genremusical` (
  `idGenre` int(11) NOT NULL,
  `nomGenre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genremusical`
--

INSERT INTO `genremusical` (`idGenre`, `nomGenre`) VALUES
(1, 'Rock'),
(2, 'Chanson Française'),
(3, 'Pop');

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `idGroupe` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `genre` int(11) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`idGroupe`, `nom`, `genre`, `image`) VALUES
(1, 'Red hot chili peppers', 1, 'image/groupe/RedHot.jpg'),
(2, 'Scorpion', 1, 'image/groupe/Scorpion.jpg'),
(3, 'AC-DC', 1, 'image/groupe/ACDC.jpg'),
(4, 'Tryo', 2, 'image/groupe/Tryo.jpg'),
(5, 'Coldplay', 3, 'image/groupe/Coldplay.jpg'),
(6, 'Imagine Dragons', 3, 'image/groupe/ImagineDragons.jpg'),
(7, 'Maroon 5', 3, 'image/groupe/Maroon5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `idRes` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `concert` int(11) NOT NULL,
  `nbPlace` int(11) NOT NULL,
  `prixTotal` float NOT NULL,
  `groupe` int(11) NOT NULL,
  `lieu` varchar(250) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `login`, `pass`, `email`) VALUES
(1, 'admin', '$2y$10$cE7Ee10/a80o5UOZ9aDivuLb6R3AFfC/eV.ugoZT2rSXlCbWRMSMW', ''),
(2, 'mfiquet', '$2y$10$9w.rz/Qw.8Hj9reQPPjdIODNP3bqdYxd/rw0w35bgCvYvkje5iR2i', 'maxime.fiquet@etudiant.univ-lr.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`idConcert`),
  ADD KEY `groupe` (`groupe`);

--
-- Index pour la table `genremusical`
--
ALTER TABLE `genremusical`
  ADD PRIMARY KEY (`idGenre`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`idGroupe`),
  ADD KEY `genre` (`genre`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`idRes`),
  ADD KEY `user` (`user`),
  ADD KEY `concert` (`concert`),
  ADD KEY `groupe` (`groupe`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `idConcert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `genremusical`
--
ALTER TABLE `genremusical`
  MODIFY `idGenre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `idGroupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `idRes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `concerts`
--
ALTER TABLE `concerts`
  ADD CONSTRAINT `concerts_ibfk_1` FOREIGN KEY (`groupe`) REFERENCES `groupes` (`idGroupe`);

--
-- Contraintes pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `groupes_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `genremusical` (`idGenre`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`concert`) REFERENCES `concerts` (`idConcert`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`groupe`) REFERENCES `groupes` (`idGroupe`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Auteur : Fiquet Maxime
-- Hôte : 127.0.0.1
-- Généré le : dim. 24 oct. 2021 à 12:41
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : projet_web
--

-- --------------------------------------------------------

--
-- Structure de la table groupe
--

CREATE TABLE groupe (
  id_groupe int NOT NULL PRIMARY KEY,
  nom varchar(30) NOT NULL,
  image varchar(30) NOT NULL
);

--
-- Déchargement des données de la table groupe
--

INSERT INTO groupe (id_groupe, nom, image) VALUES
(1, 'Red hot chili peppers', 'image/RedHot.jpg'),
(2, 'Scorpion', 'image/Scorpion.jpg'),
(3, 'Queen', ''),
(4, 'ZzTop', ''),
(5, 'AC-DC', 'image/ACDC.jpg');

--
-- Structure de la table concerts
--

CREATE TABLE concerts (
  id_concert int NOT NULL PRIMARY KEY,
  groupe int NOT NULL,
  lieu varchar(30) NOT NULL,
  date char(10) NOT NULL,
  prix_place float NOT NULL
);

--
-- Déchargement des données de la table concerts
--

INSERT INTO concerts (id_concert, groupe, lieu, date, prix_place) VALUES
(1, 1, 'St Denis - Stade de France', '09/07/2022', 56.5),
(2, 5, 'Southampton - Royaume Uni', '24/02/2022', 16.96),
(3, 2, 'Lille - Zenith Arena', '15/05/2022', 68);

-- --------------------------------------------------------

--
-- Index pour la table concerts
--
ALTER TABLE concerts
  ADD FOREIGN KEY (groupe) REFERENCES groupe (id_groupe);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

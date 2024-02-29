-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 29 fév. 2024 à 08:48
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données : `wiki`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
CREATE TABLE IF NOT EXISTS `appartenir` (
  `idProjet` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  PRIMARY KEY (`idProjet`,`idCategorie`),
  KEY `idCategorie` (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`idProjet`, `idCategorie`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `descriptionCategorie` varchar(500) DEFAULT NULL,
  `label` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `descriptionCategorie`, `label`) VALUES
(1, 'Projet de début d\'année sur une semaine.', 'Workshop'),
(2, 'Projet transversal sur deux années.', 'OpenInnovation'),
(3, 'Autre catégorie', 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `coach`
--

DROP TABLE IF EXISTS `coach`;
CREATE TABLE IF NOT EXISTS `coach` (
  `idCoach` int(11) NOT NULL AUTO_INCREMENT,
  `nomCoach` varchar(50) DEFAULT NULL,
  `prenomCoach` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idCoach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------------------

--
-- Structure de la table `consulter`
--

DROP TABLE IF EXISTS `consulter`;
CREATE TABLE IF NOT EXISTS `consulter` (
  `idUser` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idProjet`),
  KEY `idProjet` (`idProjet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `emprunter`
--

DROP TABLE IF EXISTS `emprunter`;
CREATE TABLE IF NOT EXISTS `emprunter` (
  `idMatos` int(11) NOT NULL,
  `dateEmprunt` date DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idMatos`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `idMsg` int(11) NOT NULL AUTO_INCREMENT,
  `objet` varchar(50) DEFAULT NULL,
  `contenu` varchar(1000) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  `idCoach` int(11) NOT NULL,
  PRIMARY KEY (`idMsg`),
  KEY `idUser` (`idUser`),
  KEY `idCoach` (`idCoach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `idProjet` int(11) NOT NULL AUTO_INCREMENT,
  `nomProjet` varchar(50) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `illustration` varchar(100) DEFAULT NULL,
  `descriptionProjet` varchar(500) DEFAULT NULL,
  `valider` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idProjet`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`idProjet`, `nomProjet`, `dateCreation`, `illustration`, `descriptionProjet`, `valider`) VALUES
(1, 'Wally', '2023-09-11', 'Illustrations_Projets\\wally.jpg', 'Un robot écolo', 0),
(2, 'Casque VR', NULL, 'Illustrations_Projets\\casque_vr.jpg', 'Réalité virtuelle ou augmentée', 0),
(3, 'Cybernéo', NULL, NULL, NULL, 0),
(4, 'BORNE D\'ARCADE', NULL, NULL, NULL, 0),
(5, 'Wiki', '2023-10-09', NULL, NULL, 0),
(6, 'Nouveau bâtiment', NULL, NULL, NULL, 0),
(10, 'Un autre projet', NULL, NULL, 'Essai d\'ajout par formulaire', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire`
--

DROP TABLE IF EXISTS `proprietaire`;
CREATE TABLE IF NOT EXISTS `proprietaire` (
  `idUser` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idProjet`),
  KEY `idProjet` (`idProjet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proprietaire`
--

INSERT INTO `proprietaire` (`idUser`, `idProjet`) VALUES
(1, 1),
(1, 4),
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nomUser` varchar(50) CHARACTER SET utf8 NOT NULL,
  `prenomUser` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `dateInscription` date DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `nomUser`, `prenomUser`, `description`, `email`, `dateInscription`) VALUES
(1, 'Chameroy', 'Diego', NULL, NULL, NULL),
(2, 'Testard', 'Matisse', NULL, 'matisse.testard@ecoles-epsi.fr', NULL),
(3, 'Coralie', 'Demarez', NULL, 'coralie.demarez@ecoles-epsi.fr', NULL),
(4, 'monNom', 'prenom', NULL, 'e@mail.nb', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 02 Juin 2015 à 09:17
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `emolyse`
--

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE IF NOT EXISTS `resultat` (
  `idProduit` int(11) NOT NULL,
  `idParticipant` int(11) NOT NULL,
  `genreAvatar` varchar(1) COLLATE utf8_bin NOT NULL,
  `angleBGx` float NOT NULL,
  `angleBGz` float NOT NULL,
  `angleBDx` float NOT NULL,
  `angleBDz` float NOT NULL,
  `angleBuste` float NOT NULL,
  `distance` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idProduit`,`idParticipant`),
  KEY `idParticipant` (`idParticipant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `resultat`
--

INSERT INTO `resultat` (`idProduit`, `idParticipant`, `genreAvatar`, `angleBGx`, `angleBGz`, `angleBDx`, `angleBDz`, `angleBuste`, `distance`, `date`) VALUES
(60, 4, 'H', 0, 0, 0, 0, 0, 170, '2015-06-02'),
(75, 4, 'H', 0, 0, 0, 0, 0, 170, '2015-06-02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

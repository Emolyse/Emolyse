-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 29 Mai 2015 à 13:30
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
-- Structure de la table `experience`
--

CREATE TABLE IF NOT EXISTS `experience` (
  `idExperience` int(11) NOT NULL AUTO_INCREMENT,
  `idEnvironnement` int(11) NOT NULL,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `consigne` mediumtext COLLATE utf8_bin NOT NULL,
  `nbProduit` int(11) NOT NULL,
  `codeLangue` varchar(2) COLLATE utf8_bin NOT NULL,
  `syncroBras` tinyint(1) NOT NULL,
  `random` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExperience`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`idExperience`, `idEnvironnement`, `nom`, `consigne`, `nbProduit`, `codeLangue`, `syncroBras`, `random`) VALUES
(16, 1, 'Expérience en italien', 'changement de la consigne pour exp 16 !!', 5, 'IT', 1, 1),
(17, 1, 'test', 'test de la consigne en franÃ§ais', 5, 'FR', 0, 0),
(20, 1, 'test drat', 'Order bla', 4, 'FR', 0, 1),
(22, 1, 'test position', '', 2, 'EN', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

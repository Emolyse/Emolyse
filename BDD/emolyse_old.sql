-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 27 Mai 2015 à 11:57
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
-- Structure de la table `avatar`
--

CREATE TABLE IF NOT EXISTS `avatar` (
  `idAvatar` int(11) NOT NULL AUTO_INCREMENT,
  `genre` varchar(45) COLLATE utf8_bin NOT NULL,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idAvatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `environnement`
--

CREATE TABLE IF NOT EXISTS `environnement` (
  `idEnvironnement` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `lienEnvironnement` varchar(500) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idEnvironnement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
  `random` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExperience`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`idExperience`, `idEnvironnement`, `nom`, `consigne`, `nbProduit`, `codeLangue`, `random`) VALUES
(16, 0, 'Expérience en italien', 'changement de la consigne pour exp 16 !!', 2, 'IT', 1),
(17, 0, 'test', 'test de la consigne en franÃ§ais', 3, 'FR', 0),
(20, 0, 'test', 'Order bla', 1, 'FR', 0);

-- --------------------------------------------------------

--
-- Structure de la table `identifiant`
--

CREATE TABLE IF NOT EXISTS `identifiant` (
  `codeIdentifiant` varchar(45) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`codeIdentifiant`),
  KEY `codeIdentifiant` (`codeIdentifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `identifiant`
--

INSERT INTO `identifiant` (`codeIdentifiant`, `description`) VALUES
('AFFICHAGE_ALEATOIRE_OBJETS', ''),
('AGE', ''),
('AJOUTER', ''),
('ANGLAIS', ''),
('BTN_EXPERIENCES', ''),
('BTN_EXPERIMENTATEUR_HOME', ''),
('BTN_PARAMETRES', ''),
('BTN_PARTICIPANTS', ''),
('BTN_PARTICIPANT_HOME', ''),
('CHAMPS_OBLIGATOIRE', ''),
('CHOISIR_LA_LANGUE', ''),
('CONSIGNE', ''),
('DEMARRER', ''),
('EDITER_LA_CONSIGNE', ''),
('ENVIRONNEMENT', ''),
('EXPERIENCE', ''),
('EXPERIENCE_TERMINEE', ''),
('FEMME', ''),
('FINALISATION', ''),
('FINALISER', ''),
('FRANCAIS', ''),
('HOMME', ''),
('ID', ''),
('IDENTIFIANT', ''),
('LANGUE', ''),
('MODIFIER', ''),
('NEE_LE', ''),
('NOM', ''),
('NOUVELLE_EXPERIENCE', ''),
('OBJETS', ''),
('PRENOM', ''),
('SEXE', ''),
('TEXT_CONSIGNE', '');

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

CREATE TABLE IF NOT EXISTS `langue` (
  `codeLangue` varchar(2) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `lienDrapeau` varchar(100) NOT NULL,
  PRIMARY KEY (`codeLangue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `langue`
--

INSERT INTO `langue` (`codeLangue`, `nom`, `lienDrapeau`) VALUES
('EN', 'Anglais', 'images/drapeau-anglais.png'),
('FR', 'Francais', '../Emolyse/images/drapeau-francais.png'),
('IT', 'Italien', 'images/drapeau-italien.png');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `idParticipant` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(45) COLLATE utf8_bin NOT NULL,
  `naissance` date NOT NULL,
  `sexe` varchar(45) COLLATE utf8_bin NOT NULL,
  `lienPhoto` varchar(500) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idParticipant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`idParticipant`, `nom`, `prenom`, `naissance`, `sexe`, `lienPhoto`) VALUES
(1, 'Arnaud', 'Alizee', '1992-08-31', 'F', '');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL AUTO_INCREMENT,
  `idExperience` int(11) NOT NULL,
  `position` int(2) NOT NULL,
  `nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `lienPhoto` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idProduit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=132 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `idExperience`, `position`, `nom`, `lienPhoto`) VALUES
(25, 8, 0, '05', 'images/imgExperience/05.jpg'),
(60, 16, 4, '13', 'images/imgExperience/13.jpg'),
(75, 16, 2, '39', 'images/imgExperience/39.jpg'),
(119, 17, 3, '05', 'images/imgExperience/05.jpg'),
(124, 17, 0, '03', 'images/imgExperience/03.jpg'),
(126, 17, 0, '06', 'images/imgExperience/06.jpg'),
(131, 20, 0, '05', 'images/imgExperience/05.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE IF NOT EXISTS `resultat` (
  `idResultat` int(11) NOT NULL AUTO_INCREMENT,
  `idProduit` int(11) NOT NULL,
  `idParticipant` int(11) NOT NULL,
  `idAvatar` int(11) NOT NULL,
  `angleBG` float NOT NULL,
  `angleBD` float NOT NULL,
  `angleBuste` float NOT NULL,
  `distance` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idResultat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `traduction`
--

CREATE TABLE IF NOT EXISTS `traduction` (
  `codeLangue` varchar(2) NOT NULL,
  `codeIdentifiant` varchar(45) NOT NULL,
  `traduction` mediumtext NOT NULL,
  PRIMARY KEY (`codeLangue`,`codeIdentifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `traduction`
--

INSERT INTO `traduction` (`codeLangue`, `codeIdentifiant`, `traduction`) VALUES
('EN', 'AFFICHAGE_ALEATOIRE_OBJETS', 'Random'),
('EN', 'AGE', 'Age'),
('EN', 'AJOUTER', 'Add'),
('EN', 'ANGLAIS', 'English'),
('EN', 'BTN_EXPERIENCES', 'Experiences'),
('EN', 'BTN_EXPERIMENTATEUR_HOME', 'Experimenter'),
('EN', 'BTN_PARAMETRES', 'Settings'),
('EN', 'BTN_PARTICIPANTS', 'Participants'),
('EN', 'BTN_PARTICIPANT_HOME', 'Participant'),
('EN', 'CHAMPS_OBLIGATOIRE', 'Required Fields'),
('EN', 'CHOISIR_LA_LANGUE', 'Select language'),
('EN', 'CONSIGNE', 'Order'),
('EN', 'DEMARRER', 'Start'),
('EN', 'EDITER_LA_CONSIGNE', 'Edit the set'),
('EN', 'ENVIRONNEMENT', 'Environment'),
('EN', 'EXPERIENCE', 'Experience'),
('EN', 'EXPERIENCE_TERMINEE', 'Experience complete'),
('EN', 'FEMME', 'Woman'),
('EN', 'FINALISATION', 'Finalization'),
('EN', 'FINALISER', 'Finish'),
('EN', 'FRANCAIS', 'French'),
('EN', 'HOMME', 'Man'),
('EN', 'ID', 'Id'),
('EN', 'IDENTIFIANT', 'Login'),
('EN', 'LANGUE', 'Language'),
('EN', 'MODIFIER', 'Update'),
('EN', 'NEE_LE', 'Born'),
('EN', 'NOM', 'Name'),
('EN', 'NOUVELLE_EXPERIENCE', 'New experience'),
('EN', 'OBJETS', 'Objects'),
('EN', 'PRENOM', 'Firstname'),
('EN', 'SEXE', 'Sex'),
('EN', 'TEXT_CONSIGNE', 'Une consigne en anglais yeah !'),
('FR', 'AFFICHAGE_ALEATOIRE_OBJETS', 'Aléatoire'),
('FR', 'AGE', 'Age'),
('FR', 'AJOUTER', 'Ajouter'),
('FR', 'ANGLAIS', 'Anglais'),
('FR', 'BTN_EXPERIENCES', 'Expériences'),
('FR', 'BTN_EXPERIMENTATEUR_HOME', 'Expérimentateur'),
('FR', 'BTN_PARAMETRES', 'Paramètres'),
('FR', 'BTN_PARTICIPANTS', 'Participants'),
('FR', 'BTN_PARTICIPANT_HOME', 'Participant'),
('FR', 'CHAMPS_OBLIGATOIRE', 'Champs Obligatoires'),
('FR', 'CHOISIR_LA_LANGUE', 'Choisir la langue'),
('FR', 'CONSIGNE', 'Consigne en francais'),
('FR', 'DEMARRER', 'Démarrer'),
('FR', 'EDITER_LA_CONSIGNE', 'Editer la consigne'),
('FR', 'ENVIRONNEMENT', 'Environnement'),
('FR', 'EXPERIENCE', 'Expérience'),
('FR', 'EXPERIENCE_TERMINEE', 'Expérience terminée'),
('FR', 'FEMME', 'Femme'),
('FR', 'FINALISATION', 'Finalisation'),
('FR', 'FINALISER', 'Finaliser'),
('FR', 'FRANCAIS', 'Français'),
('FR', 'HOMME', 'Homme'),
('FR', 'ID', 'Id'),
('FR', 'IDENTIFIANT', 'Identifiant'),
('FR', 'LANGUE', 'Langue'),
('FR', 'MODIFIER', 'Modifier'),
('FR', 'NEE_LE', 'Né(e) le'),
('FR', 'NOM', 'Nom'),
('FR', 'NOUVELLE_EXPERIENCE', 'Nouvelle expérience'),
('FR', 'OBJETS', 'Objets'),
('FR', 'PRENOM', 'Prénom'),
('FR', 'SEXE', 'Sexe'),
('FR', 'TEXT_CONSIGNE', 'Consigne en fran?ais                          '),
('IT', 'AFFICHAGE_ALEATOIRE_OBJETS', ''),
('IT', 'AGE', ''),
('IT', 'AJOUTER', 'Add'),
('IT', 'ANGLAIS', 'Inglese'),
('IT', 'BTN_EXPERIENCES', ''),
('IT', 'BTN_EXPERIMENTATEUR_HOME', ''),
('IT', 'BTN_PARAMETRES', ''),
('IT', 'BTN_PARTICIPANTS', ''),
('IT', 'BTN_PARTICIPANT_HOME', ''),
('IT', 'CHAMPS_OBLIGATOIRE', ''),
('IT', 'CHOISIR_LA_LANGUE', ''),
('IT', 'CONSIGNE', ''),
('IT', 'DEMARRER', ''),
('IT', 'EDITER_LA_CONSIGNE', ''),
('IT', 'ENVIRONNEMENT', ''),
('IT', 'EXPERIENCE', ''),
('IT', 'EXPERIENCE_TERMINEE', ''),
('IT', 'FEMME', ''),
('IT', 'FINALISATION', ''),
('IT', 'FINALISER', ''),
('IT', 'FRANCAIS', ''),
('IT', 'HOMME', ''),
('IT', 'ID', ''),
('IT', 'IDENTIFIANT', ''),
('IT', 'LANGUE', ''),
('IT', 'MODIFIER', ''),
('IT', 'NEE_LE', ''),
('IT', 'NOM', ''),
('IT', 'NOUVELLE_EXPERIENCE', ''),
('IT', 'OBJETS', ''),
('IT', 'PRENOM', ''),
('IT', 'SEXE', ''),
('IT', 'TEXT_CONSIGNE', 'consigne en italien !');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

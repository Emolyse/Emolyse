-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 02 Juin 2015 à 09:51
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Contenu de la table `environnement`
--

INSERT INTO `environnement` (`idEnvironnement`, `nom`, `lienEnvironnement`) VALUES
(1, 'salon', 'img/salon_2.jpg'),
(2, 'Salle d''attente', 'img/salle_dattente.jpg');

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
(16, 1, 'Expérience en italien', 'changement de la consigne pour exp 16 !!', 4, 'EN', 1, 1),
(17, 1, 'test', 'test de la consigne en franÃ§ais', 1, 'FR', 0, 0),
(20, 1, 'test drat', 'Order bla', 1, 'FR', 0, 1),
(22, 1, 'test position', '', 2, 'EN', 0, 1);

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
('AFFICHAGE_SYNCRO_BRAS', ''),
('AGE', ''),
('AJOUTER', ''),
('ANGLAIS', ''),
('AOUT', ''),
('AVRIL', ''),
('BTN_EXPERIENCES', ''),
('BTN_EXPERIMENTATEUR_HOME', ''),
('BTN_PARAMETRES', ''),
('BTN_PARTICIPANTS', ''),
('BTN_PARTICIPANT_HOME', ''),
('CHAMPS_OBLIGATOIRE', ''),
('CHOISIR_LA_LANGUE', ''),
('CONSIGNE', ''),
('DECEMBRE', ''),
('DEMARRER', ''),
('EDITER_LA_CONSIGNE', ''),
('ENVIRONNEMENT', ''),
('EXPERIENCE', ''),
('EXPERIENCE_TERMINEE', ''),
('FEMME', ''),
('FEVRIER', ''),
('FINALISATION', ''),
('FINALISER', ''),
('FRANCAIS', ''),
('HOMME', ''),
('ID', ''),
('IDENTIFIANT', ''),
('JANVIER', ''),
('JUILLET', ''),
('JUIN', ''),
('LANGUE', ''),
('MAI', ''),
('MARS', ''),
('MODIFIER', ''),
('NEE_LE', ''),
('NOM', ''),
('NOUVELLE_EXPERIENCE', ''),
('NOVEMBRE', ''),
('OBJETS', ''),
('OCTOBRE', ''),
('PRENOM', ''),
('SEPTEMBRE', ''),
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
('FR', 'Francais', '../Emolyse/images/drapeau-francais.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`idParticipant`, `nom`, `prenom`, `naissance`, `sexe`, `lienPhoto`) VALUES
(1, 'ARNAUD', 'Alizee', '1992-08-31', 'F', ''),
(2, 'DROUET', 'Rémy', '1992-01-12', 'H', ''),
(3, 'DAITA', 'Jordan', '1993-02-15', 'H', ''),
(6, 'sujet-6', '', '1947-06-03', 'F', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=199 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `idExperience`, `position`, `nom`, `lienPhoto`) VALUES
(25, 8, 0, '05', 'images/imgExperience/05.jpg'),
(158, 20, 1, '18', 'images/imgExperience/18.jpg'),
(165, 22, 2, 'wallpaper-2112045', 'images/imgExperience/wallpaper-2112045.jpg'),
(170, 22, 7, 'wallpaper-3027963', 'images/imgExperience/wallpaper-3027963.jpg'),
(188, 17, 1, '18', 'images/imgExperience/18.jpg'),
(192, 16, 1, '17', 'images/imgExperience/17.jpg'),
(193, 16, 2, '18', 'images/imgExperience/18.jpg'),
(194, 16, 3, '19', 'images/imgExperience/19.jpg'),
(195, 16, 4, '20', 'images/imgExperience/20.jpg');

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
(75, 4, 'H', 0, 0, 0, 0, 0, 170, '2015-06-02'),
(192, 10, 'M', 0, 0, 0, 0, 0, 246, '2015-06-02'),
(193, 10, 'M', 0, 0, 0, 0, 0, 140, '2015-06-02'),
(194, 10, 'M', 59.3072, 0, 59.3072, 0, 0, 170, '2015-06-02'),
(195, 10, 'M', 0, 0, 0, 0, 0, 170, '2015-06-02');

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
('EN', 'AFFICHAGE_SYNCRO_BRAS', 'Syncro'),
('EN', 'AGE', 'Age'),
('EN', 'AJOUTER', 'Add'),
('EN', 'ANGLAIS', 'English'),
('EN', 'AOUT', 'August'),
('EN', 'AVRIL', 'April'),
('EN', 'BTN_EXPERIENCES', 'Experiences'),
('EN', 'BTN_EXPERIMENTATEUR_HOME', 'Experimenter'),
('EN', 'BTN_PARAMETRES', 'Settings'),
('EN', 'BTN_PARTICIPANTS', 'Participants'),
('EN', 'BTN_PARTICIPANT_HOME', 'Participant'),
('EN', 'CHAMPS_OBLIGATOIRE', 'Required Fields'),
('EN', 'CHOISIR_LA_LANGUE', 'Select language'),
('EN', 'CONSIGNE', 'Instruction'),
('EN', 'DECEMBRE', 'December'),
('EN', 'DEMARRER', 'Start'),
('EN', 'EDITER_LA_CONSIGNE', 'Edit the instruction'),
('EN', 'ENVIRONNEMENT', 'Environment'),
('EN', 'EXPERIENCE', 'Experience'),
('EN', 'EXPERIENCE_TERMINEE', 'Experience complete'),
('EN', 'FEMME', 'Woman'),
('EN', 'FEVRIER', 'February'),
('EN', 'FINALISATION', 'Finalization'),
('EN', 'FINALISER', 'Finish'),
('EN', 'FRANCAIS', 'French'),
('EN', 'HOMME', 'Man'),
('EN', 'ID', 'Id'),
('EN', 'IDENTIFIANT', 'Login'),
('EN', 'JANVIER', 'January'),
('EN', 'JUILLET', 'July'),
('EN', 'JUIN', 'June'),
('EN', 'LANGUE', 'Language'),
('EN', 'MAI', 'May'),
('EN', 'MARS', 'March'),
('EN', 'MODIFIER', 'Update'),
('EN', 'NEE_LE', 'Born'),
('EN', 'NOM', 'Name'),
('EN', 'NOUVELLE_EXPERIENCE', 'New experience'),
('EN', 'NOVEMBRE', 'November'),
('EN', 'OBJETS', 'Objects'),
('EN', 'OCTOBRE', 'October'),
('EN', 'PRENOM', 'Firstname'),
('EN', 'SEPTEMBRE', 'September'),
('EN', 'SEXE', 'Sex'),
('EN', 'TEXT_CONSIGNE', 'Une consigne en anglais'),
('FR', 'AFFICHAGE_ALEATOIRE_OBJETS', 'Aléatoire'),
('FR', 'AFFICHAGE_SYNCRO_BRAS', 'Synchronisation des bras'),
('FR', 'AGE', 'Age'),
('FR', 'AJOUTER', 'Ajouter'),
('FR', 'ANGLAIS', 'Anglais'),
('FR', 'AOUT', 'Août'),
('FR', 'AVRIL', 'Avril'),
('FR', 'BTN_EXPERIENCES', 'Expériences'),
('FR', 'BTN_EXPERIMENTATEUR_HOME', 'Expérimentateur'),
('FR', 'BTN_PARAMETRES', 'Paramètres'),
('FR', 'BTN_PARTICIPANTS', 'Participants'),
('FR', 'BTN_PARTICIPANT_HOME', 'Participant'),
('FR', 'CHAMPS_OBLIGATOIRE', 'Champs Obligatoires'),
('FR', 'CHOISIR_LA_LANGUE', 'Choisir la langue'),
('FR', 'CONSIGNE', 'Consigne'),
('FR', 'DECEMBRE', 'Décembre'),
('FR', 'DEMARRER', 'Démarrer'),
('FR', 'EDITER_LA_CONSIGNE', 'Editer la consigne'),
('FR', 'ENVIRONNEMENT', 'Environnement'),
('FR', 'EXPERIENCE', 'Expérience'),
('FR', 'EXPERIENCE_TERMINEE', 'Expérience terminée'),
('FR', 'FEMME', 'Femme'),
('FR', 'FEVRIER', 'Février'),
('FR', 'FINALISATION', 'Finalisation'),
('FR', 'FINALISER', 'Finaliser'),
('FR', 'FRANCAIS', 'Français'),
('FR', 'HOMME', 'Homme'),
('FR', 'ID', 'Id'),
('FR', 'IDENTIFIANT', 'Identifiant'),
('FR', 'JANVIER', 'Janvier'),
('FR', 'JUILLET', 'Juillet'),
('FR', 'JUIN', 'Juin'),
('FR', 'LANGUE', 'Langue'),
('FR', 'MAI', 'Mai'),
('FR', 'MARS', 'Mars'),
('FR', 'MODIFIER', 'Modifier'),
('FR', 'NEE_LE', 'Né(e) le'),
('FR', 'NOM', 'Nom'),
('FR', 'NOUVELLE_EXPERIENCE', 'Nouvelle expérience'),
('FR', 'NOVEMBRE', 'Novembre'),
('FR', 'OBJETS', 'Objets'),
('FR', 'OCTOBRE', 'Octobre'),
('FR', 'PRENOM', 'Prénom'),
('FR', 'SEPTEMBRE', 'Septembre'),
('FR', 'SEXE', 'Sexe'),
('FR', 'TEXT_CONSIGNE', 'Consigne en francais pour test             ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

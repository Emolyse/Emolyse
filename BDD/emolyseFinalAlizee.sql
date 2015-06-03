-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 03 Juin 2015 à 15:36
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
-- Structure de la table `environnement`
--

CREATE TABLE IF NOT EXISTS `environnement` (
  `idEnvironnement` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lienEnvironnement` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEnvironnement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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
  `nom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `consigne` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `nbProduit` int(11) NOT NULL,
  `codeLangue` varchar(2) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `syncroBras` tinyint(1) NOT NULL,
  `random` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExperience`),
  KEY `idEnvironnement` (`idEnvironnement`),
  KEY `codeLangue` (`codeLangue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`idExperience`, `idEnvironnement`, `nom`, `consigne`, `nbProduit`, `codeLangue`, `syncroBras`, `random`) VALUES
(16, 2, 'Expérience en italien', 'changement de la consigne pour exp 16 !!', 1, 'EN', 0, 1),
(17, 1, 'test', 'test de la consigne en franÃ§ais', 0, 'FR', 0, 0),
(20, 1, 'test drat', 'Order bla', 1, 'FR', 0, 1),
(22, 1, 'test position', '', 1, 'EN', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `identifiant`
--

CREATE TABLE IF NOT EXISTS `identifiant` (
  `codeIdentifiant` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`codeIdentifiant`),
  KEY `codeIdentifiant` (`codeIdentifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `identifiant`
--

INSERT INTO `identifiant` (`codeIdentifiant`, `description`) VALUES
('AFFICHAGE_ALEATOIRE_OBJETS', ''),
('AFFICHAGE_SYNCRO_BRAS', ''),
('AGE', ''),
('AJOUTER', ''),
('AJOUTER_UN_DRAPEAU', ''),
('AJOUTER_UNE_LANGUE', ''),
('ANGLAIS', ''),
('AOUT', ''),
('AVRIL', ''),
('BTN_EXPERIENCES', ''),
('BTN_EXPERIMENTATEUR_HOME', ''),
('BTN_PARAMETRES', ''),
('BTN_PARTICIPANT_HOME', ''),
('BTN_PARTICIPANTS', ''),
('CHAMPS_OBLIGATOIRE', ''),
('CHOISIR_LA_LANGUE', ''),
('CODE_LANGUE', ''),
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
('MODIFIER_CONSIGNE_PAR_DEFAUT', ''),
('MODIFIER_LA_CONSIGNE', ''),
('NEE_LE', ''),
('NOM', ''),
('NOM_DE_LA_LANGUE', ''),
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
  `codeLangue` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lienDrapeau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`codeLangue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `langue`
--

INSERT INTO `langue` (`codeLangue`, `nom`, `lienDrapeau`) VALUES
('EN', 'Anglais', 'images/drapeau-anglais.png'),
('FR', 'Francais', 'images/drapeau-francais.png');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `idParticipant` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `naissance` date NOT NULL,
  `sexe` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lienPhoto` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idParticipant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`idParticipant`, `nom`, `prenom`, `naissance`, `sexe`, `lienPhoto`) VALUES
(1, 'ARNAUD', 'Alizee', '1992-08-31', 'F', ''),
(2, 'DROUET', 'Rémy', '1992-01-12', 'H', ''),
(3, 'DAITA', 'Jordan', '1993-02-15', 'H', ''),
(6, 'sujet-6', '', '1947-06-03', 'F', ''),
(14, 'Julie', 'routaud', '1991-03-04', 'F', ''),
(15, 'ARNAUD', 'Alizée', '1992-08-31', 'F', 'images/imgUsers/10913092_10205979193705612_1900876804_n.jpg'),
(16, 'toto', 'toto', '1999-11-14', 'F', '');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL AUTO_INCREMENT,
  `idExperience` int(11) NOT NULL,
  `position` int(2) NOT NULL,
  `nom` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lienPhoto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idProduit`),
  KEY `idExperience` (`idExperience`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=214 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `idExperience`, `position`, `nom`, `lienPhoto`) VALUES
(212, 16, 1, '01', 'images/imgExperience/16-01.png');

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE IF NOT EXISTS `resultat` (
  `idProduit` int(11) NOT NULL,
  `idParticipant` int(11) NOT NULL,
  `idExperience` int(11) NOT NULL,
  `genreAvatar` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `angleAvatar` float NOT NULL,
  `angleBGx` float NOT NULL,
  `angleBGz` float NOT NULL,
  `angleBDx` float NOT NULL,
  `angleBDz` float NOT NULL,
  `angleBuste` float NOT NULL,
  `distance` float NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idProduit`,`idParticipant`,`idExperience`),
  KEY `idParticipant` (`idParticipant`),
  KEY `idExperience` (`idExperience`),
  KEY `idProduit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `resultat`
--

INSERT INTO `resultat` (`idProduit`, `idParticipant`, `idExperience`, `genreAvatar`, `angleAvatar`, `angleBGx`, `angleBGz`, `angleBDx`, `angleBDz`, `angleBuste`, `distance`, `date`) VALUES
(212, 16, 16, 'F', 0, 31.6976, 0, 62.3127, 0, 0, 170, '2015-06-03');

-- --------------------------------------------------------

--
-- Structure de la table `traduction`
--

CREATE TABLE IF NOT EXISTS `traduction` (
  `codeLangue` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `codeIdentifiant` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `traduction` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`codeLangue`,`codeIdentifiant`),
  KEY `fk_codeIdentifiant` (`codeIdentifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `traduction`
--

INSERT INTO `traduction` (`codeLangue`, `codeIdentifiant`, `traduction`) VALUES
('EN', 'AFFICHAGE_ALEATOIRE_OBJETS', 'Random'),
('EN', 'AFFICHAGE_SYNCRO_BRAS', 'Syncro'),
('EN', 'AGE', 'Age'),
('EN', 'AJOUTER', 'Add'),
('EN', 'AJOUTER_UN_DRAPEAU', 'Add flag'),
('EN', 'AJOUTER_UNE_LANGUE', 'Add language'),
('EN', 'ANGLAIS', 'English'),
('EN', 'AOUT', 'August'),
('EN', 'AVRIL', 'April'),
('EN', 'BTN_EXPERIENCES', 'Experiences'),
('EN', 'BTN_EXPERIMENTATEUR_HOME', 'Experimenter'),
('EN', 'BTN_PARAMETRES', 'Settings'),
('EN', 'BTN_PARTICIPANT_HOME', 'Participant'),
('EN', 'BTN_PARTICIPANTS', 'Participants'),
('EN', 'CHAMPS_OBLIGATOIRE', 'Required Fields'),
('EN', 'CHOISIR_LA_LANGUE', 'Select language'),
('EN', 'CODE_LANGUE', 'Language code'),
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
('EN', 'MODIFIER_CONSIGNE_PAR_DEFAUT', 'Update default instruction'),
('EN', 'MODIFIER_LA_CONSIGNE', 'Update instruction'),
('EN', 'NEE_LE', 'Born'),
('EN', 'NOM', 'Name'),
('EN', 'NOM_DE_LA_LANGUE', 'Language name'),
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
('FR', 'AJOUTER_UN_DRAPEAU', 'Ajouter un drapeau'),
('FR', 'AJOUTER_UNE_LANGUE', 'Ajouter une langue'),
('FR', 'ANGLAIS', 'Anglais'),
('FR', 'AOUT', 'Août'),
('FR', 'AVRIL', 'Avril'),
('FR', 'BTN_EXPERIENCES', 'Expériences'),
('FR', 'BTN_EXPERIMENTATEUR_HOME', 'Expérimentateur'),
('FR', 'BTN_PARAMETRES', 'Paramètres'),
('FR', 'BTN_PARTICIPANT_HOME', 'Participant'),
('FR', 'BTN_PARTICIPANTS', 'Participants'),
('FR', 'CHAMPS_OBLIGATOIRE', 'Champs Obligatoires'),
('FR', 'CHOISIR_LA_LANGUE', 'Choisir la langue'),
('FR', 'CODE_LANGUE', 'Code langue'),
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
('FR', 'MODIFIER_CONSIGNE_PAR_DEFAUT', 'Modifier la consigne par défaut'),
('FR', 'MODIFIER_LA_CONSIGNE', 'Modifier la consigne'),
('FR', 'NEE_LE', 'Né(e) le'),
('FR', 'NOM', 'Nom'),
('FR', 'NOM_DE_LA_LANGUE', 'Nom de la langue'),
('FR', 'NOUVELLE_EXPERIENCE', 'Nouvelle expérience'),
('FR', 'NOVEMBRE', 'Novembre'),
('FR', 'OBJETS', 'Objets'),
('FR', 'OCTOBRE', 'Octobre'),
('FR', 'PRENOM', 'Prénom'),
('FR', 'SEPTEMBRE', 'Septembre'),
('FR', 'SEXE', 'Sexe'),
('FR', 'TEXT_CONSIGNE', 'Consigne en francais pour test             ');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `fk_exp_env` FOREIGN KEY (`idEnvironnement`) REFERENCES `environnement` (`idEnvironnement`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_experience_prod` FOREIGN KEY (`idExperience`) REFERENCES `experience` (`idExperience`);

--
-- Contraintes pour la table `resultat`
--
ALTER TABLE `resultat`
  ADD CONSTRAINT `fk_experience` FOREIGN KEY (`idExperience`) REFERENCES `experience` (`idExperience`),
  ADD CONSTRAINT `fk_participant` FOREIGN KEY (`idParticipant`) REFERENCES `participant` (`idParticipant`),
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `traduction`
--
ALTER TABLE `traduction`
  ADD CONSTRAINT `fk_codeIdentifiant` FOREIGN KEY (`codeIdentifiant`) REFERENCES `identifiant` (`codeIdentifiant`),
  ADD CONSTRAINT `fk_codeLangue` FOREIGN KEY (`codeLangue`) REFERENCES `langue` (`codeLangue`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

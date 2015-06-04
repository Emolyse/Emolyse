-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 04 Juin 2015 à 11:43
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
  `codeLangue` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `syncroBras` tinyint(1) NOT NULL,
  `random` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExperience`),
  KEY `idEnvironnement` (`idEnvironnement`),
  KEY `codeLangue` (`codeLangue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`idExperience`, `idEnvironnement`, `nom`, `consigne`, `nbProduit`, `codeLangue`, `syncroBras`, `random`) VALUES
(16, 2, 'Expérience en italien', 'changement de la consigne pour exp 16 !!', 1, 'EN', 0, 1),
(19, 1, 'Bla', '', 3, 'FR', 1, 0);

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
('CHARGEMENT_APPLI', ''),
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
('PHRASE_FIN', ''),
('PRENOM', ''),
('SEPTEMBRE', ''),
('SEXE', ''),
('TEXT_CONSIGNE', ''),
('TUTO_0', ''),
('TUTO_1', ''),
('TUTO_10', ''),
('TUTO_11', ''),
('TUTO_12', ''),
('TUTO_13', ''),
('TUTO_14', ''),
('TUTO_15', ''),
('TUTO_16', ''),
('TUTO_17', ''),
('TUTO_18', ''),
('TUTO_19', ''),
('TUTO_2', ''),
('TUTO_20', ''),
('TUTO_3', ''),
('TUTO_4', ''),
('TUTO_5', ''),
('TUTO_6', ''),
('TUTO_7', ''),
('TUTO_8', ''),
('TUTO_9', ''),
('TUTORIEL', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

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
(16, 'toto', 'toto', '1999-11-14', 'F', ''),
(17, 'sujet-17', '', '2013-03-03', 'H', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=218 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `idExperience`, `position`, `nom`, `lienPhoto`) VALUES
(213, 19, 1, '20-objet-publicitaire-stylo-bleu_icy', 'images/imgExperience/19-20-objet-publicitaire-stylo-bleu_icy.jpg'),
(214, 19, 2, '22-votre-objet-publicitaire-parapluie-bordeau', 'images/imgExperience/19-22-votre-objet-publicitaire-parapluie-bordeaux.jpg'),
(216, 19, 3, 'pad-ps3-rendu', 'images/imgExperience/19-pad-ps3-rendu.jpg'),
(217, 16, 1, 'pad-ps3-rendu', 'images/imgExperience/16-pad-ps3-rendu.jpg');

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
(217, 17, 16, 'F', 0, 0, 0, 0, 0, 0, 170, '2015-06-04');

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
('EN', 'CHARGEMENT_APPLI', 'Loading the app'),
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
('EN', 'PHRASE_FIN', 'Now you will complete your participation profile'),
('EN', 'PRENOM', 'Firstname'),
('EN', 'SEPTEMBRE', 'September'),
('EN', 'SEXE', 'Sex'),
('EN', 'TEXT_CONSIGNE', 'Une consigne en anglais'),
('EN', 'TUTO_0', 'Let''s see how to rotate arms'),
('EN', 'TUTO_1', 'There are 2 different ways to rotate them'),
('EN', 'TUTO_10', 'Move the sphere on his feet across the width'),
('EN', 'TUTO_11', 'Well Done ! Finally you can move the avatar across the width'),
('EN', 'TUTO_12', 'To do it draw a horizontal line with your finger'),
('EN', 'TUTO_13', 'Congratulations ! Now you know how to manipulate the avatar'),
('EN', 'TUTO_14', 'Tips : At any moment you can reset the avatar position'),
('EN', 'TUTO_15', 'Push the reset button on the left bottom corner of the screen'),
('EN', 'TUTO_16', 'Free Mode : You are free to manipulate the avatar'),
('EN', 'TUTO_17', 'When you are down, start the experience by pushing on the right bottom button'),
('EN', 'TUTO_18', 'Good luck !'),
('EN', 'TUTO_19', 'Welcome to the tutorial'),
('EN', 'TUTO_2', '1 : Profile rotation'),
('EN', 'TUTO_20', 'We will see how to handle the avatar in a few steps'),
('EN', 'TUTO_3', 'Put your avatar profile ...'),
('EN', 'TUTO_4', '... and move his hands to rotate his arms'),
('EN', 'TUTO_5', 'Well Done ! Now the second rotation'),
('EN', 'TUTO_6', '2 : To Part arms, put him back or face'),
('EN', 'TUTO_7', 'Well Done ! You can also rotate the body'),
('EN', 'TUTO_8', 'To do that, grab the head and move it'),
('EN', 'TUTO_9', 'Well Done ! Let''s see how to rotate the entire avatar'),
('EN', 'TUTORIEL', 'Tutorial'),
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
('FR', 'CHARGEMENT_APPLI', 'Chargement de l''application'),
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
('FR', 'PHRASE_FIN', 'Vous allez maintenant compléter votre profil afin de finaliser votre participation'),
('FR', 'PRENOM', 'Prénom'),
('FR', 'SEPTEMBRE', 'Septembre'),
('FR', 'SEXE', 'Sexe'),
('FR', 'TEXT_CONSIGNE', 'Consigne en francais pour test             '),
('FR', 'TUTO_0', 'Voyons comment faire pivoter les bras'),
('FR', 'TUTO_1', 'Il y a 2 rotations différentes possibles'),
('FR', 'TUTO_10', 'Déplacer dans la largeur la sphère située à ses pieds'),
('FR', 'TUTO_11', 'Bravo ! Enfin, vous pouvez déplacer l''avatar sur la largeur'),
('FR', 'TUTO_12', 'Pour cela traçez une ligne horizontale avec votre doigt'),
('FR', 'TUTO_13', 'Félicitations ! Vous savez maintenant manipuler l''avatar'),
('FR', 'TUTO_14', 'Astuce : A tout moment vous pouvez restorer la position initiale de l''avatar'),
('FR', 'TUTO_15', 'Appuyez sur le bouton "Restorer" dans le coin en bas à gauche de votre écran'),
('FR', 'TUTO_16', 'Mode libre : Vous pouvez manipuler l''avatar à votre guise'),
('FR', 'TUTO_17', 'Lorsque vous aurez fini, débutez l''expérience en appuyant sur le bouton en bas à droite'),
('FR', 'TUTO_18', 'Bonne chance !'),
('FR', 'TUTO_19', 'Bienvenue dans le tutoriel'),
('FR', 'TUTO_2', '1 : Rotation de profil'),
('FR', 'TUTO_20', 'Nous allons voir comment manipuler l''avatar en quelques étapes'),
('FR', 'TUTO_3', 'Positionnez votre avatar de profil ...'),
('FR', 'TUTO_4', '...et déplacez sa main pour faire pivoter le bras'),
('FR', 'TUTO_5', 'Bravo ! Maintenant l''autre rotation'),
('FR', 'TUTO_6', '2 : Pour écartez les bras, positionnez l''avatar de dos ou de face'),
('FR', 'TUTO_7', 'Bravo ! Vous pouvez aussi incliner le buste'),
('FR', 'TUTO_8', 'Pour cela, appliquer la rotation en appuyant sur la tête'),
('FR', 'TUTO_9', 'Bravo ! Voyons comment faire tourner l''avatar'),
('FR', 'TUTORIEL', 'Tutoriel');

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

<?php
session_start();
include("init.php");
include("connexion.php");
include("lang.php");

$filename = filter_input(INPUT_POST, 'filename');

if (isset($filename)) {
    add_picture();
}

function add_picture() {
    $filename = filter_input(INPUT_POST, 'filename');

    $name = md5(rand().time()."DuSelPourRenforcerMonHash").'.png';

    $encodedData = str_replace(' ','+',$filename);
    $decodedData = base64_decode($encodedData);

    file_put_contents('../images/'.$name, $decodedData) ;
    return TRUE;
}

// Ajout d'une langue avec ajout de tous les champs pour cette nouvelle langue dans la table des traductions
if(isset($_POST['ajoutLangue'])){
    $codeLangue = $_POST['codeLangue'];
    $nom = $_POST['nom'];
    $lienDrapeau = $_POST['lienDrapeau'];

    if($codeLangue != '' && $nom != ''){

        $requete = "INSERT INTO langue VALUES ('".$codeLangue."', '".$nom."', '".$lienDrapeau."')";
        $base->query($requete);

        // à décommenter (ajout de tous les champs dans la table des traductions)
        $requeteId = "SELECT * FROM identifiant";
        $resultatsId = $base->query($requeteId);
        while($resultatId = $resultatsId->fetch_array()){
            $requeteTradDefaut = "SELECT traduction FROM traduction WHERE codeLangue='EN' AND codeIdentifiant='".$resultatId['codeIdentifiant']."'";
            $resultatsTradDefaut = $base->query($requeteTradDefaut);
            while($resultatTradDefaut = $resultatsTradDefaut->fetch_array()){
                $requeteInsert = "INSERT INTO traduction VALUES ('".$codeLangue."', '".$resultatId['codeIdentifiant']."', '".$resultatTradDefaut['traduction']."')";
                $base->query($requeteInsert);
            }
        }

        $base->close();

        unset($codeLangue);
        unset($nom);
        unset($lienDrapeau);

    }else{
        header("Location: ../parametres.php");
    }

    header("Location: ../parametres.php");
}

// Modification de la consigne par défaut en fonction de la langue sélectionnée
if(isset($_POST['modifierConsigne'])){
    $consigne = $_POST['consigne'];
    $codeLangue = $_POST['codeLangue'];
    $codeIdentifiant = $_POST['codeIdentifiant'];

    $requete = "UPDATE traduction SET traduction='".$consigne."' WHERE codeLangue='".$codeLangue."' AND codeIdentifiant='".$codeIdentifiant."'";
    $base->query($requete);

    $base->close();

    unset($consigne);
    unset($codeLangue);
    unset($codeIdentifiant);

    header("Location: ../parametres.php");
}

// Modification de l'ordre des produits pour une expérience précise
if(isset($_GET['updateOrderList'])){
    $id = $_GET['id'];
    $order = $_GET['order'];

    $requete = "UPDATE produit SET position='".$order."' WHERE idProduit='".$id."'";
    $base->query($requete);

    $base->close();

    unset($id);
    unset($order);

    header("Location: ../gerer-experience.php");
}

// Suppression d'un produit avec le fichier photo correspondant, puis actualisation du nombre de produit pour l'expérience
if(isset($_GET['deleteProduit'])){
    $id = $_GET['id'];
    $idExperience = $_GET['idExperience'];

    $requete = "SELECT lienPhoto FROM produit WHERE idProduit='".$id."'";
    $resultats = $base->query($requete);
    while(($resultat = $resultats->fetch_array())){
        unlink("../".$resultat['lienPhoto']);
    }

    $requete = "DELETE FROM produit WHERE idProduit='".$id."'";
    $base->query($requete);

    // on compte le nombre de produits dans la base
    $requeteCountProduit = "SELECT * FROM produit WHERE idExperience=".$idExperience."";
    $resultatsCountProduit = $base->query($requeteCountProduit);

    $count = 0;
    while(($resultatsCountProduit->fetch_array())){
        $count++;
    }

    // on modifie la ligne de l'experience pour mettre à jour le nombre de produits
    $requeteUpdateNbProduit = "UPDATE experience SET nbProduit=".$count." WHERE idExperience=".$idExperience."";
    $base->query($requeteUpdateNbProduit);

    $base->close();

    unset($id);
    unset($idExperience);
    unset($count);

    header("Location: ../gerer-experience.php");
}

// Modification d'une expérience
if(isset($_GET['updateExperience'])){
    $element = $_GET['element'];
    $value = $_GET['value'];
    $id = $_GET['id'];

    $requete = "UPDATE experience SET ".$element."='".$value."' WHERE idExperience=".$id."";
    $base->query($requete);

    $base->close();;

    unset($element);
    unset($value);
    unset($id);
}

// Modification de la consigne d'une expérience
if(isset($_POST['modifierConsigneExperience'])){
    $consigne = $_POST['consigne'];
    $idExperience = $_POST['idExperience'];

    $requete = "UPDATE experience SET consigne='".$consigne."' WHERE idExperience=".$idExperience."";
    $base->query($requete);

    $base->close();

    header("Location: ../gerer-experience.php?id=$idExperience");

    unset($consigne);
    unset($idExperience);
}

// Suppression d'une expérience avec tous les produits correspondants
if(isset($_GET['deleteExp'])){
    $idExperience = $_GET['id'];

    $requeteSelect = "SELECT lienPhoto FROM produit WHERE idExperience=".$idExperience."";
    $resultatsSelect = $base->query($requeteSelect);
    while(($resultat = $resultatsSelect->fetch_array())){
        // on supprime les fichiers des produits
        unlink("../".$resultat['lienPhoto']);
    }

    $requete = "DELETE FROM experience WHERE idExperience=".$idExperience."";
    $base->query($requete);

    $requeteProduit = "DELETE FROM produit WHERE idExperience=".$idExperience."";
    $base->query($requeteProduit);

    $base->close();

    unset($idExperience);
}

// Enregistrement à la fin d'une expérience
if(isset($_POST['finaliser-experience'])){
    if(empty($_POST['jour']) || empty($_POST['mois']) || empty($_POST['annee'])){
        header("Location: ../finalisation.php?erreur=naissance");
    }elseif(empty($_POST['sexe'])){
        header("Location: ../finalisation.php?erreur=sexe");
    }else{
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $jour = $_POST['jour'];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $sexe = $_POST['sexe'];
        $lienPhoto = $_POST['lienPhotoUser'];

        $naissance = $annee."-".$mois."-".$jour;

        $requete = "INSERT INTO participant VALUES ('', '".$nom."', '".$prenom."', '".$naissance."', '".$sexe."', '".$lienPhoto."')";
        $base->query($requete);
        // Id de l'expérience qui vient d'être créée ////////////////////////
        $id = $base->insert_id;
        if($nom == ''){
            $requete = "UPDATE participant SET nom='sujet-".$id."' WHERE idParticipant=".$id."";
            $base->query($requete);
        }

        $base->close();

        unset($nom);
        unset($prenom);
        unset($jour);
        unset($mois);
        unset($annee);
        unset($sexe);
        unset($lienPhoto);
        unset($naissance);

        header("Location: ../index.php");
    }
}

if(isset($_POST['start-experience'])){
    $avatarSelection = $_POST['choixAvatar'];
    $id = $_POST['experience'];
    header("Location: ../experience.php?experience=".$id."&avatarselect=".$avatarSelection);
}

if(isset($_GET['deleteProduitListe'])){
    $idProduit = $_GET['id'];
    $idExperience = $_GET['idExperience'];

    $requete = "SELECT lienPhoto FROM produit WHERE idProduit='".$idProduit."'";
    $resultats = $base->query($requete);
    while(($resultat = $resultats->fetch_array())){
        unlink("../".$resultat['lienPhoto']);
    }

    $requete = "DELETE FROM produit WHERE idProduit='".$idProduit."'";
    $base->query($requete);

    // on compte le nombre de produits dans la base
    $requeteCountProduit = "SELECT * FROM produit WHERE idExperience=".$idExperience."";
    $resultatsCountProduit = $base->query($requeteCountProduit);

    $count = 0;
    while(($resultatsCountProduit->fetch_array())){
        $count++;
    }

    // on modifie la ligne de l'experience pour mettre à jour le nombre de produits
    $requeteUpdateNbProduit = "UPDATE experience SET nbProduit=".$count." WHERE idExperience=".$idExperience."";
    $base->query($requeteUpdateNbProduit);
}

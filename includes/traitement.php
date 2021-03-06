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

    $requete = "UPDATE traduction SET traduction='".addslashes($consigne)."' WHERE codeLangue='".$codeLangue."' AND codeIdentifiant='".$codeIdentifiant."'";
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

    $requeteSupData = "DELETE FROM resultat WHERE idProduit='".$id."'";
    $base->query($requeteSupData);

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

    $requete = "UPDATE experience SET ".$element."='".addslashes($value)."' WHERE idExperience=".$id."";
    $base->query($requete);

    $base->close();

    unset($element);
    unset($value);
    unset($id);
}

// Modification de la consigne d'une expérience
if(isset($_POST['modifierConsigneExperience'])){
    $consigne = $_POST['consigne'];
    $idExperience = $_POST['idExperience'];

    $requete = "UPDATE experience SET consigne='".addslashes($consigne)."' WHERE idExperience=".$idExperience."";
    $base->query($requete);

    $base->close();

    header("Location: ../gerer-experience.php?id=$idExperience");

    unset($consigne);
    unset($idExperience);
}

// Suppression d'une expérience avec tous les produits correspondants, les résultats et les participants
if(isset($_GET['deleteExp'])){
    $idExperience = $_GET['id'];

    $requeteSelect = "SELECT lienPhoto FROM produit WHERE idExperience=".$idExperience."";
    $resultatsSelect = $base->query($requeteSelect);
    while(($resultat = $resultatsSelect->fetch_array())){
        // on supprime les fichiers des produits
        unlink("../".$resultat['lienPhoto']);
    }

    $requeteParticipant = "SELECT idParticipant FROM resultat WHERE idExperience=".$idExperience;
    $resultatsParticipant = $base->query($requeteParticipant);

    $requeteSupData = "DELETE FROM resultat WHERE idExperience=".$idExperience;
    $base->query($requeteSupData);

    while($resultatParticipant = $resultatsParticipant->fetch_array()) {
        $deleteParticipant = "DELETE FROM participant WHERE idParticipant=".$resultatParticipant['idParticipant'];
        $base->query($deleteParticipant);
    }

    $requeteProduit = "DELETE FROM produit WHERE idExperience=".$idExperience;
    $base->query($requeteProduit);

    $requete = "DELETE FROM experience WHERE idExperience=".$idExperience;
    $base->query($requete);

    $base->close();

    unset($idExperience);
}

// Enregistrement à la fin d'une expérience
if(isset($_POST['finaliser-experience'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $jour = $_POST['jour'];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        $sexe = $_POST['sexe'];
        $lienPhoto = $_POST['lienPhotoUser'];
        $data = json_decode($_POST['data']);
        $sexeAvatar = $data[0]->sexeAvatar;
        $idExperience = $data[0]->idExperience;

        $naissance = $annee."-".$mois."-".$jour;

        $requete = "INSERT INTO participant VALUES ('', '".$nom."', '".$prenom."', '".$naissance."', '".$sexe."', '".$lienPhoto."')";
        $base->query($requete);
        // Id de l'expérience qui vient d'être créée ////////////////////////
        $id = $base->insert_id;
        if($nom == ''){
            $requete = "UPDATE participant SET nom='sujet-".$id."' WHERE idParticipant=".$id."";
            $base->query($requete);
        }

        for($i = 0 ; $i < count($data) ; $i++){
            $idObj = $data[$i]->idObj;
            $avatarRot = $data[$i]->avatarRot;
            $lArmRotX = $data[$i]->lArmRotX;
            $lArmRotZ = $data[$i]->lArmRotZ;
            $rArmRotX = $data[$i]->rArmRotX;
            $rArmRotZ = $data[$i]->rArmRotZ;
            $bodyRot = $data[$i]->bodyRot;
            $distance = $data[$i]->distance;
            $requete = "INSERT INTO resultat VALUES ($idObj, $id, $idExperience ,'".$sexeAvatar."', $avatarRot, $lArmRotX , $lArmRotZ , $rArmRotX, $rArmRotZ, $bodyRot,$distance, now())";
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
        unset($idObj);
        unset($lArmRotX);
        unset($lArmRotZ);
        unset($rArmRotX);
        unset($rArmRotZ);
        unset($bodyRot);
        unset($avatarRot);
        unset($distance);
        unset($sexeAvatar);

        header("Location: ../index.php");
}

if(isset($_POST['start-experience'])){
    $avatarSelection = $_POST['choixAvatar'];
    if(isset($_POST['experience'])) {
        $id = $_POST['experience'];
        header("Location: ../experience.php?experience=".$id."&avatarselect=".$avatarSelection);
    }
    else{
        header("Location: ../participant-accueil.php");
    }

}

if(isset($_GET['deleteProduitListe'])){
    $idProduit = $_GET['id'];
    $idExperience = $_GET['idExperience'];

    $requeteSupData = "DELETE FROM resultat WHERE idProduit='".$idProduit."'";
    $base->query($requeteSupData);

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
    $base->close();
}


// création fichier expérience

if(isset($_GET['downloadCsv'])){
    $idExperience = $_GET['idExperience'];
    $nbProduit = $_GET['nbProduit'];
    $nomExperience = $_GET['nomExperience'];

    downloadCsv($idExperience, $nbProduit, $nomExperience, $base);
}

function downloadCsv($idExperience, $nbProduit, $nomExperience, $base){
    $entete = array("PARTICIPANT_ID", "PARTICIPANT_SURNAME", "PARTICIPANT_NAME", "DATE_OF_BIRTH", "PARTICIPANT_GENDER", "AVATAR_GENDER", "DATE_OF_PARTICIPATION");
    for($i=1; $i < $nbProduit+1 ; $i++){
        array_push($entete, 'PRODUCT_ID_'.$i, 'PRODUCT_NAME_'.$i, 'AVATAR_ROTATION_'.$i, 'LEFT_ARM_ANGLE_X_AXIS_'.$i, 'LEFT_ARM_ANGLE_Z_AXIS_'.$i, 'RIGHT_ARM_ANGLE_X_AXIS_'.$i, 'RIGHT_ARM_ANGLE_Z_AXIS_'.$i, 'BODY_ANGLE_'.$i, 'DISTANCE_'.$i);
    }

    $file = fopen('../CSVFiles/'.$idExperience.'-'.$nomExperience.'.csv','w+');
    fputcsv($file, $entete); // Ligne de titres
    unset($entete);
    $reqParticipants = "SELECT p.idParticipant, p.nom, p.prenom, p.naissance, p.sexe, r.genreAvatar, r.date  FROM participant p, resultat r WHERE p.idParticipant = r.idParticipant AND idExperience=".$idExperience." GROUP BY p.idParticipant";
    $resParticipants = $base->query($reqParticipants);

    while(($resParticipant = $resParticipants->fetch_array())) {
        $reqProduit = "SELECT p.idProduit, p.nom, r.angleAvatar, r.angleBGx, r.angleBGz, r.angleBDx, r.angleBDz, r.angleBuste, r.distance FROM produit p, resultat r WHERE p.idProduit = r.idProduit AND idParticipant=".$resParticipant['idParticipant']."";
        $resProduits = $base->query($reqProduit);
        $ligne = array();
        array_push($ligne, $resParticipant[0],$resParticipant[1],$resParticipant[2],$resParticipant[3], $resParticipant[4],$resParticipant[5], $resParticipant[6]);
        while(($resProduit = $resProduits->fetch_array())) {
            array_push($ligne, $resProduit[0],$resProduit[1],$resProduit[2],$resProduit[3],$resProduit[4],$resProduit[5],$resProduit[6],$resProduit[7],$resProduit[8]);
        }
        fputcsv($file, $ligne);
        unset($ligne);
    }
    if(isset($_GET['downloadCsv'])){
        echo 'CSVFiles/'.$idExperience.'-'.utf8_encode($nomExperience).'.csv';
    }

    fclose($file);
}

if(isset($_GET['downloadZip'])){
    downloadZip($base);
}

function downloadZip($base){
    $requete = "SELECT * FROM experience";
    $resultats = $base->query($requete);
    $zip = new ZipArchive();

    while(($resultat = $resultats->fetch_array())){
        $idExperience = $resultat['idExperience'];
        $nomExperience = $resultat['nom'];
        $nbProduit = $resultat['nbProduit'];

        downloadCsv($idExperience, $nbProduit, $nomExperience, $base);

        if($zip->open('../CSVFiles/Emolyse_experiences_'.date('d-m-Y').'.zip', ZipArchive::CREATE) === true) {
            $name = $idExperience.'-'.$nomExperience.'.csv';
            $zip->addFile('../CSVFiles/'.$name ,iconv("CP1252","CP850", $name));
        }
    }
    echo 'CSVFiles/Emolyse_experiences_'.date('d-m-Y').'.zip';
    $zip->close();
}

if(isset($_GET['suppressionFichier'])){
    suppressionFichier();
}

function suppressionFichier()
{
    if (!file_exists('../CSVFiles')) {
        mkdir('../CSVFiles', 0777, true);
    }
    $repertoire = opendir('../CSVFiles');
    echo $repertoire;
    while(false !== ($fichier = readdir($repertoire)))
    {

        $chemin = "../CSVFiles/".$fichier;
        if($fichier!="." AND $fichier!=".." AND !is_dir($fichier))
        {
            unlink($chemin);
        }
    }
    closedir($repertoire);
}


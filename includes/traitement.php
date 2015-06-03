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

    $requeteSupData = "DELETE FROM resultat WHERE idExperience=".$idExperience."";
    $base->query($requeteSupData);

    $requeteProduit = "DELETE FROM produit WHERE idExperience=".$idExperience."";
    $base->query($requeteProduit);

    $requete = "DELETE FROM experience WHERE idExperience=".$idExperience."";
    $base->query($requete);


    $base->close();

    unset($idExperience);
}

// Enregistrement à la fin d'une expérience
if(isset($_POST['finaliser-experience'])){
    if(empty($_POST['jour']) || empty($_POST['mois']) || empty($_POST['annee'])){
        header("Location: ../finalisation.php?erreur=naissance");
    }elseif(empty($_POST['sexe'])){
        header("Location: ../finalisation.php?erreur=sexe");
    }elseif(empty($_POST['data'])){
        header("Location: ../index.php?erreur=nodata");
    }else{
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

        header("Location: ../index.php?state=success");
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
    $entete = ['ID_PARTICIPANT', 'NOM PARTICIPANT', 'PRENOM PARTICIPANT', 'DATE NAISSANCE', 'GENRE AVATAR'];
    for($i=1; $i < $nbProduit+1 ; $i++){
        array_push($entete, 'ID_PRODUIT_'.$i, 'NOM_PRODUIT_'.$i, 'NOM_PRODUIT_'.$i, 'ANGLE_BGX_'.$i, 'ANGLE_BGZ_'.$i, 'ANGLE_BDX_'.$i, 'ANGLE_BDZ_'.$i, 'ANGLE_BUSTE_'.$i, 'DISTANCE_'.$i, 'ANGLE_BDX_'.$i);
    }

//    echo $nomExperience;
    $file = fopen('../CSVFiles/'.$idExperience.'-'.$nomExperience.'.csv','w+');

    fputcsv($file, $entete); // Ligne de titres
    unset($entete);
    $reqParticipants = "SELECT p.idParticipant, p.nom, p.naissance, p.sexe, r.genreAvatar, r.date  FROM participant p, resultat r WHERE p.idParticipant = r.idParticipant AND idExperience=".$idExperience." GROUP BY p.idParticipant";
    $resParticipants = $base->query($reqParticipants);

    while(($resParticipant = $resParticipants->fetch_array())) {
        $reqProduit = "SELECT p.idProduit, p.nom, r.angleAvatar, r.angleBGx, r.angleBGz, r.angleBDx, r.angleBDz, r.angleBuste, r.distance FROM produit p, resultat r WHERE p.idProduit = r.idProduit AND idParticipant=".$resParticipant['idParticipant']."";
        $resProduits = $base->query($reqProduit);
        $ligne = array();
        array_push($ligne, $resParticipant[0],$resParticipant[1],$resParticipant[2],$resParticipant[3], $resParticipant[4],$resParticipant[5]);
        while(($resProduit = $resProduits->fetch_array())) {
            array_push($ligne, $resProduit[0],$resProduit[1],$resProduit[2],$resProduit[3],$resProduit[4],$resProduit[5],$resProduit[6],$resProduit[7]);
        }
        fputcsv($file, $ligne);
        unset($ligne);
    }
    if(isset($_GET['downloadCsv'])){
        echo "CSVFiles/".$idExperience."-".utf8_encode($nomExperience).".csv";
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
        $entete = ['ID_PARTICIPANT', 'NOM PARTICIPANT', 'PRENOM PARTICIPANT', 'DATE NAISSANCE', 'GENRE AVATAR'];
        $idExperience = $resultat['idExperience'];
        $nomExperience = $resultat['nom'];
        $nbProduit = $resultat['nbProduit'];
        downloadCsv($idExperience, $nbProduit, $nomExperience, $base);

        if($zip->open('../CSVFiles/Emolyse_experiences_'.date('d-m-Y').'.zip', ZipArchive::CREATE) === true) {
            $zip->addFile('../CSVFiles/'.$idExperience.'-'.$nomExperience.'.csv');
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


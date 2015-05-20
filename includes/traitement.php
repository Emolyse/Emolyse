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

if(isset($_POST['ajoutLangue'])){
    $codeLangue = $_POST['codeLangue'];
    $nom = $_POST['nom'];

    $ds= DIRECTORY_SEPARATOR;
    $storeFolder = '../images';
    if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
        $targetFile = $targetPath. $_FILES['file']['name'];
        move_uploaded_file($tempFile,$targetFile);
    }

    $lienDrapeau = '../Emolyse/images/'.$_FILES['file']['name'];

    if($codeLangue != '' && $nom != ''){

        $requete = "INSERT INTO langue VALUES ('".$codeLangue."', '".$nom."', '".$lienDrapeau."')";
        $base->query($requete);

        // à décommenter
        /*$requeteId = "SELECT * FROM identifiant";
        $resultatsId = $base->query($requeteId);
        while($resultatId = $resultatsId->fetch_array()){
            $requeteInsert = "INSERT INTO traduction VALUES ('".$codeLangue."', '".$resultatId['codeIdentifiant']."', '')";
            $base->query($requeteInsert);
        }*/

        $base->close();
    }else{
        header("Location: ../parametres.php");
    }

    header("Location: ../parametres.php");
}

if(isset($_POST['modifierConsigne'])){
    $consigne = $_POST['consigne'];
    $codeLangue = $_POST['codeLangue'];
    $codeIdentifiant = $_POST['codeIdentifiant'];

    $requete = "UPDATE traduction SET traduction='".$consigne."' WHERE codeLangue='".$codeLangue."' AND codeIdentifiant='".$codeIdentifiant."'";
    $base->query($requete);

    $base->close();

    header("Location: ../parametres.php");
}

if(isset($_GET['updateOrderList'])){
    $id = $_GET['id'];
    $order = $_GET['order'];

    $requete = "UPDATE produit SET position='".$order."' WHERE idProduit='".$id."'";
    $base->query($requete);

    $base->close();

    header("Location: ../gerer-experience.php");
}

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

    header("Location: ../gerer-experience.php");
}

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

if(isset($_GET['deleteExp'])){
    $idExperience = $_GET['id'];

    $requeteSelect = "SELECT lienPhoto FROM produit WHERE idExperience=".$idExperience."";
    $resultatsSelect = $base->query($requeteSelect);
    while(($resultat = $resultatsSelect->fetch_array())){
        unlink("../".$resultat['lienPhoto']);
    }

    $requete = "DELETE FROM experience WHERE idExperience=".$idExperience."";
    $base->query($requete);

    $requeteProduit = "DELETE FROM produit WHERE idExperience=".$idExperience."";
    $base->query($requeteProduit);

//    header("Location: ../experimentateur-experiences.php");

}

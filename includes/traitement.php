<?php
include('header.php');

if(isset($_POST['ajoutLangue'])){
    $codeLangue = $_POST['codeLangue'];
    $nom = $_POST['nom'];
    $lienDrapeau = $_POST['lienDrapeau'];

    $requete = "INSERT INTO langue VALUES ('".$codeLangue."', '".$nom."', '".$lienDrapeau."')";
    $base->query($requete);

    $requeteId = "SELECT * FROM identifiant";
    $resultatsId = $base->query($requeteId);
    while($resultatId = $resultatsId->fetch_array()){
        $requeteInsert = "INSERT INTO traduction VALUES ('".$codeLangue."', '".$resultatId['codeIdentifiant']."', '')";
        $base->query($requeteInsert);
    }

    $base->close();

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
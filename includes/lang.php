<?php
// gestion de la langue de l'application
if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'EN';

    $requete = "SELECT codeIdentifiant, traduction FROM traduction WHERE codeLangue='".$_SESSION['lang']."'";
    $resultats = $base->query($requete);
    while($resultat = $resultats->fetch_array())
    {
        define($resultat['codeIdentifiant'], $resultat['traduction']);
    }
    $resultats->close();
}else{
    if(isset($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
    }

    $requeteLangues = "SELECT * FROM langue WHERE  codeLangue='".$_SESSION['lang']."'";
    $resultatsLangue = $base->query($requeteLangues);
    // on vérifie que la langue saisie dans l'url existe
    if ($resultat = $resultatsLangue->fetch_array() == true) {
        $requete = "SELECT codeIdentifiant, traduction FROM traduction WHERE codeLangue='".$_SESSION['lang']."'";
        $resultats = $base->query($requete);
        while($resultat = $resultats->fetch_array())
        {
//            echo '<script>console.log("'.utf8_encode($resultat['traduction']).'");</script>';
            define($resultat['codeIdentifiant'], $resultat['traduction']);
        }
    }else{
        $requete = "SELECT codeIdentifiant, traduction FROM traduction WHERE codeLangue='EN'";
        $resultats = $base->query($requete);
        while($resultat = $resultats->fetch_array())
        {
            define($resultat['codeIdentifiant'], $resultat['traduction']);
        }
        $resultats->close();
    }
    $resultatsLangue->close();
}
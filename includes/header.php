<?php
    session_start();
    include("init.php");
    include("connexion.php");
    include("lang.php");
?>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Alizee ARNAUD, Jordan DAITA, Rémy DROUET" />

    <title>Emolyse</title>

    <link rel="stylesheet" href="../Emolyse/styles/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../Emolyse/styles/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="../Emolyse/styles/style.css"/>
    <script type="text/javascript" src="../Emolyse/scripts/file.js"></script>
    <script type="text/javascript" src="../Emolyse/scripts/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../Emolyse/scripts/jquery-ui.js"></script>
    <script type="text/javascript" src="../Emolyse/scripts/dropfile.js"></script>
    <script type="text/javascript" src="../Emolyse/scripts/uploadFile.js"></script>
    <script type="text/javascript" src="../Emolyse/scripts/order.js"></script>
</head>
<body>
<form action="" method="get" id="formLang">
    <?php
    $requete = "SELECT * FROM langue";
    $resultats = $base->query($requete);
    while(($resultat = $resultats->fetch_array())){
        echo "<button name='lang' value='".$resultat['codeLangue']."' type='submit' class='drapeauxLang'><img src='".$resultat['lienDrapeau']."' width='30px'/></button>";
        //echo "<input type='submit' name='lang' value='".$resultat['codeLangue']."' class='drapeauxLang' />";
    }
    ?>
</form>

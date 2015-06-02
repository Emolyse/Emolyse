<?php
    include('includes/header.php');
?>
<!-- Changement de la langue de l'application -->
<form action="" method="get" id="formLang">
    <?php
    $requete = "SELECT * FROM langue";
    $resultats = $base->query($requete);
    while(($resultat = $resultats->fetch_array())){
        echo "<button name='lang' value='".$resultat['codeLangue']."' type='submit' class='drapeauxLang'><img src='".$resultat['lienDrapeau']."' width='30px'/></button>";
    }
    ?>
</form>
<div class="logoEmolyse">
    <img src="images/logo.png" alt="logo application Emolyse" id="logoEmolyse"/>
</div>
<a href="experimentateur-accueil.php" class="btn-home btn-experimentateur"><?php echo BTN_EXPERIMENTATEUR_HOME; ?></a>
<a href="participant-accueil.php" class="btn-home btn-participant"><?php echo BTN_PARTICIPANT_HOME; ?></a>

</body>
</html>
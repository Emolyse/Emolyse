<?php
    include('includes/header.php');
?>
<!-- Changement de la langue de l'application -->
<form action="" method="get" id="formLang">
    <?php
    $requete = "SELECT * FROM langue";
    $resultats = $base->query($requete);
    while(($resultat = $resultats->fetch_array())){
        echo "<button name='lang' value='".$resultat['codeLangue']."' type='submit' class='drapeauxLang'><img src='".$resultat['lienDrapeau']."' width='40px'/></button>";
    }
    ?>
</form>
<div class="logoEmolyse">
    <img src="images/logo.png" alt="logo application Emolyse" id="logoEmolyse"/>
</div>
<a href="experimentateur-accueil.php" class="btn-home btn-experimentateur"><?php echo BTN_EXPERIMENTATEUR_HOME; ?></a>
<a href="participant-accueil.php" class="btn-home btn-participant"><?php echo BTN_PARTICIPANT_HOME; ?></a>

<span id="footer-index">Emolyse &copy; 2015 Application d&eacute;velopp&eacute;e par <a href="http://alizee-arnaud.com/" target="_blank">Aliz&eacute;e ARNAUD</a>, Jordan DAITA & R&eacute;my Drouet pour le <a
        href="https://www.liglab.fr/" target="_blank">LIG</a></span>
</body>
</html>
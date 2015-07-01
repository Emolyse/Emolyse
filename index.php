<!--
    This file is part of Emolyse.

    Emolyse is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Emolyse is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You can access the GNU General Public License by clicking on
    Emolyse (c) 2015 link on the home page of this program.
    If not, see <http://www.gnu.org/licenses/gpl-3.0.html/>.
-->
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

<span id="footer-index"><a href="http://www.gnu.org/licenses/gpl-3.0.html" target="_blank">Emolyse &copy; 2015</a> Application d&eacute;velopp&eacute;e par <a href="http://alizee-arnaud.com/" target="_blank">Aliz&eacute;e ARNAUD</a>, Jordan DAITA & R&eacute;my Drouet pour le <a
        href="https://www.liglab.fr/" target="_blank">LIG</a></span>
</body>
</html>
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
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php echo BTN_EXPERIMENTATEUR_HOME; ?></a></li>
        <li><?php echo BTN_EXPERIENCES; ?></li>
    </ul>
</section>

<section class="liste-experience">
    <div class="lienExperience">
        <a href="includes/nouvelleExperience.php"><i class="fa fa-plus-circle"></i></a>
        <a href="" class="downloadCsv" onclick="downloadZip()"><i class="fa fa-download telecharger-tout"></i></a>
    </div>
    <table class="table-experience">
        <thead>
        <th><?php echo NOM; ?></th>
        <th></th>
        <th></th>
        </thead>
        <tbody>
        <?php
        $requete = "SELECT * FROM experience";
        $resultats = $base->query($requete);
        while(($resultat = $resultats->fetch_array())){
            $idExperience = $resultat['idExperience'];
//            $nomExperience = utf8_encode($resultat['nom']);
            $nomExperience = $resultat['nom'];
            $nbProduit = $resultat['nbProduit'];
            if($nomExperience == '' && $resultat['nbProduit'] == 0){
                $requeteDelete = "DELETE FROM experience WHERE idExperience=".$idExperience;
                $base->query($requeteDelete);
            }
            echo '<tr>';
            echo '<td width=80% onclick="document.location = \'gerer-experience.php?id='.$idExperience.'\'" class="ligneClic">'.$nomExperience.'</td>';
            echo '<td width=10%><a href=""'.'class="downloadCsv" onclick="downloadCsv('.$idExperience.', '.$nbProduit.', \''.addslashes($nomExperience).'\')"><i class="fa fa-download"></i></a></td>';
            echo '<td width=10%><a href="#" class="supExperience" id="'.$idExperience.'"><i class="fa fa-times"></i></a></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        // suppression d'une experience avec envoie d'infos en get
        $( ".supExperience" ).click(function() {
            var idExperience = $(this).attr("id");

            var r = confirm("<?php echo CONFIRMATION_SUPP;?>");
            if (r == true) {
                texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?id='+escape(idExperience)
                    +'&deleteExp="deleteExp"'
                )
                location.reload();
            }
        });
    });
    function downloadCsv(idExperience, nbProduit, nomExperience){
        texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?idExperience='+escape(idExperience)
            +'&nbProduit='+nbProduit
            +'&nomExperience='+nomExperience
            +'&downloadCsv="downloadCsv"'
        );
        var lien = texte;
        $('.downloadCsv').attr('href', lien);
    }
    function downloadZip(){
        texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?downloadZip="downloadZip"')
        var lien = texte;
        $('.downloadCsv').attr('href',lien);
    }

    $( window ).unload(function() {
        texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?suppressionFichier="suppressionFichier"')
    });

</script>

</body>
</html>
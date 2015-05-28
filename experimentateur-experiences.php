<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a></li>
        <li><?php if(BTN_EXPERIENCES != ''){echo BTN_EXPERIENCES;}else{ echo('BTN_EXPERIENCES');}; ?></li>
    </ul>
</section>

<section class="liste-experience">
    <div class="lienExperience">
        <a href="includes/nouvelleExperience.php"><i class="fa fa-plus-circle"></i></a>
        <a href="#"><i class="fa fa-download telecharger-tout"></i></a>
    </div>
    <table class="table-experience">
        <thead>
<!--            <th></th>-->
            <th><?php if(NOM != ''){echo NOM;}else{ echo('NOM');}; ?></th>
            <th></th>
            <th></th>
        </thead>
            <tbody>
            <?php
                $requete = "SELECT * FROM experience";
                $resultats = $base->query($requete);
                while(($resultat = $resultats->fetch_array())){
                    $idExperience = $resultat['idExperience'];
                    if($resultat['nom'] == '' && $resultat['nbProduit'] == 0){
                        $requeteDelete = "DELETE FROM experience WHERE idExperience=".$idExperience."";
                        $base->query($requeteDelete);
                    }
                    echo "<tr>";
                    echo "<td width=80% onclick='document.location = \"gerer-experience.php?id=$idExperience\"' class='ligneClic'>".$resultat['nom']."</td>";
                    echo "<td width=10%><a href='#'><i class='fa fa-download'></i></a></td>";
                    echo "<td width=10%><a href='#' class='supExperience' id='$idExperience'><i class='fa fa-minus'></i></a></td>";
                    echo "</tr>";
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

            var r = confirm("Etes vous sûr de vouloir supprimer cette expérience ?");
            if (r == true) {
                texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?id='+escape(idExperience)
                    +'&deleteExp="deleteExp"'
                )
                location.reload();
            }
        });
    });
</script>

</body>
</html>
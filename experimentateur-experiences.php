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
        <a href="#"><i class="fa fa-download telecharger-tout"></i></a>
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
                    $entete = ['ID_PARTICIPANT', 'NOM PARTICIPANT', 'PRENOM PARTICIPANT', 'DATE NAISSANCE', 'GENRE AVATAR'];
                    $idExperience = $resultat['idExperience'];
                    $nomExperience = $resultat['nom'];
                    $nbProduit = $resultat['nbProduit'];
                    if($resultat['nom'] == '' && $resultat['nbProduit'] == 0){
                        $requeteDelete = "DELETE FROM experience WHERE idExperience=".$idExperience."";
                        $base->query($requeteDelete);
                    }
                    for($i=1; $i < $nbProduit+1 ; $i++){
                        array_push($entete, 'ID_PRODUIT_'.$i, 'NOM_PRODUIT_'.$i, 'NOM_PRODUIT_'.$i, 'ANGLE_BGX_'.$i, 'ANGLE_BGZ_'.$i, 'ANGLE_BDX_'.$i, 'ANGLE_BDZ_'.$i, 'ANGLE_BUSTE_'.$i, 'DISTANCE_'.$i, 'ANGLE_BDX_'.$i);
                    }
                    $file = fopen('CSVFiles/'.$idExperience.'-'.$nomExperience.'.csv','w+');
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
                    fclose($file);
                    echo "<tr>";
                    echo "<td width=80% onclick='document.location = \"gerer-experience.php?id=$idExperience\"' class='ligneClic'>".$resultat['nom']."</td>";
                    echo "<td width=10%><a href='CSVFiles/".$idExperience.'-'.$nomExperience.".csv'><i class='fa fa-download'></i></a></td>";
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
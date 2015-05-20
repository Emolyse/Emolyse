<?php
    include('includes/header.php');
    include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a></li>
        <li><?php if(BTN_PARTICIPANTS != ''){echo BTN_PARTICIPANTS;}else{ echo('BTN_PARTICIPANTS');}; ?></li>
    </ul>
</section>

<section class="liste-participants">
    <table class="table-participants">
        <thead>
            <th><?php if(SEXE != ''){echo SEXE;}else{ echo('SEXE');}; ?> <i class="fa fa-sort-desc"></i></th>
            <th><?php if(NOM != ''){echo NOM;}else{ echo('NOM');}; ?> <i class="fa fa-sort-desc"></i></th>
            <th><?php if(PRENOM != ''){echo PRENOM;}else{ echo('PRENOM');}; ?> <i class="fa fa-sort-desc"></i></th>
            <th><?php if(AGE != ''){echo AGE;}else{ echo('AGE');}; ?> <i class="fa fa-sort-desc"></i></th>
            <th></th>
        </thead>
        <tbody>
            <?php
                $requete = "SELECT * FROM participant";
                $resultats = $base->query($requete);
                while(($resultat = $resultats->fetch_array())){
                    echo "<tr>";
                    echo "<td>".$resultat['sexe']."</td>";
                    echo "<td>".$resultat['nom']."</td>";
                    echo "<td>".$resultat['prenom']."</td>";
                    echo "<td>".$resultat['naissance']."</td>";
                    echo "<td><a href='#'><i class='fa fa-download'></i></a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>

</body>
</html>
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
            <tr>
                <td><img src="images/profil_h.png" alt="Homme"/></td>
                <td>Martin</td>
                <td>Bernard</td>
                <td>28 ans</td>
                <td><a href="#"><i class="fa fa-download"></i></a></td>
            </tr>
            <tr>
                <td><img src="images/profil_h.png" alt="Homme"/></td>
                <td>André</td>
                <td>Michel</td>
                <td>40 ans</td>
                <td><a href="#"><i class="fa fa-download"></i></a></td>
            </tr>
            <tr>
                <td><img src="images/profil_h.png" alt="Homme"/></td>
                <td>Petit</td>
                <td>Michelle</td>
                <td>45 ans</td>
                <td><a href="#"><i class="fa fa-download"></i></a></td>
            </tr>
        </tbody>
    </table>
</section>

</body>
</html>
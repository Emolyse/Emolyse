<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a></li>
        <li><?php if(BTN_PARAMETRES != ''){echo BTN_PARAMETRES;}else{ echo('BTN_PARAMETRES');}; ?></li>
    </ul>
</section>

<section class="parametres">
    <div class="gerer-parametres">
        <a href="#" id="edit-default-consigne"><i class="fa fa-pencil"></i> <?php if(CONSIGNE != ''){echo CONSIGNE;}else{ echo('CONSIGNE');}; ?></a>
        <a href="#" id="add-language"><i class="fa fa-plus"></i> <?php if(LANGUE != ''){echo LANGUE;}else{ echo('LANGUE');}; ?></a>
    </div>
    <table class="table-parametres">
        <thead>
            <th><?php if(IDENTIFIANT != ''){echo IDENTIFIANT;}else{ echo('IDENTIFIANT');}; ?></th>
            <th><?php if(FRANCAIS != ''){echo FRANCAIS;}else{ echo('FRANCAIS');}; ?></th>
            <th><?php if(ANGLAIS != ''){echo ANGLAIS;}else{ echo('ANGLAIS');}; ?></th>
        </thead>
        <tbody>
        <tr>
            <td>btn-ajout</td>
            <td>Ajouter</td>
            <td>Add</td>
        </tr>
        <tr>
            <td>btn-demarrer</td>
            <td>Démarrer</td>
            <td>Start</td>
        </tr>
        <tr>
            <td>accueil</td>
            <td>Accueil</td>
            <td>Home</td>
        </tr>
        </tbody>
    </table>
</section>

</body>
</html>
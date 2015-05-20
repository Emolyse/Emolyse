<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a></li>
        <li><a href="experimentateur-experiences.php"><?php if(BTN_EXPERIENCES != ''){echo BTN_EXPERIENCES;}else{ echo('BTN_EXPERIENCES');}; ?></a></li>
        <li><?php if(MODIFIER != ''){echo MODIFIER;}else{ echo('MODIFIER');}; ?></li>
    </ul>
</section>

<section class="ajout-experience">
    <form action="#" id="formulaire-experience">
        <div class="params1">
            <label>202 - </label><input type="text" name="nom" id="champs-nom-experience"/>
            <a href="#"><img src="images/drapeau-francais.png" alt="<?php if(CHOISIR_LA_LANGUE != ''){echo CHOISIR_LA_LANGUE;}else{ echo('CHOISIR_LA_LANGUE');}; ?>" class="drapeau-experience"/></a>
            <a href="#" class="editer-consigne-add-experience"><?php if(EDITER_LA_CONSIGNE != ''){echo EDITER_LA_CONSIGNE;}else{ echo('EDITER_LA_CONSIGNE');}; ?></a>
        </div>
        <div class="objet">
            <h3><?php if(OBJETS != ''){echo OBJETS;}else{ echo('OBJETS');}; ?></h3><input type="checkbox" name="aleatoire" id="champs-aleatoire-experience"/> <?php if(AFFICHAGE_ALEATOIRE_OBJETS != ''){echo AFFICHAGE_ALEATOIRE_OBJETS;}else{ echo('AFFICHAGE_ALEATOIRE_OBJETS');}; ?>
            <div class="liste-objets">
                <button type="button" id="add-objects"><i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
        <div class="environnement">
            <h3><?php if(ENVIRONNEMENT != ''){echo ENVIRONNEMENT;}else{ echo('ENVIRONNEMENT');}; ?></h3>
            <div class="select-environnement">
                <button type="button" id="add-env"><i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
        <input type="submit" id="btn-update-experience" name="update-experience" value="<?php if(MODIFIER != ''){echo MODIFIER;}else{ echo('MODIFIER');}; ?>"/>
    </form>
</section>

</body>
</html>
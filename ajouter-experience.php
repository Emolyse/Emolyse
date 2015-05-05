<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php">Expérimentateur</a></li>
        <li><a href="experimentateur-experiences.php">Expérience</a></li>
        <li>Ajouter</li>
    </ul>
</section>

<section class="ajout-experience">
    <div class="params1">
        <form action="#" id="formulaire-experience">
            <label>202 - </label><input type="text" name="nom" id="champs-nom-experience"/>
            <a href="#"><img src="images/drapeau-français.png" alt="Choisir la langue" class="drapeau-experience"/></a>
            <a href="#" class="editer-consigne-add-experience">Editer la consigne</a>
        </form>
    </div>
    <div class="objet">
        <h3>Objets</h3><input type="checkbox" name="aleatoire" id="champs-aleatoire-experience"/> Affichage aléatoire des objets
        <div class="liste-objets">
            <button type="button" id="add-objects"><i class="fa fa-plus-circle"></i></button>
        </div>
        <h3>Environnement</h3>
        <div class="environnement">
            <button type="button" id="add-env"><i class="fa fa-plus-circle"></i></button>
        </div>
</section>

</body>
</html>
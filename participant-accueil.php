<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php if(NOUVELLE_EXPERIENCE != ''){echo NOUVELLE_EXPERIENCE;}else{ echo('NOUVELLE_EXPERIENCE');}; ?></li>
    </ul>
</section>

<section class="nouvelle-experience">
    <div class="avatarFemme"></div>
    <div>
        <form action="includes/traitement.php" method="post">
            <select name="experience" id="select-experience">
                <?php
                // on veut afficher uniquement les expériences avec au moins un produit
                $requete = "SELECT * FROM experience WHERE nbProduit > 1";
                $resultats = $base->query($requete);
                while(($resultat = $resultats->fetch_array())){
                    $idExperience = $resultat['idExperience'];
                    echo "<option value='".$idExperience."'>".$resultat['nom']."</option>";
                }
                ?>
            </select>
            <input type="submit" id="btn-start-experience" name="start-experience" value="<?php if(DEMARRER != ''){echo DEMARRER;}else{ echo('DEMARRER');}; ?>"/>
        </form>
    </div>
    <div class="avatarHomme"></div>
</section>

</body>
</html>
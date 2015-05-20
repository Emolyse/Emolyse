<?php
    include('includes/header.php');
    include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></li>
    </ul>
</section>

<section class="menu_experimentateur">
    <ul>
        <li><a href="experimentateur-participants.php?order=name" class="btn-experimentateur-home"><i class="fa fa-user"></i> <?php if(BTN_PARTICIPANTS != ''){echo BTN_PARTICIPANTS;}else{ echo('BTN_PARTICIPANTS');}; ?></a></li>
        <li><a href="experimentateur-experiences.php" class="btn-experimentateur-home"><i class="fa fa-flask"></i> <?php if(BTN_EXPERIENCES != ''){echo BTN_EXPERIENCES;}else{ echo('BTN_EXPERIENCES');}; ?></a></li>
        <li><a href="parametres.php" class="btn-experimentateur-home"><i class="fa fa-cog"></i> <?php if(BTN_PARAMETRES != ''){echo BTN_PARAMETRES;}else{ echo('BTN_PARAMETRES');}; ?></a></li>
    </ul>
</section>

</body>
</html>
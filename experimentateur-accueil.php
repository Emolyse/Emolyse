<?php
    include('includes/header.php');
    include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php echo BTN_EXPERIMENTATEUR_HOME; ?></li>
    </ul>
</section>

<section class="menu_experimentateur">
    <ul>
        <li><a href="experimentateur-participants.php?order=name" class="btn-experimentateur-home"><i class="fa fa-user"></i> <?php echo BTN_PARTICIPANTS; ?></a></li>
        <li><a href="experimentateur-experiences.php" class="btn-experimentateur-home"><i class="fa fa-flask"></i> <?php echo BTN_EXPERIENCES; ?></a></li>
        <li><a href="parametres.php" class="btn-experimentateur-home"><i class="fa fa-cog"></i> <?php echo BTN_PARAMETRES; ?></a></li>
    </ul>
</section>

</body>
</html>
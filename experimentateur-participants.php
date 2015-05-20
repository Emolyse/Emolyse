<?php
    include('includes/header.php');
    include('includes/en-tete.php');
?>

<?php
    $tablename = 'participants';
    $tri_autorises = array('sexe','nom','prenom','naissance');
    $order_by = in_array($_GET['order'], $tri_autorises) ? $_GET['order'] : 'nom';
    $order_dir = isset($_GET['inverse']) ? 'DESC' : 'ASC';

    $requete = "SELECT * FROM participant ORDER BY ".$order_by." ".$order_dir."";
    $resultats = $base->query($requete);

    function sort_link($text, $order=false)
    {
        global $order_by, $order_dir;

        if(!$order)
            $order = $text;

        $link = '?order=' . $order;
        if($order_by==$order && $order_dir=='ASC')
            $link .= '&inverse=true';

        return $link;
    }

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
            <th><a href="<?php echo sort_link('Sexe', 'sexe') ?>"><?php if(SEXE != ''){echo SEXE;}else{ echo('SEXE');}; ?> <i class="fa fa-sort-desc"></i></a></th>
            <th><a href="<?php echo sort_link('Nom', 'nom') ?>"><?php if(NOM != ''){echo NOM;}else{ echo('NOM');}; ?> <i class="fa fa-sort-desc"></i></a></th>
            <th><a href="<?php echo sort_link('Prenom', 'prenom') ?>"><?php if(PRENOM != ''){echo PRENOM;}else{ echo('PRENOM');}; ?> <i class="fa fa-sort-desc"></i></a></th>
            <th><a href="<?php echo sort_link('Naissance', 'naissance') ?>"><?php if(AGE != ''){echo AGE;}else{ echo('AGE');}; ?> <i class="fa fa-sort-desc"></i></a></th>
            <th></th>
        </thead>
        <tbody>
            <?php
                while(($resultat = $resultats->fetch_array())){
                    echo "<tr>";
                    echo "<td>";
                    if($resultat['sexe'] == 'F'){
                        echo "<img src='images/profil_f.png' alt='Femme' class='pictoSexe' />";
                    }elseif($resultat['sexe'] == 'H'){
                        echo "<img src='images/profil_h.png' alt='Femme' class='pictoSexe' />";
                    }
                    echo "</td>";
                    echo "<td>".$resultat['nom']."</td>";
                    echo "<td>".$resultat['prenom']."</td>";
                    // convertion de la date de naissance en age
                    $date = $resultat['naissance'];
                    $age = (time() - strtotime($date)) / 3600 / 24 / 365.242;
                    echo "<td>".(int)$age." ans</td>";
                    echo "<td><a href='#'><i class='fa fa-download'></i></a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</section>

</body>
</html>
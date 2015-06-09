<?php
include('includes/header.php');
include('includes/en-tete.php');
?>


<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php echo NOUVELLE_EXPERIENCE; ?></li>
    </ul>
</section>

<section class="nouvelle-experience">
    <div class="choixAvatar" onclick="avatarSelected('woman');"><img src="images/imgAvatar/avatar_woman.png" alt="Choix de l'avatar femme" id="avatarW"/></div>
    <div>
        <form action="includes/traitement.php" method="post">
            <select name="experience" id="select-experience">
                <?php
                // on veut afficher uniquement les expériences avec au moins un produit
                $requete = "SELECT * FROM experience WHERE nbProduit > 0";
                $resultats = $base->query($requete);
                $rows=mysqli_num_rows($resultats);
                if($rows > 0){
                    $disable = '';
                }
                else {
                    $disable = 'disabled';
                }
                while(($resultat = $resultats->fetch_array())){
                    $idExperience = $resultat['idExperience'];
                    echo "<option value='".$idExperience."'>".$resultat['nom']."</option>";
                }
                ?>
            </select>
            <input type="hidden" id="choixAvatarInput" name="choixAvatar" value=""/>
            <input type="submit" <?php echo $disable ?> id="btn-start-experience" name="start-experience" value="<?php echo DEMARRER; ?>"/>
        </form>
    </div>
    <div class="choixAvatar" onclick="avatarSelected('man');"><img src="images/imgAvatar/avatar_man.png" alt="Choix de l'avatar femme" id="avatarM"/></div>
</section>

<script>
    var avatarSelection;
    function avatarSelected(choix)
    {
        avatarSelection = choix;
        $('input[name="choixAvatar"]').val(avatarSelection);
        if(avatarSelection == 'woman'){
            $("#avatarW").attr("src","images/imgAvatar/avatar_woman_selected.png");
            $("#avatarM").attr("src","images/imgAvatar/avatar_man.png");
        }
        else{
            $("#avatarW").attr("src","images/imgAvatar/avatar_woman.png");
            $("#avatarM").attr("src","images/imgAvatar/avatar_man_selected.png");
        }
    }
</script>

</body>
</html>
<!--
    This file is part of Emolyse.

    Emolyse is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Emolyse is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You can access the GNU General Public License by clicking on
    Emolyse (c) 2015 link on the home page of this program.
    If not, see <http://www.gnu.org/licenses/gpl-3.0.html/>.
-->
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
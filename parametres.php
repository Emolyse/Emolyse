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
        <tr>
            <th><?php if(IDENTIFIANT != ''){echo IDENTIFIANT;}else{echo('IDENTIFIANT');}; ?></th>
            <?php
                $requete = "SELECT * FROM traduction GROUP BY codeLangue";
                $resultats = $base->query($requete);
                while($resultat = $resultats->fetch_array())
                {
                    echo "<th>".$resultat['codeLangue']."</th>";
                }
                $resultats->close();
            ?>
        </tr>
        <?php
            $requeteId = "SELECT * FROM identifiant";
            $resultatsId = $base->query($requeteId);
            $rowcount = mysqli_num_rows($resultatsId);
            $i = 1;
            while(($resultatId = $resultatsId->fetch_array()) || ($i == $rowcount+1))
            {
                echo "<tr>";
                echo "<td>".$resultatId['codeIdentifiant']."</td>";

                $requete = "SELECT * FROM traduction GROUP BY codeLangue";
                $resultats = $base->query($requete);

                while(($resultat = $resultats->fetch_array()))
                {
                    $requeteTraductions = "SELECT * FROM traduction WHERE codeLangue='".$resultat['codeLangue']."' AND codeIdentifiant='".$resultatId['codeIdentifiant']."'";
                    $resultatsTraductions = $base->query($requeteTraductions);

                    $j = 1;
                    while(($resultatTrad = $resultatsTraductions->fetch_array()))
                    {
                        echo "<td><input type='text' name='".$resultatTrad['codeLangue']."-".$resultatTrad['codeIdentifiant']."' value='".$resultatTrad['traduction']."' class='champ_text_transparent' onkeyup='updateTraduction(\"".$resultatTrad['codeLangue']."-".$resultatTrad['codeIdentifiant']."\")' /></td>";
                    }
                }
                echo "</tr>";
                $i = $i+1;
            }
        ?>
    </table>
</section>

<!--POP-UP AU CLIC SUR "AJOUTER UNE LANGUE"-->
<div class="pop-up">
    <i class="fa fa-times-circle-o close"></i>
    <div class="box">
        <h3>Ajouter une langue</h3>
        <form action="includes/traitement.php" method="post" enctype="multipart/form-data">
            <input type="text" name="codeLangue" id="codeLangue" placeholder="Code langue*"/>
            <input type="text" name="nom" id="nom" placeholder="Nom de la langue*"/>
            <input type="file" name="lienDrapeau"/>
            <input type="submit" value="Ajouter" name="ajoutLangue"/>
        </form>

    </div>
</div>

<!--POP-UP AU CLIC SUR "CONSIGNE"-->
<div class="pop-up-consigne">
    <i class="fa fa-times-circle-o close"></i>
    <div class="box">
        <h3>Modifier la consigne</h3>
        <form action="includes/traitement.php" method="post" enctype="multipart/form-data">
            <textarea name="consigne" id="consigne" cols="30" rows="10">
                <?php
                    $requete = "SELECT traduction FROM traduction WHERE codeLangue='FR' AND codeIdentifiant='TEXT_CONSIGNE'";
                    $resultats = $base->query($requete);
                    while($resultat = $resultats->fetch_array()){
                        echo utf8_decode($resultat['traduction']);
                    }
                ?>
            </textarea>
            <input type="hidden" name="codeLangue" value="FR"/>
            <input type="hidden" name="codeIdentifiant" value="TEXT_CONSIGNE"/>
            <input type="submit" value="Modifier" name="modifierConsigne"/>
            <div class="error"></div>
        </form>

    </div>
</div>


<script>
    $(document).ready(function () {
        // Gestion de la pop-up
        document.body.style.overflow = 'auto';
        $("#add-language").click(function() {
            $('.pop-up').show();
            document.body.style.overflow = 'hidden';
        });
        $(".close").click(function() {
            $('.pop-up').hide();
            $('.pop-up-consigne').hide();
            document.body.style.overflow = 'auto';
        });

        $("#edit-default-consigne").click(function() {
            $('.pop-up-consigne').show();
            document.body.style.overflow = 'hidden';
        });
    });
    function updateTraduction(ID_element)
    {
        var value = document.getElementsByName(ID_element).item(0).value;

        console.log('http://'+window.location.host+'/Emolyse/Emolyse/includes/modifTraduction.php?ID_element='+escape(ID_element)
            +'&value='+escape(value));

        texte = file('http://'+window.location.host+'/Emolyse/Emolyse/includes/modifTraduction.php?ID_element='+escape(ID_element)
            +'&value='+escape(value)
        )
    }
    function file(fichier)
    {
        if(window.XMLHttpRequest)
            xhr_object = new XMLHttpRequest();
        else if(window.ActiveXObject) // IE
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
        else
            return(false);
        xhr_object.open("GET", fichier, false);
        xhr_object.send(null);
        if(xhr_object.readyState == 4) return(xhr_object.responseText);
        else return(false);
    }
</script>
</body>
</html>
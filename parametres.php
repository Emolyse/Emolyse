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
        <li><a href="experimentateur-accueil.php"><?php echo BTN_EXPERIMENTATEUR_HOME; ?></a></li>
        <li><?php echo BTN_PARAMETRES; ?></li>
    </ul>
</section>

<section class="parametres">
    <div class="gerer-parametres">
        <a href="#" id="edit-default-consigne"><i class="fa fa-pencil"></i> <?php echo CONSIGNE; ?></a>
        <a href="#" id="add-language"><i class="fa fa-plus"></i> <?php echo LANGUE; ?></a>
    </div>
    <table class="table-parametres">
        <tr>
            <th><?php echo IDENTIFIANT; ?></th>
            <?php
                $requete = "SELECT * FROM traduction t, langue l WHERE t.codeLangue = l.codeLangue AND codeIdentifiant <> 'TEXT_CONSIGNE' GROUP BY t.codeLangue";
                $resultats = $base->query($requete);
                while($resultat = $resultats->fetch_array())
                {
                    echo "<th>".$resultat['nom']."</th>";
                }
                $resultats->close();
            ?>
        </tr>
        <?php
            $requeteId = "SELECT * FROM identifiant";
            $resultatsId = $base->query($requeteId);
            $rowcount = mysqli_num_rows($resultatsId);
            $rowcount = $rowcount-1;
            $i = 1;
            while(($resultatId = $resultatsId->fetch_array()) || ($i == $rowcount+1))
            {
                echo "<tr>";
                if($resultatId['codeIdentifiant'] != 'TEXT_CONSIGNE'){
                    echo "<td>".$resultatId['codeIdentifiant']."</td>";
                }

                $requete = "SELECT * FROM traduction GROUP BY codeLangue";
                $resultats = $base->query($requete);

                while(($resultat = $resultats->fetch_array()))
                {
                    $requeteTraductions = "SELECT * FROM traduction WHERE codeLangue='".$resultat['codeLangue']."' AND codeIdentifiant='".$resultatId['codeIdentifiant']."' AND codeIdentifiant <> 'TEXT_CONSIGNE'";
                    $resultatsTraductions = $base->query($requeteTraductions);

                    $j = 1;
                    while(($resultatTrad = $resultatsTraductions->fetch_array()))
                    {
                        echo '<td><input type="text" name="'.$resultatTrad['codeLangue'].'-'.$resultatTrad['codeIdentifiant'].'" value="'.$resultatTrad['traduction'].'" class="champ_text_transparent" onkeyup="updateTraduction(\''.$resultatTrad['codeLangue'].'-'.$resultatTrad['codeIdentifiant'].'\')" /></td>';
                    }
                }
                echo '</tr>';
                $i = $i+1;
            }
        ?>
    </table>
</section>

<!--POP-UP AU CLIC SUR "AJOUTER UNE LANGUE"-->
<div class="pop-up">
    <i class="fa fa-times-circle-o close"></i>
    <div class="box">
        <h3><?php echo AJOUTER_UNE_LANGUE; ?></h3>
        <form action="includes/traitement.php" method="post" enctype="multipart/form-data">
            <input type="text" name="codeLangue" id="codeLangue" placeholder="<?php echo CODE_LANGUE; ?>*"/>
            <input type="text" name="nom" id="nom" placeholder="<?php echo NOM_DE_LA_LANGUE; ?>*"/>
            <div id="fileLangClic">
                <span id="indicationUploadImg"><?php echo AJOUTER_UN_DRAPEAU; ?></span>
            </div>
            <input type="hidden" name="lienDrapeau" id="lienDrapeau"/>
            <input type="file" name="file" id="fileLang" style="visibility: hidden" />
            <input type="submit" value="<?php echo AJOUTER; ?>" name="ajoutLangue"/>
        </form>
    </div>
</div>

<!--POP-UP AU CLIC SUR "CONSIGNE"-->
<div class="pop-up-consigne">
    <i class="fa fa-times-circle-o close"></i>
    <div class="box">
        <h3><?php echo MODIFIER_LA_CONSIGNE; ?></h3>

            <ul class="tabs">
                <?php
                    $requete = "SELECT * FROM langue";
                    $resultats = $base->query($requete);
                    while(($resultat = $resultats->fetch_array())){
                        echo "<li><a href='#' title='consigne-".$resultat['codeLangue']."' class='tab'>".$resultat['nom']."</a></li>";
                    }
                ?>
            </ul>

            <?php
                $requeteLang = "SELECT * FROM langue";
                $resultatsLang = $base->query($requeteLang);
                while(($resultatLang = $resultatsLang->fetch_array())){
                    echo "<div class='content consigne-".$resultatLang['codeLangue']."'>";
                    echo "<form action='includes/traitement.php' method='post' enctype='multipart/form-data'>";
                    echo "<textarea name='consigne' id='consigne-".$resultatLang['codeLangue']."' cols='30' rows='10'>";
                        $requete = "SELECT traduction FROM traduction WHERE codeLangue='".$resultatLang['codeLangue']."' AND codeIdentifiant='TEXT_CONSIGNE'";
                        $resultats = $base->query($requete);
                        while($resultat = $resultats->fetch_array()){
                            echo $resultat['traduction'];
                        }
                    echo "</textarea>";
                    echo "<input type='hidden' name='codeLangue' value='".$resultatLang['codeLangue']."' />";
                    echo "<input type='hidden' name='codeIdentifiant' value='TEXT_CONSIGNE' />";
                    echo "<input type='submit' value='".MODIFIER."' name='modifierConsigne' />";
                    echo "<div class='error'></div>";
                    echo "</form>";
                    echo "</div>";
                }
            ?>
    </div>
</div>


<script>
    $(document).ready(function () {
        // Gestion des pop-up
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

        $(document).mouseup(function (e){
            var container = $(".pop-up-consigne");
            if (container.has(e.target).length === 0) {
                container.hide();
                document.body.style.overflow = 'auto';
            }
        });
        $(document).mouseup(function (e){
            var container = $(".pop-up");
            if (container.has(e.target).length === 0)
                container.hide();
            document.body.style.overflow = 'auto';
        });
        // tabs dans la pop-up de la consigne pour les différantes langues
        $("a[title*='consigne-FR']").addClass("active");
        $("a.tab").click(   function ()
            {
                $(".active").removeClass("active");

                $(this).addClass("active");

                $(".content").hide();

                var contenu_aff = $(this).attr("title");
                $("." + contenu_aff).show();
            }
        );

        // gestion de l'upload du fichier drapeau
        $('#fileLangClic').click(function(){
            $('#fileLang').click();
        });
        $("#fileLang").on('change', function(e){
            var files = e.target.files;
            upload(files,0);
        });
        function upload(files, index){
            var file = files[index];
            var xhr = new XMLHttpRequest();

            xhr.addEventListener('load', function(e){
                var json = jQuery.parseJSON(e.target.responseText);
                if(index < files.length-1){
                    upload(files, index+1);
                }
                if(json.error){
                    alert(json.error);
                    return false;
                }
                if(json.content != ''){
                    $('#fileLangClic').html(json.content);
                }
                $('#lienDrapeau').val(json.link);

            });

            xhr.open('post', 'includes/uploadFlag.php', true);
            xhr.setRequestHeader('content-type', 'multipart/form-data');
            xhr.setRequestHeader('x-file-type', file.type);
            xhr.setRequestHeader('x-file-size', file.size);
            xhr.setRequestHeader('x-file-name', file.name);
            xhr.send(file);
        }
    });
    function updateTraduction(ID_element)
    {
        var value = document.getElementsByName(ID_element).item(0).value;
        console.log('http://'+window.location.host+'/Emolyse/includes/modifTraduction.php?ID_element='+escape(ID_element)
            +'&value='+escape(value));

        texte = file('http://'+window.location.host+'/Emolyse/includes/modifTraduction.php?ID_element='+escape(ID_element)
            +'&value='+escape(value));
    }
</script>
</body>
</html>
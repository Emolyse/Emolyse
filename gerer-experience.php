<?php
include('includes/header.php');
include('includes/en-tete.php');
//include('includes/nouvelleExperience.php');
$idExperience = $_GET['id'];
?>

<script type="text/javascript">
    jQuery(function($){
        // détection des événements à l'ajout d'une image (en drag & drop ou manuellement)
       $('.dropfile').dropfile();
       $('.dropfile').uploadFile(
           {
               message: "<?php echo AJOUTER; ?>"
           }
       );
    });
</script>
<input type="hidden" id="idExperience" value="<?php echo $idExperience; ?>"/>
<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php echo BTN_EXPERIMENTATEUR_HOME; ?></a></li>
        <li><a href="experimentateur-experiences.php"><?php echo BTN_EXPERIENCES; ?></a></li>
        <li><?php echo EXPERIENCE; ?></li>
    </ul>
</section>

<?php
    $requeteExperience = "SELECT * FROM experience WHERE idExperience=".$idExperience."";
    $resultatsExperience = $base->query($requeteExperience);
    while(($resultatExperience = $resultatsExperience->fetch_array())){
?>
    <section class="ajout-experience">
        <div class="params1">
            <input type="text" name="nom" id="champs-nom-experience" placeholder="<?php echo NOM; ?>" onkeyup="updateExperience('nom')" value="<?php echo $resultatExperience['nom']; ?>"/>
            <div id="btn-update-lang">
                <?php
                $requeteFlag = "SELECT lienDrapeau FROM langue WHERE codeLangue='".$resultatExperience['codeLangue']."'";
                $resultatsFlag = $base->query($requeteFlag);
                while($resultatFlag = $resultatsFlag->fetch_array()){
                    echo "<img src='".$resultatFlag['lienDrapeau']."'  id='current_flag_img'/>";
                }
                ?>
            </div>
            <input type="checkbox" name="syncroBras" onchange="updateExperience('syncroBras')" class="syncroBrasCheckbox" <?php if($resultatExperience['syncroBras'] == 1){echo "checked='checked'";}else{ echo('');}; ?>/> <?php echo AFFICHAGE_SYNCRO_BRAS; ?>


            <div id="langueAddExp">
            <i class="fa fa-times-circle-o closeAddExp"></i>
             <?php
                $requete = "SELECT * FROM langue";
                $resultats = $base->query($requete);
                while($resultat = $resultats->fetch_array()){
                    echo "<label class='radioImage'>";
                    echo "<input type='radio' name='codeLangue' value='".$resultat['codeLangue']."' id='".$resultat['lienDrapeau']."' class='codeLangueCheckbox' />";
                    echo "<img src='".$resultat['lienDrapeau']."'/>";
                    echo "</label>";
                }
             ?>
            </div>
            <a href="#" id="edit-consigne"><i class="fa fa-pencil"></i> <?php echo EDITER_LA_CONSIGNE; ?></a>

        </div>
        <div class="objet">
            <h3><?php echo OBJETS; ?></h3><input type="checkbox" name="random" onchange="updateExperience('random')" class="randomCheckbox" <?php if($resultatExperience['random'] == 1){echo "checked='checked'";}else{ echo('');}; ?>/> <?php echo AFFICHAGE_ALEATOIRE_OBJETS; ?>


            <ul id="delete" class="sortable"></ul>

            <div class="block-objets dropFile">
                <ul class="liste-objets sortable">
                    <?php
                        $requete = "SELECT * FROM produit WHERE idExperience=".$idExperience." ORDER BY position ASC";
                        $resultats = $base->query($requete);
                        $i = 0;
                        while(($resultat = $resultats->fetch_array())){
                            echo "<li class='objets ui-state-default' data-order='".$resultat['position']."' data-id='".$resultat['idProduit']."'>";
                            echo "<img src='".$resultat['lienPhoto']."' />";
                            echo "</li>";
                            $i++;
                        }
                    ?>
                </ul>
                <div id="manualAdd"></div>
                <input type="file" style="visibility: hidden;" name="lienPhoto" id="lienPhoto" multiple/>
            </div>
        </div>
        <div class="environnement">
            <h3><?php echo ENVIRONNEMENT; ?></h3>
            <div class="select-environnement">
                <?php
                $requeteEnv = "SELECT * FROM environnement";
                $resultatsEnv = $base->query($requeteEnv);
                while($resultatEnv = $resultatsEnv->fetch_array()){
                    echo "<label class='radioEnv'>";
                    if($resultatEnv['idEnvironnement'] == $resultatExperience['idEnvironnement']){
                        $checked = "checked";
                    }else{
                        $checked = "";
                    }
                    echo "<input type='radio' name='idEnvironnement' value='".$resultatEnv['idEnvironnement']."' id='".$resultatEnv['lienEnvironnement']."' class='apercuEnvCheckbox' ".$checked."/>";
                    echo "<img src='".$resultatEnv['lienEnvironnement']."' class='apercuEnv' />";
                    echo "</label>";
                }
                ?>
            </div>
        </div>
        <input type="submit" id="btn-add-experience" style="visibility: hidden" name="add-experience" value="<?php echo AJOUTER; ?>"/>

    <!--POP-UP AU CLIC SUR "CONSIGNE"-->
    <div class="pop-up-consigne">
        <i class="fa fa-times-circle-o close"></i>
        <div class="box">
            <h3><?php echo MODIFIER_CONSIGNE_PAR_DEFAUT; ?></h3>

            <?php
            if($resultatExperience['consigne'] == ''){
                $codeLangue = $_SESSION['lang'];
                $requeteConsigne = "SELECT traduction FROM traduction WHERE codeIdentifiant = 'CONSIGNE' AND codeLangue='$codeLangue'";
                $resultatsConsigne = $base->query($requeteConsigne);
                while(($resultatConsigne = $resultatsConsigne->fetch_array())){
                    echo "<div class='content'>";
                    echo "<form action='includes/traitement.php' method='post' enctype='multipart/form-data'>";
                    echo "<textarea name='consigne' cols='30' rows='10'>";
                    echo $resultatConsigne['traduction'];
                    echo "</textarea>";
                    echo "<input type='hidden' name='idExperience' value='".$idExperience."' />";
                    echo "<input type='submit' value='".MODIFIER."' name='modifierConsigneExperience' />";
                    echo "</form>";
                    echo "</div>";
                }
            }else{
                echo "<div class='content'>";
                echo "<form action='includes/traitement.php' method='post' enctype='multipart/form-data'>";
                echo "<textarea name='consigne' cols='30' rows='10'>";
                echo $resultatExperience['consigne'];
                echo "</textarea>";
                echo "<input type='hidden' name='idExperience' value='".$idExperience."' />";
                echo "<input type='submit' value='".MODIFIER."' name='modifierConsigneExperience' />";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        // au click sur le picto image de l'expérience on affiche une div pour choisir une langue
        $('#btn-update-lang img').click(function() {
            $('#langueAddExp').show();
        });
        // Dans la div sui apparait avec toutes les langues que l'on peut choisir si on click sur la croix la div disparait
        $('.closeAddExp').click(function(){
            $('#langueAddExp').hide();
        });
        // quand on click sur un drapeau au choix dans la div des langues dispos le drapeau derrière change et on change dans la base la valeurs avec la fonction 'updateExperience'
        $( "input.codeLangueCheckbox" ).on( "click", function() {
            var current_flag = $("input.codeLangueCheckbox:checked").attr("id");
            var current_flag_value = $("input.codeLangueCheckbox:checked").attr("name");
            updateExperience(current_flag_value);
            $('#current_flag_img').attr('src', current_flag);
        });

        // pour changer d'environnement
        $( "input.apercuEnvCheckbox" ).on( "click", function() {
            var current_env_value = $("input.apercuEnvCheckbox:checked").attr("name");
            updateExperience(current_env_value);
        })

        // suppression d'un produit
        document.oncontextmenu = function() {return false;}; // suppression de l'apparition de la pop-up au clic long

        // quand on click sur la croix dans la pop-up de la consigne de l'expérience on ferme celle-ci
        $(".close").click(function() {
            $('.pop-up').hide();
            $('.pop-up-consigne').hide();
            document.body.style.overflow = 'auto';
        });
        // pop-up de la langue qui disparait si on clique en dehors
        $(document).mouseup(function (e){
            var container = $("#langueAddExp");
            if (container.has(e.target).length === 0)
                container.hide();
        });
        // pop-up de la consigne qui disparait si on clique en dehors
        $(document).mouseup(function (e){
            var container = $(".pop-up-consigne");
            if (container.has(e.target).length === 0)
                container.hide();
        });

        // quand on click sur "éditer la consigne" une pop-up apparait
        $("#edit-consigne").click(function() {
            $('.pop-up-consigne').show();
            $(".content").show();
            document.body.style.overflow = 'hidden';
        });

    });

    // fonction d'enregistrement de l'experience avec en paramètre le nom de l'éléments modifié
    var idExperience = $('#idExperience').val();
    var value = '';
    function updateExperience(element)
    {
        if(element == 'random'){
            if($('.randomCheckbox').prop('checked')){
                value = 1;
            }else{
                value = 0;
            }
        }
        if(element == 'syncroBras'){
            if($('.syncroBrasCheckbox').prop('checked')){
                value = 1;
            }else{
                value = 0;
            }
        }
        if(element == 'codeLangue'){
            value = $(".codeLangueCheckbox:checked").val();
        }
        if(element == 'idEnvironnement'){
            value = $(".apercuEnvCheckbox:checked").val();
        }
        if(element == 'nom' && element != 'codeLangue'){
            value = document.getElementsByName(element).item(0).value;
        }
        texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?element='+escape(element)
            +'&value='+escape(value)
            +'&id='+escape(idExperience)
            +'&updateExperience="updateExperience"'
        )
    }
</script>

</body>
</html>
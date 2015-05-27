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
       $('.dropfile').uploadFile();
    });
</script>
<input type="hidden" id="idExperience" value="<?php echo $idExperience; ?>"/>
<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a></li>
        <li><a href="experimentateur-experiences.php"><?php if(BTN_EXPERIENCES != ''){echo BTN_EXPERIENCES;}else{ echo('BTN_EXPERIENCES');}; ?></a></li>
        <li><?php if(EXPERIENCE != ''){echo EXPERIENCE;}else{ echo('EXPERIENCE');}; ?></li>
    </ul>
</section>

<?php
    $requeteExperience = "SELECT * FROM experience WHERE idExperience=".$idExperience."";
    $resultatsExperience = $base->query($requeteExperience);
    while(($resultatExperience = $resultatsExperience->fetch_array())){
?>

<section class="ajout-experience">
<!--    <form action="#" id="formulaire-experience">-->
        <div class="params1">
            <input type="text" name="nom" id="champs-nom-experience" onkeyup="updateExperience('nom')" value="<?php if($resultatExperience['nom'] != ''){echo $resultatExperience['nom'];}else{ echo('');}; ?>"/>
            <div id="btn-update-lang">
                <?php
                    $requeteFlag = "SELECT lienDrapeau FROM langue WHERE codeLangue='".$resultatExperience['codeLangue']."'";
                    $resultatsFlag = $base->query($requeteFlag);
                    while($resultatFlag = $resultatsFlag->fetch_array()){
                        echo "<img src='".$resultatFlag['lienDrapeau']."'  id='current_flag_img'/>";
                    }
                ?>

            </div>

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
            <a href="#" id="edit-default-consigne"><i class="fa fa-pencil"></i> <?php if(EDITER_LA_CONSIGNE != ''){echo EDITER_LA_CONSIGNE;}else{ echo('CONSIGNE');}; ?></a>

        </div>
        <div class="objet">
            <h3><?php if(OBJETS != ''){echo OBJETS;}else{ echo('OBJETS');}; ?></h3><input type="checkbox" name="random" onchange="updateExperience('random')" class="randomCheckbox" <?php if($resultatExperience['random'] == 1){echo "checked='checked'";}else{ echo('');}; ?>/> <?php if(AFFICHAGE_ALEATOIRE_OBJETS != ''){echo AFFICHAGE_ALEATOIRE_OBJETS;}else{ echo('AFFICHAGE_ALEATOIRE_OBJETS');}; ?>
            <div class="block-objets dropFile">
                <ul class="liste-objets" id="sortable">
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
<!--                <div class="dropFile"></div>-->
                <div id="manualAdd"></div>
                <input type="file" style="visibility: hidden;" name="lienPhoto" id="lienPhoto" multiple/>
            </div>
        </div>
        <div class="environnement">
            <h3><?php if(ENVIRONNEMENT != ''){echo ENVIRONNEMENT;}else{ echo('ENVIRONNEMENT');}; ?></h3>
            <div class="select-environnement">
                <button type="button" id="add-env"><i class="fa fa-plus-circle"></i></button>
            </div>
        </div>
        <input type="submit" id="btn-add-experience" style="visibility: hidden" name="add-experience" value="<?php if(AJOUTER != ''){echo AJOUTER;}else{ echo('AJOUTER');}; ?>"/>
<!--    </form>-->
    <!--POP-UP AU CLIC SUR "CONSIGNE"-->
    <div class="pop-up-consigne">
        <i class="fa fa-times-circle-o close"></i>
        <div class="box">
            <h3>Modifier la consigne par défaut</h3>

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
                    echo "<input type='submit' value='Modifier' name='modifierConsigneExperience' />";
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
                echo "<input type='submit' value='Modifier' name='modifierConsigneExperience' />";
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
        $( "input" ).on( "click", function() {
            var current_flag = $("input:checked").attr("id");
            var current_flag_value = $("input:checked").attr("name");
            updateExperience(current_flag_value);
            $('#current_flag_img').attr('src', current_flag);
        });

        // suppression d'un produit
        document.oncontextmenu = function() {return false;}; // suppression de l'apparition de la pop-up au clic long

        var timeoutId = 0;
        $('.liste-objets').on('mousedown','.objets', function(){
            var id = $(this).attr("data-id");
            var idExperience = $('#idExperience').val();
            timeoutId = setTimeout(function(){
                var r = confirm("Etes vous sûr de vouloir supprimer ce produit ?");
                if (r == true) {
                    texte = file('http://'+window.location.host+'/Emolyse/Emolyse/includes/traitement.php?id='+escape(id)
                        +'&idExperience='+escape(idExperience)
                        +'&deleteProduit="deleteProduit"'
                    )
                    location.reload();
                }
            }, 1000);
        }).bind('mouseup mouseleave', function() {
            clearTimeout(timeoutId);

        });

        // quand on click sur la croix dans la pop-up de la consigne de l'expérience on ferme celle-ci
        $(".close").click(function() {
            $('.pop-up').hide();
            $('.pop-up-consigne').hide();
            document.body.style.overflow = 'auto';
        });

        // quand on click sur "éditer la consigne" une pop-up apparait
        $("#edit-default-consigne").click(function() {
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
        if(element == 'codeLangue'){
            value = $(".codeLangueCheckbox:checked").val();
        }
        console.log(element);
        if(element == 'nom' && element != 'codeLangue'){
            value = document.getElementsByName(element).item(0).value;
        }

        texte = file('http://'+window.location.host+'/Emolyse/Emolyse/includes/traitement.php?element='+escape(element)
            +'&value='+escape(value)
            +'&id='+escape(idExperience)
            +'&updateExperience="updateExperience"'
        )
    }

</script>

</body>
</html>
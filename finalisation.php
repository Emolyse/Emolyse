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

if(isset($_POST['data'])) {
    $data = $_POST['data'];
    $decodeData = json_decode($data);
    $sexeAvatar = $decodeData[0]->sexeAvatar;
}
else{
    header("Location: ./participant-accueil.php");
}
?>
<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php echo FINALISATION; ?></li>
    </ul>
</section>

<section class="nouvelle-experience">
    <div class="avatarFinal"><img src="images/imgAvatar/<?php if($sexeAvatar == 'M') echo 'avatar_man.png'; else echo 'avatar_woman.png'?>" alt="resumé de l'avatar" id="recapAvatar"/></div>
    <div class="form-finalisation">
        <form action="includes/traitement.php" method="post" enctype="multipart/form-data" onsubmit="return validationForm()">
            <div class="titreForm">
                <?php echo EXPERIENCE_TERMINEE; ?>
            </div>
            <div class="infosParticipants">
                <div class="sexeForm">
                    <label style="<?php if(isset($_GET['erreur']) == 'sexe'){echo "color: red;";}else{ echo "";}; ?>"><?php echo SEXE; ?>* : </label>
                    <input type="radio" name="sexe" value="F"> <?php echo FEMME; ?>
                    <input type="radio" name="sexe" value="M"> <?php echo HOMME; ?>
                </div>
                <div class="dateNaissForm">
                    <label style="<?php if(isset($_GET['erreur']) == 'naissance'){echo "color: red;";}else{ echo "";}; ?>"><?php echo NEE_LE; ?>* :</label>
                    <select name="jour" id="select-jour">
                        <option value="">--</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select name="mois" id="select-mois">
                        <option value="">---</option>
                        <option value="01"><?php echo JANVIER; ?></option>
                        <option value="02"><?php echo FEVRIER; ?></option>
                        <option value="03"><?php echo MARS; ?></option>
                        <option value="04"><?php echo AVRIL; ?></option>
                        <option value="05"><?php echo MAI; ?></option>
                        <option value="06"><?php echo JUIN; ?></option>
                        <option value="07"><?php echo JUILLET; ?></option>
                        <option value="08"><?php echo AOUT; ?></option>
                        <option value="09"><?php echo SEPTEMBRE; ?></option>
                        <option value="10"><?php echo OCTOBRE; ?></option>
                        <option value="11"><?php echo NOVEMBRE; ?></option>
                        <option value="12"><?php echo DECEMBRE; ?></option>
                    </select>
                    <select name="annee" id="select-annee">
                        <option value="">--</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                        <option value="2013">2013</option>
                        <option value="2012">2012</option>
                        <option value="2011">2011</option>
                        <option value="2010">2010</option>
                        <option value="2009">2009</option>
                        <option value="2008">2008</option>
                        <option value="2007">2007</option>
                        <option value="2006">2006</option>
                        <option value="2005">2005</option>
                        <option value="2004">2004</option>
                        <option value="2003">2003</option>
                        <option value="2002">2002</option>
                        <option value="2001">2001</option>
                        <option value="2000">2000</option>
                        <option value="1999">1999</option>
                        <option value="1998">1998</option>
                        <option value="1997">1997</option>
                        <option value="1996">1996</option>
                        <option value="1995">1995</option>
                        <option value="1994">1994</option>
                        <option value="1993">1993</option>
                        <option value="1992">1992</option>
                        <option value="1991">1991</option>
                        <option value="1990">1990</option>
                        <option value="1989">1989</option>
                        <option value="1988">1988</option>
                        <option value="1987">1987</option>
                        <option value="1986">1986</option>
                        <option value="1985">1985</option>
                        <option value="1984">1984</option>
                        <option value="1983">1983</option>
                        <option value="1982">1982</option>
                        <option value="1981">1981</option>
                        <option value="1980">1980</option>
                        <option value="1979">1979</option>
                        <option value="1978">1978</option>
                        <option value="1977">1977</option>
                        <option value="1976">1976</option>
                        <option value="1975">1975</option>
                        <option value="1974">1974</option>
                        <option value="1973">1973</option>
                        <option value="1972">1972</option>
                        <option value="1971">1971</option>
                        <option value="1970">1970</option>
                        <option value="1969">1969</option>
                        <option value="1968">1968</option>
                        <option value="1967">1967</option>
                        <option value="1966">1966</option>
                        <option value="1965">1965</option>
                        <option value="1964">1964</option>
                        <option value="1963">1963</option>
                        <option value="1962">1962</option>
                        <option value="1961">1961</option>
                        <option value="1960">1960</option>
                        <option value="1959">1959</option>
                        <option value="1958">1958</option>
                        <option value="1957">1957</option>
                        <option value="1956">1956</option>
                        <option value="1955">1955</option>
                        <option value="1954">1954</option>
                        <option value="1953">1953</option>
                        <option value="1952">1952</option>
                        <option value="1951">1951</option>
                        <option value="1950">1950</option>
                        <option value="1949">1949</option>
                        <option value="1948">1948</option>
                        <option value="1947">1947</option>
                        <option value="1946">1946</option>
                        <option value="1945">1945</option>
                        <option value="1944">1944</option>
                        <option value="1943">1943</option>
                        <option value="1942">1942</option>
                        <option value="1941">1941</option>
                        <option value="1940">1940</option>
                    </select>
                </div>
                <div class="infos">
                    <div class="nomForm">
                        <input type="text" name="nom" placeholder="<?php echo NOM; ?>"/>
                    </div>
                    <div class="prenomForm">
                        <input type="text" name="prenom" placeholder="<?php echo PRENOM; ?>"/>
                    </div>
                </div>
                <div class="fileForm">
                    <div id="filePhotoUserClic"><span id="indicationUploadImg">Ajouter une photo</span>
                    </div>
                    <input type="hidden" name="lienPhotoUser" id="lienPhotoUser"/>
                    <input type="hidden" name="data" id="data"/>
                    <input type="file" name="file" id="filePhotoUser" style="visibility: hidden" />
                </div>
                <input type="submit" id="finaliser-experience" name="finaliser-experience" value="<?php echo FINALISER; ?>"/>
                <span class="obligatoire">* <?php echo CHAMPS_OBLIGATOIRE; ?></span>
            </div>
        </form>
    </div>
</section>
<script>
    $(document).ready(function () {
        var data = JSON.stringify(<?php echo $data ?>);
        $("#data").attr("value",data);
        // Custom du bouton d'upload d'une image et envoie des infos pour enregistrement
        $('#filePhotoUserClic').click(function(){
            $('#filePhotoUser').click();
        });
        $("#filePhotoUser").on('change', function(e){
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
                $('#filePhotoUserClic').html(json.content);
            }
            $('#lienPhotoUser').val(json.link);
        });

            xhr.open('post', 'includes/uploadPhotoUser.php', true);
            xhr.setRequestHeader('content-type', 'multipart/form-data');
            xhr.setRequestHeader('x-file-type', file.type);
            xhr.setRequestHeader('x-file-size', file.size);
            xhr.setRequestHeader('x-file-name', file.name);
            xhr.send(file);
        }

    });

    function validationForm(){
        var retour = true;
        $(".sexeForm label").css({'color': 'black'});
        $(".dateNaissForm label").css({'color': 'black'});

        if ($("input[name='sexe']").val() == '' || $("select[name='jour']").val() == '' || $("select[name='mois']").val() == '' || $("select[name='annee']").val() == '' ) {
            retour = false;
        }

        if (!$("input[name='sexe']").is(":checked") ) {
            $(".sexeForm label").css({'color': 'red'});
        }

        if ($("select[name='jour']").val() == '' || $("select[name='mois']").val() == '' || $("select[name='annee']").val() == '' ) {
            $(".dateNaissForm label").css({'color': 'red'});
        }

        return retour;
    }
</script>

</body>
</html>
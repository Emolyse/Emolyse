<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><?php if(NOUVELLE_EXPERIENCE != ''){echo NOUVELLE_EXPERIENCE;}else{ echo('NOUVELLE_EXPERIENCE');}; ?></li>
    </ul>
</section>

<section class="nouvelle-experience">
    <div class="avatarFemme"></div>
    <div>
        <form action="#">
            <select name="experience" id="select-experience">
                <option value="202-tactile">Tactile</option>
                <option value="203-cuisine">Cuisine</option>
            </select>
            <input type="submit" id="btn-start-experience" name="start-experience" value="<?php if(DEMARRER != ''){echo DEMARRER;}else{ echo('DEMARRER');}; ?>"/>
        </form>
    </div>
    <div class="avatarHomme"></div>
</section>

</body>
</html>
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
        <li><?php echo BTN_EXPERIMENTATEUR_HOME; ?></li>
    </ul>
</section>

<section class="menu_experimentateur">
    <ul>
        <li><a href="experimentateur-experiences.php" class="btn-experimentateur-home"><i class="fa fa-flask"></i> <?php echo BTN_EXPERIENCES; ?></a></li>
        <li><a href="experimentateur-participants.php?order=name" class="btn-experimentateur-home"><i class="fa fa-user"></i> <?php echo BTN_PARTICIPANTS; ?></a></li>
        <li><a href="parametres.php" class="btn-experimentateur-home"><i class="fa fa-cog"></i> <?php echo BTN_PARAMETRES; ?></a></li>
    </ul>
</section>

</body>
</html>
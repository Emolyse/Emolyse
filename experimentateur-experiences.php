<?php
include('includes/header.php');
include('includes/en-tete.php');
?>

<section class="breadcrumb">
    <ul>
        <li><a href="index.php"><img src="images/home.png" alt="Revenir à l'accueil de l'application" id="pictoHome"/></a></li>
        <li><a href="experimentateur-accueil.php">Expérimentateur</a></li>
        <li>Expérience</li>
    </ul>
</section>

<section class="liste-experience">
    <a href="ajouter-experience.php"><i class="fa fa-plus-circle"></i></a>
    <a href="#"><i class="fa fa-download telecharger-tout"></i></a>
    <table class="table-experience">
        <thead>
        <th></th>
        <th>Id</th>
        <th>Nom</th>
        <th></th>
        <th></th>
        </thead>
        <tbody>
        <tr>
            <td><img src="images/tablette.png" alt="aperçu de l'expérience"/></td>
            <td>202</td>
            <td>Tactile</td>
            <td><a href="#"><i class="fa fa-download"></i></a></td>
            <td><a href="#"><i class="fa fa-minus"></i></a></td>
        </tr>
        <tr>
            <td><img src="images/tablette.png" alt="aperçu de l'expérience"/></td>
            <td>203</td>
            <td>Cuisine</td>
            <td><a href="#"><i class="fa fa-download"></i></a></td>
            <td><a href="#"><i class="fa fa-minus"></i></a></td>
        </tr>
        <tr>
            <td><img src="images/tablette.png" alt="aperçu de l'expérience"/></td>
            <td>204</td>
            <td>Musique</td>
            <td><a href="#"><i class="fa fa-download"></i></a></td>
            <td><a href="#"><i class="fa fa-minus"></i></a></td>
        </tr>
        </tbody>
    </table>
</section>

</body>
</html>
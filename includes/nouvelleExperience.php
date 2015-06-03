<?php
include("connexion.php");

$requete = "INSERT INTO experience VALUES ('', '1', '', '', '', 'FR', '0', '0')";
$base->query($requete);

$id = $base->insert_id;

$base->close();

header("Location: ../gerer-experience.php?id=$id");

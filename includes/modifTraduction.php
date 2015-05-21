<?php
include('header.php');

// Modification des traductions dans la table 'traduction' en fonction de l'ID de la trad, de son code langue et de son code identifiant
$ID_element = $_GET['ID_element'];
$value = $_GET['value'];

list($codeLangue, $codeIdentifiant) = split('[-]', $ID_element);

$requete = "UPDATE traduction SET traduction='".$value."' WHERE codeLangue='".$codeLangue."' AND codeIdentifiant='".$codeIdentifiant."'";
$base->query($requete);

$base->close();;

unset($ID_element);
unset($codeLangue);
unset($codeIdentifiant);

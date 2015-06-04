<?php
include('header.php');
//RECUPERATION DES FORMULAIRES EN GET
$ID_element = $_GET['ID_element'];
$value = $_GET['value'];
list($codeLangue, $codeIdentifiant) = split('[-]', $ID_element);

$requete = "UPDATE traduction SET traduction='".addslashes($value)."' WHERE codeLangue='".$codeLangue."' AND codeIdentifiant='".$codeIdentifiant."'";
$base->query($requete);
$base->close();

unset($ID_element);
unset($codeLangue);
unset($codeIdentifiant);
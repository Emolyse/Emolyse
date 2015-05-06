<?php
    session_start();
    include("init.php");
    include("connexion.php");
    include("lang.php");
?>
<html>
<head>
    <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Alizee ARNAUD, Jordan DAITA, Rémy DROUET" />

    <title>Emolyse</title>

    <link rel="stylesheet" href="../Emolyse/styles/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../Emolyse/styles/style.css"/>
</head>
<body>
<form action="" method="get">
    <input type="submit" name="lang" value="FR" />
    <input type="submit" name="lang" value="EN" />
</form>

<?php
    define ('SERVEUR_BD','localhost');
    define ('LOGIN_BD','root');
    define ('PASS_BD','');
    define ('NOM_BD','emolyse');

    $base = mysqli_connect(SERVEUR_BD, LOGIN_BD, PASS_BD, NOM_BD);

    /* Vérification de la connexion */
    if (mysqli_connect_errno()) {
        printf("Échec de la connexion : %s\n", mysqli_connect_error());
        exit();
    }
?>
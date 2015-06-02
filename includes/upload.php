<?php
    header('content-type: application/json');
    include("connexion.php");
    $h = getallheaders();
    $o = new stdClass();
    $source = file_get_contents('php://input');
    $types = Array('image/png', 'image/gif', 'image/jpeg');

//    echo '<pre>', print_r($h['x-file-type'], 1), '</pre>';
    if(!in_array($h['x-file-type'], $types)){
        $o->error = 'Format du fichier non supporté';
    }else{

        $nameOriginal = $h['x-file-name'];
        $name = pathinfo($nameOriginal);
        $name = $name['filename'];
        $idExperience = $h['idExperience'];

        file_put_contents('../images/imgExperience/'.$idExperience.'-'.$h['x-file-name'], $source);
        $o->name = $h['x-file-name'];

        $requeteMax = "SELECT MAX(position) as max FROM produit WHERE idExperience=".$idExperience."";
        $resultatsMax = $base->query($requeteMax);
        while(($resultat = $resultatsMax->fetch_array())){
            $position = $resultat['max'];
        }
        $position = $position+1;

        $requeteInsert = "INSERT INTO produit VALUES ('', '".$idExperience."', '".$position."','".$name."', 'images/imgExperience/".$idExperience."-".$nameOriginal."')";
        $base->query($requeteInsert);

        $id = $base->insert_id;
        $o->content = '<li class="objets ui-state-default ui-sortable-handle" data-id="'.$id.'" ><img src="images/imgExperience/'.$idExperience.'-'.$h['x-file-name'].'" /></li>';

        // on compte le nombre de produits dans la base
        $requeteCountProduit = "SELECT * FROM produit WHERE idExperience=".$idExperience."";
        $resultatsCountProduit = $base->query($requeteCountProduit);
        $count = 0;
        while(($resultatsCountProduit->fetch_array())){
            $count++;
        }

        $o->count = $count;

        // on modifie la ligne de l'experience pour mettre à jour le nombre de produits
        $requeteUpdateNbProduit = "UPDATE experience SET nbProduit=".$count." WHERE idExperience=".$idExperience."";
        $base->query($requeteUpdateNbProduit);

        $base->close();
    }

    echo json_encode($o);

<?php
    header('content-type: application/json');
    $h = getallheaders();
    $o = new stdClass();
    $source = file_get_contents('php://input');
    $types = Array('image/png', 'image/gif', 'image/jpeg');

    if(!in_array($h['x-file-type'], $types)){
        $o->error = 'Format du fichier non supporté';
    }else{
        file_put_contents('../images/imgUsers/'.$h['x-file-name'], $source);
        $o->name = $h['x-file-name'];

        $nameOriginal = $h['x-file-name'];
        $name = pathinfo($nameOriginal);
        $name = $name['filename'];

        $o->content = '<img src="images/imgUsers/'.$h['x-file-name'].'" id="apercuImgUser" />';
        $o->link = 'images/imgUsers/'.$h['x-file-name'];
    }

    echo json_encode($o);
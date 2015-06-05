<?php
session_start();
include("includes/init.php");
include("includes/connexion.php");
include("includes/lang.php");
?>
<!--<!DOCTYPE html>-->
<html lang="en">
<head>
    <title>three.js webgl - collada - skinning</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="styles/font-awesome.min.css">
    <style>
        body {
            color: #000;
            font-family: Arial;
            font-size: 13px;
            text-align: center;

            background-color: #000;
            margin: 0;
            overflow: hidden;
        }
        a {
            color: #f00;
        }
        #console {
            display: none;
            position: fixed;
            background-color: #ffffff;
            color: #000000;
            z-index: 1000;
            width: 100%;
            text-align: center;
            height: 45px;
            padding-top: 5px;
            font-size: 30px;
            opacity: 0.8;
        }
        #containerObjet {
            position: absolute;
            width: 15%;
            top: 23%;
            left: 76%;
        }
        .objet {
            display: none;
            width: 100%;
            position: absolute;
            color: red;
        }
        #resetButton {
            z-index: 1000;
            position: fixed;
            bottom: 20px;
            cursor: pointer;
            color: #fff;
            font-size: 66px;
            padding: 15px;
            left: 20px;
            transition: all 500ms ease;
        }
        .rotate360{
            -webkit-transform : rotate(360deg);
            transform : rotate(360deg);
        }
        .icon_env{
            display: block;
            color: #fff;
            font-size: 66px;
            padding: 15px;
        }
        #icon_confirm{
            display: none;
            color: #289148;
            font-size: 66px;
        }
        #icon-env{
            position: fixed;
            display: block;
            bottom: 20px;
            right: 20px;
        }
        .display{
            display: block;
        }

        /* LOADER */
        .fullLoader {

            position: absolute;
            height: 100%;
            width: 100%;
            background: #262526;
            z-index: 9999;
        }
        .loader {
            font-size: 10px;
            margin: 25em auto;
            text-indent: -9999em;
            width: 11em;
            height: 11em;
            border-radius: 50%;
            background: #ffffff;
            background: -moz-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -webkit-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -o-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: -ms-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            background: linear-gradient(to right, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
            position: relative;
            -webkit-animation: load3 1.4s infinite linear;
            animation: load3 1.4s infinite linear;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }
        .loader:before {
            width: 50%;
            height: 50%;
            background: #FFF;
            border-radius: 100% 0 0 0;
            position: absolute;
            top: 0;
            left: 0;
            content: '';
        }
        .loader:after {
            background: #262526;
            width: 75%;
            height: 75%;
            border-radius: 50%;
            content: '';
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        @-webkit-keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes load3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .txtLoading{
            color: #fff;
            font-size: 20px;
            position: relative;
            margin-top: -17%;
        }
        .logoChargement{
            width: 250px;
        }

        /*OVERLAY INSTRUCTION*/
        #overlay-instruction{
            position: fixed;
            z-index: 9998;
            width: 70%;
            height: 70%;
            opacity: 0.85;
            background-color: #262526;
            color: #FFFFFF;
            padding: 15%;
        }
        #overlay-content{
        }
        #overlay-content h1{
            font-size: 3em;
            text-align: left;
            border-bottom: solid 1px #FFFFFF;
        }
        #overlay-content p{
            text-align: justify;
            font-size: 1.4em;
        }
        .btn-overlay{
            border : solid 1px #FFFFFF;
            font-size: 2em;
            display: inline-block;
            margin : 10% 10% auto 10%;
            padding : 10px;
            cursor: pointer;
        }

        /*FINALIZER*/
        #finalizer{
            display: none;
            width: 0;
            height: 0;
            position: fixed;
            z-index: 1000;
            left:50%;
            top: 50%;
            padding: 20px;
            background-color: #FFFFFF;
            border : solid 3px #aaaaaa;
            border-radius : 10px;
            opacity: 0;
            box-sizing: border-box;
        }
        #finalizer div{
            opacity: 0;
        }
        #finalizer span {
            font-size: 1.5em;
            display: inline-block;
            max-width: 90%;
            text-align: left;
        }#finalizer p {
             font-size: 2em;
         }
        #finalizer i{
            font-size: 4em;
            display: inline-block;
            color: #00B236;
        }
        #console-tuto{
            display: none;
            z-index: 1000;
            width: 100%;
            text-align: center;
            position: fixed;
            top : 50%;
            color: #ffffff;
            text-shadow: 4px 4px #333333;
            font-size: 4em;
        }
        #arrow-right, #arrow-left, #move-arrow{
            position: fixed;
            display: none;
            width: 15%;
        }

        #double-arrow{
            position: fixed;
            display: none;
            width: 30%;
        }
    </style>
</head>
<body>
<div class="fullLoader">
    <div class="loader">Loading...</div>
    <p class="txtLoading">Chargement de l'application</p>
    <img src="images/logo.png" alt="" class="logoChargement "/>
</div>
<i class="fa fa-refresh icon-refresh" id="resetButton"></i>

<div id="console"></div>
<div id="containerObjet">
    <?php
    if(isset($_GET['experience'])){
        $nbObjet = 0;
        $experience = $_GET['experience'];
        $reqExp = "SELECT consigne, nbProduit, codeLangue, syncroBras, random, lienEnvironnement from experience exp, environnement env where exp.idEnvironnement=env.idEnvironnement and exp.idExperience =".$experience;
        $resExp = $base->query($reqExp);
        while(($rowExp = $resExp->fetch_array())){
            //On récupère l'environnement
            $lienEnvironnement = $rowExp['lienEnvironnement'];

            //On vérifie si les bras doivent être synchronisés
            $synchroneArm = false;
            if($rowExp['syncroBras'] == 1){
                $synchroneArm = true;
            }

            //La consigne
            $consigne = $rowExp['consigne'];
            if($consigne == ''){
                if($rowExp['codeLangue'] == $_SESSION['lang']){
                    $consigne = TEXT_CONSIGNE;
                } else {
                    $reqConsigne = "SELECT traduction from traduction when codeLangue=".$rowExp['codeLangue']." and codeIdentifiant=TEXT_CONSIGNE";
                }
            }
            //Puis les Objets
            if($rowExp['random'] == 0){
                $reqObjet = "SELECT * FROM produit WHERE idExperience=".$experience." ORDER BY position ASC";
            }elseif($rowExp['random'] == 1){
                $reqObjet = "SELECT * FROM produit WHERE idExperience=".$experience." ORDER BY Rand()";
            }
            $resObjet = $base->query($reqObjet);
            while(($rowObjet = $resObjet->fetch_array())){
                $idObj[$nbObjet] = $rowObjet['idProduit'];
                $nbObjet++;
                $lienPhoto = $rowObjet['lienPhoto'];
                $idProduit = $rowObjet['idProduit'];
                echo "<img class='objet' src='".$lienPhoto."' id='produit-".$idProduit."' />";
            }
        }
    }


    ?>

</div>

<div id="overlay-instruction">
    <div id="overlay-content">
        <h1><?php echo CONSIGNE;?></h1>
        <p><?php echo $consigne;?></p>
        <div id="btn-tuto" class="btn-overlay"><?php echo TUTORIEL;?></div>
        <div id="btn-start" class="btn-overlay"><?php echo DEMARRER;?></div>
    </div>
</div>

<div id="icon-env">
    <i id="icon_confirm" class="fa fa-check-circle"></i>
    <i class="fa fa-chevron-circle-right icon_env"></i>
</div>

<div id="container"></div>

<div id="finalizer">
    <div>
        <p><?php echo FINALISATION;?> !</p>
        <span><?php echo  PHRASE_FIN;?></span>
        <i class="fa fa-arrow-circle-o-right"></i>
    </div>
</div>

<div id="console-tuto"></div>

<img id="arrow-right" src="images/arrow_right.png" alt="arrow-arm-rotation"/>
<img id="arrow-left" src="images/arrow_right.png" alt="arrow-arm-rotation"/>
<img id="double-arrow" src="images/double_arrow.png" alt="arrow-avatar-rotation"/>
<img id="move-arrow" src="images/arrow-move.png" alt="arrow-avatar-move"/>

<script src="js/three.min.js"></script>
<script src="js/ColladaLoader.js"></script>
<script src="js/Detector.js"></script>
<script src="js/jquery.min.js"></script>
<script src="scripts/file.js"></script>
<script>

    if (!Detector.webgl) Detector.addGetWebGLMessage();


    /*
     Information récupérees de la BDD
     */
    var nbObjects = <?php echo $nbObjet ?>;
    var idExperience = <?php echo $experience ?>;
    var idObj = [];
    <?php
        if(isset($idObj)){
            foreach($idObj as $cle=>$valeur){
                    echo "idObj[$cle] = $valeur;";
            }
        }
    ?>
    /*
     Information récupérees du get
     */

    var choixAvatar = '<?php echo $_GET['avatarselect'] ?>';
    var urlAvatar, sexeAvatar='F';
    var container;
    var data = [];
    var posScreen = new THREE.Vector3(170,120,-150);
    var camera, scene, currentFrame=0, renderer, backgroundScene, backgroundCamera, avatar;
    var targetList = [];
    var tutoTargets = [];
    var idBonesTargeted = [14, 17, 18];
    var intersects = [];
    var borneMin=-140, borneMax=30;
    var mousePosDown, mousePosMove;
    var animation, animationState;
    var originalSkeleton, skeleton;

    var avatarRotation = 0,lArmRotX = 0,lArmRotZ = 0, rArmRotX = 0, rArmRotZ = 0, bodyRot = 0;

    var clock = new THREE.Clock();
    var offsetWidth=0,offsetHeight=0;

    var synchroneArm = Boolean(<?php echo $synchroneArm ?>);
    var manipulable = false;

    var lockRotation = false;
    var lockMove = false;
    var iTuto = 0;

    var interval;

    init();

    function init() {
        container = document.getElementById('container');

        scene = new THREE.Scene();

//        var axisHelper = new THREE.AxisHelper(100);
//        scene.add(axisHelper);
        /***************
         *    CAMERA   *
         **************/
        camera = new THREE.PerspectiveCamera(25, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.set(0, 0, 500);
        camera.updateProjectionMatrix(true);
        camera.lookAt(new THREE.Vector3(0, 0, 0));

        camera.up.set(0, 0, 0);

        /***************
         *    LIGHT    *
         **************/
        var light = new THREE.DirectionalLight(0xF2D9B4, 1.8);
        light.castShadow = true;
        light.position.set(-500, 0, 0);
        light.lookAt(new THREE.Vector3(-5, 0, 0));
        scene.add(light);

        /***************
         *  RENDERER   *
         **************/
        renderer = new THREE.WebGLRenderer({antialias: true});
        renderer.setClearColor(0xfff4e5);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.sortObjects = false;

        container.appendChild(renderer.domElement);

        /*
         * Bones :
         *    6 : buste
         *   12 : bras droit
         *   13: bras gauche
         */
        //Url de l'avatar
        if(choixAvatar == 'man'){
            urlAvatar = 'Homme/avatar_man.dae';
            sexeAvatar = 'M';
        }
        else{
            urlAvatar = 'Femme/avatar_woman.dae'
            sexeAvatar = 'F';
        }
        loadAvatar(urlAvatar, function () {
            avatar.updateMatrixWorld(true);
            targetList = getTargetList(15,false);
            $(document).on('touchstart', onCanvasMouseDown);
            $("#resetButton").on('touchstart', function () {
                if(!lockMove && !lockRotation && manipulable) {
                    $(this).toggleClass("rotate360");
                    resetBones();
                }
            });
            loadScreen(function(){
                $('.fullLoader').hide();
            });
        });

        /************************************
         *          Environnement           *
         ************************************/
        var lienEnvironnement = "<?php echo $lienEnvironnement ?>";
        var texture = THREE.ImageUtils.loadTexture(lienEnvironnement);
        var backgroundMesh = new THREE.Mesh(
            new THREE.PlaneGeometry(2, 2, 0),
            new THREE.MeshBasicMaterial({
                map: texture
            }));

        backgroundMesh.material.depthTest = false;
        backgroundMesh.material.depthWrite = false;

        // Create your background scene
        backgroundScene = new THREE.Scene();
        backgroundCamera = new THREE.Camera();
        backgroundScene.add(backgroundCamera);
        backgroundScene.add(backgroundMesh);
        window.addEventListener('resize', onWindowResize, false);
        onWindowResize();
        render();

    }
    function onWindowResize() {

        camera.aspect = 16 / 9;
        backgroundCamera.aspect = 16 / 9;
        camera.updateProjectionMatrix();

        if(window.innerWidth / window.innerHeight > 16 / 9){
            offsetWidth = window.innerWidth - 16 * window.innerHeight / 9;
            offsetHeight = 0;
            renderer.setSize(window.innerWidth - offsetWidth, window.innerHeight);
            $('canvas').css({'marginTop':'0'});
        }else{
            offsetHeight = window.innerHeight - 9 * window.innerWidth / 16;
            offsetWidth = 0;
            renderer.setSize(window.innerWidth, window.innerHeight - offsetHeight);
            $('canvas').css({'marginTop':offsetHeight/2});
        }

        loadObject();
    }

    function render() {
        requestAnimationFrame( render, renderer.domElement );
        renderer.autoClear = false;
        renderer.antialias=true;
        renderer.clear();
        renderer.render( backgroundScene, backgroundCamera);
        renderer.render( scene, camera );
    }
    /*****************************************************************************************
     * @description Load the .dae file according to the name et initialize it in the scene   *
     * @param name                                                                           *
     * @param callback                                                                       *
     *****************************************************************************************/

    function loadAvatar(name, callback) {
        var loader = new THREE.ColladaLoader();
        loader.load("3D/dae/" + name, function (collada) {
            avatar = collada.skins[0];
            avatar.normalizeSkinWeights();
            console.log(avatar);
            scene.add(avatar);

            var skeleton = avatar.skeleton;

            for(var i = 0;i < avatar.material.materials.length;i++){
                avatar.material.materials[i].shininess = 10;
            }

            // create a smooth skin
            // On active la manipulation des bones sur tous les matériaux qui composent un mesh
            for (var i = 0; i < avatar.material.materials.length; i++) {
                avatar.material.materials[i].skinning = true;
            }
            avatar.castShadow = true;
            avatar.receiveShadow = true;
            avatar.skeleton.useVertexTexture = false;

            avatar.translateY(-80);


            skeleton.bones[12].rotateZ(THREE.Math.degToRad(30));
            skeleton.bones[12].rotateX(THREE.Math.degToRad(-15));
            skeleton.bones[13].rotateZ(THREE.Math.degToRad(-30));
            skeleton.bones[13].rotateX(THREE.Math.degToRad(-15));

            avatar.updateMatrixWorld(true);

            originalSkeleton = saveSkeleton();

            animation = new THREE.Animation( avatar, avatar.geometry.animation );
            animation.loop = true;
            animation.timeScale = 0.7;
            callback();
        });
    }

    function loadConsole(msg) {
        $("#console").text(msg);
    }

    function loadObject(){

        var w = $('canvas').height();
        var h = $('canvas').width();
        var t = w*0.18+offsetHeight/2;
        var l = h*0.76+offsetWidth/2;
        w = w*0.27;
        $('#containerObjet').css({
            'top': t+"px",
            'left': l+"px",
            'width' : w+"px"
        });
    }

    function loadScreen(callback){
        var loaderObject = new THREE.ColladaLoader();
        var screen;
        loaderObject.load("3D/dae/meubles/screen.dae", function (collada) {
            screen = collada.scene;
            scene.add(screen);
            screen.position.set(posScreen.x, posScreen.y, posScreen.z);
            screen.scale.set(1.0,0.75,0.75);
            screen.rotateY(THREE.Math.degToRad(-80));
            callback();
        });
    }

    /*******************************************************
     * @description Couch de dialogue avatar/touchInterface
     *******************************************************/

    function getTargetList(size,visible) {
        avatar.updateMatrixWorld(true);
        var res = [];
        for (var i = 0; i < idBonesTargeted.length; i++) {
            var target = sphereGenerator(size, "#01B0F0",visible);
            var pos = avatar.skeleton.bones[idBonesTargeted[i]].getWorldPosition();
            target.position.set(pos.x, pos.y, pos.z);
            target.name = avatar.skeleton.bones[idBonesTargeted[i]].name;
            scene.add(target);
            res.push(target);
        }
        //On créé la cible de rotation de l'avatar
        var avatarTarget = sphereGenerator(size, "#01B0F0",visible);
        avatarTarget.position.set(0, -80, 0);
        avatarTarget.name = 'avatarRot';
        scene.add(avatarTarget);
        res.push(avatarTarget);
        return res;
    }

    function updateTargets() {
        avatar.updateMatrixWorld(true);
        for (var i = 0; i < targetList.length - 1; i++) {
            var pos = avatar.skeleton.bones[idBonesTargeted[i]].getWorldPosition();
            targetList[i].position.set(pos.x, pos.y, pos.z);
            if(tutoTargets.length)
                tutoTargets[i].position.set(pos.x, pos.y, pos.z);
        }
        targetList[targetList.length - 1].position.setX(avatar.position.x);
        if(tutoTargets.length)
            tutoTargets[tutoTargets.length - 1].position.setX(avatar.position.x);
    }

    function onCanvasMouseDown(evt) {
        if(manipulable) {
            evt.preventDefault();
            evt = evt.originalEvent.changedTouches[0];
            var vector = mouseToWorld(evt);

            mousePosDown = vector.clone();
            mousePosMove = vector.clone();

            var raycaster = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());

            intersects = raycaster.intersectObjects(targetList);

            $(document).on('touchend', onDocumentMouseUp);
            if (intersects.length > 0) {
                $(document).on('touchmove', onContainerMouseMove);
            }
        }
    }

    function onDocumentMouseUp(evt) {
        evt.preventDefault();
        evt = evt.originalEvent.changedTouches[0];
        $(document).off('touchend');
        $(document).off('touchmove');
        if (intersects.length > 0) {
        } else {
            var mousePosUp = mouseToWorld(evt);
            var long = mousePosUp.x - mousePosDown.x; // long est la longueur de déplacement du touch
            if (Math.abs(long) > 10 && !lockMove) {
                if (long > 0) { // L'avatar avance
                    if(long+avatar.position.x >= borneMax){
                        long = borneMax - avatar.position.x;
                    }
                }
                else { // L'avatar recule
                    if(long+avatar.position.x <= borneMin){
                        long = borneMin - avatar.position.x;
                    }
                }
                if(Math.abs(long) > 1)
                    start((long) / (Math.abs(long) / 2), (Math.abs(long) / 2));
            }
        }
    }

    function onContainerMouseMove(evt) {
        evt.preventDefault();
        evt = evt.originalEvent.changedTouches[0];

        var name = intersects[0].object.name;
        //si on synchronise et qu'on a ciblé un bras
        if(manipulable) {
            if (synchroneArm && (name == 'rHand' || name == 'lHand')) {
                //on applique d'abord la rotation au bras ciblé et on l'applique ensuite à l'autre bras grace a l'angle résultant
                if (name == 'rHand') {
                    applyRotation('rHand', evt, function (angle) {
                        applyRotation('lHand', evt, updateTargets, angle);
                    });
                } else {
                    applyRotation('lHand', evt, function (angle) {
                        applyRotation('rHand', evt, updateTargets, angle);
                    });
                }
            } else {//dans tous les autres cas on applique une rotation unique
                applyRotation(name, evt, updateTargets);
            }
        }

    }

    function applyRotation(name,evt,callback, angle){
        var bone, res = 0;
        var tmpMousePosMove = mouseToWorld(evt);
        var first = false;
        if(angle == undefined && synchroneArm) {
            first = true;
        }
        var minRotXArm = THREE.Math.degToRad(-55), maxRotXArm = THREE.Math.degToRad(135);
        var minRotZArm = 0, maxRotZArm = THREE.Math.degToRad(100);
        var minRotBody = THREE.Math.degToRad(-30), maxRotBody = THREE.Math.degToRad(90);

        switch (name) {
            case 'rHand':
                bone = avatar.skeleton.bones[12];
                if(first) {
                    angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                    res = angle;
                    mousePosMove = mouseToWorld(evt);
                }
                if(!synchroneArm) {
                    angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                    mousePosMove = mouseToWorld(evt);
                }

                if (angle) {
                    if (Math.abs(avatarRotation) <= 0.8 || Math.abs(avatarRotation) >= Math.PI - 0.8) {//On rotate autour de l'axe des épaules
                        if(Math.abs(avatarRotation) > 0.8){//l'avatar est dos à l'objet -> on inverse la rotation
                            angle = -angle;
                        }
                        if(rArmRotX+angle<maxRotXArm && rArmRotX+angle>minRotXArm) {//on vérifie l'angle de rotation
                            //on applique la rotation
                            bone.rotateX(angle);
                            rArmRotX += angle;
                        }
                    } else {//On rotate de manière à écarter les bras
                        res = -res;//on inverse l'angle de synchronisé pour l'autre bras
                        if(avatarRotation>=0){//l'avatar est de dos par rapport à l'utilisateur -> on inverse la rotation
                            angle = -angle;
                        }
                        if(rArmRotZ+angle>-maxRotZArm && rArmRotZ+angle<=minRotZArm) {
                            bone.rotateZ(angle);
                            rArmRotZ += angle;
                        }
                    }
                }
                break;
            case 'lHand':
                bone = avatar.skeleton.bones[13];
                if(first) {
                    angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                    res = angle;
                    mousePosMove = mouseToWorld(evt);
                }
                if(!synchroneArm) {
                    angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                    mousePosMove = mouseToWorld(evt);
                }

                if (Math.abs(avatarRotation) <= 0.8 || Math.abs(avatarRotation) >= Math.PI - 0.8) {//On rotate autour de l'axe des épaules
                    if(Math.abs(avatarRotation) > 0.8){//l'avatar est dos à l'objet -> on inverse la rotation
                        angle = -angle;
                    }
                    if(lArmRotX+angle<maxRotXArm && lArmRotX+angle>minRotXArm) {//on vérifie l'angle de rotation
                        //on applique la rotation
                        bone.rotateX(angle);
                        lArmRotX += angle;
                    }
                } else {//On rotate de manière à écarter les bras
                    res = -res;//on inverse l'angle de synchronisé pour l'autre bras
                    if(avatarRotation>=0){//l'avatar est de dos par rapport à l'utilisateur -> on inverse la rotation
                        angle = -angle;
                    }
                    if(lArmRotZ+angle<maxRotZArm && lArmRotZ+angle>=minRotZArm) {
                        bone.rotateZ(angle);
                        lArmRotZ += angle;
                    }
                }
                break;
            case 'head':
                bone = avatar.skeleton.bones[3];
                angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                mousePosMove = mouseToWorld(evt);
                if (angle) {
                    if (Math.abs(avatarRotation) <= Math.PI / 2) {
                        angle = -angle;
                    }
                    if (bodyRot + angle < maxRotBody && bodyRot + angle > minRotBody) {
                        bone.rotateX(angle);
                        bodyRot += angle;
                    }
                }
                break;
            case 'avatarRot':
                if(!lockRotation) {
                    var v1 = mousePosMove.clone().normalize();
                    var v2 = tmpMousePosMove.clone().normalize();
                    mousePosMove = mouseToWorld(evt);
                    angle = (v2.x - v1.x) * Math.PI;
                    avatar.rotateY(angle);
                    avatarRotation += angle;
                    if (avatarRotation > Math.PI)
                        avatarRotation = -(2 * Math.PI - avatarRotation);
                    if (avatarRotation <= -Math.PI)
                        avatarRotation = 2 * Math.PI + avatarRotation;
                    break;
                }
        }
        if(first) {//si on synchronise les bras et qu'on traite le bras ciblé on envoie l'angle pour synchroniser l'autre bras
            callback(res);
        }
        else callback();//sinon on update les target
    }

    function getAngle(origin, v1, v2) {
        v1.x -= origin.x;
        v2.x -= origin.x;
        v1.y -= origin.y;
        v2.y -= origin.y;
        var cosTeta = (v1.x * v2.x + v1.y * v2.y) / (Math.sqrt(Math.pow(v1.x, 2) + Math.pow(v1.y, 2)) * Math.sqrt(Math.pow(v2.x, 2) + Math.pow(v2.y, 2)));
        var teta = Math.acos(cosTeta);
        if ((( v1.x > 0 && v2.y < 0 || v1.x < 0 && v2.y > 0) && ( v1.y > 0 && v2.x > 0 || v1.y < 0 && v2.x < 0))
            || (v1.x > 0 && v1.y > 0 && v2.x > 0 && v2.y > 0 && (v1.y > v2.y || v1.x < v2.x))
            || (v1.x > 0 && v1.y < 0 && v2.x > 0 && v2.y < 0 && (v1.y > v2.y || v1.x > v2.x))
            || (v1.x < 0 && v1.y < 0 && v2.x < 0 && v2.y < 0 && (v1.y < v2.y || v1.x > v2.x))
            || (v1.x < 0 && v1.y > 0 && v2.x < 0 && v2.y > 0 && (v1.y < v2.y || v1.x < v2.x))
        )
            teta = -teta;
        return teta;
    }

    function mouseToWorld(evt) {
        var mouseX = ((evt.clientX-offsetWidth/2) / (window.innerWidth-offsetWidth)) * 2 - 1;
        var mouseY = -((evt.clientY-offsetHeight/2) / (window.innerHeight-offsetHeight)) * 2 + 1;

        var vector = new THREE.Vector3(mouseX, mouseY, 0.99799794);//Mystery number = 0.99799794
        vector.unproject(camera);
        return vector;
    }

    function worldToScreen(pos) {
        var p = pos.clone();
        var vector = p.project(camera);

        vector.x = (vector.x + 1) / 2 * (window.innerWidth-offsetWidth)+offsetWidth;
        vector.y = -(vector.y - 1) / 2 * (window.innerHeight-offsetHeight)+offsetHeight;

        return vector;
    }
    /*******************************************************
     * Fonctions d'animation de l'avatar
     *******************************************************/
    function start(translation, nbFrame) {
        if (!animationState) {
            skeleton = saveSkeleton();
            if(translation>0){ // Il avance et donc marche à l'endroit
                avatar.rotateY(-avatarRotation);
                avatarRotation = 0;

            }else{ // Il recule
                if(avatarRotation < Math.PI/2 && avatarRotation > -Math.PI/2){ //Il marche à reculons
                    avatar.rotateY(-avatarRotation);
                    avatarRotation = 0;
                }
                else{ // Il marche à l'endroit
                    avatar.rotateY(Math.PI-avatarRotation);
                    avatarRotation = Math.PI;
                }
            }
            animation.play();
            loop(translation, nbFrame);
        }
    }

    function stop() {
        if (animationState) {
            animation.stop();
            window.cancelAnimationFrame(animationState);
            animationState = undefined;
            currentFrame = 0;
            takePose(skeleton);
            updateTargets();
            avatar.updateMatrixWorld();
        }
    }


    function loop(translation, nbFrame){
        animationState = requestAnimationFrame(
            function(){
                loop(translation, nbFrame);
                updateTargets();
            }, renderer.domElement);
        THREE.AnimationHandler.update(clock.getDelta());
        avatar.position.x+=translation;
        currentFrame++;
        if(currentFrame >= nbFrame){
            stop();
        }
    }
    /***************************
     *      Les Bones          *
     ***************************/
    function saveSkeleton(){
        var res = [];
        for(var i=0;i<avatar.skeleton.bones.length;i++){
            res.push(avatar.skeleton.bones[i].rotation.clone());
        }
//        res.push(avatarRotation);
        return res;
    }

    function resetBones(){
        takePose(originalSkeleton);
        avatar.rotateY(-avatarRotation);
        avatarRotation = 0;
        avatar.position.setX(0);
        rArmRotX = 0; rArmRotZ = 0;
        lArmRotX = 0; lArmRotZ = 0;
        bodyRot = 0;
        updateTargets();
    }
    function takePose(skeleton){
        for(var i=0;i<avatar.skeleton.bones.length;i++){
            avatar.skeleton.bones[i].rotation.set(skeleton[i].x,skeleton[i].y,skeleton[i].z);
        }
        /*Enregistre la roatation de l'avatar*/
        //avatar.rotateY(skeleton[skeleton.length-1] - avatarRotation);
        //avatarRotation = skeleton[skeleton.length-1];
    }

    function sphereGenerator(width, color, visible) {
        var planeGeometry = new THREE.SphereGeometry(width, 100, 100);
        var material = new THREE.MeshPhongMaterial({color: color, visible: visible});

        return new THREE.Mesh(planeGeometry, material);
    }

    function extractData(){
        var res = {objPos:posObject,idObj:idObj[posObject],idExperience:idExperience,avatarRot:THREE.Math.radToDeg(avatarRotation),rArmRotX:THREE.Math.radToDeg(rArmRotX),rArmRotZ:THREE.Math.radToDeg(rArmRotZ),lArmRotX:THREE.Math.radToDeg(lArmRotX),lArmRotZ:THREE.Math.radToDeg(lArmRotZ),bodyRot:THREE.Math.radToDeg(bodyRot),distance:posScreen.x-avatar.position.x,sexeAvatar:sexeAvatar};
        return res;
    }

    function tutorial(){
        var slow = 6000, quick = 4000;
        var pos;
        switch (iTuto){
            case 0 :
                //rotationX des bras
                msgTuto("<?php echo TUTO_0;?>",slow, function () {
                    msgTuto("<?php echo TUTO_1;?>",quick, function () {
                        msgTuto("<?php echo TUTO_2;?>",quick, function () {
                            msgTuto("<?php echo TUTO_3;?>",quick, function () {
                                msgTuto("<?php echo TUTO_4;?>",quick, function () {
                                    avatar.skeleton.bones[17].updateMatrixWorld(true);
                                    pos = worldToScreen(avatar.skeleton.bones[17].getWorldPosition());
                                    $('#arrow-right').css({
                                        left : pos.x + 0.02*$('canvas').width(),
                                        top : pos.y - $('#arrow-right').height()+0.10*$('canvas').height(),
                                        '-webkit-transform' : 'rotate(-150deg)',
                                        transform : 'rotate(-150deg)'
                                    }).slideToggle(300,function(){
                                        manipulable = true;
                                        lockRotation = true;
                                        lockMove = true;
                                        interval = setInterval(function () {
                                            if(Math.abs(THREE.Math.radToDeg(rArmRotX))>70 || Math.abs(THREE.Math.radToDeg(lArmRotX))>70){
                                                $('#arrow-right').fadeOut(500);
                                                manipulable = false;
                                                lockRotation = false;
                                                lockMove = false;
                                                iTuto++;
                                                clearInterval(interval);
                                                tutorial();
                                            }
                                        },500);
                                    });
                                })
                            })
                        })
                    });
                });
                break;
            case 1 :
                msgTuto("<?php echo TUTO_5;?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo TUTO_6;?>",slow, function () {
                        avatar.rotateY(-Math.PI/2);
                        avatarRotation -= Math.PI/2;
                        updateTargets();
                        avatar.skeleton.bones[18].updateMatrixWorld(true);
                        pos = worldToScreen(avatar.skeleton.bones[18].getWorldPosition());
                        var pos2 = worldToScreen(avatar.skeleton.bones[17].getWorldPosition());
                        $('#arrow-left').css({
                            left : pos2.x - $('#arrow-right').width() - 0.02*$('canvas').width(),
                            top : pos2.y - $('#arrow-right').height()+0.1*$('canvas').height(),
                            '-webkit-transform' : 'rotate(-150deg) scaleY(-1)',
                            transform : 'rotate(-30deg) scaleY(-1)'
                        }).slideToggle(300);
                        $('#arrow-right').css({
                            left : pos.x + 0.02*$('canvas').width(),
                            top : pos.y - $('#arrow-right').height()+0.10*$('canvas').height(),
                            '-webkit-transform' : 'rotate(-150deg)',
                            transform : 'rotate(-150deg)'
                        }).slideToggle(300,function(){
                            manipulable = true;
                            lockRotation = true;
                            lockMove = true;
                            interval = setInterval(function () {
                                if(Math.abs(THREE.Math.radToDeg(rArmRotZ))>70 || Math.abs(THREE.Math.radToDeg(lArmRotZ))>70){
                                    $('#arrow-right').fadeOut(500);
                                    $('#arrow-left').fadeOut(500);
                                    manipulable = false;
                                    lockRotation = false;
                                    lockMove = false;
                                    iTuto++;
                                    clearInterval(interval);
                                    tutorial();
                                }
                            },500);
                        });
                    });

                });
                break;
            case 2 :
                msgTuto("<?php echo TUTO_7;?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo TUTO_8;?>", slow, function () {
                        avatar.skeleton.bones[14].updateMatrixWorld(true);
                        pos = worldToScreen(avatar.skeleton.bones[14].getWorldPosition());
                        $('#arrow-right').css({
                            left : pos.x + 0.05*$('canvas').width(),
                            top : pos.y-$('#arrow-right').height()/4,
//                            '-webkit-transform' : 'rotate(-150deg)  scaleX(-1)',
                            transform : 'rotate(160deg) scaleY(-1)'
                        }).slideToggle(300, function () {
                            manipulable = true;
                            lockMove = true;
                            lockRotation = true;
                            interval = setInterval(function () {
                                if(Math.abs(THREE.Math.radToDeg(bodyRot))>60){
                                    $('#arrow-right').fadeOut(500);
                                    manipulable = false;
                                    lockRotation = false;
                                    lockMove = false;
                                    iTuto++;
                                    clearInterval(interval);
                                    tutorial();
                                }
                            },500);
                        });
                    });
                });
                break;
            case 3 :
                msgTuto("<?php echo TUTO_9;?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo TUTO_10;?>", slow, function () {
                        pos = worldToScreen(new THREE.Vector3(0,-80,0));
                        $('#double-arrow').css({
                            left : pos.x - $('#double-arrow').width()/2,
                            top : pos.y - $('#double-arrow').height()/2
                        }).slideToggle(300, function () {
                            manipulable = true;
                            lockMove = true;
                            interval = setInterval(function () {
                                if(Math.abs(THREE.Math.radToDeg(avatarRotation))>70){
                                    $('#double-arrow').fadeOut(500);
                                    manipulable = false;
                                    lockMove = false;
                                    iTuto++;
                                    clearInterval(interval);
                                    tutorial();
                                }
                            },500);
                        });
                    });
                });
                break;
            case 4 :
                msgTuto("<?php echo TUTO_11;?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo TUTO_12;?>", slow, function () {
                        pos = worldToScreen(new THREE.Vector3(0,0,0));
                        $('#move-arrow').css({
                            left : pos.x + 0.05*$('canvas').width(),
                            top : pos.y - $('#double-arrow').height()/2
                        }).slideToggle(300, function () {
                            manipulable = true;
                            interval = setInterval(function () {
                                if(Math.abs(avatar.position.x)>10){
                                    $('#move-arrow').fadeOut(500);
                                    manipulable = false;
                                    iTuto++;
                                    clearInterval(interval);
                                    tutorial();
                                }
                            },500);
                        });
                    });
                });
                break;
            case 5 :
                msgTuto("<?php echo TUTO_13;?>", slow, function () {
                    resetBones();
                    msgTuto("<?php echo TUTO_14;?>", slow, function(){
                        msgTuto("<?php echo TUTO_15;?>", slow, function () {
                            msgTuto("<?php echo TUTO_16;?>", slow, function () {
                                msgTuto("<?php echo TUTO_17;?>", slow, function () {
                                    msgTuto("<?php echo TUTO_18;?>", quick, function () {
                                        manipulable = true;
                                        $('#icon_confirm').on('touchstart', function () {
                                            $('.fa-times-circle').addClass('fa-chevron-circle-right').removeClass('fa-times-circle').css('color', '#ffffff');
                                            $(this).slideToggle();
                                            $(this).off();
                                            $('.fa-chevron-circle-right').off();
                                            for(var i=0;i<tutoTargets.length;i++){
                                                scene.remove(tutoTargets[i]);
                                            }
                                            tutoTargets = [];
                                            startExperience();
                                        });
                                        $('.fa-chevron-circle-right').on('touchstart', function (e) {
                                            e.preventDefault();
                                            $("#icon_confirm").slideToggle(200);
                                            if($(this).hasClass('fa-times-circle')) {
                                                $(this).addClass('fa-chevron-circle-right').removeClass('fa-times-circle').css('color', '#ffffff');
                                                manipulable = true;
                                            }
                                            else {
                                                $(this).removeClass('fa-chevron-circle-right').addClass('fa-times-circle').css('color', 'rgb(199, 58, 76)');
                                                manipulable = false;
                                            }
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
        }
    }

    function msgTuto (msg, temp,callback){
        $('#console-tuto').html(msg).fadeIn(300, function () {
            setTimeout(function () {
                $('#console-tuto').fadeOut(300, function () {
                    callback();
                });
            },temp);
        });
    }
</script>

<script type="text/javascript">
    var posObject = 0;
    var redirect = "../Emolyse/finalisation.php";
    var myRedirect = function(redirectUrl, arg, value) {
        var form = $('<form action="' + redirectUrl + '" method="post">' +
        '<input type="hidden" id="myForm" name="'+ arg +'"></input>' + '</form>');
        $('body').append(form);
        $("#myForm").attr("value",value);
        $(form).submit();
    };

    $(document).ready(function () {
        $("#btn-start").on('touchstart', function (e) {
            e.preventDefault();
            $('#overlay-instruction').fadeOut(400, function () {
                $('#overlay-instruction').hide();
                startExperience();
            })
        });
        $("#btn-tuto").on('touchstart', function (e) {
            e.preventDefault();
            $('#overlay-instruction').fadeOut(400, function () {
                $('#overlay-instruction').hide();

                tutoTargets = getTargetList(8,true);
                msgTuto("<?php echo TUTO_19;?>",6000,function(){
                    msgTuto("<?php echo TUTO_20;?>",6000,function(){
                        tutorial();
                    })
                });
            })
        })
    });


    function startExperience () {
        manipulable = true;
        resetBones();
        //Affichage des objets
        $('.objet:first').addClass('display');

        $('#icon_confirm').on('touchstart', function (e) {
            e.preventDefault();
            $('.fa-times-circle').addClass('fa-chevron-circle-right').removeClass('fa-times-circle').css('color', '#ffffff');
            $(this).slideToggle();
            data[posObject] = extractData();
            if(posObject<nbObjects-1) {
                manipulable = true;
                posObject++;
                resetBones();
                $('.display').next('.objet').addClass('display');
                $('.display').prev('.display').removeClass('display');
            }
            else{
                $("#resetButton").slideToggle(200);
                $('#icon-env').slideToggle(200);
                $('#finalizer').show().animate({
                    opacity : 0.9,
                    height : '30%',
                    width : '50%',
                    left : '25%',
                    top : '35%'
                },800, function () {
                    $("#finalizer div").animate({
                        opacity : 1
                    },500);
                });
                $('#finalizer div i').on('touchstart', function () {
                    myRedirect(redirect, "data", JSON.stringify(data));
                });
            }
        });
        $(".fa-chevron-circle-right").on('touchstart', function(e){
            e.preventDefault();
            $("#icon_confirm").slideToggle(200);
            if($(this).hasClass('fa-times-circle')) {
                $(this).addClass('fa-chevron-circle-right').removeClass('fa-times-circle').css('color', '#ffffff');
                manipulable = true;
            }
            else {
                $(this).removeClass('fa-chevron-circle-right').addClass('fa-times-circle').css('color', 'rgb(199, 58, 76)');
                manipulable = false;
            }
        });
    }
</script>

</body>
</html>
<?php
session_start();
include("includes/init.php");
include("includes/connexion.php");
if(!isset($_GET['experience'])) {
    header("Location: ./participant-accueil.php");
}
?>
<html lang="fr">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="author" content="Alizee ARNAUD, Jordan DAITA, Rémy DROUET" />
    <title>Emolyse</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
    <link rel="stylesheet" href="styles/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style-experience.css">
</head>
<body>

<i class="fa fa-refresh icon-refresh" id="resetButton"></i>

<div id="console"></div>
<div id="containerObjet">
    <?php
    /***
     * This php section get from the database experience settings
     */
    if(isset($_GET['experience'])){
        $nbObjet = 0;
        $experience = $_GET['experience'];
        $reqExp = "SELECT consigne, nbProduit, codeLangue, syncroBras, random, lienEnvironnement from experience exp, environnement env where exp.idEnvironnement=env.idEnvironnement and exp.idExperience =".$experience;
        $resExp = $base->query($reqExp);
        while(($rowExp = $resExp->fetch_array())){
            //Environment
            $lienEnvironnement = $rowExp['lienEnvironnement'];

            //Arm synchronization params
            $synchroneArm = false;
            if($rowExp['syncroBras'] == 1){
                $synchroneArm = true;
            }

            //Traduction & instruction
            $consigne = nl2br($rowExp['consigne']);
            $tmpSession = $_SESSION['lang'];
            $_SESSION['lang'] = $rowExp['codeLangue'];
            include("includes/lang.php");
            $_SESSION['lang'] = $tmpSession;
            if($consigne == ''){
                $consigne = nl2br(TEXT_CONSIGNE);
            }
            //Products
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

<div class="fullLoader">
    <div class="loader">Loading...</div>
    <p class="txtLoading"><?php echo CHARGEMENT_APPLI;?></p>
    <img src="images/logo.png" alt="" class="logoChargement "/>
</div>
<div id="overlay-instruction">
    <div id="overlay-content">
        <h1><?php echo CONSIGNE;?></h1>
        <p><?php echo $consigne;?></p>
        <div id="btn-tuto" class="btn-overlay"><?php echo TUTORIEL;?></div>
        <div id="btn-start" class="btn-overlay"><?php echo DEMARRER;?></div>
    </div>
</div>

<i id="fullscreen" class="fa fa-expand" onclick="fullScreenHandler()"></i>
<div id="icon-env">
    <i id="icon_confirm" class="fa fa-check-circle"></i>
    <i id="icon-next" class="fa fa-chevron-circle-right icon_env"></i>
</div>

<div id="container"></div>

<div id="finalizer">
    <div class="opacity-div">
        <p><?php echo FINALISATION;?> !</p>
        <div>
            <span><?php echo  PHRASE_FIN;?></span>
            <i class="fa fa-arrow-circle-o-right"></i>
        </div>
    </div>
</div>

<div id="console-tuto"></div>

<img id="arrow-right" src="images/arrow_right.png" alt="arrow-arm-rotation"/>
<img id="arrow-left" src="images/arrow_right.png" alt="arrow-arm-rotation"/>
<img id="double-arrow" src="images/double_arrow.png" alt="arrow-avatar-rotation"/>
<img id="move-arrow" src="images/arrow-move.png" alt="arrow-avatar-move"/>

<script src="scripts/three.min.js"></script>
<script src="scripts/ColladaLoader.js"></script>
<script src="scripts/Detector.js"></script>
<script src="scripts/jquery-2.1.4.min.js"></script>
<script src="scripts/jquery.fullscreen.js"></script>
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
        //Avatar url
        if(choixAvatar == 'man'){
            urlAvatar = 'Homme/avatar_man.dae';
            sexeAvatar = 'M';
        }
        else{
            urlAvatar = 'Femme/avatar_woman.dae'
            sexeAvatar = 'F';
        }

        /***
         *  When the avatar is loaded we activate mouseDown listener, create targets & hide the load screen
         */
        loadAvatar(urlAvatar, function () {
            avatar.updateMatrixWorld(true);
            targetList = getTargetList(15,false);
            $(document).on('touchstart mousedown', onDocumentMouseDown);
            $("#resetButton").on('touchstart click', function (e) {
                e.preventDefault();
                console.log(e.type);
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

    /***
     *  @description Window resize handler
     */
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
        updateTargets();
    }

    /***
     *  @description ThreeJS procedure to render scenes with set cameras (backgroundScene & scene)
     */
    function render() {
        requestAnimationFrame( render, renderer.domElement );
        renderer.autoClear = false;
        renderer.antialias=true;
        renderer.clear();
        renderer.render( backgroundScene, backgroundCamera);
        renderer.render( scene, camera );
    }
    /***
     * @description Load the .dae file according to the name et load it in the scene
     * @param name Collada file name
     * @param callback
     */

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
            //Activation of the avatar manipulation for every required bones
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

    /***
     *  @description Console : Usefull development tool for debugging in LiveEdit PhpStorm mode
     */
    function loadConsole(msg) {
        $("#console").text(msg);
    }

    /***
     *  @description Update the product picture size and position
     */
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

    /***
     *  @description load the 3D screen object in the scene
     */
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

    /***
     *  @description Create targets for the avatar manipulation (3D Spheres)
     *  @param size sphere radius
     *  @param visible
     *  @return An array of the created targets
     */
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
        //Creation of the avatar manipulation targets
        var avatarTarget = sphereGenerator(size, "#01B0F0",visible);
        avatarTarget.position.set(0, -80, 0);
        avatarTarget.name = 'avatarRot';
        scene.add(avatarTarget);
        res.push(avatarTarget);
        return res;
    }

    /***
     *  @description Update targets position when avatar posture/position have been modified
     */
    function updateTargets() {
        if(avatar) {
            avatar.updateMatrixWorld(true);
            for (var i = 0; i < targetList.length - 1; i++) {
                var pos = avatar.skeleton.bones[idBonesTargeted[i]].getWorldPosition();
                targetList[i].position.set(pos.x, pos.y, pos.z);
                if (tutoTargets.length)
                    tutoTargets[i].position.set(pos.x, pos.y, pos.z);
            }
            targetList[targetList.length - 1].position.setX(avatar.position.x);
            if (tutoTargets.length)
                tutoTargets[tutoTargets.length - 1].position.setX(avatar.position.x);
        }
    }

    /***
     *  @description Triggered event when the mouse is moving, it will load required mouse events and the mouse position
     *  @param evt mouse event
     */
    function onDocumentMouseDown(evt) {
        if(manipulable) {
            console.log(evt.type);
            if(evt.type == "touchstart") {
                evt.preventDefault();
                evt = evt.originalEvent.changedTouches[0];
            }
            var vector = mouseToWorld(evt);

            mousePosDown = vector.clone();
            mousePosMove = vector.clone();

            var raycaster = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());

            intersects = raycaster.intersectObjects(targetList);

            $(document).on('touchend mouseup', onDocumentMouseUp);
            if (intersects.length > 0) {
                $(document).on('touchmove mousemove', onContainerMouseMove);
            }
        }
    }

    /***
     *  @description Triggered event when the mouse go up, it will applied avatar move
     *  @param evt mouse event
     */
    function onDocumentMouseUp(evt) {
        console.log(evt.type);
        if(evt.type == "touchend") {
            evt.preventDefault();
            evt = evt.originalEvent.changedTouches[0];
        }
        $(document).off('touchend mouseup');
        $(document).off('touchmove mousemove');
        if (intersects.length > 0) {
        } else {
            var mousePosUp = mouseToWorld(evt);
            var long = mousePosUp.x - mousePosDown.x; // long is the slide value for the avatar move
            if (Math.abs(long) > 10 && !lockMove) {
                if (long > 0) { // The avatar is moving forward
                    if(long+avatar.position.x >= borneMax){
                        long = borneMax - avatar.position.x;
                    }
                }
                else { // The avatar is moving back
                    if(long+avatar.position.x <= borneMin){
                        long = borneMin - avatar.position.x;
                    }
                }
                if(Math.abs(long) > 1)
                    start((long) / (Math.abs(long) / 2), (Math.abs(long) / 2));
            }
        }
    }

    /***
     *  @description Triggered event when the mouse is moving, it will applied the rotation and update the avatar posture & targets position (used for avatar manipulation only)
     *  @param evt mouse event
     */
    function onContainerMouseMove(evt) {

        if(evt.type == "touchmove") {
            evt.preventDefault();
            evt = evt.originalEvent.changedTouches[0];
        }

        var name = intersects[0].object.name;
        //When the arm synchronization is activated and an arm target is selected
        if(manipulable) {
            if (synchroneArm && (name == 'rHand' || name == 'lHand')) {
                //The targeted arm rotation is applied first then we apply it on the other arm thanks to the angle result
                if (name == 'rHand') {
                    applyRotation('rHand', evt, function (angle) {
                        applyRotation('lHand', evt, updateTargets, angle);
                    });
                } else {
                    applyRotation('lHand', evt, function (angle) {
                        applyRotation('rHand', evt, updateTargets, angle);
                    });
                }
            } else {//In other case we apply an unique rotation
                applyRotation(name, evt, updateTargets);
            }
        }

    }
    /***
     *  @description Apply a rotation according to the selected target
     *  @param name targte name
     *  @param evt mouse event
     *  @param callback
     *  @param angle applied angle (used for arm synchronization)
     */
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
                    if (Math.abs(avatarRotation) <= 0.8 || Math.abs(avatarRotation) >= Math.PI - 0.8) {//We apply the rotation on the shoulder axis
                        if(Math.abs(avatarRotation) > 0.8){//The avatar is back to the object -> Rotation reversed
                            angle = -angle;
                        }
                        if(rArmRotX+angle<maxRotXArm && rArmRotX+angle>minRotXArm) {//Check rotation limits
                            //Rotation applied
                            bone.rotateX(angle);
                            rArmRotX += angle;
                        }
                    } else {//Rotation to part arms
                        res = -res;//Rotation angle reversed for the other arm
                        if(avatarRotation>=0){//The avatar is back to the user -> Rotation reversed
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

                if (Math.abs(avatarRotation) <= 0.8 || Math.abs(avatarRotation) >= Math.PI - 0.8) {//We apply the rotation on the shoulder axis
                    if(Math.abs(avatarRotation) > 0.8){//The avatar is back to the object -> Rotation reversed
                        angle = -angle;
                    }
                    if(lArmRotX+angle<maxRotXArm && lArmRotX+angle>minRotXArm) {//Check rotation limits
                        //Rotation applied
                        bone.rotateX(angle);
                        lArmRotX += angle;
                    }
                } else {//Rotation to part arms
                    res = -res;//Rotation angle reversed for the other arm
                    if(avatarRotation>=0){//The avatar is back to the user -> Rotation reversed
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
        if(first) {//If the arm synchronization is activated and the targeted arm has just been rotate we send the angle to rotated the other arm
            callback(res);
        }
        else callback();//Otherwise we update targets position
    }

    /***
     *  @description Will return the correct rotation angle for a specific avatar rotation
     *  @param origin rotate bone world position
     *  @param previous click/touch position
     *  @param current click/touch position
     *  @return rotation angle
     */
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

    /***
     *  @description Will convert a screen 2D vector in a
     *  @param evt mouse position
     *  @return ThreeJS 3D vector
     */
    function mouseToWorld(evt) {
        var mouseX = ((evt.clientX-offsetWidth/2) / (window.innerWidth-offsetWidth)) * 2 - 1;
        var mouseY = -((evt.clientY-offsetHeight/2) / (window.innerHeight-offsetHeight)) * 2 + 1;

        var vector = new THREE.Vector3(mouseX, mouseY, 0.99799794);//Mystery number = 0.99799794
        vector.unproject(camera);
        return vector;
    }

    /***
     *  @description Will convert a ThreeJS 3D vector in a screen 2D vector
     *  @param pos ThreeJS 3D Vector
     *  @return Screen 2D vector
     */
    function worldToScreen(pos) {
        var p = pos.clone();
        var vector = p.project(camera);

        vector.x = (vector.x + 1) / 2 * (window.innerWidth-offsetWidth)+offsetWidth/2;
        vector.y = -(vector.y - 1) / 2 * (window.innerHeight-offsetHeight)+offsetHeight/2;
        console.log(offsetWidth+' - '+offsetHeight);

        return vector;
    }
    /*******************************************************
     * Fonctions d'animation de l'avatar
     *******************************************************/

    /***
     *  @description Start the move animation
     *  @param translation
     *  @param nbFrame
     */

    function start(translation, nbFrame) {
        if (!animationState) {
            skeleton = saveSkeleton();
            if(translation>0){ // It moves forward
                avatar.rotateY(-avatarRotation);
                avatarRotation = 0;

            }else{ // It walks away
                if(avatarRotation < Math.PI/2 && avatarRotation > -Math.PI/2){ // it walks backwards
                    avatar.rotateY(-avatarRotation);
                    avatarRotation = 0;
                }
                else{ // It moves to the back
                    avatar.rotateY(Math.PI-avatarRotation);
                    avatarRotation = Math.PI;
                }
            }
            animation.play();
            loop(translation, nbFrame);
        }
    }

    /***
     *  @description Stop the avatar animation when the destination is reached
     */
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

    /***
     *  @description This function will animate the avatar with the clock delta and make it move towards its destination
     *  @param translation
     *  @param nbFrame
     */
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
    /***
     * @description Will save an avatar position (bones rotations included) at this moment
     * @return avatar_position
     */
    function saveSkeleton(){
        var res = [];
        for(var i=0;i<avatar.skeleton.bones.length;i++){
            res.push(avatar.skeleton.bones[i].rotation.clone());
        }
//        res.push(avatarRotation);
        return res;
    }

    /***
     * @description Will restore the initial avatar position (bones rotations included)
     */
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

    /***
     * @description Will restore an avatar position (bones rotations included) based on a saved position (skeleton)
     * @param skeleton saved position
     */
    function takePose(skeleton){
        for(var i=0;i<avatar.skeleton.bones.length;i++){
            avatar.skeleton.bones[i].rotation.set(skeleton[i].x,skeleton[i].y,skeleton[i].z);
        }
        /*Save the avatar rotation*/
        //avatar.rotateY(skeleton[skeleton.length-1] - avatarRotation);
        //avatarRotation = skeleton[skeleton.length-1];
    }
    /***
     * @description Create a 3D sphere in the ThreeJS environment
     * @param width radial value of the sphere
     * @param color
     * @param visible
     */
    function sphereGenerator(width, color, visible) {
        var planeGeometry = new THREE.SphereGeometry(width, 100, 100);
        var material = new THREE.MeshPhongMaterial({color: color, visible: visible});

        return new THREE.Mesh(planeGeometry, material);
    }

    /***
     * @description Extract in a JSON result all data result for an object
     */
    function extractData(){
        var res = {objPos:posObject,idObj:idObj[posObject],idExperience:idExperience,avatarRot:THREE.Math.radToDeg(avatarRotation),rArmRotX:THREE.Math.radToDeg(rArmRotX),rArmRotZ:Math.abs(THREE.Math.radToDeg(rArmRotZ)),lArmRotX:THREE.Math.radToDeg(lArmRotX),lArmRotZ:Math.abs(THREE.Math.radToDeg(lArmRotZ)),bodyRot:THREE.Math.radToDeg(bodyRot),distance:avatar.position.x,sexeAvatar:sexeAvatar};
        return res;
    }

    /***
     * @description Trigger a tutorial step (You can easily modify it to access each step independantly using iTuto value)
     */
    function tutorial(){
        var slow = 6000, quick = 4000;
        var pos;
        switch (iTuto){
            case 0 :
                //Arm rotation on X
                msgTuto("<?php echo addslashes(TUTO_0);?>",slow, function () {
                    msgTuto("<?php echo addslashes(TUTO_1);?>",quick, function () {
                        msgTuto("<?php echo addslashes(TUTO_2);?>",quick, function () {
                            msgTuto("<?php echo addslashes(TUTO_3);?>",quick, function () {
                                msgTuto("<?php echo addslashes(TUTO_4);?>",quick, function () {
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
                msgTuto("<?php echo addslashes(TUTO_5);?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo addslashes(TUTO_6);?>",slow, function () {
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
                msgTuto("<?php echo addslashes(TUTO_7);?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo addslashes(TUTO_8);?>", slow, function () {
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
                msgTuto("<?php echo addslashes(TUTO_9);?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo addslashes(TUTO_10);?>", slow, function () {
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
                msgTuto("<?php echo addslashes(TUTO_11);?>",slow, function () {
                    resetBones();
                    msgTuto("<?php echo addslashes(TUTO_12);?>", slow, function () {
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
                msgTuto("<?php echo addslashes(TUTO_13);?>", slow, function () {
                    resetBones();
                    msgTuto("<?php echo addslashes(TUTO_14);?>", slow, function(){
                        msgTuto("<?php echo addslashes(TUTO_15);?>", slow, function () {
                            msgTuto("<?php echo addslashes(TUTO_16);?>", slow, function () {
                                msgTuto("<?php echo addslashes(TUTO_17);?>", slow, function () {
                                    msgTuto("<?php echo addslashes(TUTO_18);?>", quick, function () {
                                        manipulable = true;
                                        $('#icon_confirm').on('click', function (e) {
                                            e.preventDefault();
                                            console.log(e.type);
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
                                        $('#icon-next').on('click touchstart', function (e) {
                                            e.preventDefault();
                                            console.log(e.type);
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

    /***
     * @description This function will display a message during a precised duration in the middle of the screen
     * @param msg the message you want to display
     * @param temp display duration
     * @param callback
     */
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

    /****
     * @description Send the input data (arg) to the redirectUrl page
     * @param redirectUrl
     * @param arg
     * @param value
     */
    var myRedirect = function(redirectUrl, arg, value) {
        var form = $('<form action="' + redirectUrl + '" method="post">' +
        '<input type="hidden" id="myForm" name="'+ arg +'"></input>' + '</form>');
        $('body').append(form);
        $("#myForm").attr("value",value);
        $(form).submit();
    };

    $(document).ready(function () {
        /***
         * @description Start directly the experience without tutorial
         */
        $("#btn-start").on('click', function (e) {
            e.preventDefault();
            console.log(e.type);
            $('#overlay-instruction').fadeOut(400, function () {
                $('#overlay-instruction').hide();
                startExperience();
            })
        });
        /***
         * @description Activate the tutorial mode
         */
        $("#btn-tuto").on('click', function (e) {
            e.preventDefault();
            console.log(e.type);
            $('#overlay-instruction').fadeOut(400, function () {
                $('#overlay-instruction').hide();

                tutoTargets = getTargetList(10,true);
                msgTuto("<?php echo addslashes(TUTO_19);?>",6000,function(){
                    msgTuto("<?php echo addslashes(TUTO_20);?>",6000,function(){
                        tutorial();
                    })
                });
            })
        })
    });

    /***
     * @description Initialize all required settings to start an experience
     */
    function startExperience () {
        manipulable = true;
        resetBones();
        //Displaying products
        $('.objet:first').addClass('display');

        /***
         * @description Animate & Activate the confirmation button listening event
         */
        $('#icon_confirm').on('click', function (e) {
            e.preventDefault();
            console.log(e.type);
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
                    height : '250px',
                    width : '40%',
                    left : '30%',
                    top : '35%'
                },800, function () {
                    $("#finalizer .opacity-div").animate({
                        opacity : 1
                    },500);
                });
                $('#finalizer .opacity-div i').on('click', function (e) {
                    e.preventDefault();
                    console.log(e.type);
                    myRedirect(redirect, "data", JSON.stringify(data));
                });
            }
        });

        /***
         * @description Animate & Activate the next/cancel button listening event
         */
        $("#icon-next").on('click touchstart', function(e){
            e.preventDefault();
            console.log(e.type);
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
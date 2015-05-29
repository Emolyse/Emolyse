<!--<!DOCTYPE html>-->
<html lang="en">
<?php
    include("includes/connexion.php");
?>
<head>
    <title>three.js webgl - collada - skinning</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="styles/font-awesome.min.css">
    <style>
        body {
            color: #000;
            font-family: Monospace;
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
            -webkit-perspective: 198px;
            perspective: 198px;
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
        }
        .icon_env{
            display: inline-block;
            color: #fff;
            font-size: 66px;
            padding: 15px;
        }
        #icon-env{
            position: fixed;
            bottom: 20px;
            right: 20px;
            cursor: pointer;
        }
        .display{
            display: block;
        }
    </style>
</head>
<body>

<i class="fa fa-refresh icon-refresh" id="resetButton"></i>
<div id="console"></div>
<div id="containerObjet">
    <?php
    if(isset($_GET['experience'])){
        $nbObjet = 0;
        $experience = $_GET['experience'];
        $requete = "SELECT * FROM produit WHERE idExperience=".$experience." ORDER BY position ASC";
        $resultats = $base->query($requete);
        while(($resultat = $resultats->fetch_array())){
            $nbObjet++;
            $lienPhoto = $resultat['lienPhoto'];
            $idProduit = $resultat['idProduit'];
            echo "<img class='objet' src='".$lienPhoto."' id='produit-".$idProduit."' />";
        }
    }
    ?>


    <?php
    // Récupération de l'environnement
    if(isset($_GET['experience'])){
        $lienEnvironnement = "img/salon_2.jpg";
        $experience = $_GET['experience'];
        $requeteExp = "SELECT idEnvironnement FROM experience WHERE idExperience=".$experience."";
        $resultatsExp = $base->query($requeteExp);
        while(($resultatExp = $resultatsExp->fetch_array())){
            $idEnvironnement = $resultatExp['idEnvironnement'];
            $requeteEnv = "SELECT * FROM environnement WHERE idEnvironnement=".$idEnvironnement."";
            $resultatsEnv = $base->query($requeteEnv);
            while(($resultatEnv = $resultatsEnv->fetch_array())){
                $lienEnvironnement = $resultatEnv['lienEnvironnement'];
            }
        }
    }
    ?>



</div>
<div id="icon-env">
    <i class="fa fa-chevron-circle-right icon_env"></i>
</div>

<div id="container">
</div>

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

    /*
     Information récupérees du get
     */

    var choixAvatar = '<?php echo $_GET['avatarselect'] ?>';
    var urlAvatar;
    var container;
    var data = [];
    var posScreen = new THREE.Vector3(170,120,-150);
    var camera, scene, currentFrame=0, renderer, backgroundScene, backgroundCamera, avatar;
    var targetList = [];
    var idBonesTargeted = [14, 17, 18];
    var intersects = [];
    var borneMin=-140, borneMax=30;
    var mousePosDown, mousePosMove;
    var animation, animationState;
    var originalSkeleton, skeleton;

    var avatarRotation = 0,lArmRotX = 0,lArmRotZ = 0, rArmRotX = 0, rArmRotZ = 0, bodyRot = 0;

    var clock = new THREE.Clock();
    var offsetWidth=0,offsetHeight=0;
    var mouseMoving = false;

    init();

    function init() {
        container = document.getElementById('container');

        scene = new THREE.Scene();

        var axisHelper = new THREE.AxisHelper(100);
        scene.add(axisHelper);
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
        }
        else{
            urlAvatar = 'Femme/avatar_woman.dae'
        }
        loadAvatar(urlAvatar, function () {
            avatar.updateMatrixWorld(true);
            targetList = getTargetList();
            $(document).on('touchstart', onCanvasMouseDown);
            $("#resetButton").on('touchstart', resetBones);
            var loaderObject = new THREE.ColladaLoader();
            var screen;
            loaderObject.load("3D/dae/meubles/screen.dae", function (collada) {
                scene.add(collada.scene);
                console.log(scene);
                screen = scene.children[7];
                screen.position.set(posScreen.x, posScreen.y, posScreen.z);
                screen.scale.set(1.0,0.75,0.75);
                screen.rotateY(THREE.Math.degToRad(-80));
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


    /*******************************************************
     * @description Couch de dialogue avatar/touchInterface
     *******************************************************/

    function getTargetList() {
        avatar.updateMatrixWorld(true);
        var res = [];
        for (var i = 0; i < idBonesTargeted.length; i++) {
            var target = sphereGenerator(20, "#01B0F0");
            var pos = avatar.skeleton.bones[idBonesTargeted[i]].getWorldPosition();
            target.position.set(pos.x, pos.y, pos.z);
            target.name = avatar.skeleton.bones[idBonesTargeted[i]].name;
            scene.add(target);
            res.push(target);
        }
        //On créé la cible de rotation de l'avatar
        var avatarTarget = sphereGenerator(20, "#01B0F0");
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
        }
        targetList[targetList.length - 1].position.setX(avatar.position.x)
    }

    function onCanvasMouseDown(evt) {
        evt.preventDefault();
        evt = evt.originalEvent.changedTouches[0];
        var vector = mouseToWorld(evt);

        mousePosDown = vector.clone();
        mousePosMove = vector.clone();

        var raycaster = new THREE.Raycaster(camera.position, vector.sub(camera.position).normalize());

        intersects = raycaster.intersectObjects(targetList);

        $(document).on('touchend', onDocumentMouseUp);
        if (intersects.length > 0) {
            $("#container").on('touchmove', onContainerMouseMove);
        }
    }

    function onDocumentMouseUp(evt) {
        evt.preventDefault();
        evt = evt.originalEvent.changedTouches[0];
        $("#container").off();
        $(document).off('touchend');
        if (intersects.length > 0) {
            loadConsole(avatarRotation);
        } else {
            var mousePosUp = mouseToWorld(evt);
            var long = mousePosUp.x - mousePosDown.x; // long est la longueur de déplacement du touch
            if (Math.abs(long) > 10) {
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
        var bone, angle;
        var tmpMousePosMove = mouseToWorld(evt);
        switch (intersects[0].object.name) {
            case 'rHand':
                bone = avatar.skeleton.bones[12];
                angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                mousePosMove = mouseToWorld(evt);
                if (angle) {
                    if (Math.abs(avatarRotation) <= 0.8) {
                        bone.rotateX(angle);
                        rArmRotX+=angle;
                    } else if (Math.abs(avatarRotation) >= Math.PI - 0.8) {
                        bone.rotateX(-angle);
                        rArmRotX-=angle;
                    } else if (avatarRotation < 0) {
                        bone.rotateZ(angle);
                        rArmRotZ+=angle;
                    } else {
                        bone.rotateZ(-angle);
                        rArmRotZ-=angle;
                    }
                }
                break;
            case 'lHand':
                bone = avatar.skeleton.bones[13];
                angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                mousePosMove = mouseToWorld(evt);
                if (angle) {
                    if (Math.abs(avatarRotation) <= 0.8) {
                        bone.rotateX(angle);
                        lArmRotX+=angle;
                    } else if (Math.abs(avatarRotation) >= Math.PI - 0.8) {
                        bone.rotateX(-angle);
                        lArmRotX-=angle;
                    } else if (avatarRotation < 0) {
                        bone.rotateZ(angle);
                        lArmRotZ+=angle;
                    } else {
                        bone.rotateZ(-angle);
                        lArmRotZ-=angle;
                    }
                }
                break;
            case 'head':
                bone = avatar.skeleton.bones[3];
                angle = getAngle(bone.getWorldPosition(), mousePosMove, tmpMousePosMove);
                mousePosMove = mouseToWorld(evt);
                if (angle)
                    if (Math.abs(avatarRotation) > Math.PI/2) {
                        bone.rotateX(angle);
                        bodyRot += angle;
                    } else {
                        bone.rotateX(-angle);
                        bodyRot -= angle;
                    }
                break;
            case 'avatarRot':
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
        updateTargets();
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
        res.push(avatarRotation);
        loadConsole(res[res.length-1]);
        return res;
    }

    function resetBones(){
        takePose(originalSkeleton);
        avatar.rotateY(-avatarRotation);
        avatar.position.setX(0);
        avatarRotation = 0;
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

    function sphereGenerator(width, color) {
        var planeGeometry = new THREE.BoxGeometry(width+10, width, width, 3, 3);
        var material = new THREE.MeshPhongMaterial({color: color, visible: false});

        return new THREE.Mesh(planeGeometry, material);
    }

    function extractData(){
        var res = {objId:posObject,expId:idExperience,avatarRot:avatarRotation,rArmRotX:rArmRotX,rArmRotZ:rArmRotZ,lArmRotX:lArmRotX,lArmRotZ:lArmRotZ,bodyRot:bodyRot,distance:posScreen.x-avatar.position.x};
        return res;
    }

</script>

<script type="text/javascript">
    var posObject = 0;
    $(document).ready(function () {

        //Affichage des objets
        $('.objet:first').addClass('display');

        $(".fa-chevron-circle-right").on('touchstart', function(){
            var r = confirm("Avez-vous vraiment terminé ?");
            if (r == true) {
                data[posObject] = extractData();
                if(posObject<nbObjects-1) {
                    posObject++;
                    resetBones();
                    $('.display').next('.objet').addClass('display');
                    $('.display').prev('.display').removeClass('display');
                }
                else{

                }
            }
        });
    });
</script>

</body>
</html>
/**
 * Created by Rémy on 12/08/2015.
 */

/**************************************
 *        SMOOTH SCROLLING SCRIPT     *
 *************************************/
var preventLRArrows = false;
var preventScroll = false;

/***
 * Cette fonction se charge d'effectuer le smooth scrolling en fonction de l'ancre et elle met à jour les info relatives
 * au changement : menu, barre d'adresse, style
 * @param $anchor
 */
function scrollTo($anchor){
    //ajouter le scroll watcher
    if(!preventScroll){
        preventScroll = true;
        if($anchor.selector === "body"){
            console.log("body");
            var scroll = $anchor.scrollTop();
        } else {
            //on reccupere la position de l'ancre
            var scroll = $anchor.offset().top;

            //on reccupere l'ID de l'ancre ou de son menu rattaché
            if($anchor.data("menu")){
                var ref = "#"+$anchor.data("menu");
            } else {
                var ref = "#"+$anchor.attr("id");
            }
            //on met a jour la navbar
            history.replaceState(null, null, "http://localhost/Emolyse/"+ref);
            $('.scroll-navbar li').removeClass('active');
            $('.scroll-navbar li a[href^="'+ref+'"]').parent().addClass('active');
        }
        $("body").animate({
            scrollTop:scroll
        },1000, function () {
            preventScroll = false;
            //on vérifie que l'on a bien atteint l'autre section avant de changer le style du menu
            //pour les ancre placées a la fin avec une hauteur < window.innerHeight
            if (Math.abs($anchor.offset().top-$("body").scrollTop())<10){
                if ($anchor.data("invert") === true) {
                    $(".scroll-navbar").addClass("invert");
                } else {
                    $(".scroll-navbar").removeClass("invert");
                }
            }
        });
    }
}

function getPrevScrollAnchor(){
    var $res = $("body");
    var currentScroll = $("body").scrollTop();
    $(".scroll-anchor").each(function (index,e) {
        if(currentScroll>$(this).offset().top+10){
            $res = $(this);
        }else{
            return false;
        }
    });
    return $res;
}
function getNextScrollAnchor(){
    var $res = $("body");
    var currentScroll = $("body").scrollTop();
    $(".scroll-anchor").each(function (index,e) {
        if(currentScroll<$(this).offset().top-10){
            $res = $(this);
            return false;
        }
    });
    return $res;
}

function scrollToPrev(){
    scrollTo(getPrevScrollAnchor());
}
function scrollToNext(){
    scrollTo(getNextScrollAnchor());
}
function scrollKeysHandler(e) {
    //Pour le scroll vertical
    if(e.keyCode>31 && e.keyCode<41)
        e.preventDefault();
    //top
    if(e.keyCode == 38 && !preventScroll){
        scrollToPrev();
    }
    //bottom
    if(e.keyCode == 40 && !preventScroll){
        scrollToNext();
    }

    //Pour le carousel
    //left
    if(e.keyCode == 37 && !preventLRArrows){
        $('.carousel').carousel('prev');
    }
    //right
    if(e.keyCode == 39 && !preventLRArrows){
        $('.carousel').carousel('next');
    }
}
function mouseWheelHandler(e){
    e.preventDefault();
    if(!preventScroll) {
        if (e.originalEvent.wheelDelta >= 0) {
            scrollToPrev();
        }
        else {
            scrollToNext()
        }
    }
}

function scrollClickHandler(e){
    e.preventDefault();
    var target = $(e.target).attr("href");
    if(target==="#")
        var $anchor = $(".scroll-anchor").first();
    else var $anchor = $(""+target);
    console.log($anchor);
    scrollTo($anchor);
}

$(document).ready(function () {

    $(document).keydown(scrollKeysHandler);
    var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
    $(window).on(mousewheelevt,mouseWheelHandler);
    $(".scroll-navbar a").click(scrollClickHandler);
    $('#Home').on('slide.bs.carousel', function () {
        preventLRArrows = true;
    });
    $('#Home').on('slid.bs.carousel', function () {
        preventLRArrows = false;
    });

    var $sprite = $('.sprite-pseudo');

    setInterval(function () {
        $sprite.after().fadeOut(800, function () {
            var offset = parseFloat($sprite.css("background-position-x"))-100/3;
            if(offset<-100)
                offset=0;
            $sprite.css("background-position-x",offset+'%');
            $sprite.fadeIn(800);
        });
    },7000);

});
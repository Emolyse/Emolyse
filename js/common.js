/**
 * Created by Rémy on 12/08/2015.
 */

/**************************************
 *        SMOOTH SCROLLING SCRIPT     *
 *************************************/

// SMOOTH SCROLL PARAMS
var $body = $("html");
var preventLRArrows = false;
var preventScroll = false;
var deltaError = 50;//Even after a scrollTo on an $anchor there is a small difference between body.scrollTop and anchor.offset.top this param solve this issue
var smoothScrollDuration = 800;

// SMOOTH SCROLL TOOLS
function majScrollMenuStyle($anchor){
    if ($anchor.data("invert") === true) {
        $(".scroll-navbar").addClass("invert");
    } else {
        $(".scroll-navbar").removeClass("invert");
    }
}

function getClosestScrollAnchor(){
    var $res = $(".scroll-anchor").first();
    $(".scroll-anchor").each(function () {;
        if ($body.scrollTop()-$(this).offset().top + parseFloat($(this).css("padding-top"))>=-deltaError){
            $res = $(this);
        } else {
            return false;
        }
    });
    return $res;
}

function majScrollMenuActive($anchor){
    if($anchor.data("menu")){
        var ref = "#"+$anchor.data("menu");
    } else {
        var ref = "#"+$anchor.attr("id");
    }
    history.replaceState(null, null, "http://localhost/Emolyse/"+ref);
    //history.replaceState(null, null, "http://emolyse.github.io/Emolyse/"+ref);
    $('.scroll-navbar li').removeClass('active');
    $('.scroll-navbar li a[href^="'+ref+'"]').parent().addClass('active');
}

function getPrevScrollAnchor(){
    var $res = $body;
    var currentScroll = $body.scrollTop();
    $(".scroll-anchor").each(function (index,e) {
        if(currentScroll>=$(this).offset().top+deltaError){
            $res = $(this);
        }else{
            return false;
        }
    });
    return $res;
}

function getNextScrollAnchor(){
    var $res = $body;
    var currentScroll = $body.scrollTop();
    $(".scroll-anchor").each(function () {
        if(currentScroll<=$(this).offset().top-deltaError){
            $res = $(this);
            return false;
        }
    });
    return $res;
}

// SMOOTH SCROLL HANDLERS
function smoothScrollKeysHandler(e) {
    //Pour le scroll vertical
    if(e.keyCode>31 && e.keyCode<41)
        e.preventDefault();
    //top
    if(e.keyCode == 38 && !preventScroll){
        smoothScrollToPrev();
    }
    //bottom
    if(e.keyCode == 40 && !preventScroll){
        smoothScrollToNext();
    }

    //A supprimer quand pas de carousel
    //left
    if(e.keyCode == 37 && !preventLRArrows){
        $('.carousel').carousel('prev');
    }
    //right
    if(e.keyCode == 39 && !preventLRArrows){
        $('.carousel').carousel('next');
    }
}

function smoothScrollMouseWheelHandler(e){
    e.preventDefault();
    if(!preventScroll) {
        if (e.originalEvent.deltaY < 0) {
            smoothScrollToPrev();
        }
        else {
            smoothScrollToNext()
        }
    }
}

function smoothScrollClickHandler(e){
    e.preventDefault();
    var target = $(e.target).attr("href");
    if(target==="#")
        var $anchor = $(".scroll-anchor").first();
    else var $anchor = $(""+target);
    smoothScrollTo($anchor);
}

// SMOOTH SCROLL UTILITIES
function smoothScrollTo($anchor){
    //ajouter le scroll watcher
    if(!preventScroll){
        preventScroll = true;
        if($anchor.selector === $body.selector){
            var scroll = $anchor.scrollTop();
        } else {
            //on reccupere la position de l'ancre
            var scroll = $anchor.offset().top;

            //on reccupere l'ID de l'ancre ou de son menu rattaché
            majScrollMenuActive($anchor);
        }
        $body.animate({
            scrollTop:scroll
        },smoothScrollDuration, function () {
            preventScroll = false;
            //On situe le menu avant de mettre à jour son style (invert)
            if (Math.abs($anchor.offset().top-$body.scrollTop())>=deltaError){
                $anchor = getClosestScrollAnchor();
            }
            majScrollMenuStyle($anchor);
        });
    }
}

function smoothScrollToPrev(){
    smoothScrollTo(getPrevScrollAnchor());
}

function smoothScrollToNext(){
    smoothScrollTo(getNextScrollAnchor());
}

function initSmoothScroll(duration,navbar){
    if(/Chrome/i.test(navigator.userAgent) || /Safari/i.test(navigator.userAgent) || /Opera/i.test(navigator.userAgent)){
        $body = $('body');
    }
    deltaError = navbar ? navbar : $(".scroll-navbar").height();
    //On met à jour le menu
    if(duration)
        smoothScrollDuration = duration;
    var $anchor = getClosestScrollAnchor();
    majScrollMenuStyle($anchor);
    majScrollMenuActive($anchor);

    //On met en place tous les event handler
    $(document).keydown(smoothScrollKeysHandler);
    $(window).on('wheel',smoothScrollMouseWheelHandler);
    $(".scroll-navbar a").click(smoothScrollClickHandler);


    //A supprimer quand pas de carousel
    $('#Home').on('slide.bs.carousel', function () {
        preventLRArrows = true;
    });
    $('#Home').on('slid.bs.carousel', function () {
        preventLRArrows = false;
    });
}

/**************************************
 *                END                 *
 *************************************/
$(document).ready(function () {

    initSmoothScroll();

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
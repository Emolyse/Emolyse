/**
 * Created by Rémy on 12/08/2015.
 */

/**************************************
 *        SMOOTH SCROLLING SCRIPT     *
 *************************************/
var preventLRArrows = false;
var preventScroll = false;

function scrollTo($anchor){
    if(!preventScroll){
        preventScroll = true;
        if($anchor.selector === "body"){
            console.log("body");
            var scroll = $anchor.scrollTop();
        } else {
            var scroll = $anchor.offset().top;
        }
        $("body").animate({
            scrollTop:scroll
        },1000, function () {
            preventScroll = false;
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
    if(e.keyCode>31 && e.keyCode<41)
        e.preventDefault();
    //left
    if(e.keyCode == 37 && !preventLRArrows){
        $('.carousel').carousel('prev');
    }
    //top
    if(e.keyCode == 38 && !preventScroll){
        scrollToPrev();
    }
    //right
    if(e.keyCode == 39 && !preventLRArrows){
        $('.carousel').carousel('next');
    }
    //bottom
    if(e.keyCode == 40 && !preventScroll){
        scrollToNext();
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


$(document).ready(function () {

    $(document).keydown(scrollKeysHandler);
    var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
    $(window).on(mousewheelevt,mouseWheelHandler);
    $('#myCarousel').on('slide.bs.carousel', function () {
        preventLRArrows = true;
    });
    $('#myCarousel').on('slid.bs.carousel', function () {
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
jQuery(function ($) {
    // var clickvolume = 0;
    // $(".az-volume").click(function(){
    //     var id = $(this).attr('data-id');
    //     if(clickvolume == 0){
    //         $('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
    //         $('#'+id).trigger("play");
    //         clickvolume = 1;
    //     } else {
    //         $('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
    //         $('#'+id).trigger("pause");
    //         clickvolume = 0;
    //     }
    // });

    $(".trangtinchitiet-content .az-volume").click(function(){
        var id      = $(this).attr('data-id');
        var status  = $(this).attr('data-status');
        if(status == 'off'){
            $(this).attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
            $('#'+id).trigger("play");
            $(this).attr('data-status','on');
        } else {
            if($('#iframe_'+id).length > 0) {
                $('#iframe_'+id).remove();
            }
            $(this).attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
            $('#'+id).trigger("pause");
            $(this).attr('data-status','off');
        }
    });

    $(document).on('scroll',function(e) {
        var itempost = $('.wowslider-container');
        var volume_element = $(this).find(".trangtinchitiet-slidermedia .az-volume");
        var id = volume_element.attr('data-id');

        if(itempost.length > 0) {

            var tolerancePixel = 300;
            var scrollTop = $(window).scrollTop() + tolerancePixel;
            var scrollBottom = $(window).scrollTop() + $(window).height() - tolerancePixel;
            var yTopMedia = itempost.offset().top;
            var yBottomMedia = itempost.height() + yTopMedia;
            if ($(window).scrollTop() == 0) {
                volume_element.attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                if($('#iframe_'+id).length > 0) {
                    $('#iframe_'+id).remove();
                }
                $('#'+id).trigger("play");
                volume_element.attr('data-status','on');
            }
            else if (scrollTop > yBottomMedia ) {
                volume_element.attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
                if($('#iframe_'+id).length > 0) {
                    $('#iframe_'+id).remove();
                }
                $('#'+id).trigger("pause");
                volume_element.attr('data-status','off');
            }
        }
    });

    $('#customer').owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
        dots: true,
        items: 2,
        responsive:{
            0:{
                items:1
            },
            768:{
                items:2
            }
        }
    });

    $('.textonimg0').owlCarousel({ animateIn: 'fadeIn', animateOut: 'fadeOut', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });

    var a = 0;
    $(window).scroll(function() {
        if($('#post_statistic').length){
            $('#post_statistic').addClass('exist');
        }

        if($('#post_statistic').hasClass('exist')){
            var oTop = $('#post_statistic').offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() > oTop) {
                $('.countnumber').each(function() {
                    var $this = $(this), countTo = $this.attr('data-count');
                    $({ countNum: $this.text() }).animate({ countNum: countTo }, { duration: 5000, easing: 'swing', step: function() {
                            $this.text(Math.floor(this.countNum));
                        }, complete: function() { $this.text(this.countNum); } });
                });
                a = 1;
            }
        }

    });

});
jQuery(document).ready(function($) {
    $(function() {
        $('.tinchitiet-slider').not('.slick-initialized').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            infinite: false
        });
    });
    if($('.play-youtube').length){
        $('.play-youtube').lightGallery();
    }
});
$(window).load(function() {
    if($('.sidebarsm').is(":visible")){
        var menu_active = $('.sidebarsm li.active');
        var li_index = menu_active.index();
        var li_width = menu_active.outerWidth(true);
        var siderbar_with = $('.sidebarsm .tindoanhnghiep-list-menu').outerWidth();
        if(li_index > 2){
            $('.sidebarsm .tindoanhnghiep-list-menu').animate({'scrollLeft': ((li_index * li_width) - (siderbar_with / 2) + (li_width / 2) )},500);
        }
    }

    // scroll level 2
    if($('.page-scroll-to-lvl2').length){
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.page-scroll-to-lvl2').offset().top
        }, 800);
    }else if($('.page-scroll-to-lvl1').length && $('.sidebarsm').is(":visible")){
        //scroll level 1
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.page-scroll-to-lvl1').offset().top
        }, 800);
    }

});
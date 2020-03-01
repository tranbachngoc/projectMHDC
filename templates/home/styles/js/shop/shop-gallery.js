$(window).on("load",function(){
    $(".style-weblink").mCustomScrollbar({
        axis:"x",
        theme:"dark-thin",
        autoExpandScrollbar:true,
        advanced:{autoExpandHorizontalScroll:true}
    });
});

function detectBackground(x) {
    if (x.matches) {
        $('.trangcuatoi.tindoanhnghiep').removeClass('display-md');
        if(!$('.trangcuatoi.tindoanhnghiep').hasClass('display-sm')){
            $('.trangcuatoi.tindoanhnghiep').addClass('display-sm');
        }
    }else {
        $('.trangcuatoi.tindoanhnghiep').removeClass('display-sm');
        if(!$('.trangcuatoi.tindoanhnghiep').hasClass('display-md')){
            $('.trangcuatoi.tindoanhnghiep').addClass('display-md');
        }
    }
}

var matchBlackBackground = window.matchMedia("(max-width: 767px)");
// matchBlackBackground.addListener(detectBackground);
detectBackground(matchBlackBackground);

var timeout_resize = false;
$(window).resize(function() {
    clearTimeout(timeout_resize);
    timeout_resize = setTimeout(function () {
        detectBackground(matchBlackBackground);
    }, 300);
});

$('.tag-selecting').click(function(){
    $(this).toggleClass('is-active');
    if ($(this).hasClass('is-active')) {
        $('.tag-list-product').show();
        $('.tag-list-product-slider').get(0).slick.setPosition();
    } else {
        $('.tag-list-product').hide();
        $(this).removeClass('is-active');
    }
});
$('.closebox').click(function(){
    $('.tag-list-product').hide();
    $('.tag-selecting').removeClass('is-active');
});
$('.luot-xem-tin').click(function(){
    $(this).addClass('opened');
});
$('.dong-luot-xem-tin').click(function(){
    $('.luot-xem-tin').removeClass('opened');
});

$(document).ready(function() {

    var masonryOptions = {
        itemSelector: '.item',
        horizontalOrder: true
    };

    var $grid = $('.grid').masonry(masonryOptions);
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });

    if (PAGE_VIEW == 'video-page' && VIEW_TYPE == 'grid-view') 
    {
        $grid.masonry('destroy');
    }

    //change view list || grid in mobile
    $('.js_view-action').on( "click", function(event) {
        event.preventDefault();

        if ($(this).hasClass('js-new-button')) 
        {
            if(PAGE_VIEW === 'video-page') 
            {
                console.log('templates/home/styles/js/shop/shop-gallery.js:81');
                if ($(this).hasClass('js-see-haftwidth')) 
                {
                    $('body').find('main').removeClass('bg-black').addClass('bg-white');
                    $('body').find('.xemluoi').removeClass('xemluoi');
                    VIEW_TYPE = 'list-view';
                    $('img', this).attr("src","/templates/home/styles/images/svg/xemluoi_on.svg");
                    $('.js-see-fullwidth').find('img').attr("src","/templates/home/styles/images/svg/danhsach_off.svg");

                    $('.avata-part-right .share-click .icon.sm').attr("src","/templates/home/styles/images/svg/share.svg");
                    $('.avata-part-right .xemthem .icon.sm').attr("src","/templates/home/styles/images/svg/3dot_doc.svg");
                    $('.avata-part-right .js_tel .icon.sm').attr("src","/templates/home/styles/images/svg/tel.svg");
                    $('.avata-part-right .js_message .icon.sm').attr("src","/templates/home/styles/images/svg/comment_3dot.svg");

                    history.pushState({}, "", window.location.origin + window.location.pathname + '?view=grid');
                    $grid = $('.grid').masonry(masonryOptions);
                    $grid.imagesLoaded().progress( function() {
                        $grid.masonry('layout');
                    });
                } 
                else 
                {   
                    $('body').find('main').removeClass('bg-white').addClass('bg-black');
                    VIEW_TYPE = 'grid-view';
                    $('.liet-ke-hinh-anh').find('.grid').addClass('xemluoi');
                    $(this).find('img').attr("src","/templates/home/styles/images/svg/danhsach_white_on.svg");
                    $('.js-see-haftwidth').find('img').attr("src","/templates/home/styles/images/svg/xemluoi_off.svg");

                    $('.avata-part-right .share-click .icon.sm').attr("src","/templates/home/styles/images/svg/share_white01.svg");
                    $('.avata-part-right .xemthem .icon.sm').attr("src","/templates/home/styles/images/svg/3dot_doc_white.svg");
                    $('.avata-part-right .js_tel .icon.sm').attr("src","/templates/home/styles/images/svg/tel_white.svg");
                    $('.avata-part-right .js_message .icon.sm').attr("src","/templates/home/styles/images/svg/comment_3dot_white.svg");

                    history.pushState({}, "", window.location.origin + window.location.pathname + '?view=list');
                    $grid.masonry('destroy');
                }
                
            } 
            else 
            {
                if ($(this).hasClass('js-see-haftwidth')) 
                {
                    $('body').find('.xemluoi').removeClass('xemluoi');
                    
                    VIEW_TYPE = 'list-view';
                    $('img', this).attr("src","/templates/home/styles/images/svg/xemluoi_on.svg");
                    $('.js-see-fullwidth').find('img').attr("src","/templates/home/styles/images/svg/danhsach_off.svg");
                    history.pushState({}, "", window.location.origin + window.location.pathname + '?view=grid');
                } 
                else 
                {  
                    VIEW_TYPE = 'grid-view';
                    $('.liet-ke-hinh-anh').find('.grid').addClass('xemluoi');
                    $(this).find('img').attr("src","/templates/home/styles/images/svg/danhsach_on.svg");
                    $('.js-see-haftwidth').find('img').attr("src","/templates/home/styles/images/svg/xemluoi_off.svg"); 
                    history.pushState({}, "", window.location.origin + window.location.pathname + '?view=list');
                }

                $grid.imagesLoaded().progress( function() {
                    $grid.masonry('layout');
                });
            }
        } 
        else 
        {
            if($(this).hasClass('list-view')){
                $(this).removeClass('list-view').addClass('gird-view');
                VIEW_TYPE = 'grid-view';
                $('.grid', document).addClass('xemluoi');
                $('main', document).removeClass('bg-white').addClass('bg-black');
                $('img', this).attr("src","/templates/home/styles/images/svg/xemluoi_white_on.svg");
                history.pushState({}, "", window.location.origin + window.location.pathname + '?view=list');
            }else{
                VIEW_TYPE = 'list-view';
                $('.grid', document).removeClass('xemluoi');
                $('main', document).removeClass('bg-black').addClass('bg-white');
                $(this).removeClass('gird-view').addClass('list-view');
                $('img', this).attr("src","/templates/home/styles/images/svg/danhsach_on.svg");
                history.pushState({}, "", window.location.origin + window.location.pathname + '?view=grid');
            }
            $grid.imagesLoaded().progress( function() {
                $grid.masonry('layout');
            });
        }

        if(PAGE_VIEW === 'video-page'){
            if($('video.play-video').length){
                $('video.play-video').trigger('pause');
            }
            $('.tindoanhnghiep.display-sm .video-page.xemluoi video').first().trigger("click");
        }        
    });

    // scroll load more data
    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function(event) {
        $element = $('.wrapper');
        $loadding = $('#loadding-more');
        if($(window).scrollTop() + $(window).height() >= $element.height() - 200) {
            if (is_busy == true){
                event.stopPropagation();
                return false;
            }
            if (stopped == true){
                event.stopPropagation();
                return false;
            }
            $loadding.removeClass('hidden');
            is_busy = true;
            page++;

            $.ajax({
                type: 'post',
                dataType: 'html',
                url: window.location.href,
                data: {page: page},
                success: function (result) {
                    $loadding.addClass('hidden');
                    if(result == '') {
                        stopped = true;
                    }
                    if(result){
                        var $content = $(result);
                        $grid.append( $content ).masonry('appended', $content);
                        $grid.imagesLoaded().progress( function() {
                            $grid.masonry('layout');
                        });
                    }
                }
            }).always(function() {
                is_busy = false;
            });
            return false;
        }
    });
});

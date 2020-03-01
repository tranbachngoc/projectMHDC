function isElementInViewport (el) {

    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        //rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
    );
}

$(document).ready(function() {
    var masonryOptions = {
        itemSelector: '.item',
        horizontalOrder: true
    };
    var $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });
    $('.tab-recent .item').click(function () {
        $(".tab-recent .item").removeClass('active');
        $(this).addClass('active');
        var num =  $('.tab-recent .item.active').index();
        $(".tab-recent-content .liet-ke-hinh-anh").hide().eq(num).show();
        $grid.imagesLoaded().progress( function() {
            $grid.masonry('layout');
        });
    });
    $('.tab-recent .item.activge').trigger('click');
});

$(window).scroll(function() {
    $('.bosuutap-content-detail-modal .popup-image-sm video').each(function(i,e) {
        if(!isElementInViewport($(e))) {
            $(e).trigger("pause");
        }else{
            $(e).trigger("play");
        }
    });
});
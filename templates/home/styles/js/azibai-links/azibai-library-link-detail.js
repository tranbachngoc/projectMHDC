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
    $('.tab-recent .item.active').trigger('click');
});
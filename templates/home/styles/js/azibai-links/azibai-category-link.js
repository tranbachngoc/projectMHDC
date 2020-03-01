$(document).ready(function() {
    var masonryOptions = {
        itemSelector: '.item',
        horizontalOrder: true
    };

    var $grid = $('.list-link-content .grid').masonry(masonryOptions);
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });

    var view_type = 'gird';

    $('.js_action-view.js-see-haftwidth').on('click', function(event) {
        event.preventDefault();
        view_type = 'gird';
        custom_background(true);
        $('.js_action-view').removeClass('active');
        $(this).addClass('active');
        $('.liet-ke-hinh-anh .grid').removeClass('fullwidth').removeClass('youtubelayer');
        $(this).find('img').attr("src","/templates/home/styles/images/svg/xemluoi_white_on.svg");
        $('.js-see-fullwidth').find('img').attr("src","/templates/home/styles/images/svg/danhsach_off.svg");
        $('.js-see-youtubelayer').find('img').attr("src","/templates/home/styles/images/svg/xemlietke_off.svg");
        $grid.masonry( masonryOptions );
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=grid');
    });

    $('.js_action-view.js-see-fullwidth').click(function(event) {
        event.preventDefault();
        view_type = 'list';
        custom_background(true);
        $('.js_action-view').removeClass('active');
        $(this).addClass('active');
        $grid.masonry('destroy');
        $('body .tindoanhnghiep .grid').addClass('fullwidth').removeClass('youtubelayer');
        $(this).find('img').attr("src","/templates/home/styles/images/svg/danhsach_white_on.svg");
        $('.js-see-haftwidth').find('img').attr("src","/templates/home/styles/images/svg/xemluoi_off.svg");
        $('.js-see-youtubelayer').find('img').attr("src","/templates/home/styles/images/svg/xemlietke_off.svg");
        $grid.masonry( masonryOptions );
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=list');
    });

    $('.js_action-view.js-see-youtubelayer').click(function(event) {
        event.preventDefault();
        view_type = 'line';
        custom_background(false);
        $('.js_action-view').removeClass('active');
        $(this).addClass('active');
        $grid.masonry('destroy');
        $('body .liet-ke-hinh-anh').find('.grid').addClass('youtubelayer').removeClass('fullwidth');
        $(this).find('img').attr("src","/templates/home/styles/images/svg/xemlietke_white_on.svg");
        $('.js-see-haftwidth').find('img').attr("src","/templates/home/styles/images/svg/xemluoi_off.svg");
        $('.js-see-fullwidth').find('img').attr("src","/templates/home/styles/images/svg/danhsach_off.svg");
        $grid.masonry( masonryOptions );
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=line');
    });

    $('.tindoanhnghiep.display-sm .js_action-view.active').trigger('click');

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
                return;
            }
            $loadding.removeClass('hidden');
            is_busy = true;
            page++;

            $.ajax({
                type: 'post',
                dataType: 'html',
                url: window.location.origin + window.location.pathname + '/ajax?view=' + view_type,
                data: {page: page},
                success: function (result) {
                    $loadding.addClass('hidden');
                    if(result == '' || result == '123') {
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
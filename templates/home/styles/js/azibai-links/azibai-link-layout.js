jQuery(document).ready(function($) {
    var masonryOptions = {
        itemSelector: '.item',
        horizontalOrder: true
    };

    var $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });

    var isActive = true;
    var view_type = 'grid';
    $('body .js-see-haftwidth').on('click', function () {
        view_type = 'gird';
        custom_background(true);
        $('.liet-ke-hinh-anh .grid').removeClass('youtubelayer').removeClass('fullwidth');
        $(this).find('img').attr("src", "/templates/home/styles/images/svg/xemluoi_white_on.svg");
        $('.js-see-fullwidth').find('img').attr("src", "/templates/home/styles/images/svg/danhsach_off.svg");
        $('.js-see-youtubelayer').find('img').attr("src", "/templates/home/styles/images/svg/xemlietke_off.svg");
        if(!isActive){
            $('.js-youtubelayer-slider').slick('unslick');
        }
        var $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
        $grid.masonry('layout');
        isActive = true;
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=grid');
    });

    $('body .js-see-fullwidth').on('click', function (e) {
        e.preventDefault();
        view_type = 'list';
        custom_background(true);
        $('body .tindoanhnghiep .grid').addClass('fullwidth').removeClass('youtubelayer');
        $(this).find('img').attr("src", "/templates/home/styles/images/svg/danhsach_white_on.svg");
        $('.js-see-haftwidth').find('img').attr("src", "/templates/home/styles/images/svg/xemluoi_off.svg");
        $('.js-see-youtubelayer').find('img').attr("src", "/templates/home/styles/images/svg/xemlietke_off.svg");
        if(!isActive){
            $('.js-youtubelayer-slider').slick('unslick');
        }
        var $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
        $grid.masonry('layout');
        isActive = true;
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=list');
    });

    $('body .js-see-youtubelayer').on('click', function (e) {
        e.preventDefault();
        view_type = 'line';
        custom_background(false);
        if(isActive){
            $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
            $grid.masonry('destroy');
        }
        isActive = false;
        $('body .liet-ke-hinh-anh').find('.grid').addClass('youtubelayer').removeClass('fullwidth');
        $(this).find('img').attr("src", "/templates/home/styles/images/svg/xemlietke_white_on.svg");
        $('.js-see-haftwidth').find('img').attr("src", "/templates/home/styles/images/svg/xemluoi_off.svg");
        $('.js-see-fullwidth').find('img').attr("src", "/templates/home/styles/images/svg/danhsach_off.svg");
        // re-init Masonry
        history.pushState({}, "", window.location.origin + window.location.pathname + '?view=line');
        $(document).ready(function () {
            // Slick Selector.
            $('body .js-youtubelayer-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                infinite: false
            });
        });
    });


    $('.tindoanhnghiep.display-sm .js_action-view.active').trigger('click');

    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function(event) {
        $element  = $('.group-list-link-content');
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
                url: window.location.origin + window.location.pathname + '/ajax?view='+ view_type,
                data: {page: page},
                success: function (result) {
                    $loadding.addClass('hidden');
                    if(result){
                        if(isActive == true){
                            var $content = $(result);
                            $('.group-list-link-content').append($content);
                            $grid = $('.liet-ke-hinh-anh .grid').masonry(masonryOptions);
                            $grid.imagesLoaded().progress( function() {
                                $grid.masonry('layout');
                            });
                        }else{
                            $('.group-list-link-content')
                                .append(result)
                                .find('.js-youtubelayer-slider').last()
                                .slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: false,
                                    dots: true,
                                    infinite: false
                                });
                        }
                    }else{
                        stopped = true;
                    }
                }
            }).always(function() {
                is_busy = false;
            });
            return false;
        }
    });
});
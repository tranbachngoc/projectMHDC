var url_get_data_videos_more = window.location.origin + '/library/videos/';
$(document).ready(function() {
    //---------- block bộ sưu tập scroll horizontal trang chủ cá nhân------------------------
    $(".style-weblink, .list-bosuutap-slider").mCustomScrollbar({
        axis:"x",
        theme:"dark-thin",
        autoExpandScrollbar:true,
        advanced:{autoExpandHorizontalScroll:true}
    });
    //---------- block bộ sưu tập------------------------
    //---------- scroll auto play video home page personal--------------
    var flag_pause = false;

    function scrollNewsHome(el)
    {
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }
        var rect = el.getBoundingClientRect();
        var rect_parent = $(el).parents('.js_item-detect-video-action')[0];
        var offset_negative = rect_parent.clientHeight - window.innerHeight;
        var result_detect = {
            'video'     : rect.top >= 0 && rect.bottom  <= (window.innerHeight),
            'item_news' : rect.top >= -(offset_negative+50) && rect.bottom  <= (rect_parent.clientHeight),
        };
        return result_detect

    }

    var videojs_inited = [];

    $(document).on('click', '.content-posts .video-inner > img.poster-video, .content-posts .video-inner .btn-add-video', function (event) {
        event.preventDefault();
        var video = $(this).parent().parent('.video');
        var temp_id = $(video).data('target_video');
        if(temp_id && videojs_inited.indexOf(temp_id) === -1) {
            addvideo($(video), $(video).attr('data-video'));
            videojs(temp_id, {
                aspectRatio: '9:16',
            }).play();
        }
    });

    $(window).scroll(function() {
        $('.tindoanhnghiep .content .video').each(function() {
            var result_detect = scrollNewsHome($(this));
            $video = $(this).find('.videoautoplay');
            if(result_detect.video === true) {
                var data_video = $(this).attr('data-video');
                var temp_id = $(this).data('target_video');
                if(temp_id && videojs_inited.indexOf(temp_id) === -1 && $video.length == 0) {
                    addvideo($(this),data_video);
                    videojs(temp_id, {
                        aspectRatio: '16:9'
                    });
                    videojs_inited.push(temp_id);
                }

                if(!$video.hasClass('no-autoplay')){
                    $('.vjs-playing video.vjs-tech').trigger('pause');
                    $('video.video-play').trigger('pause');
                    $('video.vjs-tech', $video).trigger("play");
                }else{
                    //không auto pause video slider horizontal trước khi scroll qua nó
                    flag_pause = true;
                }
            }else {
                if (result_detect.item_news === false) {
                    if ($video.hasClass('vjs-playing')) {
                        if (!$video.hasClass('no-autoplay')) {
                            $('video', $video).trigger("pause");
                        } else if (flag_pause) {
                            $('video', $video).trigger("pause");
                        }
                    }
                }
            }
        });
        $('#addlinkthem:not(.no-active)').each(function() {
            $('li:first video', $(this)).each(function() {
                var result_detect = scrollNewsHome($(this));
                if(result_detect.video === true) {
                    $('video.video-play').trigger('pause');
                    $(this).trigger("play");
                }else {
                    $(this).trigger("pause");
                }
            });
        });
    });
    //---------- end scroll auto play video home page personal--------------
    //-------------load more news--------------------
    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function () {
        $element = $('#content');
        $loadding = $('#loadding');
        if ($(window).scrollTop() + $(window).height() >= $element.height() - 200) {
            if (is_busy == true) {
                return false;
            }
            if (stopped == true) {
                return false;
            }
            is_busy = true;
            page++;
            $.ajax({
                type: 'post',
                dataType: 'text',
                url: url_ajax + '/get_more_news/',
                data: {page: page, type: $element.attr('data-type')},
                success: function (result) {
                    if (result == '') {
                        stopped = true;
                        $loadding.addClass('hidden');
                    }
                    $element.append(result);
                    $('.rowpro .owl-carousel').owlCarousel({
                        loop: false,
                        margin: 5,
                        nav: true,
                        dots: false,
                        responsive: {0: {items: 1}, 600: {items: 2}}
                    });
                    $('[data-countdown]').each(function () {
                        var $this = $(this), finalDate = $(this).data('countdown');
                        $this.countdown(finalDate, function (event) {
                            $this.html(event.strftime('%D ngày %H:%M:%S'));
                        });
                    });
                }
            }).always(function () {
                is_busy = false;
            });
            return false;
        }
    });

    //-------------load more news--------------------



    // collapse seemore
    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };


    $('.js-detect-item-viewport').each(function () {
        var description = $(this).find('.js-viewport-get');
        var data_collapse = $(description).html();
        $(description).attr('data-showed', data_collapse);
    });
    $(window).on('resize scroll', function() {
        $('body').find('.js-detect-item-viewport').each(function () {
            var description = $(this).find('.js-viewport-get');
            // nếu chưa có data-showed thì add vào
            if($(description).attr('data-showed') == '' || $(description).attr('data-showed') == undefined) {
                var data_collapse = $(description).html();
                $(description).attr('data-showed', data_collapse);
            } else {
                // element has been scroll over
                if (!$(this).isInViewport()) {
                    var data_return = $(description).attr('data-showed');
                    $(description).html(data_return);
                }
            }
        });
    });

    /*
    * sweep slider home
    *
    * if current video is playing => pause
    * if next slide is video => play
    * */
    $('.slider-for.slick-initialized').on('swipe', function(event, slick, direction){
        var nextSlide = 0;
        if(direction === 'left'){
            nextSlide = direction - 1;
        }else{
            nextSlide = direction + 1;
        }
        var temp_currernt = $('video', slick.$slides.get(slick.currentSlide));
        var temp_next     = $('div.vjs-playing video', slick.$slides.get(nextSlide));
        if(temp_currernt){
            $(temp_currernt).trigger('play');
        }
        if(temp_next){
            $(temp_next).trigger('pause');
        }
    });
});





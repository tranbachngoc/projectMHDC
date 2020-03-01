(function($) {
    $.fn.swipeDetail = function(options) {
        // Default thresholds & swipe functions
        var defaults = {
            threshold: {
                x: 30,
                y: 30
            },
            swipeLeft: function() {
                $('#modal-show-detail-img .next.controls').click();
            },
            swipeRight: function() {
                $('#modal-show-detail-img .previous.controls').click();
            },
            swipeDown: function() {
                $('#modal-show-detail-img .dong-luot-xem-tin').click();
            },
            swipeUp: function() {
                $('#modal-show-detail-img .luot-xem-tin').click();
            },
        };

        var options = $.extend(defaults, options);

        if (!this) return false;

        return this.each(function() {

            var me = $(this)

            // Private variables for each element
            var originalCoord = { x: 0, y: 0 }
            var finalCoord = { x: 0, y: 0 }
            var start_M = false;


            // Store coordinates as finger is swiping
            function touchMove(event) {
                if (start_M == true) {
                    event.preventDefault();
                    if (event.targetTouches !== undefined) {
                        var touches = event.targetTouches[0];
                    }
                    finalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                    finalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;
                }
            }

            // Done Swiping
            // Swipe should only be on X axis, ignore if swipe on Y axis
            // Calculate if the swipe was left or right
            function touchEnd(event) {

                if (start_M == true) {

                    if (options.verticalSwiping === true)
                    {
                        var changeY = parseInt(originalCoord.y - finalCoord.y);
                        var changeX = parseInt(originalCoord.x - finalCoord.x);
                        swipeLength = Math.round(Math.sqrt(Math.pow(changeY, 2)));
                        
                        if (swipeLength > 20 && Math.abs(changeY) > Math.abs(changeX))
                        {
                            if (changeY > 0 )
                            {
                                defaults.swipeUp()
                            }
                            else
                            {
                                defaults.swipeDown();
                            }
                        }
                    }
                    else
                    {
                        var changeY = originalCoord.y - finalCoord.y;

                        swipeLength = Math.round(Math.sqrt(
                            Math.pow(finalCoord.x - originalCoord.x, 2)));

                        if (swipeLength > 20) {
                            xDist = originalCoord.x - finalCoord.x;
                            yDist = originalCoord.y - finalCoord.y;
                            r = Math.atan2(yDist, xDist);

                            swipeAngle = Math.round(r * 180 / Math.PI);

                            if (swipeAngle < 0) {
                                swipeAngle = 360 - Math.abs(swipeAngle);
                            }
                            if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
                                defaults.swipeLeft()
                            }
                            if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
                                defaults.swipeLeft()
                            }
                            if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
                                defaults.swipeRight()
                            }
                        }
                    }
                    start_M = false;
                }
            }

            // Swipe was started
            function touchStart(event) {

                start_M = true;
                if (event.targetTouches !== undefined) {
                    var touches = event.targetTouches[0];
                }
                originalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                originalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;

                finalCoord.x = originalCoord.x
                finalCoord.y = originalCoord.y
            }


            if (options.verticalSwiping === true)
            {
                this.addEventListener("touchstart", touchStart, false);
                this.addEventListener("touchend", touchEnd, false);
                this.addEventListener("touchcancel", touchEnd, false);
                this.addEventListener("touchmove", touchMove, false);
            }
            else
            {
                this.addEventListener("mousedown", touchStart, false);
                this.addEventListener("mousemove", touchMove, false);
                this.addEventListener("mouseup", touchEnd, false);
                this.addEventListener("mouseleave", touchEnd, false);
            }

        });
    };
})(jQuery);

$( document ).ready(function() {
    var link_href = '';
    var link_avatar = '';
    var info_popup = {};
    var tags_pop = [];
    var full_text = '';
    var key_id = 0;
    var myCarousel;
    var ratio_3d = -1;
    var new_id = 0;
    var click_show_tags = 0;
    $('#modal-show-detail-img .jR3DCarouselGallery').swipeDetail();

    $('#modal-show-detail-img #action-swipe').swipeDetail({verticalSwiping:true});
    $('#modal-show-detail-img .list-image-recent').swipeDetail({verticalSwiping:true});


    function showTagHomeTwo(key_tags, tags) {
        var str = '';
        tags_pop[key_tags] = {};
        tags_pop[key_tags] = JSON.parse(tags);
        if (tags_pop[key_tags].length > 0) {
            $.each(tags_pop[key_tags], function( index, value ) {
                var positionStyle = getPositionStyle(value.x, value.y);
                var wrapperElement = '<div style="display:none; left: '+positionStyle.left+'; top: '+positionStyle.top+'" class="taggd__wrapper position-tag">';
                wrapperElement += '<div class="tag-photo-home-2 tag-selecting" data-id="'+ index +'" data-key="'+ key_tags +'"><img style="" src="/templates/home/icons/boxaddnew/tag.svg"></div>';
                wrapperElement += '</div>';
                str += wrapperElement;
            });
        }
        return str;
    }

    $('body').on('click', '#modal-show-detail-img .tag-number-selected', function(){
        if($(this).hasClass('is-active')) {
            var parent_id = $(this).parents('.jR3DCarouselCustomSlide');
            $(parent_id).find('.taggd__wrapper').hide();
            $(this).removeClass('is-active');
        } else {
            var parent_id = $(this).parents('.jR3DCarouselCustomSlide');
            $(parent_id).find('.taggd__wrapper').show();
            $(this).addClass('is-active');
        }
    });
 
    function show_detail_two(_key_id) {
        $('#modal-show-detail-img .jR3DCarouselGallery').empty();

        // slider bottom img3
        if($('#modal-show-detail-img .list-image-recent-slider').hasClass('slick-initialized')){
            $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('unslick');
        }
        $('#modal-show-detail-img .list-image-recent-slider').removeClass('slick-initialized slick-slider');
        $('#modal-show-detail-img .list-image-recent-slider').html('');

        if (info_popup.listImg !== undefined) {
            $.each(info_popup.listImg, function( index, value ) {
                //  tags
                if (value.type == 'img') {
                    var template_img = $('#js-list-3d-tag').html();

                    switch (value.orientation) {
                        case '90':
                            template_img = template_img.replace(/{{CLASS_ORIENTATION}}/g, 'rotate-r-90');break;
                        case '180':
                            template_img = template_img.replace(/{{CLASS_ORIENTATION}}/g, 'rotate-180');break;
                        case '270':
                            template_img = template_img.replace(/{{CLASS_ORIENTATION}}/g, 'rotate-l-90');break;
                    }

                    /*if (info_popup.info.type_post == 'webf') {
                        template_img = template_img.replace(/{{IMAGE_LINK_TAG}}/g, info_popup.info.path_img +value.image);
                    } else {
                        template_img = template_img.replace(/{{IMAGE_LINK_TAG}}/g, info_popup.info.path_img + '1x1_'+value.image);
                    }*/ //cancel 1x1_
                    template_img = template_img.replace(/{{IMAGE_LINK_TAG}}/g, info_popup.info.path_img +value.image);

                    template_img = template_img.replace(/{{KEY_INDEX}}/g, index);

                    if (value.tags !== undefined && value.tags !== null) {
                        template_img = template_img.replace(/{{TOTAL_TAG}}/g, value.tags.length);
                        var str = showTagHomeTwo(index,JSON.stringify(value.tags));
                        template_img = template_img.replace(/{{LIST_TAG}}/g, str);
                        if (value.tags.length == 0) {
                            template_img = template_img.replace(/{{HIDE_SHOW}}/g, 'hide_0');
                        } else {
                            template_img = template_img.replace(/{{HIDE_SHOW}}/g, 'hide_1');
                        }

                    }else {
                        template_img = template_img.replace(/{{TOTAL_TAG}}/g, 0);
                        template_img = template_img.replace(/{{LIST_TAG}}/g, '');
                        template_img = template_img.replace(/{{HIDE_SHOW}}/g, 'hide_0');
                    }
                    $('#modal-show-detail-img .jR3DCarouselGallery').append(template_img);

                    /*if (info_popup.info.type_post == 'webf') {
                        var slider_img = '<li href="'+info_popup.info.path_img +value.image+'">';
                        slider_img += '<img src="'+info_popup.info.path_img +value.image+'" alt="" data-title="'+value.title+'"';
                        switch (value.orientation) {
                            case '90':
                                slider_img += ' class="rotate-r-90"';break;
                            case '180':
                                slider_img += ' class="rotate-180"';break;
                            case '270':
                                slider_img += ' class="rotate-l-90"';break;
                        }
                        slider_img += '>';
                        slider_img += '<p class="sub-tit two-lines">'+value.title+'</p>';
                        slider_img += '</li>';
                    } else {
                        var slider_img = '<li href="'+info_popup.info.path_img + '1x1_'+value.image+'">';
                        slider_img += '<img src="'+info_popup.info.path_img + '1x1_'+value.image+'" alt="" data-title="'+value.title+'"';
                        switch (value.orientation) {
                            case '90':
                                slider_img += ' class="rotate-r-90"';break;
                            case '180':
                                slider_img += ' class="rotate-180"';break;
                            case '270':
                                slider_img += ' class="rotate-l-90"';break;
                        }
                        slider_img += '>';
                        slider_img += '<p class="sub-tit two-lines">'+value.title+'</p>';
                        slider_img += '</li>';
                    }*/ //cancel 1x1_
                    var slider_img = '<li href="'+info_popup.info.path_img + value.image+'">';
                    slider_img += '<img src="'+info_popup.info.path_img + value.image+'" alt="" data-title="'+value.title+'"';
                    switch (value.orientation) {
                        case '90':
                            slider_img += ' class="rotate-r-90"';break;
                        case '180':
                            slider_img += ' class="rotate-180"';break;
                        case '270':
                            slider_img += ' class="rotate-l-90"';break;
                    }
                    slider_img += '>';
                    slider_img += '<p class="sub-tit two-lines">'+value.title+'</p>';
                    slider_img += '</li>';
                    $('#modal-show-detail-img .list-image-recent-slider').append(slider_img);
                }

                if (value.type == 'video') {
                    var template_video = $('#js-list-3d-video').html();
                    template_video = template_video.replace(/{{VIDEO_URL}}/g, value.link);
                    template_video = template_video.replace(/{{KEY_INDEX}}/g, index);
                    $('#modal-show-detail-img .jR3DCarouselGallery').append(template_video);

                    var slider_img = '<li href="'+value.link+'">';
                    slider_img += '<video playsinline="" muted="1" autoplay="false" preload="metadata" controls="controls">';
                    slider_img += '<source src="'+value.link+'" type="video/mp4">';
                    slider_img += '</video>';
                    slider_img += '</li>';
                    $('#modal-show-detail-img .list-image-recent-slider').append(slider_img);
                }

                var get_ratio_3d = value.image_size.width/value.image_size.height;
                if (ratio_3d == -1 || ratio_3d > get_ratio_3d) {
                    ratio_3d = get_ratio_3d;
                }

            });
            $('body').find('#modal-show-detail-img .list-image-recent-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 3,
                arrows: true,
                dots: false,
                infinite: false,
                speed: 300,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            arrows: false,
                        }
                    }
                ]
            });
            $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', _key_id);
            $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+_key_id+'"]').addClass('is-active');
        }
        $('.tag-list-product .tag-list-product-slider').html('');
    }

    $('body').on('click', '#modal-show-detail-img .read-more', function() {
        var element = $('#modal-show-detail-img .pop-descrip');
        var _key_id = $(this).attr('data-id');
        if ($( element ).hasClass( "have-read-more" )) {
            $( element ).removeClass( "have-read-more" );
            $( element ).find('.read-more').remove();
        }
        if (info_popup.listImg[_key_id] !== undefined) {
            info_popup.listImg[_key_id].show_full_text = full_text;
        }
        $('#modal-show-detail-img .pop-descrip').html(full_text);
    });

    $('body').on('click', '.video .btn-pause-home-page.js_btn-pause', function(event) {
        event.preventDefault();
        $('#'+ $(this).data('video-id')).trigger('play');
    });

    $('body').on('click', '.video .mask-video', function(e) {
        e.preventDefault();
        $($(this).parents('.video').data('target_video')).trigger('click');
    });

    var popup;
    var text_shr = '';
    $('body').on('click', '.popup-detail-image', function(e) {
        e.preventDefault();
        if(popup > 0 && $('.detail_url').length > 0){
            $('.load-wrapp').css('background-color','rgba(0, 0, 0, 0.91)');
        }
        var _this = $(this);
        new_id = $(this).attr('data-news-id');
        key_id = parseInt($(this).attr('data-key'));
        link_href = $(this).parents('.post-detail').find('.info-product .descrip a').attr('href');

        link_avatar = $(this).parents('.post').find('.shop_avatar_link').attr('href');

        if (link_avatar === undefined || link_avatar == '')
        {
            link_avatar = $('.trangtinchitiet-info-header').find('.avata a').attr('href');
        }


        var info_video = {};
        var get_video = $(this).parents('.item-element-parent').find('.popup-detail-video');
        popup = $('#modal-show-detail-img .share-click-popup').attr('data-pop');
        var at_pop;
        if(popup > 0 && $('.detail_url').length > 0){
            click_show_tags = 1;
            if (get_video.length == 1) {
                info_video = {
                    id: $(get_video).attr('data-video-id'),
                    link: $(get_video).attr('data-video-link') + '#t=' + $(get_video).get(0).currentTime ,
                    shop_link: $(get_video).attr('data-shop-link'),
                    clientHeight: $(get_video)[0].clientHeight,
                    clientWidth: $(get_video)[0].clientWidth,
                }
            }
        }else{
            click_show_tags = 0;
            if($(this).hasClass('fs-gal')) {
                click_show_tags = 1;
            }
            else if (get_video.length == 1) {
                info_video = {
                    id: $(get_video).attr('data-video-id'),
                    link: $(get_video).attr('data-video-link') + '#t=' + $(get_video).get(0).currentTime ,
                    shop_link: $(get_video).attr('data-shop-link'),
                    clientHeight: $(get_video)[0].clientHeight,
                    clientWidth: $(get_video)[0].clientWidth,
                }
            }
        }
        // Nhập dữ liệu cho commnet
        // id = $(this).attr('data-id');
        // $('#modal-show-detail-img #button-send-comment').attr('onclick','sendcoment('+id+',"image")');
        // var content_comment = $('#modal-show-detail-img .area-comment').html();
        // content_comment = content_comment.replace(/{{CONTENT_CONMMENT}}/g, 'commnet_content_'+id);
        // $('#modal-show-detail-img .area-comment').html(content_comment);
        text_shr = $(this).data('name');
        $('#modal-show-detail-img').find('.share-click-popup').attr('data-name',convert_percent_encoding(text_shr));
        $('#modal-show-detail-img').find('.share-click-popup').attr('data-value',$(this).data('value'));
        $('#modal-show-detail-img').find('.share-click-popup').attr('data-type',$(this).data('type'));

        if (link_href === undefined || link_href == '')
        {
            link_href = $(this).data('value');
        }

        $.ajax({
            url: siteUrl + 'tintuc/getDetailImg',
            type: "POST",
            data: {new_id: new_id, key_id:key_id, info_video: info_video },
            dataType: "json",
            beforeSend: function () {
                info_popup = {};
            },
            success: function (response) {

                info_popup = response;
                ratio_3d = -1;
                if (response.info) {
                    $('#modal-show-detail-img .pop_shop_name').text(response.info.name);
                    $('#modal-show-detail-img .pop_shop_img').attr('src', response.info.avatar);
                    $('#modal-show-detail-img .pop_new_date').text(response.info.created);
                    if(response.info.is_shop == 1){
                        $('#modal-show-detail-img .post-head-name').addClass('is-shop').removeClass('is-profile');
                    }else{
                        $('#modal-show-detail-img .post-head-name').addClass('is-profile').removeClass('is-shop');
                    }
                }

                if (get_video.length == 1 && !$(_this).hasClass('popup-detail-video') && !$(_this).hasClass('fs-gal')) {
                    key_id = parseInt(key_id)  + 1;
                }

                show_detail_two(key_id);

                if ($(_this).hasClass('popup-detail-video')) {
                    $('#video_popup_0').prop('muted', false);
                    $('#video_popup_0').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                    $('#video_popup_0').prev('.az-volume').addClass("volume_off");
                }

                $('#modal-show-detail-img').modal('show');
                $('#modal-show-detail-img').find('.jR3DCarouselGallery').removeAttr('style');
                // $('#modal-show-detail-img').find('.share-click').attr('data-target','#shareClick'+new_id);
                $('#shareClick'+new_id).find('.congdong').attr('class','item congdong share-img');

                if (info_popup.listImg.length > 1) {
                    if(popup > 0 && $('.detail_url').length > 0){
                        var type_tag = '';
                        $(info_popup.listImg).each(function(at, item){
                            if(item.id == popup){
                                at_pop = at;
                                type_tag = item.type;
                            }
                        });
                        if(at_pop >= 0){
                            key_id = at_pop;
                        }
                    }

                    var width_window = $(window).width();
                    if (ratio_3d != -1 && width_window > 768) {
                        var height = 650/ratio_3d;
                        myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
                            width: 650, // largest allowed width
                            height: height, // largest allowed height
                            slideClass: 'jR3DCarouselCustomSlide',
                            slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
                            animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
                            animationCurve: 'ease',
                            animationDuration: 800,
                            animationInterval: 800,
                            autoplay: false,
                            onSlideShow: shown3d, // callback when Slide show event occurs
                            // navigation: 'circles'
                            controls: true,
                        });
                    } else {
                        myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
                            width: 650, // largest allowed width
                            // height: 400, // largest allowed height
                            slideClass: 'jR3DCarouselCustomSlide',
                            slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
                            animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
                            animationCurve: 'ease',
                            animationDuration: 800,
                            animationInterval: 800,
                            autoplay: false,
                            onSlideShow: shown3d, // callback when Slide show event occurs
                            // navigation: 'circles'
                            controls: true,
                        });
                    }
                    myCarousel.showSlide(key_id);

                    if(type_tag == 'video'){
                        $('#video_popup_0').prop('muted', false);
                        // $('#video_popup_0').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                        // $('#video_popup_0').prev('.az-volume').addClass("volume_off");
                        // $('#video_popup_0').trigger("play");
                    }
                } else {
                    $('#modal-show-detail-img').find('.jR3DCarouselGallery').attr('style', '');
                    showDetail();
                    $('#modal-show-detail-img').find('.tag-number-selected').trigger('click');
                    if(info_popup.listImg[key_id].id > 0){
                        var img_id = info_popup.listImg[key_id].id;
                        var img_slider = info_popup.info.path_img+info_popup.listImg[key_id].image;
                        $('.bg-image-blur').css('background-image','url("'+img_slider+'")');
                        active_like(info_popup.listImg[key_id].id);
                        active_share(info_popup.listImg[key_id].id);
                        $('#modal-show-detail-img').find('.share-click-popup').attr('data-id',info_popup.listImg[key_id].id);
                    }
        
                }
                $('body').find('video').each(function() {
                    $(this).trigger("pause");
                });
                if(key_id == 0 && get_video.length == 1) {
                    $('#modal-show-detail-img').find('#video_popup_0').trigger("play");
                }
            },
            error: function () {}
        });

        $.ajax({
            url: siteUrl + 'comment/loadcomment/'+$(this).attr('data-news-id'),
            type: "POST",
            data: {comment_type : 'image'},
            dataType: "json",
            beforeSend: function () {
                info_popup = {};
            },
            success: function (response) {
                if(response.type == 'success') {
                    $('#comment_block_popup').html(response.data);
                }
            },
            error: function () {}
        });
    });

    function shown3d(slide) {

        if (click_show_tags == 1) {
            slide.find('.tag-number-selected').trigger('click');
        }

        key_id = slide.find('img.image_main_tag').attr('data-id');
        $('#modal-show-detail-img').find('video').each(function() {
            $(this).trigger("pause");
        });
        if (key_id == undefined) {
            key_id = slide.find('video').attr('data-id');
            $('#modal-show-detail-img').find('#video_popup_0').trigger("play");
        }
        key_id = parseInt(key_id);

        if ($('.tag-list-product').hasClass('opening')) 
        {
            $('.tag-list-product .closebox').click();
        }
        showDetail();
        if(info_popup.listImg[key_id].id > 0){
            var img_slider = info_popup.info.path_img+info_popup.listImg[key_id].image;
            active_like(info_popup.listImg[key_id].id);
            active_share(info_popup.listImg[key_id].id);
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-id',info_popup.listImg[key_id].id);
            $('.bg-image-blur').css('background-image','url("'+img_slider+'")');
            $('#modal-show-detail-img .share-click-popup').attr('data-pop', info_popup.listImg[key_id].id);
        }
        var textshr = text_shr;
        var title_desc = $('#modal-show-detail-img .info-product .pop-descrip');
        if(title_desc.find('.tit').length > 0 && title_desc.find('.tit').text() != ''){
            textshr = title_desc.find('.tit').text();
        }else{
            if(title_desc.find('.mb10').length > 0 && title_desc.find('.mb10').text() != ''){
                textshr = title_desc.find('.mb10').text();
            }
        }
        $('#modal-show-detail-img').find('.share-click-popup').attr('data-name',convert_percent_encoding(textshr));
    } 

    function active_like(id_image){
        // $('.load-wrapp').show();
        // $('#modal-show-detail-img').find('.share-click-popup').attr('data-value',$(this).data('value'));
        var list_like = '.modal-show-detail .list-like-js';
        $(list_like).attr('data-id',id_image);
        $(list_like+' .count-like').attr('class','count-like js-count-like-'+id_image);
        if($('#video_popup_0').length > 0 && key_id == 0) {
            var js_show_like = 'list-like-js js-show-like-video';
            var class_show_like = '.modal-show-detail .js-show-like-video';
            $('.modal-show-detail .like').attr('class','like js-like-video js-like-image-'+id_image+' cursor-pointer');
            url = urlFile +'like/active_like_video';
            $('.share-to-pages').attr('data-type','video');

            //add class count like, shr, comment
            $('#modal-show-detail-img .show-number-action.version01').attr('class','show-number-action version01 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
            $('#modal-show-detail-img .show-number-action.version02').attr('class','show-number-action version02 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
        }else{
            var js_show_like = 'list-like-js js-show-like-image';
            var class_show_like = '.modal-show-detail .js-show-like-image';
            $('.modal-show-detail .like').attr('class','like js-like-image js-like-image-'+id_image+' cursor-pointer');
            url = urlFile +'like/active_like_image';
            $('.share-to-pages').attr('data-type','image');

            //add class count like, shr, comment
            $('#modal-show-detail-img .show-number-action.version01').attr('class','show-number-action version01 js-item-id js-item-id-'+id_image+' js-countact-image-'+id_image);
            $('#modal-show-detail-img .show-number-action.version02').attr('class','show-number-action version02 js-item-id js-item-id-'+id_image+' js-countact-image-'+id_image);
        }
        $(list_like).attr('class',js_show_like);
        $(class_show_like).attr('data-id',id_image);
        $('.modal-show-detail .js-like-image-'+id_image).attr('data-id',id_image);
        var _this = $('.modal-show-detail .js-like-image-'+id_image);
        $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id_image: id_image},
          success: function(result){
            if (result.error == false) {
                var img_like = $(_this).find('img');
                if (result.count > 0) {
                  $(img_like).attr('src', $(img_like).attr('data-like-icon'));
                    _this.find('span').text('Bỏ thích');
                } else {
                    _this.find('span').text('Thích');
                    $('.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like.svg');
                    $('.col-lg-7 .like.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
                    $('.sm .like.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
                    // $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
                }
            }
            $('.js-count-like-'+id_image).text(result.total);

            //Neu co luot thich cho click show ds nguoi thich
            if(result.total == 0){
                $(list_like).attr('class','list-like-js');
                
                if($('#video_popup_0').length > 0 && key_id == 0) {
                    $('.bg-gray-blue .js-countact-video-'+id_image).css('display',' none');
                }
                else{
                    $('.bg-gray-blue .js-countact-image-'+id_image).css('display',' none');
                }
                $('.js-show-like-image').css('display',' none');
                $(list_like).css('display',' none');
            }else{
                $(list_like).attr('class',js_show_like);
                if($('#video_popup_0').length > 0 && key_id == 0) {
                    $('.bg-gray-blue .js-countact-video-'+id_image).attr('style','');
                }
                else{
                    $('.bg-gray-blue .js-countact-image-'+id_image).attr('style','');
                }
                $('.js-show-like-image').attr('style','');
                $(list_like).attr('style','');
            }
            // $('.load-wrapp').hide();
            if(popup > 0 && $('.detail_url').length > 0){
                // $(window).load(function(){
                    $('.load-wrapp').hide();
                // });
            }
          }
        });
    }
 
    function active_share(id_image){
        // $('.img-loader').show();
        var url = '';
        var list_share = '.modal-show-detail .js-list-share';
        var class_js_shr = 'js-list-share js-list-share-'+id_image+' cursor-pointer';
        $('.modal-show-detail .js-item-id').attr('data-id',id_image);
        var js_item_id = '.modal-show-detail .js-item-id-' + id_image;

        if($('#video_popup_0').length > 0 && key_id == 0) {
            url = siteUrl + 'share/api_share_videos';
            $(list_share).attr('class',class_js_shr + ' js-list-share-video');
            if($('#modal-show-detail-img .post-head-name').hasClass('is-shop') == true){
                $('#modal-show-detail-img .share-click-popup').attr('data-type_imgvideo', 72);
            }else{
                $('#modal-show-detail-img .share-click-popup').attr('data-type_imgvideo', 74);
            }
            $('#modal-show-detail-img .share-click-popup').attr('data-tag', 'video');
        }else{
            url = siteUrl + 'share/api_share_images';
            $(list_share).attr('class', class_js_shr + ' js-list-share-img');

            if($('#modal-show-detail-img .post-head-name').hasClass('is-shop') == true){
                $('#modal-show-detail-img .share-click-popup').attr('data-type_imgvideo', 71);
            }else{
                $('#modal-show-detail-img .share-click-popup').attr('data-type_imgvideo', 73);
            }
            $('#modal-show-detail-img .share-click-popup').attr('data-tag', 'image');
        }
        
        $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id: id_image},
          success: function(result){
            if(result.data.total_share == 0){
                $(js_item_id + ' .js-list-share').css('display', 'none');
            }else{
                $(js_item_id + ' .js-list-share').removeAttr('style');
                $('.js-countact-image-' + id_image).removeAttr('style');
            }
            $(js_item_id + ' .total-share-img').text(result.data.total_share);
            $('.img-loader').hide();
            $(js_item_id + ' span').removeClass('hidden');
          }
        });
    }

    function convert_percent_encoding(str) {
        str = str.replace(/&curren;/g, '#');
        str = str.replace(/&percnt;/g, '%');
        str = str.replace(/&apos;/g, "'");
        str = str.replace(/&quot;/g, '"').replace(/%22/g, '"');
        str = str.replace(/&amp;/g, "&");
        str = str.replace(/&lsquo;/g, '‘').replace(/\'/g, '‘');
        str = str.replace(/&rsquo;/g, '’');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&frasl;/g, '\\');
        str = str.replace(/&tilde;/g, '˜');
        str = str.replace(/&permil;/g, '‰');
        str = encodeURIComponent(str);
        str = str.replace(/%3Cbr%3E/g, '%0A').replace(/%3Cbr%2F%3E/g, '%0A').replace(/%3Cbr+%2F%3E/g, '%0A');
        return str;
    }

    function showDetail() {
        if (info_popup.listImg[key_id] !== undefined) {
            $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide').removeClass('is-active');
            $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', key_id);
            $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+key_id+'"]').addClass('is-active');

            var data_add = info_popup.listImg[key_id];
            $('#modal-show-detail-img .sanpham_link').hide();
            $('#modal-show-detail-img .lienket_link').hide();
            if (data_add.pro_link != undefined && data_add.pro_link != '' && data_add.type == 'img') {
                $('#modal-show-detail-img .sanpham_link').attr('href', data_add.pro_link);
                $('#modal-show-detail-img .sanpham_link').show();
            }
            //  wait Duc check
            if (data_add.lienket_link != undefined && data_add.lienket_link != '' && data_add.type == 'img') {
                $('#modal-show-detail-img .lienket_link').attr('href', data_add.lienket_link);
                $('#modal-show-detail-img .lienket_link').show();
            }

            $('#modal-show-detail-img .pop-descrip').html('');
            $('#modal-show-detail-img .pop-descrip-title').html('');
            if (data_add.type == 'img') {
                if (data_add.show_full_text === undefined) {
                    var str = '';
                    if (data_add.title != '') {
                        str += '<h3 class="tit">' + data_add.title + '</h3>';
                    }

                    full_text = str;
                    if (data_add.caption != '') {
                        str += '<p class="mb10">' + data_add.caption;
                        full_text += '<p class="mb10">' + data_add.caption + '</p>';
                    }

                    if (str.split(' ').length > 100 ) {
                        $("#modal-show-detail-img .pop-descrip").html(str.split(' ').slice(0,100).join(' ') + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span></p>');
                    } else if (str.split(' ').length < 100 && data_add.icon_caption != '') {
                        $('#modal-show-detail-img .pop-descrip').html(str + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span></p>');
                    } else if (str.split(' ').length < 100 && data_add.icon_caption == '') {
                        $('#modal-show-detail-img .pop-descrip').html(str);
                    }

                    if (str.split(' ').length > 20 ) {
                        $("#modal-show-detail-img .pop-descrip-title").html(str.split(' ').slice(0,20).join(' ') + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>');
                        info_popup.listImg[key_id].show_top_text = str.split(' ').slice(0,20).join(' ') + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>';
                    } else if (str.split(' ').length < 20 && data_add.icon_caption != '') {
                        $('#modal-show-detail-img .pop-descrip-title').html(str + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>');
                        info_popup.listImg[key_id].show_top_text = str + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>';
                    } else if (str.split(' ').length < 20 && data_add.icon_caption == '') {
                        $('#modal-show-detail-img .pop-descrip-title').html(str);
                        info_popup.listImg[key_id].show_top_text = str;
                    }


                    if (data_add.icon_caption != '' && data_add.icon_caption !== undefined) {
                        if (str == '') {
                            $('#modal-show-detail-img .pop-descrip').addClass('have-read-more');
                            $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption);
                            var length_icon = $('#modal-show-detail-img .pop-descrip').find('.clearfix.mb10').length

                            if (length_icon > 1) {
                                $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span>');
                            }
                        }
                        full_text += data_add.icon_caption;
                    }
                } else {
                    $('#modal-show-detail-img .pop-descrip').html(data_add.show_full_text);
                    $('#modal-show-detail-img .pop-descrip-title').html(data_add.show_top_text);
                }
            }

            if (link_href != undefined) {
                if (data_add.type == 'img') {
                    $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
                    $('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href);
                } else {
                    $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
                    $('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href);
                }

            } else {
                $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '');
                $('#modal-show-detail-img .btn-chitiettin-js').attr('href','');
            }

            if (link_avatar != undefined) {
                $('#modal-show-detail-img .pop_shop_avatar').attr('target', '_bank');
                $('#modal-show-detail-img .pop_shop_avatar').attr('href', link_avatar );
            } else {
                $('#modal-show-detail-img .pop_shop_avatar').attr('target', '');
                $('#modal-show-detail-img .pop_shop_avatar').attr('href','');
            }
        }
    }

    $('body').on('click','#modal-show-detail-img .list-image-recent-slider .slick-slide', function(){
        key_id = parseInt($(this).attr('data-slick-index'));
        if (myCarousel != undefined) {
            var get_current = myCarousel.getCurrentSlide();
            var key_current = get_current.find('.slider_check_main').attr('data-id');
            myCarousel.showSlide(key_id);
        }
    });

    $('body').on('click','#modal-show-detail-img .tag-photo-home-2', function(){
        var id_tag = $(this).attr('data-id');
        var key_tag = $(this).attr('data-key');
        $('.tag-photo-home-2').removeClass('is-active');
        $(this).addClass('is-active');
        $('.popup-image-sm').addClass('luot-xem-tin-showing');
        $('.tag-list-product').addClass('opening');
         
        if($('.tag-list-product .tag-list-product-slider').hasClass('slick-initialized')){
            $('body').find('.tag-list-product .tag-list-product-slider').slick('unslick');
        }
        $('.tag-list-product .tag-list-product-slider').removeClass('slick-initialized slick-slider');
        $('.tag-list-product .tag-list-product-slider').html('');
        $('.image-tag-recs-close').show();
        $('.tag-list-product').show();
        $('.luot-xem-tin').removeClass('opened');

        var option_slick = {
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 2.5,
            slidesToScroll: 1,
            variableWidth: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1.5,
                        slidesToScroll: 1
                    }
                }
            ]
        };
        // show loadding

        if (tags_pop[key_tag] !== undefined && tags_pop[key_tag][id_tag] !== undefined) {
            // link
            if(tags_pop[key_tag][id_tag].list_link.length > 0 ) {
                $.each(tags_pop[key_tag][id_tag].list_link, function( key_link, value_link ) {

                    var template_link = $('#js-link-photo-tag').html();
                    template_link = template_link.replace(/{{IMAGE_LINK_TAG}}/g, value_link.image);
                    template_link = template_link.replace(/{{TITLE_LINK_TAG}}/g, value_link.title);
                    template_link = template_link.replace(/{{LINK_TAG}}/g, value_link.save_link);
                    template_link = template_link.replace(/{{DOMAIN_TAG}}/g, value_link.host);
                    $('.tag-list-product .tag-list-product-slider').append(template_link);
                });

                $('body').find('.tag-list-product-slider').slick(option_slick);

            } else {

                $.ajax(
                    {
                        type        : 'post',
                        dataType    : 'json',
                        url         : siteUrl + 'product/getProChoose',
                        data        : {product: tags_pop[key_tag][id_tag].list_pro, type:'pro_tag' },
                        success     : function (result)
                        {
                            if (result.list_product != "") {
                                $('.tag-list-product .tag-list-product-slider').html(result.list_product);
                            }
                        }
                    })
                    .always(function()
                    {
                        $('body').find('.tag-list-product-slider').slick(option_slick);
                        // remove loadding
                    });

            }
        }
    });

    $('body').on('click', '#modal-show-detail-img .prev-img-detail', function(){
        var key_id = $('#modal-show-detail-img').find('.image_main_tag').attr('data-id');
        var key_count = parseInt(key_id) - 1;
        if (key_count != -1) {
            show_detail(key_count);
        }else {
            show_detail(0);
        }

    });

    $('body').on('click', '#modal-show-detail-img .next-img-detail', function(){
        var key_id = $('#modal-show-detail-img').find('.image_main_tag').attr('data-id');
        var key_count = parseInt(key_id) + 1;

        if (info_popup.listImg != undefined) {
            if(key_count >= info_popup.listImg.length) {
                show_detail(info_popup.listImg.length);
            } else {
                show_detail(key_count);
            }
        }
    });

    $('.tag-selecting').click(function(){
        if (window.matchMedia("(max-width: 767px)").matches) {
            $(this).toggleClass('is-active');
            if ($(this).hasClass('is-active')) {
                $('.tag-list-product').css('left', '0');
                $('.tag-list-product').show();
                $('.tag-list-product-slider').get(0).slick.setPosition();
            } else {
                $('.tag-list-product').css('left', '100%');
                $('.tag-list-product').hide();
                $(this).removeClass('is-active');
            }
        } else {
            $(this).toggleClass('is-active');
            if ($(this).hasClass('is-active')) {
                // $('.tag-list-product').css('left', '0');
                $('.tag-list-product').show();
                $('.tag-list-product-slider').get(0).slick.setPosition();
            } else {
                // $('.tag-list-product').css('left', '100%');
                $('.tag-list-product').hide();
                $(this).removeClass('is-active');
            }
        }
    });

    $('.closebox').click(function(){
        // $('.tag-list-product').css('left', '100%');
        $('.tag-list-product').hide();
        $('.tag-selecting').removeClass('is-active');
        $('.popup-image-sm').removeClass('luot-xem-tin-showing');
        $('.tag-list-product').removeClass('opening');

    });

    $('.luot-xem-tin').click(function(){
        $(this).addClass('opened');
        $(this).hide();
        $('.popup-image-sm').addClass('luot-xem-tin-showing');
    });

    $('.dong-luot-xem-tin').click(function(){
        $('.luot-xem-tin').show();
        $('.luot-xem-tin').removeClass('opened');
        $('.popup-image-sm').removeClass('luot-xem-tin-showing')
    });

    $("#modal-show-detail-img").on('hidden.bs.modal', function () {
        $('#modal-show-detail-img').find('video').each(function() {
            $(this).trigger("pause");
        });

        if ($('#video_popup_0').length == 1) {
            var link_video = $('#video_popup_0').get(0).currentTime;
            $('#video_'+ new_id).get(0).currentTime =  link_video;
        }

        $('video').each(function() {
            if(isElementInViewport($(this))) {
                if ($(this).parents('.list-image-recent-slider').length == 0){
                    $(this).trigger("play");
                }
            }else {
                $(this).trigger("pause");
            }
        });

        $('#video_popup_0').prop('muted', true);
        $('#video_popup_0').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
        $('#video_popup_0').prev('.az-volume').removeClass("volume_off");
        $('#modal-show-detail-img .show-number-action.version01').attr('class','show-number-action version01');
        $('#modal-show-detail-img .show-number-action.version02').attr('class','show-number-action version02');

        $('.modal.share-page').each(function () {
            $(this).find('.shr-html').removeClass(' hidden');
            $(this).find('.shr-html-js').addClass(' hidden');
            $(this).find('.congdong').attr('class','item congdong share-content');
        });

        if(popup > 0 && $('.detail_url').length > 0){
            window.location.href = window.location.protocol + '//' + window.location.hostname  + '/share-content-page/'+ new_id + '?redirect=' + window.location.href;
            // $('.load-wrapp').hide();
        }
    });

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    $('body').on('click','.img-popup-ctv',function(){
        var uoctinh = $(this).attr('data-key');
        var phantram = $(this).attr('data-valuea');
        var tien = $(this).attr('data-valueb');
        var src = $('.hrc'+$(this).attr('data-id')).attr('href');
        if(phantram > 0){
            $('.ptramhoahong').removeClass('hidden');
            $('#myModal_ctv .tilehoahong').text(phantram+'%');
        }else{
            $('.ptramhoahong').addClass('hidden');
            $('#myModal_ctv .tilehoahong').text(formatNumber(tien));
        }
        $('#myModal_ctv .uoctinh').text(formatNumber(uoctinh));
        $('#myModal_ctv a.share-link').attr('onclick',"copylink('"+src+"')");
        $('#myModal_ctv').modal('show');
    });

    $('#myModal_ctv').on('hidden.bs.modal', function () {
        if($('#modal-show-detail-img').hasClass('show') == true){
            $('body').addClass(' modal-open');
        }
    });
});

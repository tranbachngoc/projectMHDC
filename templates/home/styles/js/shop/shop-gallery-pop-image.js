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
            }
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

            this.addEventListener("mousedown", touchStart, false);
            this.addEventListener("mousemove", touchMove, false);
            this.addEventListener("mouseup", touchEnd, false);
            this.addEventListener("mouseleave", touchEnd, false);

        });
    };
})(jQuery);

$(document).ready(function() {
    var link_href = '',
        index_3d = 0,
        info_popup = {},
        tags_pop = [],
        full_text = '',
        key_id = 0 ,
        myCarousel ,
        ratio_3d = -1 ,
        news_id = 0 ,
        click_show_tags = 0,
        index_get = 0,
        total_item_get,
        url_get_data = window.location.origin + window.location.pathname,
        path_news_relation = '/relation_images/',
        data_add;

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

    function show_detail_two($items) {
        if ($items !== undefined && $items.length) {
            $.each($($items), function( index, item ) {
                if($('.detail',item).get(0) != undefined){
                    value = $('.detail',item).get(0).dataset;
                    var slider_img = '', template_3d = '';
                    if (value && typeof value.type !== 'undefined' && value.type === 'image') {
                        template_3d = $('#js-list-3d-tag').html();
                        template_3d = template_3d.replace(/{{IMAGE_LINK_TAG}}/g, value.image_url);
                        template_3d = template_3d.replace(/{{KEY_INDEX}}/g, index_3d);
                        template_3d = template_3d.replace(/{{KEY_START}}/g, $(item).data('index'));
                        template_3d = template_3d.replace(/{{KEY_ID}}/g, value.id);
                        // check hình up từ đâu -> có trong tin hay ko
                        template_3d = template_3d.replace(/{{HAS_INNEWS}}/g, value.has_in_news);

                        if (value.tags !== 'undefined' && value.tags && typeof value.tags === 'string') {
                            value.tags = JSON.parse(value.tags);
                        }

                        if (value.tags !== 'undefined' && value.tags.length) {
                            template_3d = template_3d.replace(/{{TOTAL_TAG}}/g, value.tags.length);
                            // var str = showTagHomeTwo(index,JSON.stringify(value.tags));
                            // template_3d = template_3d.replace(/{{LIST_TAG}}/g, str);
                            template_3d = template_3d.replace(/{{HIDE_SHOW}}/g, '');
                        }else {
                            template_3d = template_3d.replace(/{{TOTAL_TAG}}/g, 0);
                            template_3d = template_3d.replace(/{{LIST_TAG}}/g, '');
                            template_3d = template_3d.replace(/{{HIDE_SHOW}}/g, 'hide_0');
                        }

                        slider_img += '<li href="'+value.image_url+'">';
                        slider_img += '     <img src="'+value.image_url+'" alt="'+value.title+'" data-title="'+value.title+'">';
                        slider_img += '     <p class="sub-tit two-lines">'+value.title+'</p>';
                        slider_img += '</li>';
                    }

                    if (value && typeof value.type !== 'undefined' && value.type === 'video') {
                        template_3d = $('#js-list-3d-video').html();
                        template_3d = template_3d.replace(/{{VIDEO_URL}}/g, value.video_url);
                        template_3d = template_3d.replace(/{{POSTER}}/g, value.image_url);
                        template_3d = template_3d.replace(/{{KEY_INDEX}}/g, index_3d);
                        template_3d = template_3d.replace(/{{KEY_START}}/g, $(item).data('index'));
                        template_3d = template_3d.replace(/{{KEY_ID}}/g, value.id);

                        slider_img += '<li href="'+value.image_url+'" data-video-url="'+value.video_url+'">';
                        slider_img += '     <img src="'+value.image_url+'" alt="'+value.title+'" data-title="'+value.title+'">';
                        slider_img += '     <p class="sub-tit two-lines">'+value.title+'</p>';
                        slider_img += '</li>';
                    }

                    if(value){
                        $.each(value, function (data_index, data_item) {
                            template_3d = $(template_3d).attr('data-'+data_index, data_item);
                        });
                    }

                    if($('#modal-show-detail-img .jR3DCarouselGallery .jR3DCarousel').length){
                        $('#modal-show-detail-img .jR3DCarouselGallery .jR3DCarousel').append(template_3d);
                    }else{
                        $('#modal-show-detail-img .jR3DCarouselGallery').append(template_3d);
                    }

                    if($('#modal-show-detail-img .list-image-recent-slider').hasClass('slick-initialized')){
                        $('#modal-show-detail-img .list-image-recent-slider').slick('slickAdd',slider_img);
                    }else{
                        $('#modal-show-detail-img .list-image-recent-slider').append(slider_img);
                    }

                    var get_ratio_3d;
                    if(value && value.image_size && typeof value.image_size.width !== 'undefined'){
                        get_ratio_3d = value.image_size.width/value.image_size.height;
                    }else{
                        get_ratio_3d = -1;
                    }

                    if (ratio_3d === -1 || ratio_3d > get_ratio_3d) {
                        ratio_3d = get_ratio_3d;
                    }
                    index_3d++;
                }
            });
        }
        if(typeof myCarousel !== 'undefined' && myCarousel.length){
            myCarousel.reload3dSlider();
        }
        $('.tag-list-product .tag-list-product-slider').html('');
    }

    //PAGE_VIEW VIEW_TYPE
    $(document).on('click', '.image-page .js_action-play-popup, .video-page .js_action-play-popup', function (event) {
        event.preventDefault();
        total_item_get = 10;
        if(PAGE_VIEW === 'video-page' && VIEW_TYPE === 'grid-view' && !$('.trangcuatoi.tindoanhnghiep').hasClass('display-md')){
            event.stopPropagation();
            return;
        }

        if(PAGE_VIEW === 'image-page' && VIEW_TYPE === 'grid-view'){
            total_item_get = 1;
        }

        var $this = $(this).parent('.detail');
        index_3d = 0;
        click_show_tags = 0;
        ratio_3d = -1;

        $('#modal-show-detail-img .jR3DCarouselGallery').empty();
        $('#modal-show-detail-img .list-image-recent-slider').html('').removeClass('slick-initialized slick-slider');

        if($($this).hasClass('fs-gal')) {
            click_show_tags = 1;
        }
        key_id = $($this).data('id');
        index_get = $($this).data('index');
        data_items = $('.grid .item').slice(index_get, (index_get + total_item_get));
        var new_id = $(this).data('news_id');

        if(data_items && data_items.length){
            show_detail_two(data_items);
            $('#modal-show-detail-img .list-image-recent-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                infinite: false,
                speed: 300,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 1,
                            arrows: false
                        }
                    }
                ]
            });
            $(document).find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', 0);
            $(document).find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+0+'"]').addClass('is-active');

            if ($($this).hasClass('popup-detail-video')) {
                $('.jR3DCarouselGallery video[data-index="0"]').prop('muted', true);
                $('.jR3DCarouselGallery video[data-index="0"]').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                $('.jR3DCarouselGallery video[data-index="0"]').prev('.az-volume').addClass("volume_off");
            }

            // $('.action-left-listaction .share-click').attr('data-target','#shareClick'+$(this).attr('data-news_id'));
            $('.share-modal .share-page').attr('id','shareClick'+$(this).attr('data-news_id'));
            $('.share-modal .share-page').find('.congdong').attr('class','item congdong share-img');
            $('.fixed-modal-ios').addClass(' cancel-fixed');

            var text_shr = $(this).data('title');
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-name',text_shr);//convert_percent_encoding(text_shr));
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-value',$($this).data('content_url'));
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-id',$(this).attr('data-id'));
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-type_imgvideo',$(this).attr('data-type'));
            $('#modal-show-detail-img').modal('show');
            if (data_items.length) {
                var img_slider = $($this).attr('data-image_url');
                $('.bg-image-blur').css('background-image','url("'+img_slider+'")');
                if (ratio_3d != -1) {
                    var height = 650/ratio_3d;
                    myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
                        width: 650, // largest allowed width
                        height: height, // largest allowed height
                        infinite: false,
                        slideClass: 'jR3DCarouselCustomSlide',
                        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
                        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
                        animationCurve: 'ease',
                        animationDuration: 800,
                        animationInterval: 800,
                        autoplay: false,
                        onSlideShow: shown3d, // callback when Slide show event occurs
                        navigation: false,
                        controls: true
                    });
                } else {
                    myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
                        width: 650, // largest allowed width
                        infinite: false,
                        slideClass: 'jR3DCarouselCustomSlide',
                        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
                        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
                        animationCurve: 'ease',
                        animationDuration: 800,
                        animationInterval: 800,
                        navigation: false,
                        autoplay: false,
                        onSlideShow: shown3d, // callback when Slide show event occurs
                        controls: true
                    });
                }
            } else {
                $('#modal-show-detail-img').find('.jR3DCarouselGallery').attr('style', '');
                $('#modal-show-detail-img').find('.tag-number-selected').trigger('click');
            }

            if(PAGE_VIEW === 'image-page' && VIEW_TYPE === 'grid-view'){
                load_more_media();
            }

            // var temp_video = $('#modal-show-detail-img .jR3DCarouselGallery video[data-index="0"]')[0];
            // temp_video.onloadstart = function () {
            //     temp_video.play();
            // };
            showDetail();

            if($(this).attr('data-id') > 0){
                active_like($(this).attr('data-id'));
                active_share($(this).attr('data-id'));
                if(new_id == 0){
                    $('.action-left-listaction .share-click').css('display','none');
                }else{
                    $('#modal-show-detail-img').find('.share-click-popup').attr('data-id',$(this).attr('data-id'));
                    $('.action-left-listaction .share-click').removeAttr('style');
                }
            }
        }

    });

    function shown3d(slide)
    {
        if($(slide).data('index') + 1 === slide['prevObject'].length){
            if(!(PAGE_VIEW === 'image-page' && VIEW_TYPE === 'grid-view')){
                load_more_media($(slide).data('start'));
            }
        }
        if (click_show_tags == 1) {
           slide.find('.tag-number-selected').trigger('click');
        }

        key_id = parseInt(slide.data('id'));

        if($('#modal-show-detail-img video').length){
            $('#modal-show-detail-img video').each(function() {
                $(this).trigger("pause");
            });
        }

        $('.tag-list-product .closebox').click();

        showDetail();
        if(key_id > 0){
            active_like(key_id);
            active_share(key_id);
            var shr_url = slide.data('content_url');
            var shr_name = slide.data('title');
            var new_id = slide.data('news_id');
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-value',shr_url);
            $('#modal-show-detail-img').find('.share-click-popup').attr('data-name',convert_percent_encoding(shr_name));
            if(new_id == 0){
                $('.action-left-listaction .share-click-popup').css('display','none');
            }else{
                var img_slider = slide.data('image_url');
                $('.action-left-listaction .share-click-popup').css('display','block');
                $('#modal-show-detail-img').find('.share-click-popup').attr('data-id',key_id);
                $('#modal-show-detail-img').find('.share-click-popup').attr('data-pop',key_id);
                $('.bg-image-blur').css('background-image','url("'+img_slider+'")');
            }
        }
        var text_shr = $('#detail_content_'+new_id+' .txt a').text();
        var title_desc = $('#modal-show-detail-img .info-product .pop-descrip');
        if(title_desc.find('.tit').length > 0 && title_desc.find('.tit').text() != ''){
            text_shr = title_desc.find('.tit').text();
        }else{
            if(title_desc.find('.mb10').length > 0 && title_desc.find('.mb10').text() != ''){
                text_shr = title_desc.find('.mb10').text();
            }
        }
        $('#modal-show-detail-img').find('.share-click-popup').attr('data-name',convert_percent_encoding(text_shr));
    }

    function active_like(id_image){
        // $('.img-loader').show();
        var list_like = '.modal-show-detail .list-like-js';
        $(list_like).attr('data-id',id_image);
        $(list_like+' .count-like').attr('class','count-like js-count-like-'+id_image);
        if($('.js_action-play-popup video').length > 0) {
            var js_show_like = 'list-like-js js-show-like-video';
            var class_show_like = '.modal-show-detail .js-show-like-video';
            $('.modal-show-detail .like').attr('class','like cursor-pointer js-like-video js-like-image-'+id_image);
            url = urlFile +'like/active_like_video';
            $('#modal-show-detail-img .show-number-action.version01').attr('class','show-number-action version01 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
            $('#modal-show-detail-img .show-number-action.version02').attr('class','show-number-action version02 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
        }else{
            var js_show_like = 'list-like-js js-show-like-image';
            var class_show_like = '.modal-show-detail .js-show-like-image';
            $('.modal-show-detail .like').attr('class','like cursor-pointer js-like-image js-like-image-'+id_image);
            url = urlFile +'like/active_like_image';
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
                  $('.js-like-image-' + id_image+' span').text('Bỏ thích');
                } else {
                    $('.js-like-image-' + id_image+' span').text('Thích');
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
                
                if($('.js_action-play-popup video').length > 0) {
                    $('.bg-gray-blue .js-countact-video-'+id_image).css('display',' none');
                }else{
                    $('.bg-gray-blue .js-countact-image-'+id_image).css('display',' none');
                }
                $(list_like).css('display',' none');
            }else{
                $(list_like).attr('style','');
                $(list_like).attr('class',js_show_like);

                if($('.js_action-play-popup video').length > 0) {
                    $('.bg-gray-blue .js-countact-video-'+id_image).attr('style','');;
                }else{
                    $('.bg-gray-blue .js-countact-image-'+id_image).attr('style','');
                }
            }
            $('.img-loader').hide();
          }
        });
    }
 
    function active_share(id_image){
        var url = class_countact = '';
        var list_share = '.modal-show-detail .js-list-share';
        $('.modal-show-detail .js-item-id').attr('data-id',id_image);
        $('.js-list-share-'+id_image+' .total-share-img').addClass('hidden');
        var js_item_id = '.modal-show-detail .js-item-id-' + id_image;
        
        if($('.js_action-play-popup video').length > 0) {
            url = siteUrl + 'share/api_share_videos';
            $(list_share).attr('class','js-list-share js-list-share-video js-list-share-'+id_image);
            class_countact = '.js-countact-video-' + id_image;
            $('#modal-show-detail-img .share-click-popup').attr('data-tag', 'video');
        }else{
            url = siteUrl + 'share/api_share_images';
            $(list_share).attr('class','js-list-share js-list-share-img js-list-share-'+id_image);
            class_countact = '.js-countact-image-' + id_image;
            $('#modal-show-detail-img .share-click-popup').attr('data-tag', 'image');
        }

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {id: id_image},
            beforeSend: function(){
                // $('.img-loader').show();
            },
            success: function(result){
                $('.img-loader').show();
                if(result.data.total_share == 0){
                    $(js_item_id + ' .js-list-share').css('display', 'none');
                }else{
                    $(js_item_id + ' .js-list-share').removeAttr('style');
                    $(class_countact).removeAttr('style');
                }
                $('.img-loader').hide();
                $(js_item_id + ' span').removeClass('hidden');
                $(js_item_id + ' .total-share-img').text(result.data.total_share);
            },
            complete:function(data){
                // $('.img-loader').hide();
            }
        });
    }

	function convert_percent_encoding(str) {
        str = str.replace(/&curren;/g, '#');
        str = str.replace(/&percnt;/g, '%');
        str = str.replace(/&apos;/g, "'");
        str = str.replace(/&quot;/g, '"');
        str = str.replace(/&amp;/g, "&");
        str = str.replace(/&lsquo;/g, '‘').replace(/\'/g, '‘');
        str = str.replace(/&rsquo;/g, '’');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&frasl;/g, '\\');
        str = str.replace(/&tilde;/g, '˜');
        str = str.replace(/'&permil;'/g, '‰');
        str = encodeURIComponent(str);
        str = str.replace(/'%3Cbr%3E'/g, '%0A').replace(/'%3Cbr%2F%3E'/g, '%0A').replace(/'%3Cbr+%2F%3E'/g, '%0A');
        return str;
    }

    function showDetail() {

        if ($('.3d-item-' + key_id).length) {
            $this = $('.3d-item-' + key_id);
            $('#modal-show-detail-img .title a').attr('href', $this.data('linkpro_shop'));
            $('#modal-show-detail-img .title a').attr('title', $this.data('shopname'));
            $('#modal-show-detail-img .pop_shop_name').text($this.data('shopname'));
            $('#modal-show-detail-img .pop_shop_img').attr('src', $this.data('avatar'));
            $('#modal-show-detail-img .pop_new_date').text($this.data('not_begindate'));
            $('#modal-show-detail-img a.pop_shop_avatar').attr('href', $this.data('linkpro_shop'));
           if($('.3d-item-' + key_id).hasClass('video')){

               var temp_video = document.getElementById('video_popup_' + key_id);
               if(temp_video && temp_video.paused){
                   temp_video.play();
               }

           }
           data_add = $('.3d-item-' + key_id).get(0);
           data_add = data_add.dataset;
           data_index = data_add.index;
           news_id   = data_add.news_id;
           link_href = data_add.content_url;

           $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide').removeClass('is-active');
           $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', (data_index));
           $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+(data_index)+'"]').addClass('is-active');

           $('#modal-show-detail-img .sanpham_link').hide();
           $('#modal-show-detail-img .lienket_link').hide();

           if (typeof data_add.pro_link !== 'undefined' && data_add.pro_link != '' && data_add.type == 'img') {
               $('#modal-show-detail-img .sanpham_link').attr('href', data_add.pro_link);
               $('#modal-show-detail-img .sanpham_link').show();
           }
           //  wait Duc check
           if (typeof data_add.lienket_link !== 'undefined' && data_add.lienket_link != '' && data_add.type == 'img') {
               $('#modal-show-detail-img .lienket_link').attr('href', data_add.lienket_link);
               $('#modal-show-detail-img .lienket_link').show();
           }

           $('#modal-show-detail-img .pop-descrip').html('');
           $('#modal-show-detail-img .pop-descrip-title').html('');
           $('#modal-show-detail-img .pop_new_date').text(data_add.not_begindate);
           if (data_add && data_add.caption !== '') {
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
                       $("#modal-show-detail-img .pop-descrip").html(str.split(' ').slice(0,100).join(' ') + '</p>');
                   } else {
                       $('#modal-show-detail-img .pop-descrip').html(str);
                   }

                   if (str.split(' ').length > 20 ) {
                       $("#modal-show-detail-img .pop-descrip-title").html(str.split(' ').slice(0,20).join(' ') + '</p>');
                       data_add.show_top_text = str.split(' ').slice(0,20).join(' ') + '</p>';
                   } else {
                       $('#modal-show-detail-img .pop-descrip-title').html(str);
                       data_add.show_top_text = str;
                   }

                   if (data_add.icon_caption != '' && data_add.icon_caption !== undefined) {
                       if (str == '') {
                           $('#modal-show-detail-img .pop-descrip').addClass('have-read-more');
                           $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption);
                           var length_icon = $('#modal-show-detail-img .pop-descrip').find('.clearfix.mb10').length;

                           if (length_icon > 1) {
                               $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption);
                           }
                       }
                       full_text += data_add.icon_caption;
                   }
               } else {
                   $('#modal-show-detail-img .pop-descrip').html(data_add.show_full_text);
                   $('#modal-show-detail-img .pop-descrip-title').html(data_add.show_top_text);
               }
           }

           if (link_href) {
               if (data_add.type == 'image') {
                   if(data_add.has_in_news == 'false') {
                        // ẩn xem chi tiết tin nếu hình up từ thiết bị
                        $('#modal-show-detail-img .btn-chitiettin-js').hide();
                   }
                   if(data_add.has_in_news == 'true') {
                        // show xem chi tiết tin nếu hình up trong tin
                        $('#modal-show-detail-img .btn-chitiettin-js').show();
                        $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
                        $('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href +'#block_image_'+data_add.id);
                    }
               } else {
                   $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
                   $('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href +'#video_'+news_id);
               }

           } else {
               $('#modal-show-detail-img .btn-chitiettin-js').attr('target', '');
               $('#modal-show-detail-img .btn-chitiettin-js').attr('href','');
           }

           // old_slide_3d = slide;
       }
    }

    $(document).on('click', '#modal-show-detail-img .read-more', function() {
        var element = $('#modal-show-detail-img .pop-descrip');
        var key_id = $(this).attr('data-id');
        if ($( element ).hasClass( "have-read-more" )) {
            $( element ).removeClass( "have-read-more" );
            $( element ).find('.read-more').remove();
        }
        // if (info_popup.listImg[key_id] !== undefined) {
        //     info_popup.listImg[key_id].show_full_text =  data_add.caption;
        // }
        $('#modal-show-detail-img .pop-descrip').html($('.3d-item-' + key_id).data('caption'));
        // $('#modal-show-detail-img .pop-descrip-title').html(full_text);
    });

    $(document).on('click','#modal-show-detail-img .list-image-recent-slider .slick-slide', function(){
       key_id = parseInt($(this).attr('data-slick-index'));
       if (myCarousel != undefined) {
           var get_current = myCarousel.getCurrentSlide();
           var key_current = get_current.find('.slider_check_main').attr('data-id');
           myCarousel.showSlide(key_id);
       }
    });

    $("#modal-show-detail-img").on('hidden.bs.modal', function () {
        $('#modal-show-detail-img .show-number-action.version01').attr('class','show-number-action version01');
        $('#modal-show-detail-img .show-number-action.version02').attr('class','show-number-action version02');
        $('#modal-show-detail-img').find('video').each(function() {
           $(this).trigger("pause");
        });
        $('.fixed-modal-ios').removeClass(' cancel-fixed');
    });

    $('body').on('click',function(){
        $('.share-page').on('hidden.bs.modal', function () {
            $(this).removeAttr('style');
            if($('#modal-show-detail-img').hasClass('show') == true){
                $('body').addClass('modal-open');
            }
        });
    });
    
    /*$('body').on('click','.js_gallery_pop_image .share-click', function(){
        var id = $(this).attr('data-id');
        var new_id = $(this).attr('data-value');
        var share_url = $('.item-id-'+id+' .detail').data('content_url');
        var share_name = $('.item-id-'+id+' .detail').data('title');
        $('.share-modal .share-page').attr('id','shareClick'+new_id);
        share(id, new_id, share_url, share_name);
    });*/

    $(document).on('click','.az-volume', function() {
        if($(this).hasClass('volume-off') || !$(this).hasClass('volume-on')){
            $(this).removeClass('volume-off').addClass('volume-on').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
            $('#'+$(this).parent('.video').find('video').attr('id')).prop('muted', false);
        } else {
            $(this).removeClass('volume-on').addClass('volume-off').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
            $('#'+$(this).parent('.video').find('video').attr('id')).prop('muted', true);
        }
    });

    var is_busy = false;
    var page = 1;
    var stopped = false;

    function load_more_media(start) {
        if (is_busy == true){
            event.stopPropagation();
            return false;
        }
        is_busy = true;
        page++;

        $.ajax({
            type: 'post',
            dataType: 'text',
            url: url_get_data + (PAGE_VIEW === 'image-page' && VIEW_TYPE === 'grid-view' ? (path_news_relation + news_id + '/' + key_id) : ''),
            data: {
                page: page,
                limit: 3,
                start: (parseInt(start) + 1)
            },
            success: function (results) {
                if(results == '') {
                    stopped = true;
                }
                if(results){
                    show_detail_two($(results));
                    myCarousel.reload3dSlider();
                }
            }
        }).always(function() {
            is_busy = false;
        });
    }
});
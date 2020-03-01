
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
        path_news_relation = '/relation_images/',
        data_add;
    var new_id = 0;

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
                value = item.dataset;
                var slider_img = '', template_3d = '';
                if (value && typeof value.type !== 'undefined' && value.type === 'image') {
                    template_3d = $('#js-list-3d-tag-news').html();
                    template_3d = template_3d.replace(/{{IMAGE_LINK_TAG}}/g, value.image_url);
                    template_3d = template_3d.replace(/{{KEY_INDEX}}/g, index_3d);
                    template_3d = template_3d.replace(/{{KEY_START}}/g, $(item).data('index'));
                    template_3d = template_3d.replace(/{{KEY_ID}}/g, value.id);
                    if (value.tags !== 'undefined' && value.tags && typeof value.tags === 'string') {
                        value.tags = JSON.parse(value.tags);
                    }

                    if (value.tags !== 'undefined' && value.tags.length) {
                        template_3d = template_3d.replace(/{{TOTAL_TAG}}/g, value.tags.length);
                        var str = showTagHomeTwo(index,JSON.stringify(value.tags));
                        template_3d = template_3d.replace(/{{LIST_TAG}}/g, str);
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
                    template_3d = $('#js-list-3d-video-news').html();
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

                if($('#modal-show-detail-video .jR3DCarouselGallery .jR3DCarousel').length){
                    $('#modal-show-detail-video .jR3DCarouselGallery .jR3DCarousel').append(template_3d);
                }else{
                    $('#modal-show-detail-video .jR3DCarouselGallery').append(template_3d);
                }

                if($('#modal-show-detail-video .list-image-recent-slider').hasClass('slick-initialized')){
                    $('#modal-show-detail-video .list-image-recent-slider').slick('slickAdd',slider_img);
                }else{
                    $('#modal-show-detail-video .list-image-recent-slider').append(slider_img);
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
            });
        }
        if(typeof myCarousel !== 'undefined' && myCarousel.length){
            myCarousel.reload3dSlider();
        }
        $('.tag-list-product .tag-list-product-slider').html('');
    }

    //PAGE_VIEW VIEW_TYPE
    $(document).on('click', '.js_content-video .js_news-video-content, .js_content-video .js_btn-pause', function (event) {
        event.preventDefault();
        $('.js_content-video video.video-play').trigger('pause');
        total_item_get = 10;
        var $this = $(this).parent('.detail');
        index_3d = 0;
        click_show_tags = 0;
        ratio_3d = -1;

        new_id = $($this).data('news_id');
        $('#modal-show-detail-video .jR3DCarouselGallery').empty();
        $('#modal-show-detail-video .list-image-recent-slider').html('').removeClass('slick-initialized slick-slider');
        if($($this).hasClass('fs-gal')) {
            click_show_tags = 1;
        }
        // key_id = $($this).data('id');
        index_get = $($this).data('index');
        data_items = $('.js_content-video .item_video').slice(index_get, (index_get + total_item_get));
        if(data_items && data_items.length){
            show_detail_two(data_items);
            new_id = data_items[0].dataset.news_id;

            $('#modal-show-detail-video .list-image-recent-slider').slick({
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
            $(document).find('#modal-show-detail-video .list-image-recent-slider').slick('slickGoTo', 0);
            $(document).find('#modal-show-detail-video .list-image-recent-slider .slick-slide[data-slick-index="0"]').addClass('is-active');

            if ($($this).hasClass('popup-detail-video')) {
                $('.jR3DCarouselGallery video[data-index="0"]').prop('muted', false);
                $('.jR3DCarouselGallery video[data-index="0"]').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                $('.jR3DCarouselGallery video[data-index="0"]').prev('.az-volume').addClass("volume_off");
            }

            $('#modal-show-detail-video').modal('show');

            if (data_items.length) {
                if (ratio_3d != -1) {
                    var height = 650/ratio_3d;
                    myCarousel = $('#modal-show-detail-video').find('.jR3DCarouselGallery').jR3DCarousel({
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
                    myCarousel = $('#modal-show-detail-video').find('.jR3DCarouselGallery').jR3DCarousel({
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
                $('#modal-show-detail-video').find('.jR3DCarouselGallery').attr('style', '');
                $('#modal-show-detail-video').find('.tag-number-selected').trigger('click');
            }
            key_id = data_items[0].dataset.id;
            showDetail();
        }
        $('#modal-show-detail-video').find('.jR3DCarouselGallery video[data-index="0"]').trigger("play");

        var text_shr = $($this).attr('data-title');
        if(text_shr == ''){
            text_shr = $($this).attr('data-caption');
        }
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-name',convert_percent_encoding(text_shr));
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-value',$($this).attr('data-content_url'));
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-id',$($this).data('id'));
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-type_imgvideo',$($this).data('type_shrvideo'));
        if($($this).attr('data-id') > 0){
            active_like($($this).data('id'));
            active_share($($this).data('id'));
        }
        $('.share-page').find('.congdong').attr('class','item congdong share-img');
    });

    function shown3d(slide)
    {
        if($(slide).data('index') + 1 === slide['prevObject'].length){
            load_more_media($(slide).data('start'));
        }
        if (click_show_tags == 1) {
            slide.find('.tag-number-selected').trigger('click');
        }

        key_id = parseInt(slide.data('id'));

        if($('#modal-show-detail-video video').length){
            $('#modal-show-detail-video video').each(function() {
                $(this).trigger("pause");
            });
        }
        $('.tag-list-product .closebox').click();
        showDetail();

        var text_shr = $(slide).attr('data-title');
        if(text_shr == ''){
            text_shr = $(slide).attr('data-caption');
        }
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-name',convert_percent_encoding(text_shr));
        $('#modal-show-detail-video').find('.share-click-popup').attr('data-value',$(slide).attr('data-content_url'));
        if(key_id > 0){
            new_id = slide.data('news_id');
            active_like(key_id);
            active_share(key_id);
            $('#modal-show-detail-video').find('.share-click-popup').attr('data-id',key_id);
            $('#modal-show-detail-video').find('.share-click-popup').attr('data-pop',key_id);// $('.share-item-news .share-page').attr('id','shareClick'+new_id);
            // var shr_url = slide.data('content_url');
            // var shr_name = slide.data('title');
            // if(shr_name == ''){
            //     shr_name = slide.data('des');
            // }
            // share(key_id, new_id, shr_url, shr_name);
        }
    }

    function active_like(id_image){
        var list_like = '.modal-show-detail .list-like-js';
        $(list_like).attr('data-id',id_image);
        $(list_like+' .count-like').attr('class','count-like js-count-like-'+id_image);

        var js_show_like = 'list-like-js js-show-like-video';
        var class_show_like = '.modal-show-detail .js-show-like-video';
        $('.modal-show-detail .like').attr('class','like cursor-pointer js-like-video js-like-image-'+id_image);
        url = urlFile +'like/active_like_video';

        $(list_like).attr('class',js_show_like);
        $(class_show_like).attr('data-id',id_image);
        $('.modal-show-detail .js-like-image-'+id_image).attr('data-id',id_image);
        //add div box count like, comment, share
        $('#modal-show-detail-video .show-number-action.version01').attr('class', 'show-number-action version01 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
        $('#modal-show-detail-video .show-number-action.version02').attr('class', 'show-number-action version02 js-item-id js-item-id-'+id_image+' js-countact-video-'+id_image);
        
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
                    $('.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
                    $('.col-lg-5 .like.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like.svg');
                    $('.sm .like.js-like-image-'+id_image+' img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
                }
            }
            $('.js-count-like-'+id_image).text(result.total);

            //Neu co luot thich cho click show ds nguoi thich
            if(result.total == 0){
                $('.list-like-js').attr('class','list-like-js');
                $('.bg-gray-blue .js-countact-video-'+id_image).css('display',' none');
                $(list_like).css('display',' none');
            }else{
                $('.bg-gray-blue .js-countact-video-'+id_image).attr('style','');
                $('.list-like-js').attr('class',js_show_like);
                $(list_like).attr('style','');
            }
          }
        });
    }


    function active_share(id_image){
        var list_share = '.modal-show-detail .js-list-share';
        $('.modal-show-detail .js-item-id').attr('data-id',id_image);
        $(list_share).attr('class','js-list-share js-list-share-video cursor-pointer js-list-share-'+id_image);
        $('.modal-show-detail .js-list-share-'+id_image).attr('data-id',id_image);
        $('#modal-show-detail-video .share-click-popup').attr('data-tag', 'video');
        var js_item_id = '.modal-show-detail .js-item-id-' + id_image;
        
        $.ajax({
          type: 'POST',
          url: siteUrl + 'share/api_share_videos',
          dataType: 'json',
          data: {id: id_image},
          success: function(result){
                if(result.data.total_share == 0){
                    $(js_item_id + ' .js-list-share').css('display', 'none');
                }else{
                    $(js_item_id + ' .js-list-share').removeAttr('style');
                    $('.js-countact-video-' + id_image).removeAttr('style');
                }
                $(js_item_id + ' .total-share-img').text(result.data.total_share);
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

    function share(id_, new_id, shr_url, shr_name){
        $('#modal-show-detail-video').find('.share-click.popup').attr('data-target','#shareClick'+new_id);
        $('.share-click.popup').click(function () {
            
            $('#shareClick'+new_id).addClass('popup'+new_id);
            $('.popup'+new_id).find('.shr-html').addClass(' hidden');
            $('.popup'+new_id).find('.shr-html-js').removeClass(' hidden');
        });
        $('#shareClick'+new_id).on('show.bs.modal', function () {
            $(this).css('z-index',1051);
            var template_share = $('#js-share').html();
            // var shr_url = $(this).find('.shr-data').attr('data-value');
            // var shr_name = $(this).find('.shr-data').attr('data-name');
            var af_id = shr_url.split('?');
            var id_img = id_imgtwitter = '?img='+id_;

            if(af_id.length > 1){
                id_img =  '%26img='+id_;
            }

            template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
            template_share = template_share.replace(/{{SHARE_URL}}/g, shr_url + id_img + '%23image_'+id_);
            $(this).find('.shr-html-js').html(template_share);
        });
        $('#shareClick'+new_id).on('hidden.bs.modal', function () {
            $(this).find('.shr-html').removeClass(' hidden');
            $(this).find('.shr-html-js').addClass(' hidden');
        });
    }

    function showDetail() {
        $('#modal-show-detail-video').find('video').each(function() {
            $(this).trigger("pause");
        });
        if ($('.3d-item-' + key_id).length) {
            if($('.3d-item-' + key_id).hasClass('video')){
                $('video#video_popup_' + key_id).trigger('play');
                // old_slide_3d để pause video
            }
            data_add = $('.3d-item-' + key_id).get(0);
            data_add = data_add.dataset;
            data_index = data_add.index;
            news_id   = data_add.news_id;
            link_href = data_add.content_url;
            $('body').find('#modal-show-detail-video .list-image-recent-slider .slick-slide').removeClass('is-active');
            $('body').find('#modal-show-detail-video .list-image-recent-slider').slick('slickGoTo', (data_index));
            $('body').find('#modal-show-detail-video .list-image-recent-slider .slick-slide[data-slick-index="'+(data_index)+'"]').addClass('is-active');

            $('#modal-show-detail-video .sanpham_link').hide();
            $('#modal-show-detail-video .lienket_link').hide();

            if (typeof data_add.pro_link !== 'undefined' && data_add.pro_link != '' && data_add.type == 'img') {
                $('#modal-show-detail-video .sanpham_link').attr('href', data_add.pro_link);
                $('#modal-show-detail-video .sanpham_link').show();
            }
            //  wait Duc check
            if (typeof data_add.lienket_link !== 'undefined' && data_add.lienket_link != '' && data_add.type == 'img') {
                $('#modal-show-detail-video .lienket_link').attr('href', data_add.lienket_link);
                $('#modal-show-detail-video .lienket_link').show();
            }

            $('#modal-show-detail-video .pop-descrip').html('');
            $('#modal-show-detail-video .pop-descrip-title').html('');
            $('#modal-show-detail-video .pop_new_date').text(data_add.not_begindate);
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
                        $("#modal-show-detail-video .pop-descrip").html(str.split(' ').slice(0,100).join(' ') + '</p>');
                    } else {
                        $('#modal-show-detail-video .pop-descrip').html(str);
                    }

                    if (str.split(' ').length > 20 ) {
                        $("#modal-show-detail-video .pop-descrip-title").html(str.split(' ').slice(0,20).join(' ') + '</p>');
                        data_add.show_top_text = str.split(' ').slice(0,20).join(' ') + '</p>';
                    } else {
                        $('#modal-show-detail-video .pop-descrip-title').html(str);
                        data_add.show_top_text = str;
                    }

                    if (data_add.icon_caption != '' && data_add.icon_caption !== undefined) {
                        if (str == '') {
                            $('#modal-show-detail-video .pop-descrip').addClass('have-read-more');
                            $('#modal-show-detail-video .pop-descrip').html(data_add.icon_caption);
                            var length_icon = $('#modal-show-detail-video .pop-descrip').find('.clearfix.mb10').length;

                            if (length_icon > 1) {
                                $('#modal-show-detail-video .pop-descrip').html(data_add.icon_caption);
                            }
                        }
                        full_text += data_add.icon_caption;
                    }
                } else {
                    $('#modal-show-detail-video .pop-descrip').html(data_add.show_full_text);
                    $('#modal-show-detail-video .pop-descrip-title').html(data_add.show_top_text);
                }
            }

            if (link_href != undefined) {
                if (data_add.type == 'image') {
                    $('#modal-show-detail-video .btn-chitiettin-js').attr('target', '_bank');
                    $('#modal-show-detail-video .btn-chitiettin-js').attr('href', link_href +'#block_image_'+data_add.id);
                } else {
                    $('#modal-show-detail-video .btn-chitiettin-js').attr('target', '_bank');
                    $('#modal-show-detail-video .btn-chitiettin-js').attr('href', link_href +'#video_'+news_id);
                }

            } else {
                $('#modal-show-detail-video .btn-chitiettin-js').attr('target', '');
                $('#modal-show-detail-video .btn-chitiettin-js').attr('href','');
            }

            // old_slide_3d = slide;
        }
    }

    $(document).on('click', '#modal-show-detail-video .read-more', function() {
        var element = $('#modal-show-detail-video .pop-descrip');
        var key_id = $(this).attr('data-id');
        if ($( element ).hasClass( "have-read-more" )) {
            $( element ).removeClass( "have-read-more" );
            $( element ).find('.read-more').remove();
        }
        // if (info_popup.listImg[key_id] !== undefined) {
        //     info_popup.listImg[key_id].show_full_text =  data_add.caption;
        // }
        $('#modal-show-detail-video .pop-descrip').html($('.3d-item-' + key_id).data('caption'));
        // $('#modal-show-detail-video .pop-descrip-title').html(full_text);
    });

    $(document).on('click','#modal-show-detail-video .list-image-recent-slider .slick-slide', function(){
        key_id = parseInt($(this).attr('data-slick-index'));
        if (myCarousel != undefined) {
            var get_current = myCarousel.getCurrentSlide();
            var key_current = get_current.find('.slider_check_main').attr('data-id');
            myCarousel.showSlide(key_id);
        }
    });

    $("#modal-show-detail-video").on('hidden.bs.modal', function () {
        $('#modal-show-detail-video').find('video').each(function() {
            $(this).trigger("pause");
        });
        $('#modal-show-detail-video .jR3DCarouselGallery').empty();
        $('.modal.share-page').each(function () {
            $(this).find('.shr-html').removeClass(' hidden');
            $(this).find('.shr-html-js').addClass(' hidden');
            $(this).find('.congdong').attr('class','item congdong share-content');
        });
    });

    $('#modal-show-detail-video .show-number-action.version01').attr('class','show-number-action version01');
    $('#modal-show-detail-video .show-number-action.version02').attr('class','show-number-action version02');

    $('body').on('click',function(){
        $('.share-page').on('hidden.bs.modal', function () {
            $(this).removeAttr('style');
            if($('#modal-show-detail-video').hasClass('show') == true){
                $('body').addClass('modal-open');
            }
        });
        $('#luotthich').on('hidden.bs.modal', function () {
            if($('#modal-show-detail-video').hasClass('show') == true){
                $('body').addClass('modal-open');
            }
        });
    });

    $(document).on('click','.az-volume', function() {
        var target_video = $(this).data('target_video');
        if($(this).hasClass('volume-off') || !$(this).hasClass('volume-on')){
            $(this).removeClass('volume-off').addClass('volume-on').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
            if(target_video){
                $(target_video).prop('muted', false);
            }else{
                $('#'+$(this).parent('.video').find('video').attr('id')).prop('muted', false);
            }
        } else {
            $(this).removeClass('volume-on').addClass('volume-off').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
            if(target_video){
                $(target_video).prop('muted', true);
            }else{
                $('#'+$(this).parent('.video').find('video').attr('id')).prop('muted', true);
            }
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
            url: url_get_data_videos_more + 'news',
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
var formData = new FormData();
$( document ).ready(function() {

    //shr ngoài

    function share_social(_this){
        var shr_url = $(_this).attr('data-value');
        var shr_name = $(_this).attr('data-name');
        var template_share = $('#js-share').html();
        var _thispopup = '.temp-share #shareClick'; 
        
        $(_thispopup).find('.shr-html').addClass(' hidden');
        $(_thispopup).find('.shr-html-js').removeClass(' hidden');
        
        template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
        template_share = template_share.replace(/{{SHARE_URL}}/g, shr_url);
        template_share = template_share.replace(/{{SHARE_COPPY_URL}}/g, shr_url);
        $(_thispopup+' .shr-html-js').html(template_share);
        $(_thispopup).css('z-index',1051);
        $(_thispopup).modal('show');
        // $('.share-page .congdong').attr('class','item congdong share-customlink');
        $.getScript('https://sp.zalo.me/plugins/sdk.js');
        $.getScript('https://zjs.zdn.vn/zalo/sdk.js');
        $.getScript('https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0');

        $('.share-fb').attr('data-ref', shr_url);
        $('.share-fb').attr('data-type', $(_this).attr('data-type'));
        $('.share-fb').attr('data-id', $(_this).attr('data-item_id'));
        $('.share-fb').attr('data-tag', $(_this).attr('data-tag'));
        if($(_this).attr('data-type_imgvideo') > 0){
            $('.share-fb').attr('data-type', $(_this).attr('data-type_imgvideo'))
        }
    }

    function share_social_image(_this){
        var shr_id = $(_this).attr('data-id');
        var shr_url = $(_this).attr('data-value');
        var shr_name = $(_this).attr('data-name');
        var template_share = $('#js-share').html();
        var _thispopup = '.temp-share #shareClick';
        var af_id = shr_url.split('?');
        var id_img = id_imgtwitter = id_img_coppy = '?img='+shr_id;

        if(af_id.length > 1){
            id_img =  '%26img='+shr_id;
            id_img_coppy =  '&img='+shr_id;
        }
        share_url = shr_url + id_img  + '%23image_'+shr_id;
        share_coppy_url = shr_url + id_img_coppy  + '#image_'+shr_id;
        
        $(_thispopup).find('.shr-html').addClass(' hidden');
        $(_thispopup).find('.shr-html-js').removeClass(' hidden');
        
        template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
        template_share = template_share.replace(/{{SHARE_URL}}/g, share_url);
        template_share = template_share.replace(/{{SHARE_COPPY_URL}}/g, share_coppy_url);
        $(_thispopup+' .shr-html-js').html(template_share);
        $(_thispopup).css('z-index',1051);
        $(_thispopup).modal('show');

        $('.share-page .congdong').attr('class','item congdong share-customlink');
        $.getScript('https://sp.zalo.me/plugins/sdk.js');

        $('.share-fb').attr('data-ref', share_url);
        $('.share-fb').attr('data-type', $(_this).attr('data-type'));
        $('.share-fb').attr('data-id', $(_this).attr('data-id'));
        $('.share-fb').attr('data-tag', $(_this).attr('data-tag'));
        if($(_this).attr('data-item_id') > 0){
            $('.share-fb').attr('data-id', $(_this).attr('data-item_id'))
        }
        if($(_this).attr('data-type_imgvideo') > 0){
            $('.share-fb').attr('data-type', $(_this).attr('data-type_imgvideo'))
        }
    }

    function share_social_popup(_this){
        var shr_id = $(_this).attr('data-id');
        var shr_url = $(_this).attr('data-value');
        var shr_name = $(_this).attr('data-name');
        var template_share = $('#js-share').html();
        var _thispopup = '.temp-share #shareClick';
        var af_id = shr_url.split('?');
        var id_img = id_imgtwitter = id_img_coppy = '?pop='+shr_id;
        var type = '';
        if(af_id.length > 1){
            id_img =  '%26pop='+shr_id;
            id_img_coppy =  '&pop='+shr_id;
        }
        share_url = shr_url + id_img  + '%23image_'+shr_id;
        share_coppy_url = shr_url + id_img_coppy  + '#image_'+shr_id;

        $(_thispopup).find('.shr-html').addClass(' hidden');
        $(_thispopup).find('.shr-html-js').removeClass(' hidden');
        
        template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
        template_share = template_share.replace(/{{SHARE_URL}}/g, share_url);
        template_share = template_share.replace(/{{SHARE_COPPY_URL}}/g, share_coppy_url);
        $(_thispopup+' .shr-html-js').html(template_share);
        $(_thispopup).css('z-index',1051);
        $(_thispopup).modal('show');

        $('.share-page .congdong').attr('class','item congdong share-customlink');
        $.getScript('https://sp.zalo.me/plugins/sdk.js');

        $('.share-fb').attr('data-ref', share_url);
        $('.share-fb').attr('data-type', $(_this).attr('data-type_imgvideo'));
        $('.share-fb').attr('data-id', $(_this).attr('data-id'));
        $('.share-fb').attr('data-tag', $(_this).attr('data-tag'));
    }

    //Share noi bo
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
          var filesAmount = input.files.length;
          for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();
              reader.onload = function(event) {
                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
              }
              reader.readAsDataURL(input.files[i]);
          }
        }
    };

    // Tạo id của hình
    function GenerateRandomString(len){
        var d = new Date();
        var text = d.getTime();

        return text;
    }

    // Reader file
    function renderFileInfo(file,type) {
        var fileReader = new FileReader();
        fileReader.onload = function(e) {
            var id = GenerateRandomString(10);
            var data_image = {
                'image_id'      : id,
                'image_url'     : e.target.result
            };

            if(file.type == 'video/mp4') {
                var video = new VideoHandler(file);
                var html = '';
                html +='<div class="insert-img" data-id="'+id+'">';
                        html +='<div class="insert-video">';
                        html +='<img src="'+website_url+'templates/home/styles/images/default/error_image_400x400.jpg" alt="">';
                        html +='<span class="play-video"><img src="'+website_url+'templates/home/styles/images/svg/play_video.svg" alt=""></span>';
                        html +='</div>';
                        html +='<span class="close" data-id="'+id+'"><img src="/templates/home/styles/images/svg/close_white.svg" alt=""></span>';
                html +='</div>';
                $('.shareModal-addnewcomment-gallery').append(html);
                $('.shareModal-addnewcomment-gallery').css('display','block');
                $('.shareModal-addnewcomment-gallery .insert-img').css({'margin-right':'3%', 'display':'inline-block'});
                
            }else {
                formData.set('images', file, file.name);
                $.ajax({
                    url: website_url+'addimage',
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'POST',
                    dataType : 'json',
                    success:function(data){
                        if(data.type == 'success') {
                            var images = {
                                'image_id'      : id,
                                'image_name'    : data.image_name,
                                'image_url'     : data.image_url,
                                'image_crop'    : '',
                                'path'          : data.path,
                                'text_list'     : {}
                            };
                            var html = '';
                            html +='<div class="insert-img" data-id="'+id+'">';
                                    html +='<img src="'+data.image_url+'" alt="">';
                                    html +='<span class="close" data-id="'+id+'"><img src="/templates/home/styles/images/svg/close_white.svg" alt=""></span>';
                            html +='</div>';
                            $('.shareModal-addnewcomment-gallery').append(html);
                            $('.shareModal-addnewcomment-gallery').css('display','block');
                            $('.shareModal-addnewcomment-gallery .insert-img').css({'margin-right':'3%', 'display':'inline-block'});
                            formData.append('images['+id+']', JSON.stringify(images));
                            formData.set('have_image', 1);
                        }
                        
                    }
                });
            }
            
        }
        fileReader.readAsDataURL(file);
    }

    function share_content(new_id,img_id,type){
        var template_html_share = $('.shareModal .modal-body-js').html();
        var html_share = $('#js-share-content').html();

        $.ajax({
            url: siteUrl + 'share/ajax_showtin',
            type: "POST",
            data: {new_id: new_id},
            dataType: "json",
            beforeSend: function () {
                info_popup = {};
            },
            success: function (response) {
                var template_img = '';
                var template_video = '';
                info_popup = response;
                if (info_popup.listImg !== undefined) {
                    $.each(info_popup.listImg, function( index, value ) {
                        if (value.type == 'img') {
                            var slider_img = '<li href="'+info_popup.info.path_img + '1x1_'+value.image+'">';
                            slider_img += '<img src="'+info_popup.info.path_img + '1x1_'+value.image+'" alt="" data-title="'+value.title+'">';
                            // slider_img += '<p class="sub-tit two-lines">'+value.title+'</p>';
                            slider_img += '</li>';
                        }
                        template_img += slider_img;
                    });
                }

                if (info_popup.detail.not_video_url1 > 0 || type == 'video') {
                    var slider_video = '<video playsinline="" muted="1" autoplay="false" preload="metadata" controls="controls">';
                    slider_video += '<source src="'+info_popup.detail.video_path+'" type="video/mp4">';
                    slider_video += '</video>';
                    template_video += slider_video;
                } 
                    
                html_share = html_share.replace(/{{SHARE_NEWS_VIDEO}}/g, template_video);
                html_share = html_share.replace(/{{SHARE_NEWS_SLIDER}}/g, template_img);
            
                html_share = html_share.replace(/{{SHARE_NEWS_LINK}}/g, info_popup.detail.link_news);
                //user share
                html_share = html_share.replace(/{{SHARE_USER_LOGO}}/g, info_popup.user.use_id+'/'+info_popup.user.avatar);
                html_share = html_share.replace(/{{SHARE_USER_NAME}}/g, info_popup.user.use_fullname);

                //user post
                html_share = html_share.replace(/{{SHARE_SHOP_LOGO}}/g, info_popup.info.avatar);
                html_share = html_share.replace(/{{SHARE_SHOP_LINK}}/g, info_popup.info.link);
                html_share = html_share.replace(/{{SHARE_SHOP_NAME}}/g, info_popup.info.name);
                html_share = html_share.replace(/{{SHARE_DATE_NEWS}}/g, info_popup.info.created);
                html_share = html_share.replace(/{{SHARE_VIEW_NEWS}}/g, info_popup.detail.not_view);

                //Friend
                if(info_popup.info.type == 'shop'){
                    html_share = html_share.replace(/{{SHARE_USER_ID}}/g, info_popup.info.sho_id);
                }else{
                    html_share = html_share.replace(/{{SHARE_USER_ID}}/g, info_popup.user.use_id);
                }
                html_share = html_share.replace(/{{SHARE_CLASS_FRIEND}}/g, info_popup.friend.class_fr);
                html_share = html_share.replace(/{{SHARE_CSS_FRIEND}}/g, info_popup.friend.css_fr);
                html_share = html_share.replace(/{{SHARE_FRIEND_STATUS}}/g, info_popup.friend.status_fr);
                
                var title_new = '<strong>'+info_popup.detail.not_title+'</strong>';
                var desc = '';
                if(info_popup.detail.not_description != ''){
                    desc = info_popup.detail.not_description;
                }else{
                    desc = info_popup.detail.not_detail;
                }
                title_new += '<p class="sub-tit two-lines">'+desc+'</p>';
                html_share = html_share.replace(/{{SHARE_NEWS_CONTENT}}/g, title_new);
                
                $('.shareModal').modal('show');

                if($('.shareModal-addnewcomment-gallery').children().length == 0){
                    $('.shareModal .modal-body-js').html(html_share);
                }
                if (info_popup.listImg.length > 0) {

                    $('body').find('.shareModal .slider-img-share').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        focusOnSelect: true,
                        infinite: false,
                        arrows: false,
                        speed: 300,
                        responsive: [
                        {
                          breakpoint: 768,
                          settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                          }
                        }]
                    });

                    $('.button-showmore').removeClass(' hidden');

                    $('.slider-img-share').find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
                }else{
                    $('.shareModal-uncollapse').css('height','auto');
                }

                $('#gallery-photo-add').on('change', function() {
                    var type = $(this).attr('data-type');
                    var files = event.target.files;
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        renderFileInfo(file,type);
                    }
                });

                $('body').on('click', '.close', function () {
                    var item = $(this).closest(".insert-img");
                    $(item).closest(".insert-img").remove();
                });
            },
            error: function () {
                alert('Lỗi');
            }
        });
    }

    function share_product(pro_id){
        var html_share = $('#js-share-product').html();

        $.ajax({
            url: siteUrl + 'share/ajax_showproduct',
            type: "POST",
            data: {pro_id: pro_id},
            dataType: "json",
            beforeSend: function () {
                info_popup = {};
            },
            success: function (response) {
                var template_img = '';
                var template_video = '';
                info_popup = response;
                
                //user share
                html_share = html_share.replace(/{{SHARE_USER_LOGO}}/g, info_popup.user.use_id+'/'+info_popup.user.avatar);
                html_share = html_share.replace(/{{SHARE_USER_NAME}}/g, info_popup.user.use_fullname);

                html_share = html_share.replace(/{{SHARE_SHOP_LOGO}}/g, info_popup.info.avatar);
                html_share = html_share.replace(/{{SHARE_SHOP_LINK}}/g, info_popup.info.link);
                html_share = html_share.replace(/{{SHARE_SHOP_NAME}}/g, info_popup.info.name);
                //Friend
                html_share = html_share.replace(/{{SHARE_USER_ID}}/g, info_popup.info.sho_id);
                html_share = html_share.replace(/{{SHARE_CLASS_FRIEND}}/g, info_popup.friend.class_fr);
                html_share = html_share.replace(/{{SHARE_CSS_FRIEND}}/g, info_popup.friend.css_fr);
                html_share = html_share.replace(/{{SHARE_FRIEND_STATUS}}/g, info_popup.friend.status_fr);
                
                //user post
                html_share = html_share.replace(/{{SHARE_PRODUCT_IMG}}/g, info_popup.product.image);
                html_share = html_share.replace(/{{SHARE_PRODUCT_NAME}}/g, info_popup.product.pro_name);
                html_share = html_share.replace(/{{SHARE_PRODUCT_CREATE}}/g, info_popup.product.created_date);
                html_share = html_share.replace(/{{SHARE_PRODUCT_VIEWS}}/g, info_popup.product.pro_view);
                
                var htmlflash_sale = '';
                var htmldate_sale = '';
                var htmlprice = '';
                var price_sale = 0;
                var time = Math.floor($.now()/1000);
                if(info_popup.product.off_amount > 0 && info_popup.product.end_date_sale >= time){
                    htmldate_sale += '<span class="time-flash-sale" id="flash-sale_'+info_popup.product.pro_id+'">';
                    htmldate_sale += cd_time(info_popup.product.end_date_sale*1000,info_popup.product.pro_id);
                    htmldate_sale += '</span>';

                    htmlflash_sale += '<span class="icon-flas">';
                    htmlflash_sale += '<img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt="">';
                    htmlflash_sale += '</span>';

                    price_sale = info_popup.product.pro_cost - info_popup.product.off_amount;
                    htmlprice += '<span class="price-main">'+formatNumber(info_popup.product.pro_cost)+'</span>';
                    htmlprice += ' <span class="price-sale">'+formatNumber(price_sale)+'</span>';
                }else{
                    htmlprice += '<span class="price-sale">'+formatNumber(info_popup.product.pro_cost)+'</span>';
                }
                html_share = html_share.replace(/{{SHARE_PRODUCT_FLASHSALE}}/g, htmlflash_sale);
                html_share = html_share.replace(/{{SHARE_PRODUCT_PRICE}}/g, htmlprice);
                html_share = html_share.replace(/{{SHARE_PRODUCT_DATESALE}}/g, htmldate_sale);
                
                if($('.shareModal-addnewcomment-gallery').children().length == 0){
                    $('.shareModal .modal-body-js').html(html_share);
                }
                
                $('.shareModal').modal('show');

                $('#gallery-photo-add').on('change', function() {
                    var type = $(this).attr('data-type');
                    var files = event.target.files;
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        renderFileInfo(file,type);
                    }
                });

                $('body').on('click', '.close', function () {
                    var item = $(this).closest(".insert-img");
                    $(item).closest(".insert-img").remove();
                });
            },
            error: function () {
                alert('Lỗi');
            }
        });
    }

    $('body').on('click','.js-customlink', function(){
        share_social(this);
    });

    $('body').on('click','.share-click.shr-content', function(){//.avata-part 
        $('.share-to-pages').attr('data-id',$('.js-like-content').attr('data-id'));
        $('#shareClick .congdong').attr('class','item congdong share-content');
    });

    $('body').on('click','.congdong.share-content',function(){
        var new_id = $('#shareClick').attr('data-item_id');
        var img_id = $(this).parents('.share-to-pages').attr('data-key');
        var type = $(this).parents('.share-to-pages').attr('data-type');
        share_content(new_id,img_id,type);
    });

    $('body').on('click','.share-click.shr-product', function(){//.avata-part 
        $('.share-to-pages').attr('data-id',$('.js-like-product').attr('data-id'));
        $('#shareClick .congdong').attr('class','item congdong share-product');
    });

    $('body').on('click','.congdong.share-product',function(){
        var pro_id = $(this).parents('.share-to-pages').attr('data-id');
        share_product(pro_id);
    });

    $('body').on('click','.shr-img',function(){
        $('.share-page .congdong').attr('class','item congdong share-img');
    });

    $('body').on('click','.shr-bosuutap',function(){
        $('.share-page .congdong').attr('class','item congdong share-bosuutap');
    });

    $('body').on('click','.share-click', function(){//.avata-part
        share_social(this);
        $('#shareClick').attr('data-type',$(this).data('type'));
        $('#shareClick').attr('data-item_id',$(this).data('item_id'));
        var type = $(this).attr('data-type');
        var item_id = $(this).data('item_id');
        var permission = $(this).data('permission');
        if(permission == 1){
            $.ajax({
                url: "/share/get_avatarShare",
                type: "POST",
                data: {type: type, item_id: item_id},
                dataType: 'json',
                success: function (response) {
                    var temp_avtshare = '';
                    if(response.count > 0){
                        temp_avtshare += '<div class="update_avtShare">';
                            temp_avtshare += '<form class="text-center">';
                                temp_avtshare += '<label class="change-img">';
                                    temp_avtshare += '<span class="btn avatar-share" id="">';
                                        temp_avtshare += '<b class="text-red">Đổi ảnh xem trước</b>';
                                        temp_avtshare += '<input type="file" class="form-control" name="avatarShare" accept="image/*" id="img-avatarShare" style="display:none">';
                                    temp_avtshare += '</span>';
                                temp_avtshare += '</label>';
                                temp_avtshare += '<label class="btn delete_avtShare"><b>Xóa ảnh</b></label>';
                                temp_avtshare += '<img class="img_avtShare" src="'+response.data[0].image+'">';
                                temp_avtshare += '<div id="crop-avatarShare"></div>';
                                temp_avtshare += '<input type="hidden" name="id" class="id" value="'+response.data[0].id+'">';
                                temp_avtshare += '<input type="hidden" name="item_id" class="item_id" value="'+response.data[0].item_id+'">';
                            temp_avtshare += '</form>';
                        temp_avtshare += '</div>';
                        $('#shareClick .upavatar-share').html(temp_avtshare);
                    }else{
                        temp_avtshare += '<div class="add_avtShare">';
                            temp_avtshare += '<form class="text-center">';
                                temp_avtshare += '<label class="change-img">';
                                    temp_avtshare += '<span class="btn avatar-share" id="">';
                                        temp_avtshare += '<b class="text-red">Đổi ảnh xem trước</b>';
                                        temp_avtshare += '<input type="file" class="form-control" name="avatarShare" accept="image/*" id="img-avatarShare" style="display:none">';
                                    temp_avtshare += '</span>';
                                temp_avtshare += '</label>';
                                temp_avtshare += '<div id="crop-avatarShare"></div>';
                                temp_avtshare += '<input type="hidden" name="type" class="type" value="'+type+'">';
                                temp_avtshare += '<input type="hidden" name="item_id" class="item_id" value="'+item_id+'">';
                            temp_avtshare += '</form>';
                        temp_avtshare += '</div>';
                        $('#shareClick .upavatar-share').html(temp_avtshare);
                    }
                },
                error: function () {
                    //alert("Error conection!!!");
                }
            });
        }
        $('#shareClick').attr('data-url_page',$(this).data('url_page'));
    });

    $('body').on('click','.share-click-image', function(){//.avata-part 
        share_social_image(this);
    });

    $('body').on('click','.share-click-popup', function(){//.avata-part 
        share_social_popup(this);
    });

    $('body').on('click','.share-fb', function(){//.avata-part
        var domain_site = $('.domain_site').data('site');
        var type = $(this).data('type');
        var id = $(this).data('id');
        var tag = $(this).data('tag');
        var api_get_linkshr = '';

        var href = $(this).data('ref');
        var check = href.includes(domain_site);

        if(check == true){
            FB.ui(
            {
                display: 'popup',
                method: 'share',
                href: href,
            },
            // callback
            function(response) {
                if (response && !response.error_message) {
                  $.ajax({
                    url: siteUrl + 'share/api_push_share',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id, type: type, source: 'Facebook', tag: tag},
                    success: function(result){
                        if(result.error == false && result.data.total_share > 0){
                            $('.js-item-id-'+id).removeAttr('style');
                            $('.js-item-id-'+id+' .js-list-share').removeAttr('style');
                            $('.js-item-id-'+id+' .total-share-img').text(result.data.data.total_share);
                        }
                    }
                  });
                }
            });
        }else{
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + href,'facebook-share-dialog','width=500,height=500');
        }
    });

    $('body').on('click','.button-showmore .text', function(){
        var parent = $(this).closest('.shareModal-uncollapse');
        parent.toggleClass('shareModal-collapse');
        if (parent.hasClass('shareModal-collapse')) {
          $(this).html('Thu gọn <i class="fa fa-angle-up"></i>');
        } else {
          $(this).html('Hiển thị chi tiết <i class="fa fa-angle-down"></i>');
        }
    });

    // thay đổi permission album default = public = 1
    $('.shareModal input[name="share_permission"]').change(function () {
        share_permission = $(this).val();
        var text = $(this).attr('data-text');
        $('.shareModal .permision span.show-permision').text(text);
        $('.shareModal .permision-list .item-check span').removeClass('active');
    });

    $('body').on('click',function(){
        $('.share-page').on('hidden.bs.modal', function () {
            $(this).removeAttr('style');
            if($('#modal-show-detail-img').hasClass('show') == true){
                $('body').addClass('modal-open');
            }
            $('.div-temp-share').fadeIn();
            $('#shareClick .upavatar-share').html('');
            $('#shareModal .modal-body-js').html('');
        });
    });

    $('body').on('click','.js_library-link-show-more', function(){
        var shr_id = $(this).data('id');
        var shr_url = $(this).data('value');
        var shr_name = $(this).data('name');
        var type_shr = $(this).data('type_share');
        // $('.js_action-tools .js-customlink').attr('class','share-click js-customlink js-customlink'+shr_id);
        $('.js_action-tools .js-customlink').attr('data-item_id',shr_id);
        $('.js_action-tools .js-customlink').attr('data-value',shr_url);
        $('.js_action-tools .js-customlink').attr('data-name',shr_name);
        $('.js_action-tools .js-customlink').attr('data-tag', "link");
        $('.js_action-tools .js-customlink').attr('data-type', type_shr);
    });

    $('#modal_mess').on('hidden.bs.modal', function () {
        if($('#modal-show-detail-img').hasClass('show') == true){
            $('body').addClass(' modal-open');
        }
        if($('#modal-show-detail-video').hasClass('show') == true){
            $('body').addClass(' modal-open');
        }
    });

    //share

    $('body').on('click', '.js-list-share-content, .js-list-share-link', function(){
        $('.load-wrapp').show();
        var id = $(this).parents('.js-item-id').data('id');
        var url = '';

        if($(this).hasClass('js-list-share-content') === true){
          url = urlFile +'share/api_share_content';
        }
        if($(this).hasClass('js-list-share-link') === true){
          url = urlFile +'share/api_share_links';
        }

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(result){
                var temp_ul = '';
                $(result.data.data).each(function(){
                  temp_ul += '<div class="item" style="width: 100%">';
                    temp_ul += '<div class="avatar">';
                      temp_ul += '<a target="_blank" href="'+urlFile+'profile/'+this.use_id+'">';
                        temp_ul += '<div class="nickname">';
                          temp_ul += '<div class="img"><img src="'+this.avatar+'"></div>';
                        temp_ul += '</div>';
                      temp_ul += '</a>';
                    temp_ul += '</div>';
                    temp_ul += '<div class="info"><p><b>'+this.use_fullname+'</b> đã chia sẻ lên <b>'+this.share_type+'</b> ('+this.total+' lượt)</p></div>';
                  temp_ul += '</div>';
                });
                $('.modalglobal .modal-title').html(result.data.total_share+' lượt chia sẻ');
                $('.modalglobal .modal-body .detail').html(temp_ul);
                $('.load-wrapp').hide();
                $('.modalglobal').modal('show');
            }
        });
    });

    $('body').on('click', '.js-list-share-img, .js-list-share-video', function(){
        $('.load-wrapp').show();
        $('#modal_mess .modal-body p').html('');
        var id = $(this).parents('.js-item-id').attr('data-id');
        var url = '';

        if($(this).hasClass('js-list-share-video') === true){
          url = urlFile +'share/api_share_videos';
        }
        if($(this).hasClass('js-list-share-img') === true){
          url = urlFile +'share/api_share_images';
        }

        $.ajax({
          type: 'POST',
          url: url,
          dataType: 'json',
          data: {id: id},
          success: function(result){
              if(result.data.total_share > 0){
                $('.js-list-share').removeAttr('style');
                $('body').find('.js-list-share-' + id+' .total-share-img'). text(result.data.total_share);

                var temp_ul = '';
                $(result.data.data).each(function(){
                  temp_ul += '<div class="item" style="width: 100%">';
                    temp_ul += '<div class="avatar">';
                      temp_ul += '<a target="_blank" href="'+urlFile+'profile/'+this.use_id+'">';
                        temp_ul += '<div class="nickname">';
                          temp_ul += '<div class="img"><img src="'+this.avatar+'"></div>';
                        temp_ul += '</div>';
                      temp_ul += '</a>';
                    temp_ul += '</div>';
                    temp_ul += '<div class="info"><p><b>'+this.use_fullname+'</b> đã chia sẻ lên <b>'+this.share_type+'</b> ('+this.total+' lượt)</p></div>';
                  temp_ul += '</div>';
                });
                $('.modalglobal .modal-title').html(result.data.total_share+' lượt chia sẻ');
                $('.modalglobal .modal-body .detail').html(temp_ul);
                $('.modalglobal').modal('show');
                $('.load-wrapp').hide();
              }else{
                  $('.js-countact-image-' + id).css('display', 'none');
              }
          },
          error:function(){
            alert('Kết nối thất bại');;
            $('.load-wrapp').hide();
          }
        });
    });

    $('#modalglobal').on('hidden.bs.modal', function () {
        if($('.modal-show-detail').hasClass('show') == true){
            $('body').addClass(' modal-open');
        }
    });
});
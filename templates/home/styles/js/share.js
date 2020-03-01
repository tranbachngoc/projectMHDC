var formData = new FormData();
$( document ).ready(function() {
    /*function share_social(id_, new_id){ 
        $('.share-click.popup').click(function () {
            $('.share-to-pages').attr('data-key',id_);
            $('#shareClick'+new_id).addClass('popup'+new_id);
            $('.popup'+new_id).find('.shr-html').addClass(' hidden');
            $('.popup'+new_id).find('.shr-html-js').removeClass(' hidden');
        });
        $('#shareClick'+new_id).on('show.bs.modal', function () {
            var template_share = $('#js-share').html();
            var shr_url = $(this).find('.shr-data').attr('data-value');
            var shr_name = $(this).find('.shr-data').attr('data-name');
            var af_id = shr_url.split('?');
            var id_img = id_imgtwitter = '?img='+id_;

            if(af_id.length > 1){
                id_img =  '%26img='+id_;
            }
            shr_url += id_img  + '%23image_'+id_;
            template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
            template_share = template_share.replace(/{{SHARE_URL}}/g, shr_url);
            $(this).css('z-index',1051);
            $(this).find('.shr-html-js').html(template_share);
        });
        $('#shareClick'+new_id).on('hidden.bs.modal', function () {
            $(this).find('.shr-html').removeClass(' hidden');
            $(this).find('.shr-html-js').addClass(' hidden');
            $('#shareClick'+new_id).removeClass('popup'+new_id);
        });
    }*/

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
    }

    function share_social_popup(_this){
        var shr_id = $(_this).attr('data-id');
        var shr_url = $(_this).attr('data-value');
        var shr_name = $(_this).attr('data-name');
        var template_share = $('#js-share').html();
        var _thispopup = '.temp-share #shareClick';
        var af_id = shr_url.split('?');
        var id_img = id_imgtwitter = '?img='+shr_id;

        if(af_id.length > 1){
            id_img =  '%26img='+shr_id;
        }
        share_url = shr_url + id_img  + '%23image_'+shr_id;
        share_coppy_url = shr_url + id_img  + '#image_'+shr_id;
        
        $(_thispopup).find('.shr-html').addClass(' hidden');
        $(_thispopup).find('.shr-html-js').removeClass(' hidden');
        
        template_share = template_share.replace(/{{SHARE_NAME}}/g, shr_name);
        template_share = template_share.replace(/{{SHARE_URL}}/g, share_url);
        template_share = template_share.replace(/{{SHARE_COPPY_URL}}/g, share_coppy_url);
        $(_thispopup+' .shr-html-js').html(template_share);
        $(_thispopup).css('z-index',1051);
        $(_thispopup).modal('show');

        $('.share-page .congdong').attr('class','item congdong share-customlink');
    }

    $('body').on('click','.js-customlink', function(){
        share_social(this);
    });

    $('body').on('click','.share-click.shr-content', function(){//.avata-part 
        $('.share-to-pages').attr('data-id',$('.js-like-content').attr('data-id'));
    });

    $('body').on('click','.share-click.shr-product', function(){//.avata-part 
        $('.share-to-pages').attr('data-id',$('.js-like-product').attr('data-id'));
    });

    $('body').on('click','.share-click', function(){//.avata-part 
        share_social(this);
    });

    $('body').on('click','.share-click-popup', function(){//.avata-part 
        share_social_popup(this);
    });

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

    $('body').on('click','.congdong.share-content',function(){
        var new_id = $(this).parents('.share-to-pages').attr('data-id');
        var img_id = $(this).parents('.share-to-pages').attr('data-key');
        var type = $(this).parents('.share-to-pages').attr('data-type');
        share_content(new_id,img_id,type);
    });

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
            data: {new_id: new_id, img_id: img_id, type:type},
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
                html_share = html_share.replace(/{{SHARE_USER_ID}}/g, info_popup.product.pro_user);
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

    $('body').on('click','.button-showmore .text', function(){
        var parent = $(this).closest('.shareModal-uncollapse');
        parent.toggleClass('shareModal-collapse');
        if (parent.hasClass('shareModal-collapse')) {
          $(this).html('Thu gọn <i class="fa fa-angle-up"></i>');
        } else {
          $(this).html('Hiển thị chi tiết <i class="fa fa-angle-down"></i>');
        }
    });

    $('body').on('click','.shr-product',function(){
        $('.share-page .congdong').attr('class','item congdong share-product');
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
        });
        $('.share-page').on('hidden.bs.modal', function () {
            $('.shareModal .modal-body-js').html('');
        });
    });

    $('body').on('click','.js_library-link-show-more', function(){
        var shr_id = $(this).data('id');
        var shr_url = $(this).data('value');
        var shr_name = $(this).data('name');
        // $('.js_action-tools .js-customlink').attr('class','share-click js-customlink js-customlink'+shr_id);
        // $('.js_action-tools .js-customlink').attr('data-id',shr_id);
        $('.js_action-tools .js-customlink').attr('data-value',shr_url);
        $('.js_action-tools .js-customlink').attr('data-name',shr_name);
    });

});
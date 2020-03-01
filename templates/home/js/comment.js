var formCommentData = new FormData();
$(document).ready(function(){
	
});
$(document).on('change', '.add-image-comment', function () {
	$('#list-image-comment').css('display','block');
    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        // Duyệt từng file trong danh sách và render vào DIV trống đặt sẵn
        renderFileInfoComment(file);
    }
});
// Tạo id của hình
function GenerateRandomStringComment(len){
    var d = new Date();
    var text = d.getTime();
    
    return text;
}

// Đọc file hình

function renderFileInfoComment(file) {
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        var id = GenerateRandomStringComment(10);
        if(file.type != 'video/mp4' && file.type != 'video/mpeg') {
            var html = '';
            html +='<div class="image-comment-item">';
            	html +='<img src="'+e.target.result+'">';
            html +='</div>';
            $('#list-image-comment').append(html);
        }
        var images = {
            'image_id'        : id,
            'image_name': file.name,
            'image_url' : e.target.result,
        };
        formCommentData.append('comment_images[]', file, file.name);
    }
    fileReader.readAsDataURL(file);
}

function sendcoment(id,parent_id) {
    var check = 0;
    var send = Math.round(new Date().getTime()/1000);
    var timer =  formCommentData.get('timer');
    formCommentData.set('timer', send);
    check = parseInt(send - timer);
	var url = website_url+'comment/addcomment/'+id;
	// Khởi tạo form data
	formCommentData.set('parent_id',parent_id);
	formCommentData.set('comment',$('#commnet_content_'+id+parent_id).val());

	cout_image = formCommentData.getAll('comment_images');
    cout_image = Object.keys(cout_image).length;
    if(cout_image > 1) {
    	formCommentData.set('list_comment_images',JSON.stringify(formCommentData.getAll('comment_images')));
    }
	if(check > 15) {
        $.ajax({
            url: url,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formCommentData,
            success:function(data){
                send = true;
                location.reload();
            }
        }); 
    }
}

// Get list images
$(document).on('click', '.show-slider-image-comment', function () {
    var url = website_url+'comment/loadcommentimage/'+$(this).attr('data-id');
    $.ajax({
        url: url,
        processData: false,
        contentType: false,
        type: 'GET',
        dataType : 'json',
        data: {},
        success:function(data){
            if(data.type == 'success') {
                var html_img = '';
                $.each(data.images, function ( index, item) {
                    html_img +='<div class="img"><img src="'+data.path+item.path+'" alt=""></div>';
                });
                $('#modal-show-comment-images .js-slider-img').html(html_img);

                $('#modal-show-comment-images').modal('show');

                // Slick Selector.
                var slickSlider = $('.js-slider-img');
                var maxDots = 3;
                var transformXIntervalNext = -18;
                var transformXIntervalPrev = 18;

                slickSlider.on('init', function (event, slick) {
                  $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
                  $(this).find('ul.slick-dots li').each(function (index) {
                    $(this).addClass('dot-index-' + index);
                  });
                  $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
                  setBoundries($(this),'default');
                  var number = $(this).find('ul.slick-dots li').length;
                    console.log(number);
                    if (number <= 2) {
                        $(this).find('.slick-dots-container').addClass("lessthanfour");
                    }
                });

                var transformCount = 0;
                slickSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                  var totalCount = $(this).find('.slick-dots li').length;
                  if (totalCount > maxDots) {
                    if (nextSlide > currentSlide) {
                      if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('n-small-1')) {
                        if (!$(this).find('ul.slick-dots li:last-child').hasClass('n-small-1')) {
                          transformCount = transformCount + transformXIntervalNext;
                          $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('n-small-1');
                          var nextSlidePlusOne = nextSlide + 1;
                          $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('n-small-1');
                          $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
                          var pPointer = nextSlide - 1;
                          var pPointerMinusOne = pPointer - 1;
                          $(this).find('ul.slick-dots li').eq(pPointerMinusOne).removeClass('p-small-1');
                          $(this).find('ul.slick-dots li').eq(pPointer).addClass('p-small-1');
                        }
                      }
                    }
                    else {
                      if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('p-small-1')) {
                        if (!$(this).find('ul.slick-dots li:first-child').hasClass('p-small-1')) {
                          transformCount = transformCount + transformXIntervalPrev;
                          $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('p-small-1');
                          var nextSlidePlusOne = nextSlide - 1;
                          $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('p-small-1');
                          $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
                          var nPointer = currentSlide + 1;
                          var nPointerMinusOne = nPointer - 1;
                          $(this).find('ul.slick-dots li').eq(nPointer).removeClass('n-small-1');
                          $(this).find('ul.slick-dots li').eq(nPointerMinusOne).addClass('n-small-1');
                        }
                      }
                    }
                  }
                });

                $('#modal-show-comment-images .js-slider-img').slick({
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  dots: true,
                  focusOnSelect: true,
                  infinite: false,
                  arrows: false,
                });
            }
        }
    });
});
function setBoundries(slick, state) {
    if (state === 'default') {
        slick.find('ul.slick-dots li').eq(2).addClass('n-small-1');
    }
}

// Đóng popup comment image 
$(document).on('click', '.close-comment-images', function () {
    $('#modal-show-comment-images').modal('hide');
});
$(document).on('click', '.comment-new-popup-mobile', function () {
    var infomation = JSON.parse($(this).attr('data-user'));
    var infomation_html = '';
    infomation_html += '<div class="infomation-user-comment-inner">';
        infomation_html += '<div class="avatar"><img src="'+infomation.avatar+'"/></div>';
        infomation_html += '<div class="infomation-inner">';
            infomation_html +='<h3>'+infomation.use_fullname+'</h3>';
        infomation_html += '</div>';
    infomation_html += '</div>';
    infomation_html +='<a class="link-detail" href="'+infomation.detail_link+'">Xem chi tiết tin</a>';
    $('#modal-show-comment-sm .infomation-user-comment').html(infomation_html);
    $.ajax({
        url: website_url + 'comment/loadcomment/'+$(this).attr('data-id'),
        type: "POST",
        data: {comment_type : 'image'},
        dataType: "json",
        beforeSend: function () {
            info_popup = {};
        },
        success: function (response) {
            if(response.type == 'success') {
                $('#modal-show-comment-sm #comment_block_popup').html(response.data);
            }
        },
        error: function () {}
    });
    $('#modal-show-comment-sm').css('display','block');
});

$(document).on('click','.mobile .input-text-comment, .mobile .button-opencomment-text', function () {
    var status = $('.area-comment').attr('data-status');
    if(status == undefined || status == 'close') {
        $('.area-comment').css('width','90%');
        $('.list-add-icon').css('display','none');
        $('.area-comment').attr('data-status','open');
    }else {
        $('.area-comment').css('width','45%');
        $('.list-add-icon').css('display','block');
        $('.area-comment').attr('data-status','close');
    }
    
});

$(document).on('click','.desktop .input-text-comment, .desktop .list-add-icon', function () {
    $element = $(this).closest('.create-new-comment');
    var status = $($element).find('.area-comment').attr('data-status');
    if(status == undefined || status == 'close') {
        $($element).find('.area-comment textarea').css({'height':'auto','border-radius':'5px'});
        $($element).find('.list-add-icon').addClass('active');
        $($element).find('.area-comment').attr('data-status','open');
    }else {
        $($element).find('.area-comment textarea').css('height','auto');
        $($element).find('.list-add-icon').css('display','block');
        $($element).find('.area-comment').attr('data-status','close');
    }
});

$(document).on('click', '#modal-show-comment-sm .button-back', function(){
    $('#modal-show-comment-sm').css('display','none');
});
// Mở đang sản phẩm
$(document).on('click', '.button-add-product-comments', function(){
    $('#modal-product').css('display','block');
});
// Show danh mục
$(document).on('click', '#modal-product #select-product-category', function(){
    var jqxhr = $.get(website_url+'comment/getcategories/0', {type : 0}, function() {}, "json");
    jqxhr.done(function(response) {
        if(response.type === 'success') {
            $('#modal-category-product-select .modal-category-product-select-body').html(response.data);
            $('#modal-product').css('display','none');
        }
    });
    $('#modal-category-product-select').css('display','block');
});
// Show danh mục con
$(document).on('click', '#modal-category-product-select ul.parent-category li', function(){
    var jqxhr = $.get(website_url+'comment/getcategorieschild/'+$(this).attr('data-value'), {type : 0}, function() {}, "json");
    jqxhr.done(function(response) {
        if(response.type === 'success') {
            $('#modal-category-product-select .modal-category-product-select-body').html(response.data);
        }
    });
});
// Lấy sản phẩm 
$(document).on('click', '#modal-category-product-select ul.child-category li', function(){
    var jqxhr = $.post(website_url+'comment/getproduct/'+$(this).attr('data-value'), {type : 0, azibai: 1}, function() {}, "json");
    jqxhr.done(function(response) {
        if(response.type === 'success') {
            $('#modal-category-product-select').css('display','none');
            $('#modal-product #list-product').html(response.data);
            $('#modal-product').css('display','block');
        }
    });
});
// Chọn sản phẩm
$(document).on('click', '#modal-product .icon-chon img', function(){
    var id = $(this).attr('data-id');
    var htmlString = '<li id="'+id+'" class="choose-pro" data-id="'+id+'">';
    htmlString += $('#'+id).html();
    htmlString +='</li>';
    htmlString = htmlString.replace('chon.svg','xoa.svg');
    htmlString = htmlString.replace('icon-chon','icon-xoa');
    $('#'+id).remove();
    formCommentData.append('listproduct[]', $(this).attr('data-id'));
    formCommentData.append('listproducthtml', htmlString);
});

// Đóng chọn sản phẩm
$(document).on('click', '#modal-product .button-back-product, #seleted-products', function(){
    $('#modal-product').css('display','none');
});
// Show sản phẩm đã chọn
$(document).on('click', '#modal-product #show-product-chose', function(){
    var htmlString = formCommentData.getAll('listproducthtml');
    var html = '';
    if(htmlString.length > 0) {
        html +='<ul class="list-product-chose">';
        $.each(htmlString, function( key, value ) {
            html += value;
        });
        html +='</ul>';
        $('#modal-product #list-product').html(html);
    }
});
$(document).on('click', '#modal-product .modal-product-header h4', function(){
    var html ='';
    html +='<ul id="select-type-product">';
        html +='<li data-value="0">Sản phẩm của tôi</li>';
        html +='<li data-value="1">Sản phẩm của azibai</li>';
    html +='</ul>';
    $('#modal-product-select .modal-product-select-body').html(html);
    $('#modal-product-select').addClass('open');
});
// Chọn loại sản phẩm
$(document).on('click', 'ul#select-type-product li', function(){
    $('#modal-product').attr('data-type',$(this).attr('data-value'));
    $('#modal-product-select').removeClass('open');
    $('#modal-product .modal-product-header h4 span').html($(this).text());
    if($(this).attr('data-value') == 1) {
        $.ajax({
            url: website_url + 'comment/loadcomment/'+$(this).attr('data-id'),
            type: "GET",
            data: {comment_type : 'image'},
            dataType: "json",
            beforeSend: function () {
                info_popup = {};
            },
            success: function (response) {
                if(response.type == 'success') {
                    $('#modal-show-comment-sm #comment_block_popup').html(response.data);
                }
            },
            error: function () {}
        });
    }
});
// Đóng mở emoji
$(document).on('click', '.emoji-button .icon-emoji-button', function(){
    var parent = $(this).closest('div.list-add-icon');
    $(parent).find('.emoji-parent').toggle( "slow");
});
$(document).on('click', '.emoji-parent-menu i', function(){
    var data_tab = $(this).attr('data-id');
    $('.emoji-parent').find('.emoji-group').css('display','none');
    $('.emoji-parent #'+data_tab).css('display','block');
});
$(document).on('click', '.emoji-data span', function(){
    var data = $(this).attr('data');
    var parent = $(this).closest('div.create-new-comment');
    var comment = $(parent).find('.input-text-comment').val();
    $(parent).find('.input-text-comment').val(comment+data);
});
// Popup comment
function openchild(comment) {
    $('#add_comment_child .modal-title').html('Bình luận cho '+comment.use_fullname);
    $.ajax({
        url: siteUrl + 'comment/loadcomment/'+comment.comment_id,
        type: "POST",
        data: {get_type: 1},
        dataType: "json",
        beforeSend: function () {
            info_popup = {};
        },
        success: function (response) {
            if(response.type == 'success') {
                $('#add_comment_child .modal-body').html(response.data);
            }
        },
        error: function () {}
    });
    $('#add_comment_child').modal('show');
}
// Close popup comment
$(document).on('click', '#add_comment_child .close', function(){
    $('#add_comment_child').modal('hide');
});

// Show danh mục
$(document).on('click', '.button-add-links-comments', function(){
    var jqxhr = $.get(website_url+'comment/getlinks', {}, function() {}, "json");
    jqxhr.done(function(response) {
        $('#comment_list_links').html(response.data.sListGroup);
    });
    
});
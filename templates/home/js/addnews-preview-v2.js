var tags = [];
var position = {};
var modalTag = false;
var swap_image;
var tagImage = {};
var page_tag = 1;
var search_tag   = false;
var is_busy = false;

var tag_home = {}

function showTagHome(tags) {
    $('.taggd').find('.taggd__wrapper').remove();
    tag_home = JSON.parse(tags);
    if (tag_home.length > 0) {
      $.each(tag_home, function( index, value ) {
        var positionStyle = getPositionStyle(value.x, value.y);
        wrapperElement = document.createElement('div');
        wrapperElement.classList.add('taggd__wrapper', 'position-tag');
        buttonElement = '<div class="tag-photo-home tag-selecting" data-id="'+ index +'"><img style="display:none" src="/templates/home/icons/boxaddnew/tag.svg"></div>';
        $(wrapperElement).html(buttonElement);
        wrapperElement.style.left = positionStyle.left;
        wrapperElement.style.top = positionStyle.top;
        // wrapperElement.style.display = "none";
        $('.taggd').append(wrapperElement); 
      });
       $('.taggd').find('.tag-photo-home img').show(0);
    }
}

function getElementOffset(el) {
  if (el.getBoundingClientRect) {
      return el.getBoundingClientRect();
  }
  else {
    var x = 0, y = 0;
    do {
        x += el.offsetLeft - el.scrollLeft;
        y += el.offsetTop - el.scrollTop;
    } 
    while (el = el.offsetParent);

    return { "left": x, "top": y }
  }
}

function getScrollTop(){
  if (window.pageYOffset) return window.pageYOffset;
  return document.documentElement.clientHeight
    ? document.documentElement.scrollTop
    : document.body.scrollTop;
};


function getPositionStyle(x, y) {
  return {
    left: x * 100 + '%',
    top: y * 100 + '%'
  };
}



$(document).ready(function() {

  $('body').on('click','.tag-photo-home', function(){
      var id_tag = $(this).attr('data-id');
      $('.tag-photo-home').removeClass('is-active');
      $(this).addClass('is-active');
      if($('.fs-gal-view-detail .product-slider').hasClass('slick-initialized')){
        $('body').find('.product-slider').slick('unslick');
      }
      $('.fs-gal-view-detail .product-slider').removeClass('slick-initialized slick-slider');
      $('.fs-gal-view-detail .product-slider').html('');
      $('.image-tag-recs-close').show();
      $('.fs-gal-view-detail').show();
      
      var option_slick = {
              dots: true,
              infinite: false,
              speed: 300,
              slidesToShow: 6,
              slidesToScroll: 6,
              variableWidth: true,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    infinite: true,
                    dots: true
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
              ]
            };
      // show loadding

      if (tag_home[id_tag] !== undefined) {
        // link
        if(tag_home[id_tag].list_link.length > 0 ) {
          $.each(tag_home[id_tag].list_link, function( key_link, value_link ) {
            var template_link = $('#js-link-photo-tag').html();
            template_link = template_link.replace(/{{IMAGE_LINK_TAG}}/g, value_link.image);
            template_link = template_link.replace(/{{TITLE_LINK_TAG}}/g, value_link.title);
            template_link = template_link.replace(/{{LINK_TAG}}/g, value_link.save_link);
            template_link = template_link.replace(/{{DOMAIN_TAG}}/g, value_link.host);
            $('.fs-gal-view-detail .product-slider').append(template_link);
          });

          $('body').find('.product-slider').slick(option_slick);

        } else {

          $.ajax(
          {
            type        : 'post',
            dataType    : 'json',
            url         : website_url + 'product/getProChoose',
            data        : {product: tag_home[id_tag].list_pro, type:'home' },
            success     : function (result)
            { 
              if (result.list_product != "") {
                $('.fs-gal-view-detail .product-slider').html(result.list_product);
              } 
            }
          })
          .always(function()
          { 
            is_busy = false;

            $('body').find('.product-slider').slick(option_slick);
            // remove loadding
            
          });

        }
      }
  });

  // đóng popup
  jQuery(document).on('click','.drawer-overlay, .js-back', function() {
    hidePopup();
    return false;
  });

  // click tag 
  $('.popup-tag .title-tabs li').click(function () {
    var num =  $('.popup-tag .title-tabs li').index(this);
    $(".popup-tag .content-sanpham-items").hide();
    $(".popup-tag .content-sanpham-items").eq(num).show();
    $(".popup-tag .title-tabs li").removeClass('is-active');
    $(this).addClass('is-active');
  });

  // change radio list category
  $('input[type="radio"][name="fromwhere"]').on('change', function() {
    page_tag = 1;
    search_tag = false;
    switch($(this).val()) {
      case '1':
        $('.for_azibai').hide();
        $('.for_me').show();
        $('.for_me[data-type="0"]').find('.tit').trigger('click');
        $('.for_me[data-type="0"]').find('.overflow > li:first-child').trigger('click');
        break;
      case '2':
        $('.for_me').hide();
        $('.for_azibai').show();
        $('.for_azibai[data-type="0"]').find('.tit').trigger('click');
        $('.for_azibai[data-type="0"]').find('.overflow > li:first-child').trigger('click');
        break;
    }
  });

  // show list category
  $(".danhmucsanpham .tit").click(function() {
    $(".danhmucsanpham .tit").not(this).removeClass('opened');
    $(".danhmucsanpham .tit").not(this).next('.danhmucsanpham-parent').hide();
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
      $(this).next('.danhmucsanpham-parent').slideDown();    
    } else {
      $(this).next('.danhmucsanpham-parent').slideUp();    
    }
    return false;
  });
    
  // get product or coupon with category
  $('body').on('click','#popup-tag .danhmucsanpham-parent li', function(){
      var _this       = $(this);
      if (is_busy == true) {
        return false;
      }
      else if ($(this).hasClass('menu-active')) {
        $(_this).find('p.danhmucsanpham-child-title').removeClass('opened');
        $(_this).find('.danhmucsanpham-child-content').slideUp();
        $(_this).removeClass('menu-active');
        return false;
      } 
      else {
        search_tag = false;
        page_tag = 1;
        is_busy = true;
        
        $('body').find('.danhmucsanpham-parent li').removeClass('menu-active');
        $(_this).addClass('menu-active');
        if ($(this).closest('ul').hasClass('danhmucsanpham-child-content')) {
          $(this).closest('ul').closest('li').addClass('child-menu-active');
        }

        // add loadding
        $('#popup-tag #loader').show();
      }

      var category_id = $(this).attr('data-id');
      var who_get     = $('input[type="radio"][name="fromwhere"]:checked').val();
      var pro_type    = $(this).closest('.list-danhmucsanpham').attr('data-type');
      var pape_get    = 1;

      var data_send = {
        page : pape_get, 
        category_id: category_id, 
        who_get: who_get, 
        pro_type: pro_type
      };


      $.ajax(
      {
        type        : 'post',
        dataType    : 'json',
        url         : website_url + 'product/getProPreview',
        data        : data_send,
        success     : function (result)
        { 
          $('#popup-tag .ajax_product_tags').html('');
          $(".scroll-div-product").scrollTop(0);  
          if (result.list_product != "") {
            $('#popup-tag .ajax_product_tags').html(result.list_product);
          }

          if (result.list_category != "" && typeof result.list_category === 'object') {
            var str = '';
            $.each(result.list_category, function( index, value ) {
              str += '<li data-id="'+ value.cat_id +'"><p>'+ $.trim(value.cat_name) +'</p></li>';
            });

            $(_this).find('ul.danhmucsanpham-child-content').html(str);
            $(_this).find('p.danhmucsanpham-child-title').addClass('opened')
            $(_this).find('.danhmucsanpham-child-content').slideDown();
          } 
           
        }
      })
      .always(function()
      { 
        is_busy = false;
        // remove loadding
        $('#popup-tag #loader').hide();
      });
  });

  // search product tag
  $('.button-tag-seach').click(function(){
      var text_search = $('.tag-search').val();
      if ($.trim(text_search) == '') {
        alert('Vui lòng nhập nội dung.');
        return false;
      } else if (is_busy == true) {
        alert('Đang load dữ liệu. Vui lòng chờ trong giây lát.');
        return false;
      }
      var category_active = $('#popup-tag').find('li.menu-active');
      var who_get     = $('input[type="radio"][name="fromwhere"]:checked').val();
      var pape_get    = 1;
      if (category_active.length != 1)
      {
        alert('Có lỗi xảy ra. Vui lòng thử lại.');
        return false;
      } 
      else
      {
        var category_id = $(category_active).attr('data-id');
        var pro_type = $(category_active).parents('.list-danhmucsanpham').attr('data-type');
      }


      var data_send = {
        page : pape_get, 
        category_id: category_id, 
        who_get: who_get, 
        pro_type: pro_type,
        text_search: text_search
      };
      search_tag = true;
      is_busy = true;
      page_tag = 1;
      $('#popup-tag #loader').show();
      $.ajax(
      {
        type        : 'post',
        dataType    : 'json',
        url         : website_url + 'product/getProPreview',
        data        : data_send,
        success     : function (result)
        { 
          $('#popup-tag .ajax_product_tags').html('');
          $(".scroll-div-product").scrollTop(0); 
          if (result.list_product != "") {
            $('#popup-tag .ajax_product_tags').html(result.list_product);
          } 
        }
      })
      .always(function()
      { 
        is_busy = false;
        // remove loadding
        $('#popup-tag #loader').hide();
      });
  });


  // scrool get product tag
  $(".scroll-div-product").scroll(function(){
      var _this = $(this);
      if($(this).scrollTop() + $(this).height() == $(this).prop('scrollHeight')) 
      {
        if (is_busy == true){
            return false;
        }
        var category_active = $('#popup-tag').find('li.menu-active');
        var who_get     = $('input[type="radio"][name="fromwhere"]:checked').val();
        if (category_active.length != 1)
        {
          alert('Có lỗi xảy ra. Vui lòng thử lại.');
          return false;
        } 
        else
        {
          var category_id = $(category_active).attr('data-id');
          var pro_type = $(category_active).parents('.list-danhmucsanpham').attr('data-type');
        }

        var text_search = '';
        if (search_tag == true) {
          text_search = $('.tag-search').val();
        }

        is_busy = true;
        page_tag++;
        var pape_get    = page_tag;

        var data_send = {
          page : pape_get, 
          category_id: category_id, 
          who_get: who_get, 
          pro_type: pro_type,
          text_search: text_search
        };

        
        $('#popup-tag #loader').show();
        $.ajax(
        {
          type        : 'post',
          dataType    : 'json',
          url         : website_url +'product/getProPreview',
          data        : data_send,
          success     : function (result)
          { 
            if (result.list_product != "") {
              $('#popup-tag .ajax_product_tags').append(result.list_product);
            } 
          }
        })
        .always(function()
        { 
          is_busy = false;
          // remove loadding
          $('#popup-tag #loader').hide();
        });
      }
  });


  function hidePopup() {
    $('#popup-tag').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
  }

  function showPopup() {
    $('#popup-tag').addClass('is-open');
    $('.wrapper').addClass('drawer-open');
    $('.list-product-choose').trigger('click');
  }

  

  function createTag(getPosition) {
    var index_tag = tags.push(getPosition);
    getPosition.index_tag = index_tag - 1;
    tags[getPosition.index_tag] = getPosition;

    var positionStyle = getPositionStyle(getPosition.x, getPosition.y);

    wrapperElement = document.createElement('div');
    wrapperElement.classList.add('taggd__wrapper');
    buttonElement = '<button class="taggd__button" data-id="'+ getPosition.index_tag +'"></button>';
    $(wrapperElement).html(buttonElement);
    wrapperElement.style.left = positionStyle.left;
    wrapperElement.style.top = positionStyle.top;
    $(swap_image).append(wrapperElement);
  }

  function editTag(getPosition) {
    tags[getPosition.index_tag] = getPosition;
  }

  function deleteTag(tagPosition) {
    tagPosition.hidden = true;
    tags[tagPosition.index_tag] = tagPosition;
    $('.taggd__button[data-id="'+ tagPosition.index_tag +'"]').closest('.taggd__wrapper').remove();
  }

  function is_url(str)
  {
    regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
    if (regexp.test(str))
    {
      return true;
    }
    else
    {
      return false;
    }
  }





  function showTagPhoto(tags) {
    if (tags.length > 0) {
      $.each(tags, function( index, value ) {
        if (value.hidden == false) {
          if (value.id_image != '') {
            var image_list = $('body').find('.image_tag[data-id="'+value.id_image+'"]');
            if (image_list.length > 0) {
               $.each(image_list, function() {
                  swap_image =  $(this).closest('div');
                  createTag(value, 'show');
               });
            }
          }
        }
      });
    }
  }

  // click create image and open modal tag
  $('body').on('click', '.addTagImgGallary', function () {
      modalTag = true;
      $('.previewnews .sidebar-left').html('');
      var image_url = '';
      var image_id = $(this).attr('data-id');
      tags = [];
      // var list_images = formData.getAll('images');
      // $.each(list_images, function( k_photo, v_photo ) {
      //     var data_photo = JSON.parse(v_photo);
      //     if (image_id == data_photo.image_id && data_photo.tags !== undefined)  {
      //       tags = data_photo.tags;
      //       return false;
      //     }
      // });
      // New code
      // 
      
      var data_image = JSON.parse(formData.get('images['+image_id+']'));
      if (data_image.tags !== undefined) {
        tags = data_image.tags;
      }
      if (data_image.image_url !== undefined) {
        image_url = data_image.image_url;
      }

     	var tag_photo = '';
      tag_photo +='<div class="taggd">';
          tag_photo +='<img src="'+image_url+'" alt="" class="image_tag taggd__image" data-id="'+image_id+'">';
      tag_photo +='</div>';
      tag_photo +='<div class="list-button-photo" data-id="'+image_id+'">';
      tag_photo +=    '<button class="photo-tag-canel btn-bg-white" data-id="'+image_id+'">Hủy</button>';
      tag_photo +=    '<button class="photo-tag-save btn-bg-gray" data-id="'+image_id+'">Lưu</button>';
      tag_photo +=    '<button class="photo-tag-next btn-bg-white" data-id="'+image_id+'">Ảnh Tiếp</button>';
      tag_photo +='</div>';
      // tag_photo += '<div><button  class="btn-bg-gray" id="buttonaddnews">Đăng Bài</button></div>';
      $('#addNewsFrontEnd #boxwork').html(tag_photo);
      $('#addNewsFrontEnd #boxwork').show();
      showTagPhoto(tags);

      
  });

  // click create new tag and show popup choose product
  $('body').on('click', '.image_tag', function (e) {
    if (modalTag === false)
      return false;
    swap_image = $(this).closest('div');
    var scrollTop = getScrollTop();
    var offset = getElementOffset($(this)[0]);
    var id_image = $(this).attr('data-id');
    position = {
      id: '',
      x: (e.pageX - offset.left) / $(this)[0].width,
      y: (e.pageY - offset.top - scrollTop) / $(this)[0].height,
      id_image: id_image,
      hidden: false,
      index_tag: '',
      list_pro: [],
      list_link: []
    };
    $('#popup-tag .img-tag-save').text('Thêm tag');
    $('#popup-tag .remove-pro-tag').hide();
    showPopup();
  });


  //  choose product for tag
  $('body').on('click', '.choose-pro-tag', function (e) {
    if (position.list_link.length > 0) {
      alert('Bạn đang sử dụng add link. không thể sử dụng chức năng này.');
      return false;
    }
    var produc_id = $(this).attr('data-id');
    if ($.inArray(produc_id, position.list_pro) == -1) {
      position.list_pro.push(produc_id);
    }
  });


  //  remove product for tag
  $('body').on('click', '.remove-pro-tag', function (e) {
    if (modalTag === false)
      return false;
    var produc_id = $(this).attr('data-id');
    var index = $.inArray(produc_id, position.list_pro);
    if (index != -1) {
        position.list_pro.splice(index, 1);

    }
    $(this).remove();
  });

  // save tag for image
  $('body').on('click', '.img-tag-save', function (e) {
      if (modalTag === false)
        return false;

      if (position.list_pro.length == 0 && position.list_link.length == 0) {
        alert('Vui lòng chọn sản phẩm hoặc thêm link.');
        return false;
      }

      if (position.index_tag == '') {
        createTag(position);
      }else {
        editTag(position);
      }
      hidePopup();
  });

  // open edit tag for image
  $('body').on('click','.taggd__button', function(){
      if (modalTag === false)
        return false;
      position = JSON.parse( JSON.stringify( tags[$(this).attr('data-id')] ) ); 
      // position = tags[$(this).attr('data-id')]; 
      $('#popup-tag .img-tag-save').text('Hoàn tất');
      $('#popup-tag .remove-pro-tag').show();
      showPopup();
  });

  // remove tag image
  $('body').on('click','.img-tag-remove', function(){
    if (modalTag === false)
      return false;
      deleteTag(position);
      hidePopup();
  });

  //  ajax get link for tag
  $('body').on('click','#add_link_tag_pt', function(){
      if (position.list_pro.length > 0) {
        alert('Bạn đang sử dụng add sản phẩm. không thể sử dụng chức năng này.');
        return false;
      }
      var link_tag_pt = $('body').find('#link_tag_pt').val();
      if(!is_url(link_tag_pt)) {
        alert('Vui lòng nhập link'); 
      } else {
        // ajax get data
        $.ajax({
          url: website_url +"tintuc/linkinfo",
          method: "POST",
          data: {link: link_tag_pt},
          dataType: "json",
          success: function(data) {
            position.list_link.push(data);
            var template_link = $('#js-link-demo-tag').html();
            template_link = template_link.replace(/{{INDEX}}/g, Object.keys(position.list_link).length - 1);
            template_link = template_link.replace(/{{IMAGE_LINK_TAG}}/g, data.image);
            template_link = template_link.replace(/{{TITLE_LINK_TAG}}/g, data.title);
            template_link = template_link.replace(/{{LINK_TAG}}/g, data.save_link);
            template_link = template_link.replace(/{{DOMAIN_TAG}}/g, data.host);
            $('#popup-tag .list-link-choose').append(template_link);
          }
        });
      }
  });

  // ajax get list product choose
  $('.ajax-pro-choose').click(function(){
      $('#popup-tag .list-pro-choose').html('');
      if (position.list_pro.length > 0)
      {
          $.ajax({
            url: website_url +"product/getProChoose",
            method: "POST",
            data: {product: position.list_pro},
            dataType: "json",
            success: function(result) {
              $('#popup-tag .div-pro-choose').scrollTop(0);
              if (result.list_product != "") {
                $('#popup-tag .list-pro-choose').html(result.list_product);
              }
            }
          });
      }
  });

  function create_link_tag() {
    $('#popup-tag .list-link-choose').html('');
    if (position.list_link.length > 0)
    {
      $.each(position.list_link, function( key_link, value_link ) {
          var template_link = $('#js-link-demo-tag').html();
          template_link = template_link.replace(/{{INDEX}}/g, key_link);
          template_link = template_link.replace(/{{IMAGE_LINK_TAG}}/g, value_link.image);
          template_link = template_link.replace(/{{TITLE_LINK_TAG}}/g, value_link.title);
          template_link = template_link.replace(/{{LINK_TAG}}/g, value_link.save_link);
          template_link = template_link.replace(/{{DOMAIN_TAG}}/g, value_link.host);
          $('#popup-tag .list-link-choose').append(template_link);
      });
    }
  }

  $('.js-link-choose').click(function(){
      create_link_tag();
  });

  $('body').on('click', '.remove-link-tag', function (e) {
      var index_link_tag = $(this).attr('data-index');
      var list_link_bak = [];
      $.each(position.list_link, function( key_link, value_link ) {
          if (key_link != index_link_tag) {
            list_link_bak.push(value_link);
          }
      });
      position.list_link = list_link_bak;
      create_link_tag();
  });


  $('body').on('click','.photo-tag-save', function(e) {
      // var list_images = formData.getAll('images');
      // var id_photo_tag = $(this).attr('data-id');
      // formData.delete('images');
      // $.each(list_images, function( k_photo, v_photo ) {
      //     var data_photo = JSON.parse(v_photo);
      //     if (id_photo_tag == data_photo.image_id) {
      //         var tag_add = [];
      //         if (tags.length > 0) {
      //           $.each(tags, function( index, value ) {
      //             if (value.hidden == false) {
      //               tag_add.push(value);
      //             }
      //           });
      //         }
      //         data_photo.tags = tag_add;
      //     }
      //     formData.append('images', JSON.stringify(data_photo));
      // });
      
      // new code
      var image_id = $(this).attr('data-id');
      var data_image = JSON.parse(formData.get('images['+image_id+']'));
      var tag_add = [];
      if (tags.length > 0) {
        $.each(tags, function( index, value ) {
          if (value.hidden == false) {
            tag_add.push(value);
          }
        });
      }
      data_image.tags = tag_add;
      formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
  });


  $('body').on('click','.photo-tag-next', function(e) {
      var id_photo_tag = $(this).attr('data-id');
      // var element_tag = $('#' + id_photo_tag).next('.boxaddimagegallerybox');
      var element_tag = $('#addNewsFrontEnd').find('.boxaddimagegallerybox[data-id="'+id_photo_tag+'"]').nextAll('.boxaddimagegallerybox:first');
      // console.log(element_tag);
      if(element_tag.length == 1) {
        // console.log($(element_tag).find('.addTagImgGallary'));
        $(element_tag).find('.addTagImgGallary').trigger('click');
      }
  });


  



});

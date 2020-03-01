<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<style type="text/css">
  .css-boder li {border: 1px solid;}
  .btn-edit-cate, .btn-delete-cate { cursor: pointer; }
  .btn_cancel_cate_gallegy {display: none;}
  .caption_gallery {display: none;}
  .show_caption {
    position: absolute;
    /*right: -10px;*/
    top: -10px;
    background: #fff;
    border-radius: 50%;
    overflow: hidden;
    width: 20px;
    height: 20px;
  }
  .class_textarea { padding-right: 0px !important; padding-top: 5px !important; }
</style>

<div class="modal modal-show-detail" id="modal-pro-gallegy">
  <button class="btn-chitiettin back mt10 mr10 btn-close-gallery">
    <img class="ml00" src="/templates/home/styles/images/svg/prev.svg" alt="">&nbsp;Đóng
  </button>
  <div class="modal-dialog modal-lg modal-lg-style" role="document">
    <div class="modal-content container">

      <!-- Modal body -->
      <div class="modal-body">
        <div class="liet-ke-hinh-anh gallery-product gallery-product-popup">
          <div class="search-product">
            <div class="input">
              <input type="text" class="add_cate_gallegy name_gallery">
              <input type="hidden" class="edit_cate_gallegy_id" value="-1">
            </div>
            <div class="btn-edit">
              <button class="btn_add_cate_gallegy">Thêm bộ sưu tập ảnh</button>
              <button class="btn_cancel_cate_gallegy">Hủy</button>
            </div>
          </div>
          <div class="product-tabs js-product-tabs">
            <ul class="nav nav-tabs css-boder">
              
              
            </ul>
          </div>  
          <div class="sm w100pc mb10 text-right">
            <span class="xem-dang-danh-sach js-xem-dang-danh-sach"><img src="/templates/home/styles/images/svg/xemluoi_on.svg" alt=""></span>
          </div> 
          <div class="tab-content product-tabs-content product-tabs-content-js">
            
          </div>
          
        </div>
      </div>
      
    </div>
  </div>
</div>

<script id="js-gallery-tab" type="text/template">
  <li class="js-tab-li" data-key="{{KEY}}">
    <a data-key="{{KEY}}" data-toggle="tab" href="#tab_{{KEY}}">{{CONTENT}}</a>
    <div class="close-product btn-delete-cate" data-key={{KEY}}>
      <img src="/templates/home/styles/images/svg/close_white.svg" alt="">
    </div>
    <span class="edit-cate btn-edit-cate" data-key={{KEY}}>
      <img  width="20" src="/templates/home/styles/images/svg/pen_black.svg" alt="">
    </span>
  </li>
</script>

<script id="js-gallery-tab-id" type="text/template">
  <div id="tab_{{KEY}}" class="tab-pane">
    <div class="upload-img">
      <input accept="image/*" class="input_gallegy_upload upload-img-button" data-key={{KEY}} type="file" name="" multiple>
      <p class="upload-img-text">Chọn hình</p>
    </div>
    <div class="grid grid_{{KEY}}"></div>
  </div>
</script>

<script id="js-gallery-item" type="text/template">
  <div class="item">
    <div class="detail">
      <a> 
        <img src="{{IMG}}" alt="" data-w="{{DETAIL_W}}" data-h="{{DETAIL_H}}">
      </a>
      <div class="text class_textarea">
        <div class="gallery-product-action">
            <textarea class="caption_gallery" type="text" data-key="{{KEY}}" data-key-id="{{KEY_ID}}" data-gallery-id="{{GALLERY_ID}}" rows="4" cols="50"></textarea>
          </div>
        </div>
        <div class="close-product close-product-js" data-key="{{KEY}}" data-key-id="{{KEY_ID}}" data-gallery-id="{{GALLERY_ID}}">
         <img src="/templates/home/styles/images/svg/close_white.svg" alt="">
        </div>

        <div class="show_caption" data-key="{{KEY}}" data-key-id="{{KEY_ID}}" data-gallery-id="{{GALLERY_ID}}">
         <img src="/templates/home/styles/images/svg/chat_new.svg" alt="Caption">
        </div>
    </div>
  </div>
</script>

<script type="text/javascript">
  var list_masonry = [];
  var masonryOptions = {
    itemSelector: '.item',
    horizontalOrder: true
  }
  $('#modal-pro-gallegy').on('shown.bs.modal', function() {
      // var masonryOptions = {
      //   itemSelector: '.item',
      //   horizontalOrder: true
      // }
      // var $grid = $('.grid').masonry( masonryOptions );
      var isActive = true;    
      $('.js-xem-dang-danh-sach').click(function() {
        $(this).toggleClass('danhsach');
        if ($(this).hasClass('danhsach')) {
          $grid.masonry('destroy');
          $(this).find('img').attr("src","asset/images/svg/danhsach_on.svg");
          $('.liet-ke-hinh-anh').find('.grid').addClass('style-xem-dang-danh-sach');
          $('body').find('.main-content').addClass('bg-black');
        } else {
          $('.liet-ke-hinh-anh').find('.grid').removeClass('style-xem-dang-danh-sach');
          $(this).find('img').attr("src","asset/images/svg/xemluoi_on.svg");
          $grid.masonry( masonryOptions );
          $('body').find('.main-content').removeClass('bg-black');
        }
      });
    });
    
    $('body').on('click','.btn-close-gallery', function(){
        var length_tab = $('.product-tabs-content-js .grid').length;
        var length_img = $('.product-tabs-content-js .grid .item').length;
        if(length_tab > length_img){
            alert('Bạn chưa up đầy đủ ảnh cho từng tab');
        }else{
            $('#modal-pro-gallegy').modal('hide');
        }
    });

    $('.gallery_add_product').click(function(){
        $('#modal-pro-gallegy').modal('show');
    });

  var data_cate = {};
  $('.btn_add_cate_gallegy').click(function(){
      var content = $.trim($('.add_cate_gallegy').val());
      var edit_cate = $('.edit_cate_gallegy_id').val();
      if (content != '') {
        if (edit_cate == -1) {
          data_cate = {
            content: content,
            hidden: false,
            list_pro: [],
          };
          var index_tag = data_product.pro_gallegy.push(data_cate) - 1;
          var template_link = $('#js-gallery-tab').html();
              template_link = template_link.replace(/{{KEY}}/g, index_tag);
              template_link = template_link.replace(/{{CONTENT}}/g, content);
              $('.js-product-tabs ul').append(template_link);

          var template_tab_content = $('#js-gallery-tab-id').html();
              template_tab_content = template_tab_content.replace(/{{KEY}}/g, index_tag);
              $('.product-tabs-content-js').append(template_tab_content);
          list_masonry[index_tag] =  $('.grid_' + index_tag).masonry( masonryOptions );
          $('.js-product-tabs').find('.js-tab-li[data-key="'+index_tag+'"] a[data-toggle="tab"]').click();
          $('.add_cate_gallegy').val('');
        } else {
          var key_gallegy = $('.gallery-product-popup .edit_cate_gallegy_id').val();
          var content = $('.gallery-product-popup .add_cate_gallegy').val();
          data_product.pro_gallegy[key_gallegy].content = content;
          $('.gallery-product-popup .btn_add_cate_gallegy').text('Thêm Danh Mục');
          $('.gallery-product-popup .btn_cancel_cate_gallegy').hide();
          $('.gallery-product-popup .edit_cate_gallegy_id').val(-1);
          $('.js-product-tabs').find('.js-tab-li[data-key="'+key_gallegy+'"] a[data-toggle="tab"]').text(content);
          $('.add_cate_gallegy').val('');
        }
      }else{
          alert('Bạn phải nhập tên bộ sưu tập ảnh của sản phẩm');
      }
  });

  $('body').on('change', '.input_gallegy_upload', function(){
    var _this = $(this);
    var files = $(this)[0].files;
    var key_gallegy = $(this).attr('data-key');
    if (files.length > 0) {
      var formData = new FormData();

      $.each(files, function(i, file) {
          formData.append(i, file);
      });

      $.ajax({
          url: siteUrl + "product/ajaxAddGallegy",
          data: formData,
          type: 'POST',
          dataType: "json",
          contentType: false,
          processData: false,
          success: function (reponse) {
              $(_this).val('');
              if (reponse.error == false) {
                $.each(reponse.list_data, function( index, value ) {
                  var index_tag = data_product.pro_gallegy[key_gallegy].list_pro.push(value) - 1;
                  var gallery_item = $('#js-gallery-item').html();
                      gallery_item = gallery_item.replace(/{{KEY}}/g, key_gallegy);
                      gallery_item = gallery_item.replace(/{{KEY_ID}}/g, index_tag);
                      gallery_item = gallery_item.replace(/{{IMG}}/g, value.link);
                      gallery_item = gallery_item.replace(/{{DETAIL_W}}/g, value.detail_w);
                      gallery_item = gallery_item.replace(/{{DETAIL_H}}/g, value.detail_h);
                      gallery_item = gallery_item.replace(/{{GALLERY_ID}}/g, value.id);
                  $gallery_item = $(gallery_item);
                  list_masonry[key_gallegy].append( $gallery_item ).masonry('appended', $gallery_item);
                  list_masonry[key_gallegy].imagesLoaded().progress( function() {
                      list_masonry[key_gallegy].masonry('layout');
                  });                  
                });
              }
          },
          error: function () {
              alert("No Data!")
          }
      });
    }
  });


  $('body').on('click', '.close-product-js', function(){
      var gallery_item = $(this).parents('.item');
      var key_gallegy = $(this).attr('data-key');
      var key_id = $(this).attr('data-key-id');
      var gallery_id = $(this).attr('data-gallery-id');
      data_product.pro_gallegy[key_gallegy].list_pro[key_id].delete = true;
      list_masonry[key_gallegy].masonry( 'remove', $(gallery_item) );
      list_masonry[key_gallegy].masonry('layout');
  });


  $('body').on('click', '.gallery-product-popup .btn-delete-cate', function(){
      var key_gallegy = $(this).attr('data-key');
      data_product.pro_gallegy[key_gallegy].hidden = true;
      $(this).parents('.js-tab-li').remove();
      $('.product-tabs-content-js #tab_' + key_gallegy).remove();

      if ($('.js-tab-li').length > 0) {
        $('.js-tab-li').find('a[data-toggle="tab"]').click();
      }
  });

  $('body').on('click', '.gallery-product-popup .js-tab-li a[data-toggle="tab"]', function(){});

  $('body').on('click', '.gallery-product-popup .btn-edit-cate', function(){
      var key_gallegy = $(this).attr('data-key');
      var content = data_product.pro_gallegy[key_gallegy].content;
          $('.gallery-product-popup .btn_add_cate_gallegy').text('Sửa Danh Mục');
          $('.gallery-product-popup .edit_cate_gallegy_id').val(key_gallegy);
          $('.gallery-product-popup .add_cate_gallegy').val(content);
          $('.gallery-product-popup .btn_cancel_cate_gallegy').show();
  });

  $('body').on('click', '.gallery-product-popup .btn_cancel_cate_gallegy', function(){
        $('.gallery-product-popup .btn_cancel_cate_gallegy').hide();
        $('.gallery-product-popup .add_cate_gallegy').val('');
        $('.gallery-product-popup .edit_cate_gallegy_id').val(-1);
        $('.gallery-product-popup .btn_add_cate_gallegy').text('Thêm Danh Mục');
  });

  $('body').on('click', '.gallery-product-popup .show_caption', function(){
      var gallery_item = $(this).parents('.item');
      var key_gallegy = $(this).attr('data-key');
      var key_id = $(this).attr('data-key-id');
      var gallery_id = $(this).attr('data-gallery-id');

      if (!$(this).hasClass('active'))
      {
        $(gallery_item).find('.caption_gallery').show();
        $(this).addClass('active');
      }
      else
      {
        $(gallery_item).find('.caption_gallery').hide();
        $(this).removeClass('active');
      }
      list_masonry[key_gallegy].masonry('layout');
  });

  $('body').on('blur', '.gallery-product-popup .caption_gallery', function(){
      var gallery_item = $(this).parents('.item');
      var key_gallegy = $(this).attr('data-key');
      var key_id = $(this).attr('data-key-id');
      var gallery_id = $(this).attr('data-gallery-id');
      data_product.pro_gallegy[key_gallegy].list_pro[key_id].caption = $(this).val();
      list_masonry[key_gallegy].masonry('layout');
  });

  $('.js-product-tabs a[data-toggle=tab]').each(function () {
    var $this = $(this);
    var key_gallegy = $(this).attr('data-key');
    $this.on('shown.bs.tab', function () {
      list_masonry[key_gallegy].imagesLoaded().progress( function() {
          list_masonry[key_gallegy].masonry('layout');
      }); 
    });
  });
  
</script>
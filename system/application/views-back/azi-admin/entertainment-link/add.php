<?php $this->load->view('home/common/overlay_waiting')?>
<div class="administrator-addedLinks">
  <form method="post" class="js-form-add-link">
  <!-- step 1 -->
  <div class="container js-step-01" >
      <h4 class="modal-title">Thêm quảng cáo</h4>
      <hr>   
      <div class="addLinks-content">
        <table class="addLinks-content-table">
          <tbody>
            <tr>
              <th class="w20pc">Chèn liên kết:</th>
              <td>
                <div class="mb05 enter-input">
                  <input type="text" placeholder="Chèn liên kết ngoài" class="form-control js-input-link">
                  <img src="/templates/home/styles/images/svg/help_black.svg">
                </div>
              </td>
            </tr>

            <tr>
              <th>Sắp xếp:</th>
              <td>
                <div class="mb05 enter-input">
                  <input type="text" name="sort_order" placeholder="Sắp xếp" class="form-control">
                </div>
              </td>
            </tr>

            <tr>
              <th>Chuyên mục:</th>
              <td>
                <div class="mb05 enter-input">
                  <select name="category_id" id="category_id" class="form-control">
                      <option value="">--- Chọn chuyên mục---</option>
                      <?php foreach ($category as $cat): ?>
                          <option value="<?= $cat->id ?>"
                              <?= !empty($params['category']) && $params['category'] == $cat->id ? "selected" : '' ?> >
                              <?= $cat->name ?>
                          </option>
                          <?php if (!empty($cat->children)): ?>
                              <?php foreach ($cat->children as $child): ?>
                              <option value="<?= $child->id ?>"
                                  <?= !empty($params['category']) && $params['category'] == $child->id ? "selected" : '' ?>>
                                  &nbsp;&nbsp;&nbsp;- <?= $child->name ?>
                              </option>
                              <?php endforeach; ?>
                          <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                </div>
              </td>
            </tr>

            <tr>
              <th>Địa Điểm:</th>
              <td>
                <div class="mb05 enter-input">
                  <select name="province_id" id="link_province" class="form-control" required>
                      <option value="0">Chọn thành phố</option>
                      <?php foreach ($province as $vals):?>
                          <option value="<?php echo $vals->pre_id; ?>">
                              <?php echo $vals->pre_name; ?>
                          </option>
                      <?php endforeach;?>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <th></th>
              <td>
                <div class="mb05 enter-input">
                  <select name="district_id" id="link_district" class="form-control">
                      <option value="0">Chọn quận/huyện</option>
                  </select>
                </div>
              </td>
            </tr>

            <!-- <tr>
              <th>Liên kết từ bài viết:</th>
              <td>
                <div class="mb05 enter-input">
                  <select name="" id="" class="form-control">
                    <option value="">Chọn bài viết</option>
                    <option value="">Chọn bài viết1</option>
                    <option value="">Chọn bài viết2</option>
                  </select>
                </div>
              </td>
            </tr> -->

            <!-- <tr>
              <th>Liên kết từ sản phẩm:</th>
              <td>
                <div class="mb05 enter-input">                        
                  <select name="" id="" class="form-control">
                    <option value="">Chọn sản phẩm</option>
                    <option value="">Chọn sản phẩm1</option>
                    <option value="">Chọn sản phẩm2</option>
                  </select>
                </div>
              </td>
            </tr> -->
          </tbody>
        </table>
      </div>
      <div class="shareModal-footer">
        <div class="permision"></div>
        <div class="buttons-direct">
          <!-- <button class="btn-cancle">Đóng</button> -->
          <button type="button" class="btn-share js-link-submit">Xử lý</button>
        </div>
      </div>
  </div>
  <!-- end step 1 -->

  <!-- step 2 -->
  <div class="container js-step-02 hidden" >
    <h4 class="modal-title">Thêm quảng cáo</h4>
    <hr>   
    <div class="addLinks-content">
        <div class="row">
          <div class="col-xl-3 col-lg-3 col-md-12">
            <div class="addLinks-content-iconFavorite">
              <div class="accordion js-accordion">
                <div class="accordion-item">
                  <div class="accordion-toggle iconFavoriteLeft">
                      <p class="addIconFavorite">
                        <img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr05">Thêm biểu tượng nổi bật &nbsp;<i class="fa fa-caret-down"></i>
                      </p>
                  </div>
                  <div class="accordion-panel iconFavoriteRight">
                    <div class="iconFavoriteRight-addIcon">
                      <div class="iconFavoriteRight-addIcon-tit js-add-icon">
                        <p class="cursor-pointer">
                          <img src="/templates/home/styles/images/svg/thembieutuong.svg" class="mr05">
                          Thêm biểu tượng (Ảnh/Video)
                        </p>                      
                      </div>
                    </div>
                    <div class="iconFavoriteRight-align">
                      <input type="file" class="hidden select-media-input" id="js-icon-file">
                      <a class="js-icon-align icon-align-01 style-btn active" data-value="0">Trái</a>
                      <a class="js-icon-align icon-align-01 style-btn" data-value="1">Giữa</a>
                      <a class="js-icon-align icon-align-01 style-btn" data-value="2">Phải</a>
                    </div>
                    <div class="iconFavoriteRight-effect">
                      <p>Hiệu ứng</p>
                      <select name="" class="form-control js-select-icon-effect" id="icon-effect-01">
                        <option value="0">Mặc định</option>
                        <option value="1">Chuyển động trái qua phải</option>
                        <option value="2">Chuyển động phải qua trái</option>
                        <option value="3">Chuyển động từ trên xuống</option>
                        <option value="4">Chuyển động từ dưới lên</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-9 col-lg-9 col-md-12">
            <div class="row justify-content-center">
              <div class="col-xl-8 col-lg-10 col-md-12">
                <div class="administrator-addedLinks-content addedLinks-template">
                  <div class="addedLinks-template-title">
                    <h2>
                      <input type="hidden" name="link" class="js-get-link">
                      <input type="text" name="header_name" class="form-control" placeholder="Thêm/ sửa tiêu đề trang">
                      <input type="hidden" name="block[0][object][0][type]" class="hidden" value="lib">
                      <input type="hidden" name="block[0][object][1][type]" class="hidden" value="text">
                      <input type="hidden" name="block[0][object][2][type]" class="js-main-type-icon hidden" value="icon">
                    </h2>
                  </div>
                  <div class="addedLinks-template-detail">
                    <div class="addedLinks-template-detail-item">
                      <div class="block-slider">
                        <ul class="addSlider js-addSlider">
                          <li class="item-slider-link">
                            <input type="hidden" class="js-image-lib" name="block[0][object][0][data][0][image]">
                            <input type="hidden" class="js-video-lib" name="block[0][object][0][data][0][video]">
                            <img class="js-first-slider object-fit-cover imgAdded" src="<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>">
                            <span class="close">
                              <img src="/templates/home/styles/images/svg/close03.svg" class="js-remove-item-slider">
                            </span>
                          </li>

                          <li id="js-button-add-slider">
                            <input type="file" class="inputAddImg" multiple>
                            <img src="/templates/home/styles/images/svg/add_circle_white02.svg" class="icon-add">
                          </li>
                        </ul>
                      </div>
                      <div class="block-text">
                        <div class="item-content">
                          <div class="text js-swap-icon">
                            <h3 class="tit text-center" data-animation="" data-delay="500">
                              <input type="text" name="block[0][object][1][data][0][title]" class="form-control text-center js-get-title-main">
                            </h3>
                            <p class="mb10 text-center" data-animation="" data-delay="500">
                              <textarea name="block[0][object][1][data][0][description]" class="form-control text-center js-get-description-main" rows="5"></textarea>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="mt10 mb10 shareModal-footer">
      <div class="permision"></div>
      <div class="buttons-direct">
        <button type="button" class="btn-cancle js-cancel-link">Quay lại</button>
        <button type="button" class="btn-share js-add-link">Thêm</button>
      </div>
    </div>
  </div>
  <!-- end step 2 -->

  </form>
</div>


<script type="text/javascript">

  var is_busy = false;
  var block_id = 0;
  var object_id = 2;
  var icon_edit = ''; 
  var option_slick = {
      slidesToShow: 1.2,
      slidesToScroll: 1,
      infinite: false,
      arrows: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
          }
        }
      ]
  };
  $('.js-addSlider').slick(option_slick);


  var image_type = ["image/gif","image/jpeg","image/png"];
  $(document).on("change",".inputAddImg",function(event) {
      var type = $(this).attr('data-type');
      var files = event.target.files;
      $('.load-wrapp').show();
      for (var i = 0; i < files.length; i++) {
          var file = files[i];
          if (image_type.indexOf(file.type) != -1)
          { 
              var number_current = $('.js-addSlider li').length;  
              if (number_current > 30 ) 
              {
                  alert('<p>Chỉ được up tối đa 30 hình hoặc video.</p>');
              }
              else 
              {
                  renderFileImage(file, 'slider');
              }
              continue;
          }
          
          if (file.type == 'video/mp4') 
          {
              var number_current = $('.js-addSlider li').length;
              if(file.size > 524288000) 
              {
                  showError('<p>Vui lòng chọn video dưới 500M</p>');
              }
              else if (number_current > 30 ) 
              {
                  alert('<p>Chỉ được up tối đa 30 hình hoặc video.</p>');
              }
              else 
              {
                  renderFileVideo(file, 'slider');
              }
              continue;
          }
      }
  });

  // Reader image
  function renderFileImage(file,typePreview) {
      is_busy = true;
      $('.load-wrapp').show();
      var fileReader = new FileReader();
      fileReader.onload = function(e) {
              var promise = new Promise(function(resolve, reject) {
                  var temp = uploadTempImage(file);
                  console.log(temp);
                  if(temp){
                      resolve(temp);
                  }else{
                      reject(false);
                  }
              });
              promise.then(function (res) {
                  if(res && typeof res.status !== 'undefined' && res.status == 1){
                    if (typePreview == 'slider') 
                    {
                      var templateHtml = $('#js-item-image-slider').html();
                      var key_slider = $('.js-addSlider li').length;
                      var appendEditData = templateHtml.replace(/{{KEY}}/gi, key_slider - 1)
                      .replace(/{{URL}}/gi, res.data.original_image.main_url)
                      .replace(/{{IMAGE}}/gi, res.data.original)
                      .replace(/{{VIDEO}}/gi, '');
                      $('.js-addSlider').slick('slickAdd', appendEditData, key_slider - 2).slick('refresh');
                    } 
                    else if (typePreview == 'icon') 
                    {
                      if (icon_edit == '') 
                      {
                        var count_item = $('.js-swap-icon').find('.icon_featured').length;
                        var icon_align =$('.js-icon-align.active').attr('data-value');
                        var icon_effect =$('.js-select-icon-effect').val();
                        var templateHtml = $('#js-icon-image-' + icon_align).html();
                        var appendEditData = templateHtml.replace(/{{KEY}}/gi, count_item)
                        .replace(/{{URL}}/gi, res.data.original_image.main_url)
                        .replace(/{{IMAGE}}/gi, res.data.original)
                        .replace(/{{VIDEO}}/gi, '')
                        .replace(/{{POSITION}}/gi, icon_align)
                        .replace(/{{EFFECT}}/gi, icon_effect)
                        .replace(/{{BLOCK_ID}}/gi, block_id)
                        .replace(/{{OBJECT_ID}}/gi, object_id)
                        .replace(/{{TIME}}/gi, $.now());
                        $('.js-swap-icon').append(appendEditData);
                      } 
                      else 
                      {
                        var templateHtml = $('#js-icon-image-part').html();
                        var appendEditData = templateHtml.replace(/{{TIME}}/gi, icon_edit)
                        .replace(/{{URL}}/gi, res.data.original_image.main_url);
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-icon-video').val('');
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-icon-image').val(res.data.original);
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-part-icon').html(appendEditData);
                      }
                      
                    }
                  } else {
                      alert('Xảy ra lỗi trong quá trình upload vui lòng thử lại.');
                      reject(false);
                  }
              }).catch(function (error) {
                  $('.load-wrapp').hide();
                  console.log('error',error);
              }).finally(function () {
                  is_busy = false;
                  $('.load-wrapp').hide();
              });
      };
      fileReader.readAsDataURL(file);
  }

  // Reader video
  function renderFileVideo(file, typePreview) {
      is_busy = true;
      $('.load-wrapp').show();
      var fileReader = new FileReader();
      fileReader.onload = function(e) {
              var promise = new Promise(function(resolve, reject) {
                  var temp = uploadTempVideo(file);
                  if(temp)
                  {
                      resolve(temp);
                  }
                  else
                  {
                      reject(false);
                  }
              });
              promise.then(function (res) {
                  if(res && typeof res.status !== 'undefined' && res.status == 1){
                    if (typePreview == 'slider') 
                    {
                      var templateHtml = $('#js-item-video-slider').html();
                      var key_slider = $('.js-addSlider li').length;
                      var appendEditData = templateHtml.replace(/{{KEY}}/gi, key_slider - 2)
                      .replace(/{{URL}}/gi, res.data.origin_video.main_url)
                      .replace(/{{IMAGE}}/gi, res.data.thumbnail)
                      .replace(/{{VIDEO}}/gi, res.data.video);
                      $('.js-addSlider').slick('slickAdd', appendEditData, key_slider - 2).slick('refresh');
                    } 
                    else if (typePreview == 'icon') 
                    {
                      if (icon_edit == '') 
                      {
                        var count_item = $('.js-swap-icon').find('.icon_featured').length;
                        var icon_align =$('.js-icon-align.active').attr('data-value');
                        var icon_effect =$('.js-select-icon-effect').val();
                        var templateHtml = $('#js-icon-video-' + icon_align).html();
                        var appendEditData = templateHtml.replace(/{{KEY}}/gi, count_item)
                        .replace(/{{URL}}/gi, res.data.origin_video.main_url)
                        .replace(/{{IMAGE}}/gi, res.data.thumbnail)
                        .replace(/{{VIDEO}}/gi, res.data.video)
                        .replace(/{{POSITION}}/gi, icon_align)
                        .replace(/{{EFFECT}}/gi, icon_effect)
                        .replace(/{{BLOCK_ID}}/gi, block_id)
                        .replace(/{{OBJECT_ID}}/gi, object_id)
                        .replace(/{{TIME}}/gi, $.now());
                        $('.js-swap-icon').append(appendEditData);
                      } 
                      else 
                      {
                        var templateHtml = $('#js-icon-video-part').html();
                        var appendEditData = templateHtml.replace(/{{TIME}}/gi, icon_edit)
                        .replace(/{{URL}}/gi, res.data.origin_video.main_url);
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-icon-video').val(res.data.video);
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-icon-image').val(res.data.thumbnail);
                        $('.icon_featured[data-key="'+icon_edit+'"]').find('.js-part-icon').html(appendEditData);
                      }
                      
                    }                    
                  } else {
                      alert('Xảy ra lỗi trong quá trình upload vui lòng thử lại.');
                      reject(false);
                  }
              }).catch(function (error) {
                  console.log('error',error);
                  $('.load-wrapp').hide();
              }).finally(function () {
                  is_busy = false;
                  $('.load-wrapp').hide();
              });
      };
      fileReader.readAsDataURL(file);
  }

  function uploadTempVideo(file) {
      var addvideo = new FormData();
      addvideo.set('video', file, file.name);
      return $.ajax({
          headers: {
              'Authorization': "Bearer "+ token,
          },
          withCredentials: true,
          url: SERVER_OPTIMIZE_URL + 'upload-video-content',
          processData: false,
          contentType: false,
          data: addvideo,
          type: 'POST',
          dataType : 'json'
      });
  }

  function uploadTempImage(file) {
      var addimage = new FormData();
      addimage.set('image', file, file.name);
      addimage.set('crop', 1);
      return $.ajax({
          headers: {
              'Authorization': "Bearer "+ token,
          },
          withCredentials: true,
          url: SERVER_OPTIMIZE_URL + 'upload-image-content',
          processData: false,
          contentType: false,
          data: addimage,
          type: 'POST',
          dataType : 'json'
      });
  }

  // step 01 get link
  


  $('body').on('click', '.js-link-submit', function (e) 
  {
      var link_preview = $('.js-input-link').val();

      var category_id = $('#category_id').val();

      if (category_id == '') 
      {
        alert('Vui lòng chọn chuyên mục.');
        return false;
      }

      if (link_preview) 
      {
          $.ajax({
              url: '/azi-admin/entertainment-link/get-link-preview',
              type: 'POST',
              dataType: 'json',
              async:true,
              data: {link: link_preview},
              beforeSend: function (){
                $('.load-wrapp').show();
              }
          })
          .done(function(response) {
              if (response.status == 1) 
              {
                  $('.js-get-link').val(link_preview);
                  $('.js-get-title-main').val(response.data.title);
                  $('.js-get-description-main').val(response.data.description);
                  if (response.data.image) 
                  { 
                    const options = { method: 'GET' };     
                    fetch('https://cors-anywhere.herokuapp.com/'+response.data.image, options)
                    .then(res => res.ok ? res.blob() : Promise.reject({err: res}))
                    .then(blob => {
                      var name_image = response.data.image.substring(response.data.image.lastIndexOf('/')+1);
                      var addimage = new FormData();
                      addimage.set('image', blob, name_image);
                      addimage.set('crop', 1);
                      $.ajax({
                          headers: {
                              'Authorization': "Bearer "+ token,
                          },
                          withCredentials: true,
                          url: SERVER_OPTIMIZE_URL +'upload-image-content',
                          processData: false,
                          contentType: false,
                          async:false,
                          data: addimage,
                          type: 'POST',
                          dataType : 'json',
                          success:function(res){
                              if(res && typeof res.status !== 'undefined' && res.status == 1)
                              {
                                $('input[name="block[0][object][0][data][0][image]"]').val(res.data.original);
                                $('.js-first-slider').attr('src', res.data.original_image.main_url);
                                
                                $('.js-step-01').hide();
                                $('.js-step-02').show();
                                setTimeout(function(){ $('.js-addSlider').slick('refresh'); }, 0);
                              }
                          }
                      })
                      .always(function(response) {
                        $('.load-wrapp').hide();
                      });
                    }).catch(error => {
                      fetch(response.data.image, options)
                      .then(res => res.ok ? res.blob() : Promise.reject({err: res}))
                      .then(blob => {
                        var name_image = response.data.image.substring(response.data.image.lastIndexOf('/')+1);
                        var addimage = new FormData();
                        addimage.set('image', blob, name_image);
                        addimage.set('crop', 1);
                        $.ajax({
                            headers: {
                                'Authorization': "Bearer "+ token,
                            },
                            withCredentials: true,
                            url: SERVER_OPTIMIZE_URL +'upload-image-content',
                            processData: false,
                            contentType: false,
                            async:false,
                            data: addimage,
                            type: 'POST',
                            dataType : 'json',
                            success:function(res){
                                if(res && typeof res.status !== 'undefined' && res.status == 1)
                                {
                                  $('input[name="block[0][object][0][data][0][image]"]').val(res.data.original);
                                  $('.js-first-slider').attr('src', res.data.original_image.main_url);
                                  
                                  $('.js-step-01').hide();
                                  $('.js-step-02').show();
                                  setTimeout(function(){ $('.js-addSlider').slick('refresh'); }, 0);
                                }
                            }
                        })
                        .always(function(response) {
                          $('.load-wrapp').hide();
                        });
                      }).catch(error => {
                        $('.load-wrapp').hide();
                      });
                    });
                  } 
                  else 
                  {
                    $('.load-wrapp').hide();
                  }
              } 
              else if (response.status == 0) 
              {
                alert('Can not get info of link.');
              }

          });
      }
  });

  // get district
  $("#link_province").on('change', function() {
      if ($("#link_province").val() != 0) {
        $.ajax({
            url: siteUrl + 'ajax_district',
            type: "POST",
            data: {province_id: $("#link_province").val()},
            success: function (response) {
              if (response) {
                var json = JSON.parse(response);
                var html_option = '<option value="0">Chọn quận/huyện</option>';
                $(json).each(function(at, item){
                  html_option += '<option value="'+item.id+'">'+item.DistrictName+'</option>';
                });
                $('#link_district').html(html_option);
                delete json;
              } else {
                alert("Lỗi! Vui lòng thử lại");
              }
            },
            error: function () {
              alert("Lỗi! Vui lòng thử lại");
            }
        });
      }
  });

  // remove item slider
  $('body').on('click', '.js-remove-item-slider', function(e) {
      var slick_index = $( this ).closest( '.slick-slide' ).attr('data-slick-index');
      var key_slider = $('.js-addSlider li').length;
      if (key_slider > 2) 
      { 
        if ( parseInt(slick_index) + 2 ==  key_slider) 
        {
          $( this ).closest( '.slick-slide' ).remove();
        } 
        else 
        {
          $('.js-addSlider').slick('slickRemove', slick_index).slick('refresh');
        }
      } 
      else
      {
        alert('Cần ít nhất 1 hình ảnh hoặc video.');
      }      
  });

  // submit form
  $('.js-add-link').click(function() {
      $('.js-form-add-link').submit();
  });

  $('.js-form-add-link').submit(function() {
    
    var item_slider_link = $('.js-addSlider .item-slider-link');
    var v_title = $('.js-get-title-main').val();
    if ($.trim(v_title) == '') 
    {
      alert('Tiêu đề không được rỗng.');
      return false;
    }

    var v_description = $('.js-get-description-main').val();
    if ($.trim(v_description) == '') 
    {
      alert('Nội dung không được rỗng.');
      return false;
    }

    $.each(item_slider_link, function( index, value ) {
        var get_image = $(this).find('.js-image-lib');
        $(get_image).attr('name', 'block[0][object][0][data]['+index+'][image]');

        var get_video = $(this).find('.js-video-lib');
        $(get_video).attr('name', 'block[0][object][0][data]['+index+'][video]');
    });

    // icon
    var title_icon = $('.js-icon-title');
    var des_icon = $('.js-icon-description');
    var sms_icon_title = '';
    $.each(title_icon, function( index, value ) {
        if ($.trim($(this).val()) == '') 
        {
          sms_icon_title = 'Tiêu đề biểu tượng nổi bật không được rỗng.\n';
          return false;
        }
    });

    var sms_icon_des = '';
    $.each(des_icon, function( index, value ) {
        if ($.trim($(this).val()) == '') 
        {
          sms_icon_des = 'Nội dung biểu tượng nổi bật không được rỗng.';
          return false;
        }
    });
    if (sms_icon_title != '' || sms_icon_des !='') 
    {
      alert(sms_icon_title + sms_icon_des);
      return false;
    }

    var list_icon = $('.js-swap-icon .icon_featured');
    if (list_icon.length == 0) 
    {
      $('.js-main-type-icon').remove();
    }


  });


  // ICON FUNCTION
  $('.js-add-icon').click(function() {
      $('#js-icon-file').click();
  });

  $('.js-icon-align').click(function() {
      $('.js-icon-align.active').removeClass('active');
      $(this).addClass('active');
      if (icon_edit != '') 
      {
        var align = $(this).attr('data-value');
        if (align == 1) 
        {
          $('.icon_featured[data-key="'+icon_edit+'"]').removeClass('block-left block-right').addClass('block-center');
        }
        else if (align == 2) 
        {
          $('.icon_featured[data-key="'+icon_edit+'"]').removeClass('block-left block-center').addClass('block-right');
        }
        else 
        {
          $('.icon_featured[data-key="'+icon_edit+'"]').removeClass('block-center block-right').addClass('block-left');
        }
        
      }
  });

  $(document).on("change","#js-icon-file",function(event) {
      var files = event.target.files;
      if (files.length > 0) 
      {
        $('.load-wrapp').show();
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (image_type.indexOf(file.type) != -1)
            { 
                renderFileImage(file, 'icon');
                continue;
            }
            
            if (file.type == 'video/mp4') 
            {   
              if(file.size > 524288000) 
              {
                  showError('<p>Vui lòng chọn video dưới 500M</p>');
              }
              else 
              {
                  renderFileVideo(file, 'icon');
              }
              continue;
            }
        }
      }
  });

  $('body').on('click', '.js-remove-icon', function() {
      $(this).closest('.icon_featured').remove();
      var list_icon = $('.js-swap-icon').find('.icon_featured');
      $.each(list_icon, function( index, value ) {
        var get_video = $(this).find('.js-icon-video');
        $(get_video).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][video]');

        var get_image = $(this).find('.js-icon-image');
        $(get_image).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][image]');

        var get_position = $(this).find('.js-icon-position');
        $(get_position).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][position]');

        var get_effect = $(this).find('.js-icon-effect');
        $(get_effect).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][effect]');

        var get_title = $(this).find('.js-icon-title');
        $(get_title).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][title]');

        var get_description = $(this).find('.js-icon-description');
        $(get_description).attr('name', 'block['+block_id+'][object]['+object_id+'][data]['+index+'][description]');

      });
  });

  $('body').on('click', '.js-edit-icon', function() {
      if ($(this).hasClass('edit')) 
      {
        icon_edit = '';
        $(this).text('Chỉnh sửa');
        $(this).removeClass('edit');
      } 
      else 
      {
        var icon_edit_current = $('.js-edit-icon.edit').removeClass('edit');
        $(icon_edit_current).text('Chỉnh sửa');
        icon_edit = $(this).attr('data-key');
        $(this).text('Xong');
        $(this).addClass('edit');
        var element_icon_edit = $(this).closest('.icon_featured');
        var effect_val = $(element_icon_edit).find('.js-icon-effect').val();
        var position_val = $(element_icon_edit).find('.js-icon-position').val();
        $('.js-select-icon-effect').val(effect_val);
        $('.js-icon-align').removeClass('active');
        $('.js-icon-align[data-value="'+position_val+'"]').addClass('active');
      }
  });

</script>
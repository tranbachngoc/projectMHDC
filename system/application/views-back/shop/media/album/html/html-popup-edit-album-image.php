<script>
 var id_image_avatar = 0;
</script>
<!-- popup edit album -->
<div class="modal creatNewAlbum js-edit-album-img" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-size-xl modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div class="creatNewAlbum-title">
          <h4 class="modal-title">Sửa album</h4>
          <div class="buttons-steps">
            <p class="style js-open-edit-lib-img">Ảnh từ thư viện</p>
            <label class="style">
              <span class="input-txt">Thêm ảnh</span>
              <input type="file" name="edit_img_upload" multiple accept="image/*">
            </label>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body fixed-body-sm">
        <div class="creatNewAlbum-content">
          <div class="creatNewAlbum-scroll-sm">
            <div class="nameAlbum">
              <form>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Tên album" name="edit_album_name" value="<?=$album_info->album_name?>">
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="2" placeholder="Thêm mô tả (tùy chọn)" name="edit_album_des"><?=$album_info->album_description?></textarea>
                </div>
              </form>
            </div>
            <div class="showImagesAlbum">
              <?php foreach ($album_items as $key => $item) {
                $this->load->view('shop/media/album/html/edit-item-in-library', ['item'=>$item,'album_info'=>$album_info]);
              }?>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal body -->
      <!-- Modal footer -->
      <div class="modal-footer fixed-footer-sm">
        <div class="shareModal-footer">
          <div class="permision">
            <p>
              <label>
                <!-- <input type="radio" name="category" value="aaa" checked="checked"> -->
                <span class="show-permision"><?=($album_info->album_permission == PERMISSION_SOCIAL_PUBLIC ? 'Công khai'
                : ($album_info->album_permission == PERMISSION_SOCIAL_FRIEND ? 'Bạn bè'
                : ($album_info->album_permission == PERMISSION_SOCIAL_ME ? 'Chỉ mình tôi' : '')))?></span>
              </label>
              <i class="fa fa-angle-down"></i>
            </p>
            <div class="permision-list">
              <ul class="item-check">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="edit_album_permission" value="3" data-text="Chỉ mình tôi" <?=$album_info->album_permission == PERMISSION_SOCIAL_ME ? 'checked' : ''?>>
                    <span>Chỉ mình tôi</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="edit_album_permission" value="1" data-text="Công khai" <?=$album_info->album_permission == PERMISSION_SOCIAL_PUBLIC ? 'checked' : ''?>>
                    <span>Công khai</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-edit-popup-album-cancel">Hủy</button>
            <button class="btn-share js-edit-popup-album-img-update">Cập nhật</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<!-- popup load library for edit album -->
<div class="modal creatNewAlbum js-edit-popup-select-library" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-size-xl modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div class="creatNewAlbum-title">
          <h4 class="modal-title">Ảnh từ thư viện</h4>
          <div class="buttons-steps">
            <p class="style js-edit-filter-content" data-page="1">Bài viết</p>
            <p class="style no-bg js-edit-filter-upload" data-page="1">Tự đăng</p>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body fixed-body-sm">
        <div class="creatNewAlbum-content selectNewAlbumFromLibrary-content">
          <div class="showImagesAlbum edit-block-content" data-page="1" style="display:flex">
            <?php foreach ($lib_images_content as $key => $item) { 
              if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
                $image_title       = trim($item->img_library_title);
              } else {
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/1x1_' . $item->name;
                $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
              }
              list($width, $height) = getimagesize($image_url);
              $class_css = $width > $height ? "img-vertical" : "img-horizontal";

              $checked = false;
              if( count($key_imgs) > 0 && in_array($item->id,$key_imgs) ) {
                $checked = true;
              }
              ?>
            <div class="col-item js-item-click-check" 
                data-check="<?=$item->id?>" 
                data-selected="<?=$checked == true ? 'true' : 'false'?>" 
                data-img="<?=$image_url?>"
                data-imgtitle="<?=$image_title?>"
                data-imgupdetect="<?=$item->img_up_detect?>">
              <div class="item">
                <div class="img">
                  <img src="<?=$image_url?>" class="up-img <?=$class_css?>" alt="">
                  <div class="icon-checked">
                    <?php if($checked == true) { ?>
                      <img src="/templates/home/styles/images/svg/checked.svg" alt="">
                    <?php } else { ?>
                      <img src="/templates/home/styles/images/svg/check.svg" alt="">
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="showImagesAlbum edit-block-upload" data-page="1" style="display:none">
            <?php foreach ($lib_images_upload as $key => $item) { 
              if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
                $image_title       = trim($item->img_library_title);
              } else {
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/1x1_' . $item->name;
                $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
              }
              list($width, $height) = getimagesize($image_url);
              $class_css = $width > $height ? "img-vertical" : "img-horizontal";

              $checked = false;
              if( count($key_imgs) > 0 && in_array($item->id,$key_imgs) ) {
                $checked = true;
              }
              ?>
            <div class="col-item js-item-click-check" 
                data-check="<?=$item->id?>" 
                data-selected="<?=$checked == true ? 'true' : 'false'?>" 
                data-img="<?=$image_url?>"
                data-imgtitle="<?=$image_title?>"
                data-imgupdetect="<?=$item->img_up_detect?>">
              <div class="item">
                <div class="img">
                  <img src="<?=$image_url?>" class="up-img <?=$class_css?>" alt="">
                  <div class="icon-checked">
                    <?php if($checked == true) { ?>
                      <img src="/templates/home/styles/images/svg/checked.svg" alt="">
                    <?php } else { ?>
                      <img src="/templates/home/styles/images/svg/check.svg" alt="">
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- End Modal body -->
      <!-- Modal footer -->
      <div class="modal-footer fixed-footer-sm">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-edit-popup-select-library-cancel">Hủy</button>
            <button class="btn-share js-edit-popup-select-library-select">Xác nhận</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<script type="text/template" id="edit-item-img-selected">
<div class="col-item">
  <div class="item">
    <div class="img">
      <img src="{{data_editSrc}}" class="up-img data-image-upload" alt=""
      data-editId = "{{data_editId}}"
      data-editDetectLib = "{{data_editDetectLib}}"
      data-editImageUpload = "{{data_editImageUpload}}"
      data-editIndex = "{{data_editIndex}}">
      <div class="action">
        <p class="act-setavatar" 
            data-editAvatar="{{data_editAvatar}}" 
            data-editFrom="{{data_editFrom}}" 
            data-editSetavatar="false">
          <img src="/templates/home/styles/images/svg/album_ico_setting.svg" alt="">
        </p>
        <p class="act-close">
          <img src="/templates/home/styles/images/svg/album_ico_close.svg" alt="">
        </p>
      </div>
    </div>
    <div class="txt">
      <div class="form-group">
        <textarea {{data_editDisable}} class="form-control" rows="2" placeholder="Tiêu đề (tùy chọn)">{{data_editTitle}}</textarea>
      </div>
    </div>
  </div>
</div>
</script>

<script>

  //////////////////////////////////////////////////////////////////////////
  /*
  // chỉnh sữa Album ẢNH
  // .js-edit-album-img popup edit album
  */
  var edit_data_current_img_id = JSON.parse('<?=json_encode($key_imgs)?>'); // array key img edit in album

  var edit_data_img_will_remove = []; // data process || array id_image sẽ remove
  var edit_data_img_will_add = []; // data process || array id_sẽ add
  var __edit_data_img_will_add = []; // data process || array object add ra ngoài
  var __edit_data_current_img_id = edit_data_current_img_id // data process || array key img edit sau khi thay đổi

  var edit_data_input = []; // data post || lưu hình up lên từ thiết bị
  var edit_data_image_from_lib = []; // data post || lưu hình up + title update, hình này được chọn từ library mà đã đc up lên từ thiết bị lúc tạo library
  var edit_data_update_list_img_key = []; // data post || chứa tất cả key id chọn từ library cuối cùng [Set data = __edit_data_current_img_id]

  // id_image_avatar lấy từ views\shop\media\album\html\edit-item-in-library.php
  var edit_max_file_upload = 30;
  var edit_album_ava = id_image_avatar;
  var edit_album_from = 'library';
  var edit_album_permission = '<?=$album_info->album_permission?>';
  var edit_album_name = '<?=$album_info->album_name?>';
  var edit_album_id = '<?=$album_info->album_id?>';
  var edit_album_des = '<?=$album_info->album_description?>';
  var edit_album_type = '<?=$album_info->album_type?>';
  var edit_css_select = {
    'border': '1px solid red',
    'border-radius': '5px'
  };
  var edit_css_not_select = {
    'border': 'none',
    'border-radius': 'none'
  };

  // close pop edit album
  $('.js-edit-album-img .js-edit-popup-album-cancel').click(function () {
    $('body').removeClass('fixed-modal-ios');
    $('.js-edit-album-img').modal('hide');
  });

  // thay đổi permision của album
  $('.js-edit-album-img input[name="edit_album_permission"]').change(function () {
    edit_album_permission = $(this).val();
    var text = $(this).attr('data-text');
    $('.js-edit-album-img .permision span.show-permision').text(text);
  });

  // thay đổi tên của album
  $('.js-edit-album-img input[name="edit_album_name"]').change(function () {
    edit_album_name = $(this).val();
  });

  // thay đổi descripton của album
  $('.js-edit-album-img textarea[name="edit_album_des"]').change(function () {
    edit_album_des = $(this).val();
  });

  // thay đổi chọn ảnh đại diện album
  $('.js-edit-album-img').on('click', '.act-setavatar', function () {
    if ($(this).attr('data-editSetavatar') == 'false') {
      edit_album_ava = $(this).attr('data-editAvatar');
      edit_album_from = $(this).attr('data-editFrom');
      $('.js-edit-album-img').find('.act-setavatar').hide();
      $(this).show();
      $(this).attr('data-editSetavatar', 'true');
      $(this).closest('.action').find('.act-close').hide();

      // css cho hình được chọn làm ảnh album
      $(this).closest("div.img").css(edit_css_select);
    } else {
      edit_album_ava = edit_album_from = '';
      $('.js-edit-album-img').find('.act-setavatar').show();
      $(this).attr('data-editSetavatar', 'false');
      $(this).closest('.action').find('.act-close').show();

      // remove css cho hình được chọn làm ảnh album
      $(this).closest("div.img").css(edit_css_not_select);
    }

  })

  // xóa ảnh được chọn để chuẩn bị update bộ sưu tập
  $('.js-edit-album-img').on('click', '.act-close', function () {
    var item = $(this).closest(".col-item");
    // xóa item được up lên từ thiết bị
    if ($(item).find('.data-image-upload').attr('data-editid') === 'false' && $(item).find('.data-image-upload').attr('data-editIndex') !== 'false') {
      var index = $(item).find('.data-image-upload').attr('data-editindex');
      delete edit_data_input[index];
      edit_max_file_upload++;
    }
    // xóa item img trong library
    else {
      var key = $(item).find('.data-image-upload').attr('data-editid');
      var id = __edit_data_current_img_id.indexOf(key);
      __edit_data_current_img_id.splice(id, 1);
    }

    $(item).remove();
  });

  //up ảnh khi edit
  $('.js-edit-album-img input[name="edit_img_upload"]').change(function (event) {
    function readAndPreview(file, i, max_i) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var formData = new FormData();
        formData.set('image', file, file.name);
        $.ajax({
          type: "post",
          url: siteUrl + "library/album-image/upImage",
          data: formData,
          processData: false,
          contentType: false,
          success:function(data){
            if(i == max_i -1){
              $('.load-wrapp').hide();
            }
            data = JSON.parse(data);
            if(data.error == false) {
              edit_data_input[index] = {
                dataImg: data.image_name,
                dataImg_w: data.image_w,
                dataImg_h: data.image_h,
                dataType: data.image_type,
                };
              var appendEditData = templateHtml
              .replace('{{data_editSrc}}', data.image_url)
              .replace('{{data_editId}}', 'false')
              .replace('{{data_editDetectLib}}', 'false')
              .replace('{{data_editImageUpload}}', data.image_name)
              .replace('{{data_editAvatar}}', data.image_name)
              .replace('{{data_editFrom}}', 'input')
              .replace('{{data_editDisable}}', '')
              .replace('{{data_editTitle}}', '')
              .replace('{{data_editIndex}}', index);

              $('.js-edit-album-img .showImagesAlbum').prepend(appendEditData)
              index++;
              edit_max_file_upload--;
            } else {
              alert(data.message);
            }
          }
        });
      }
      reader.readAsDataURL(file);
    }

    var templateHtml = $('#edit-item-img-selected').html();
    var listFile = this.files;
    if (listFile && listFile[0] && listFile.length <= edit_max_file_upload) {
      $('.load-wrapp').show();
      for (var i = 0; i < listFile.length; i++) {
        readAndPreview(listFile[i], i, listFile.length);
      }
      $(this).val('');
      reset_edit_set_avatar();
    } else {
      alert('số lượng hình có thể tải lên ' + edit_max_file_upload);
      event.stopPropagation();
    }
  });

  // update album edit
  $('.js-edit-album-img .js-edit-popup-album-img-update').click(function () {
    $('.load-wrapp').show();

    // validate
    if (isBlank(edit_album_ava)) {
      alert("Tên album không được trống");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    if (isBlank(edit_album_ava) || isBlank(edit_album_from)) {
      alert("Chưa chọn ảnh đại diện album");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }

    var items = $('.js-edit-album-img').find('.showImagesAlbum .col-item');
    if (items.length > 0) {
      items.each(function (index, value) {
        // ảnh từ up lên từ thiết bị
        console.log('detect',$(value).find('.data-image-upload').attr('data-editdetectlib'));
        console.log('index', $(value).find('.data-image-upload').attr('data-editindex'));

        if($(value).find('.data-image-upload').attr('data-editdetectlib') === 'false' 
          && $(value).find('.data-image-upload').attr('data-editindex') !== 'false') 
        {
          var key = $(value).find('.data-image-upload').attr('data-editindex');
          var title = $(value).find('textarea').val();
          edit_data_input[key].dataTitle = title;
        }
        // ảnh trong library và đc up lên từ thiết bị
        else if( $(value).find('.data-image-upload').attr('data-editdetectlib') === '<?=IMAGE_UP_DETECT_LIBRARY?>' 
          && $(value).find('.data-image-upload').attr('data-editindex') === 'false')
        {
          var temp = {
            'id': $(value).find('.data-image-upload').attr('data-editid'),
            'title': $(value).find('textarea').val()
          }
          edit_data_image_from_lib.push(temp);
        }
        else if( $(value).find('.data-image-upload').attr('data-editdetectlib') === '<?=IMAGE_UP_DETECT_CONTENT?>' 
          && $(value).find('.data-image-upload').attr('data-editindex') === 'false')
        {
          // don't do anythings
        }
        else {
          alert("Error Connection!!!");
          $('.load-wrapp').hide();
          event.stopPropagation();
          return false;
        }
      })
    } else {
      alert("Chưa có ảnh trong album");
      $('.load-wrapp').hide();
      event.stopPropagation();
      return false;
    }
    edit_data_update_list_img_key = __edit_data_current_img_id;

    // rebuild data
    edit_data_input = edit_data_input.filter(function (item) {
      return item;
    })
    edit_data_image_from_lib = edit_data_image_from_lib.filter(function (item) {
      return item;
    })
    edit_data_update_list_img_key = edit_data_update_list_img_key.filter(function (item) {
      return item;
    })


    var edit_formData = new FormData();
    edit_formData.append('album_id', edit_album_id);
    edit_formData.append('album_ava', edit_album_ava);
    edit_formData.append('album_from', edit_album_from);
    edit_formData.append('album_name', edit_album_name);
    edit_formData.append('album_des', edit_album_des);
    edit_formData.append('album_permission', edit_album_permission);
    edit_formData.append('album_type', edit_album_type);
    edit_formData.append('data_input', JSON.stringify(edit_data_input));
    edit_formData.append('data_img_update', JSON.stringify(edit_data_image_from_lib));
    edit_formData.append('data_key_img', JSON.stringify(edit_data_update_list_img_key));

    $.ajax({
      type: "post",
      url: siteUrl + "library/album-image/update",
      data: edit_formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if(response == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  })

  // load popup select library
  $('.js-edit-album-img').on('click', '.js-open-edit-lib-img', function () {
    $('.js-edit-album-img').modal('hide');
    $('.js-edit-popup-select-library').modal('show');
  })

  // check - uncheck hinh trong library ảnh để edit
  $('.js-edit-popup-select-library').on('click', '.js-item-click-check', function () {
    var selected = $(this).attr('data-selected');
    var id_img = $(this).attr('data-check');
    if (selected === 'false') {
      // select add || thao tác này trong library edit
      if(edit_data_img_will_add.indexOf(id_img) === -1){ // kt xem id đã có trong data sẽ update
        // không có trong data thì push
        edit_data_img_will_add.push(id_img);
        var data_img = {
          id: $(this).attr('data-check'),
          image: $(this).attr('data-img'),
          title: $(this).attr('data-imgtitle'),
          imgdetect: $(this).attr('data-imgupdetect'),
        }
        __edit_data_img_will_add[id_img] = data_img;
      }
      if(edit_data_img_will_remove.indexOf(id_img) !== -1){ // kt xem id đã có trong data sẽ remove
        // có trong data thì remove
        edit_data_img_will_remove.splice(edit_data_img_will_remove.indexOf(id_img), 1);
      }
      $(this).attr('data-selected', 'true');
      $(this).find('.icon-checked img').attr('src', '/templates/home/styles/images/svg/checked.svg');
    } else if (selected === 'true') {
      // select remove
      if(edit_data_img_will_remove.indexOf(id_img) === -1){ // kt xem id đã có trong data sẽ remove
        // không có trong data thì push
        edit_data_img_will_remove.push(id_img);
      }
      if(edit_data_img_will_add.indexOf(id_img) !== -1){ // kt xem id đã có trong data sẽ update
        // có trong data thì remove
        edit_data_img_will_add.splice(edit_data_img_will_add.indexOf(id_img), 1);
        delete __edit_data_img_will_add[id_img];
      }
      $(this).attr('data-selected', 'false');
      $(this).find('.icon-checked img').attr('src', '/templates/home/styles/images/svg/check.svg');
    }
  })

  // close popup select image lib for edit album
  $('.js-edit-popup-select-library').on('click', '.js-edit-popup-select-library-cancel', function () {
    $('.js-edit-popup-select-library').modal('hide');
    $('.js-edit-album-img').modal('show');
  })

  // close popup select image lib for edit album
  $('.js-edit-popup-select-library').on('click', '.js-edit-popup-select-library-select', function () {
    $('.load-wrapp').show();

    // rebuild data trong library để update (data này chỉ chứa id image trong thư viện)
    edit_data_img_will_add.forEach(function(item, index) {
      var new_i = __edit_data_current_img_id.length + 1;
      __edit_data_current_img_id[new_i] = item;
    });
    __edit_data_current_img_id.forEach(function(item, index) {
      //check __edit_data_current_img_id item trong array will remove, có = remove
      if( $.inArray( item , edit_data_img_will_remove ) !== -1 ) {
        delete __edit_data_current_img_id[index];
      }
    });
    // end rebuild data

    // rebuild data
    __edit_data_current_img_id = __edit_data_current_img_id.filter(function (item) {
      return item;
    })
    __edit_data_img_will_add = __edit_data_img_will_add.filter(function (item) {
      return item;
    })
    // end rebuild data

    // remove img mà id image có trong edit_data_img_will_remove
    var element = $('.js-edit-album-img .showImagesAlbum').find('.col-item');
    if (element.length > 0) {
      element.each(function (index, value) {
        var item = $(value).find('.data-image-upload');
        if ( (item.attr('data-editdetectlib') == 1 || item.attr('data-editdetectlib') == 0 )
        &&  (edit_data_img_will_remove.indexOf(item.attr('data-editid')) !== -1) )
        {
          $(value).remove();
        }
      });
    }
    // thêm item có trong __edit_data_img_will_add
    __edit_data_img_will_add.forEach(function(item, index) {
      var template = $('#edit-item-img-selected').html();
      var disabled = 'disabled';
      console.log('item',item);
      if(item.imgdetect == '<?=IMAGE_UP_DETECT_LIBRARY?>') {
        disabled = '';
      }
      $('.js-edit-album-img .showImagesAlbum').prepend(template
        .replace('{{data_editSrc}}', item.image)
        .replace('{{data_editSize}}', 'false')
        .replace('{{data_editId}}', item.id)
        .replace('{{data_editDetectLib}}', item.imgdetect)
        .replace('{{data_editImageUpload}}', 'false')
        .replace('{{data_editAvatar}}', item.id)
        .replace('{{data_editFrom}}', 'library')
        .replace('{{data_editDisable}}', disabled)
        .replace('{{data_editTitle}}', item.title)
        .replace('{{data_editIndex}}', 'false')
        )
    })

    $('.js-edit-popup-select-library').modal('hide');
    $('.js-edit-album-img').modal('show');
    reset_edit_set_avatar();
    $('.load-wrapp').hide();

  })

  // scroll append data pop library
  var __edit_is_busy = false;
  var __edit_stopped = false;
  $('.js-edit-popup-select-library .edit-block-content').scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.col-item').height() >= $(this).height()) {
      var __edit_page = parseInt($(this).attr('data-page')) ;
      if (__edit_is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__edit_stopped == true) {
        event.stopPropagation();
        return false;
      }
      //   $loadding.removeClass('hidden');
      __edit_is_busy = true;
      __edit_page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: siteUrl + 'library/album-image/load-img-lib',
        data: { page: __edit_page , album_id: edit_album_id, typeIMG: '<?=IMAGE_UP_DETECT_CONTENT?>'},
        success: function (result) {
          // console.log(result);

          // $loadding.addClass('hidden');
          if (result == '') {
            __edit_stopped = true;
          }
          if (result) {
            $('.js-edit-popup-select-library .edit-block-content').append(result);
            $('.js-edit-popup-select-library .edit-block-content').attr('data-page',__edit_page);
          }
        }
      }).always(function () {
        __edit_is_busy = false;
      });
      return false;
    }
  });

  $('.js-edit-popup-select-library .edit-block-upload').scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.col-item').height() >= $(this).height()) {
      var __edit_page = parseInt($(this).attr('data-page')) ;
      if (__edit_is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__edit_stopped == true) {
        event.stopPropagation();
        return false;
      }
      //   $loadding.removeClass('hidden');
      __edit_is_busy = true;
      __edit_page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: siteUrl + 'library/album-image/load-img-lib',
        data: { page: __edit_page , album_id: edit_album_id, typeIMG: '<?=IMAGE_UP_DETECT_LIBRARY?>'},
        success: function (result) {
          // console.log(result);

          // $loadding.addClass('hidden');
          if (result == '') {
            __edit_stopped = true;
          }
          if (result) {
            $('.js-edit-popup-select-library .edit-block-upload').append(result);
            $('.js-edit-popup-select-library .edit-block-upload').attr('data-page',__edit_page);
          }
        }
      }).always(function () {
        __edit_is_busy = false;
      });
      return false;
    }
  });

  // show/hide div
  $('.js-edit-popup-select-library').on('click', '.js-edit-filter-content', function () {
    if($(this).hasClass('no-bg')) {
      $(this).removeClass('no-bg');
      $(this).next().addClass('no-bg');
    }
    $('.edit-block-content').css({'display': 'flex'});
    $('.edit-block-upload').css({'display': 'none'});
    __edit_is_busy = false;
    __edit_stopped = false;
  })

  $('.js-edit-popup-select-library').on('click', '.js-edit-filter-upload', function () {
    if($(this).hasClass('no-bg')) {
      $(this).removeClass('no-bg');
      $(this).prev().addClass('no-bg');
    }
    $('.edit-block-content').css({'display': 'none'});
    $('.edit-block-upload').css({'display': 'flex'});
    __edit_is_busy = false;
    __edit_stopped = false;
  })

  function reset_edit_set_avatar() {
    edit_data_img_will_remove = []; // array id_image sẽ remove
    edit_data_img_will_add = []; // array id_sẽ add
    __edit_data_img_will_add = []; // array object add ra ngoài
    $('.js-edit-album-img .showImagesAlbum .col-item .action .act-setavatar').show();
    $('.js-edit-album-img .showImagesAlbum .col-item .action .act-setavatar').attr('data-editsetavatar','false')
    $('.js-edit-album-img .showImagesAlbum .col-item .action .act-close').show();
    $('.js-edit-album-img .showImagesAlbum .col-item div.img').css(edit_css_not_select);
  }
</script>
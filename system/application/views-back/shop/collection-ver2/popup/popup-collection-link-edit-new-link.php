<div class="modal bst-modal creatNewAlbum" id="pu-edit-custom-link">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div style="display:inline" class="add-more-txt">
          <h4 class="modal-title">Sửa liên kết
            <!-- <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span> -->
          </h4>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body fixed-body-sm">
        <div class="fixed-body-sm-content">
          <div class="fixed-body-sm-content-scroll js-append-html">
            <!-- APPEND DATA -->
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group fixed-footer-sm">
        <button type="button" class="btn btn-bg-gray js-edit-btn_save">Cập nhật</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
  var u_link = u_title = u_description = u_cate_link_id = u_image = u_video = u_mime = u_img_width = u_img_height = u_id = u_type = null;
  var u_collection = [];
  var u_orientation = u_img_width = u_img_height = 0;
  var u_is_personal = <?=$is_personal?>;
  var u_is_public = 1;

  $('body').on('click', '.menu-edit-link', function () {
    u_link = u_title = u_description = u_cate_link_id = u_image = u_video = u_mime = u_img_width = u_img_height = u_id = u_type = null;
    u_collection = [];
    u_orientation = u_img_width = u_img_height = 0;
    u_is_personal = <?=$is_personal?>;

    u_id = $(this).attr('data-id');
    u_type = $(this).attr('data-link_type');
    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_link/get_link'?>",
      data: {id: u_id, type: u_type},
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
        $('.modal').modal('hide');
      },
      success: function (response) {
        if(response.status == 1) {
          var result = response.data;
          u_link = result.save_link;
          u_title = result.title;
          u_img_width = result.image_width;
          u_img_height = result.image_height;

          var src = result.image;
          var is_video = false;
          if(result.full_video_path != "") {
            is_video = true;
            src = result.full_video_path;
          } else if(result.full_image_path != "") {
            src = result.full_image_path;
          }

          if(is_video === true) {
            var html = $('#tpl-edit-link-video').html();
            $('#pu-edit-custom-link .js-append-html').html(html.replace('{{DATA_POSTER}}',result.full_image_path)
                                                        .replace('{{DATA_VIDEO}}',src)
                                                        .replace('{{DATA_TITLE}}',result.title)
                                                        .replace('{{DATA_DES}}',result.description)
                                                        .replace('{{DATA_CONTENT}}',result.content)
                                                        .replace('{{DATA_CHECKED}}', result.is_public == 1 ? '' : 'checked'));
          } else {
            var html = $('#tpl-edit-link-img').html();
            $('#pu-edit-custom-link .js-append-html').html(html.replace('{{DATA_IMG}}',src)
                                                        .replace('{{DATA_TITLE}}',result.title)
                                                        .replace('{{DATA_DES}}',result.description)
                                                        .replace('{{DATA_CONTENT}}',result.content)
                                                        .replace('{{DATA_CHECKED}}', result.is_public == 1 ? '' : 'checked'));
          }

          $.each(result.collections, function (i, e) {
            $('#pu-edit-custom-link select[name="collection_id"] option[value="'+e+'"]').attr('selected', true);
          })
          $('#pu-edit-custom-link select[name="category_link_parent_id"]').val(result.cate_id);
          if(result.cate_link_id == result.cate_id || result.cate_link_id == 0) {
            $('#pu-edit-custom-link select[name="category_link_child_id"]').val($('#pu-edit-custom-link select[name="category_link_child_id"] option:first').val());
          } else {
            $('#pu-edit-custom-link select[name="category_link_child_id"]').val(result.cate_link_id);
          }
          $('#pu-edit-custom-link select[name="category_link_child_id"] option.p_id_'+result.cate_id).show();

          $('#pu-edit-custom-link').modal('show');
        } else {
          alert("Không tìm thấy liên kết!!!");
        }
        $('.load-wrapp').hide();
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });
  })

  // trigger click input
  $('body').on('click','#pu-edit-custom-link .js-choose-file', function(){
    $('#pu-edit-custom-link .js-input input[name="file_input"]').trigger('click');
  });

  $('body').on('change', '#pu-edit-custom-link input[name="file_input"]', function () {
    var file = $(this)[0].files[0];
    var url = '';
    var flag = null;
    if(isFileImage(file) == true) {
      url = "<?=$shop_url.'home/api_common/up_image'?>";
      flag = true;
      var formData = new FormData();
      formData.append("image", file);
    } else {
      url = "<?=$shop_url.'home/api_common/up_video'?>";
      flag = false;
      var formData = new FormData();
      formData.append("video", file);
    }

    $.ajax({
      type: "POST",
      url: url,
      data: formData,
      processData: false,
      contentType: false,
      dataType:"json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.status == 1) {
          var result = response.data;
          if(flag == true) { // image
            u_image = result.original;
            var tpl = $('#element-image').html();
            $('#pu-edit-custom-link .__image-library-link').html(tpl.replace('{{DATA_IMG}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+u_image));

            var metaData = getMeta('<?=DOMAIN_CLOUDSERVER_PATH?>'+u_image);
            setTimeout(function () {
              u_mime = metaData.contentType;
              u_img_width = metaData.width;
              u_img_height = metaData.height;
            }, 1000);
          } else { // video
            u_image = result.thumbnail;
            u_video = result.video;
            var tpl = $('#element-video').html();
            $('#pu-edit-custom-link .__image-library-link').html(tpl.replace('{{DATA_POSTER}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+u_image)
                                                              .replace('{{DATA_VIDEO}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+u_video));

            var metaData = getMeta('<?=DOMAIN_CLOUDSERVER_PATH?>'+u_image);
            setTimeout(function () {
              u_mime = metaData.contentType;
              u_img_width = metaData.width;
              u_img_height = metaData.height;
            }, 1000);
          }
        } else {
          alert("Lỗi xử lý file!!!");
        }
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });
  })

  $('body').on('click', '#pu-edit-custom-link .js-edit-btn_save', function () {
    u_description = $('#pu-edit-custom-link textarea[name="description"]').val();
    if($('#pu-edit-custom-link select[name="category_link_child_id"]').val().length > 0) {
      u_cate_link_id = $('#pu-edit-custom-link select[name="category_link_child_id"]').val();
    } else if($('#pu-edit-custom-link select[name="category_link_parent_id"]').val().length > 0) {
      u_cate_link_id = $('#pu-edit-custom-link select[name="category_link_parent_id"]').val();
    } else {
      u_cate_link_id = 0;
    }

    u_collection = $('#pu-edit-custom-link select[name="collection_id"]').val();
    u_is_personal = $('#pu-edit-custom-link input[name="permission"]').val();

    if($('#pu-edit-custom-link input[name="isPublic"]:checked').length > 0) {
      u_is_public = 0;
    } else {
      u_is_public = 1;
    }

    var formData = new FormData();
    formData.append('id', u_id);
    formData.append('type', u_type);
    formData.append('link', u_link);
    formData.append('title', u_title);
    formData.append('description', u_description);
    formData.append('collection', u_collection);
    formData.append('cate_link_id', u_cate_link_id);
    formData.append('image', u_image);
    formData.append('video', u_video);
    formData.append('orientation', u_orientation);
    formData.append('mime', u_mime);
    formData.append('img_width', u_img_width);
    formData.append('img_height', u_img_height);
    formData.append('is_personal', u_is_personal);
    formData.append('is_public', u_is_public);

    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_link/update_link'?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType:"json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert("Lỗi xử lý file!!!");
        }
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });

  })
</script>

<script>
  // change selected
  $('body').on('change', '#pu-edit-custom-link select[name="category_link_parent_id"]', function () {
    var value = $(this).val();
    $('body').find('#pu-edit-custom-link select[name="category_link_child_id"] option.js-option-change').hide();
    $('body').find('#pu-edit-custom-link select[name="category_link_child_id"] option.p_id_'+value).show();
    $('body').find('#pu-edit-custom-link select[name="category_link_child_id"]').val('');
  })

  $('body').on('change', '#pu-edit-custom-link input[name="permission"]', function () {
    var value = $(this).val();
    if(value == 0) {
      $('body').find('#pu-edit-custom-link select[name="collection_id"] option.js_permission_1').hide();
    } else {
      $('body').find('#pu-edit-custom-link select[name="collection_id"] option.js_permission_0').hide();
    }
    $('body').find('#pu-edit-custom-link select[name="collection_id"] option.js_permission_'+value).show();
    $('body').find('#pu-edit-custom-link select[name="collection_id"]').val('');
  })
</script>

<script type="text/html" id="tpl-edit-link-img">
  <div class="form-group __image-library-link">
    <img class="reviewImg center js-choose-file" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
    <div class="wrap-block-custom-link">
      <img class="center" src="{{DATA_IMG}}">
    </div>
    <div class="hidden js-input">
      <input type="file" name="file_input">
    </div>
  </div>
  <div class="form-group">
    <input disabled type="text" autocomplete="off" name="custom_link_title" class="ten-bst-input" value="{{DATA_TITLE}}">
  </div>
  <div class="form-group">
    <textarea disabled class="form-control ten-bst-input" rows="3">{{DATA_DES}}</textarea>
  </div>
  <div class="form-group">
    <textarea class="form-control ten-bst-input" name="description" rows="3" placeholder="Nhập ghi chú" spellcheck="false">{{DATA_CONTENT}}</textarea>
  </div>
  <div class="form-group">
    <label class="checkbox-style-circle">
      <input type="radio" name="permission" value="1" class=""><span>Cá nhân</span>
    </label>
    <label class="checkbox-style-circle ml30">
      <input type="radio" name="permission" value="0" class="" checked ><span>Doanh nghiệp</span>
    </label>
  </div>
  <div class="form-group">
      <select class="select-category" name="collection_id" multiple>
          <option value="">Chọn bộ sưu tập liên kết</option>
          <optgroup label="Danh sách BST">
            <?php foreach ($popup_list_collection as $key => $item) { ?>
              <option class="js_permission_<?=$item['sho_id'] > 0 ? 0 : 1?>" value="<?=$item['id']?>" style="display:<?=$item['sho_id'] > 0 ? 'block' : 'none'?>" ><?=$item['name']?></option>
            <?php } ?>
          </optgroup>
      </select>
  </div>
  <div class="form-group">
      <select name="category_link_parent_id" class="select-category js-p-link">
        <option value="">Chọn chuyên mục liên kết</option>
        <?php foreach ($link_categories_p as $key => $item) { ?>
          <option value="<?=$item['id']?>"><?=$item['name']?></option>
        <?php } ?>
      </select>
  </div>
  <div class="form-group">
      <select name="category_link_child_id" class="select-category js-ch-link">
        <option value="">Chọn chuyên mục con</option>
        <?php foreach ($link_categories_ch as $key => $item) { ?>
          <option class="js-option-change p_id_<?=$item['parent_id']?>" value="<?=$item['id']?>" style="display:none"><?=$item['name']?></option>
        <?php } ?>
      </select>
      <p class="text-danger pl-4 js_category_child-msg"></p>
  </div>
  <div class="form-group">
    <label class="checkbox-style">
    <input type="checkbox" name="isPublic" value="0" class="" {{DATA_CHECKED}}><span>Bí mật</span>
    </label>
  </div>
</script>

<script type="text/html" id="tpl-edit-link-video">
  <div class="form-group __image-library-link">
    <img class="reviewImg center js-choose-file" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
    <div class="wrap-block-custom-link">
      <video poster="{{DATA_POSTER}}" playsinline preload="none" controls>
        <source src="{{DATA_VIDEO}}" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="hidden js-input">
      <input type="file" name="file_input">
    </div>
  </div>
  <div class="form-group">
    <input disabled type="text" autocomplete="off" name="custom_link_title" class="ten-bst-input" value="{{DATA_TITLE}}">
  </div>
  <div class="form-group">
    <textarea disabled class="form-control ten-bst-input" rows="3">{{DATA_DES}}</textarea>
  </div>
  <div class="form-group">
      <textarea class="form-control ten-bst-input" name="description" rows="3" placeholder="Nhập ghi chú" spellcheck="false"></textarea>
  </div>
  <div class="form-group">
    <label class="checkbox-style-circle">
      <input type="radio" name="permission" value="1" class=""><span>Cá nhân</span>
    </label>
    <label class="checkbox-style-circle ml30">
      <input type="radio" name="permission" value="0" class="" checked ><span>Doanh nghiệp</span>
    </label>
  </div>
  <div class="form-group">
    <select class="select-category" name="collection_id" multiple>
      <option value="">Chọn bộ sưu tập liên kết</option>
      <optgroup label="Danh sách BST">
        <?php foreach ($popup_list_collection as $key => $item) { ?>
          <option class="js_permission_<?=$item['sho_id'] > 0 ? 0 : 1?>" value="<?=$item['id']?>" style="display:<?=$item['sho_id'] > 0 ? 'block' : 'none'?>"><?=$item['name']?></option>
        <?php } ?>
      </optgroup>
    </select>
  </div>
  <div class="form-group">
      <select name="category_link_parent_id" class="select-category js-p-link">
        <option value="">Chọn chuyên mục liên kết</option>
        <?php foreach ($link_categories_p as $key => $item) { ?>
          <option value="<?=$item['id']?>"><?=$item['name']?></option>
        <?php } ?>
      </select>
  </div>
  <div class="form-group">
      <select name="category_link_child_id" class="select-category js-ch-link">
        <option value="">Chọn chuyên mục con</option>
        <?php foreach ($link_categories_ch as $key => $item) { ?>
          <option class="js-option-change p_id_<?=$item['parent_id']?>" value="<?=$item['id']?>" style="display:none"><?=$item['name']?></option>
        <?php } ?>
      </select>
      <p class="text-danger pl-4 js_category_child-msg"></p>
  </div>
  <div class="form-group">
    <label class="checkbox-style">
    <input type="checkbox" name="isPublic" value="0" class="" {{DATA_CHECKED}}><span>Bí mật</span>
    </label>
  </div>
</script>
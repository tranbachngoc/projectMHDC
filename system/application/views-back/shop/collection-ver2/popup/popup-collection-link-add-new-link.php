<div class="modal bst-modal" id="pu-add-custom-link">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div style="display:inline" class="add-more-txt">
          <h4 class="modal-title">Thêm link liên kết
            <!-- <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span> -->
          </h4>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body fixed-body-sm js-append-html">
        <div class="form-group">
          <input type="text" autocomplete="off" name="url_process" class="url-processed" placeholder="nhập url" value="">
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group fixed-footer-sm">
        <button type="button" class="btn btn-bg-gray js-add-btn_save">Xong</button>
        <button type="button" class="btn btn-bg-gray js-add-btn_process">Xử lý</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
  var link = title = description = cate_link_id = image = video = mime = img_width = img_height = null;
  var collection = [];
  var orientation = img_width = img_height = 0;
  var is_personal = <?=$is_personal?>;
  var is_public = 1;
  $('body').on('click', '.pu-add-custom-link', function () {
    link = title = description = cate_link_id = image = video = mime = img_width = img_height = null;
    collection = [];
    orientation = img_width = img_height = 0;
    is_personal = <?=$is_personal?>;
    is_public = 1;
    var html = '<div class="form-group">';
      html += '<input type="text" autocomplete="off" name="url_process" class="url-processed" placeholder="nhập url" value="">';
      html += '</div>';
    $('#pu-add-custom-link .js-append-html').html(html);
    $('#pu-add-custom-link .js-add-btn_save').hide();
    $('#pu-add-custom-link .js-add-btn_process').show();
    if($('#pu-add-custom-link').hasClass('creatNewAlbum')){
      $('#pu-add-custom-link').removeClass('creatNewAlbum')
    }
    $('#pu-add-custom-link').modal('show');
  });

  $('body').on('click','#pu-add-custom-link .js-add-btn_process',function(){
    link = $('#pu-add-custom-link input[name="url_process"]').val();

    var formData = new FormData();
    formData.append('url', link);
    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_link/review_link'?>",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          var data = response.data;
          title = data.title;

          var html = $('#tpl-add-link').html();
          html = html.replace('{{DATA_IMG}}', data.image)
                      .replace('{{DATA_TITLE}}', title)
                      .replace('{{DATA_DES}}', data.description);
          $('#pu-add-custom-link .js-append-html').html(html);

          $('#pu-add-custom-link .js-add-btn_save').show();
          $('#pu-add-custom-link .js-add-btn_process').hide();

          if(!$('#pu-add-custom-link').hasClass('creatNewAlbum')){
            $('#pu-add-custom-link').addClass('creatNewAlbum')
          }
          $('.load-wrapp').hide();
        } else {
          $('.load-wrapp').hide();
          alert(response.msg);
        }
      }
    });
  });

  // trigger click input
  $('body').on('click','#pu-add-custom-link .js-choose-file', function(){
    $('#pu-add-custom-link .js-input input[name="file_input"]').trigger('click');
  });

  $('body').on('change', '#pu-add-custom-link input[name="file_input"]', function () {
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
            image = result.original;
            var tpl = $('#element-image').html();
            $('#pu-add-custom-link .__image-library-link').html(tpl.replace('{{DATA_IMG}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+image));

            var metaData = getMeta('<?=DOMAIN_CLOUDSERVER_PATH?>'+image);
            setTimeout(function () {
              mime = metaData.contentType;
              img_width = metaData.width;
              img_height = metaData.height;
            }, 1000);
          } else { // video
            image = result.thumbnail;
            video = result.video;
            var tpl = $('#element-video').html();
            $('#pu-add-custom-link .__image-library-link').html(tpl.replace('{{DATA_POSTER}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+image)
                                                              .replace('{{DATA_VIDEO}}', '<?=DOMAIN_CLOUDSERVER_PATH?>'+video));

            var metaData = getMeta('<?=DOMAIN_CLOUDSERVER_PATH?>'+image);
            setTimeout(function () {
              mime = metaData.contentType;
              img_width = metaData.width;
              img_height = metaData.height;
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

  $('body').on('click','#pu-add-custom-link .js-add-btn_save',function(){
    description = $('#pu-add-custom-link textarea[name="description"]').val();
    if($('#pu-add-custom-link select[name="category_link_child_id"]').val().length > 0) {
      cate_link_id = $('#pu-add-custom-link select[name="category_link_child_id"]').val();
    } else if($('#pu-add-custom-link select[name="category_link_parent_id"]').val().length > 0) {
      cate_link_id = $('#pu-add-custom-link select[name="category_link_parent_id"]').val();
    } else {
      cate_link_id = 0;
    }

    collection = $('#pu-add-custom-link select[name="collection_id"]').val();
    is_personal = $('#pu-add-custom-link input[name="permission"]').val();

    if($('#pu-add-custom-link input[name="isPublic"]:checked').length > 0) {
      is_public = 0;
    } else {
      is_public = 1;
    }

    var formData = new FormData();
    formData.append('link', link);
    formData.append('title', title);
    formData.append('description', description);
    formData.append('collection', collection);
    formData.append('cate_link_id', cate_link_id);
    formData.append('image', image);
    formData.append('video', video);
    formData.append('orientation', orientation);
    formData.append('mime', mime);
    formData.append('img_width', img_width);
    formData.append('img_height', img_height);
    formData.append('is_personal', is_personal);
    formData.append('is_public', is_public);

    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_link/create_link'?>",
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
  $('body').on('change', '#pu-add-custom-link select[name="category_link_parent_id"]', function () {
    var value = $(this).val();
    $('body').find('#pu-add-custom-link select[name="category_link_child_id"] option.js-option-change').hide();
    $('body').find('#pu-add-custom-link select[name="category_link_child_id"] option.p_id_'+value).show();
    $('body').find('#pu-add-custom-link select[name="category_link_child_id"]').val('');
  })

  $('body').on('change', '#pu-add-custom-link input[name="permission"]', function () {
    var value = $(this).val();
    if(value == 0) {
      $('body').find('#pu-add-custom-link select[name="collection_id"] option.js_permission_1').hide();
    } else {
      $('body').find('#pu-add-custom-link select[name="collection_id"] option.js_permission_0').hide();
    }
    $('body').find('#pu-add-custom-link select[name="collection_id"] option.js_permission_'+value).show();
    $('body').find('#pu-add-custom-link select[name="collection_id"]').val('');
  })

</script>

<script type="text/html" id="tpl-add-link">
  <div class="fixed-body-sm-content">
    <div class="fixed-body-sm-content-scroll">
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
                  <option class="js_permission_<?=$item['sho_id'] > 0 ? 0 : 1?>" value="<?=$item['id']?>" <?=$c_id == $item['id'] ? 'selected' : ''?> style="display:<?=$item['sho_id'] > 0 ? 'block' : 'none'?>"><?=$item['name']?></option>
                <?php } ?>
              </optgroup>
          </select>
      </div>
      <div class="form-group">
          <select name="category_link_parent_id" class="select-category js-p-link">
            <option value="">Chọn chuyên mục liên kết</option>
            <?php foreach ($link_categories_p as $key => $item) { ?>
              <option value="<?=$item['id']?>" <?=$cate_id == $item['id'] ? 'selected' : ''?> ><?=$item['name']?></option>
            <?php } ?>
          </select>
      </div>
      <div class="form-group">
          <select name="category_link_child_id" class="select-category js-ch-link">
            <option value="">Chọn chuyên mục con</option>
            <?php foreach ($link_categories_ch as $key => $item) { ?>
              <option class="js-option-change p_id_<?=$item['parent_id']?>" value="<?=$item['id']?>" style="display:<?=$cate_id == $item['parent_id'] ? 'block' : 'none'?>"><?=$item['name']?></option>
            <?php } ?>
          </select>
          <p class="text-danger pl-4 js_category_child-msg"></p>
      </div>
      <div class="form-group">
        <label class="checkbox-style">
        <input type="checkbox" name="isPublic" value="0" class=""><span>Bí mật</span>
        </label>
      </div>
    </div>
  </div>
  
</script>

<script type="text/html" id="element-image">
  <img class="reviewImg center js-choose-file" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
  <div class="wrap-block-custom-link">
    <img class="center" src="{{DATA_IMG}}">
  </div>
  <div class="hidden js-input">
    <input type="file" name="file_input">
  </div>
</script>

<script type="text/html" id="element-video">
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
</script>
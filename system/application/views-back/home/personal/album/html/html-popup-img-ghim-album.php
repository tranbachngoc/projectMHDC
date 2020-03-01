<!-- popup ghim album -->
<script>
  var array_temp_album_ids = [];
</script>

<div class="modal saveToAlbum modalFilter js-popup-ghim">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Lưu vào album</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <ul class="saveToAlbum-popup-list">
          <?php foreach ($albums as $key => $album) { ?>
          <li class="item" 
            data-select="<?=$album->checked ? 'true' : 'false'?>"
            data-id="<?=$album->album_id?>">
            <label class="checkbox-style">
              <div class="icon-check"><img src="<?=$album->checked ? '/templates/home/styles/images/svg/checked.svg' : '/templates/home/styles/images/svg/check.svg'?>" alt=""></div>
              <div class="info">
                <div class="photo">
                  <img src="<?=$album->album_path_full?>" alt="">
                </div>
                <div class="name">
                  <h3 class="tit one-line"><?=$album->album_name?></h3>
                  <p class="txt-small"><?=$album->total?> mục </p>
                </div>
              </div>
            </label>
          </li>
            <?php if($album->checked) {?>
              <script>
                array_temp_album_ids.push("<?=$album->album_id?>");
              </script>
            <?php }?>
          <?php } ?>
        </ul>
      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-close-popup-ghim">Hủy</button>
            <button class="btn-share js-add-ghim">Lưu</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // set id checked album
  $('.js-popup-ghim').on('click', '.saveToAlbum-popup-list .item', function () {
    var select = $(this).attr('data-select');
    if(select == 'true') {
      // bỏ chọn
      $(this).attr('data-select', 'false');
      $(this).find('.icon-check img').attr('src','/templates/home/styles/images/svg/check.svg');
      var key = array_temp_album_ids.indexOf($(this).attr('data-id'));
      if(key != -1) {
        array_temp_album_ids.splice(key,1);
      }
    } else {
      // chọn
      $(this).attr('data-select', 'true');
      $(this).find('.icon-check img').attr('src','/templates/home/styles/images/svg/checked.svg');
      array_temp_album_ids.push($(this).attr('data-id'));
    }
  });

  // close modal
  $('.js-popup-ghim').on('click', '.js-close-popup-ghim', function () {
    $('.js-popup-ghim').modal('hide');
  });

  $('.js-popup-ghim').on('click', '.js-add-ghim', function () {
    $('.load-wrapp').show();
    var formData = new FormData();
    formData.append('album_id', JSON.stringify(array_temp_album_ids));
    formData.append('img_id', img_id);

    $.ajax({
      type: "post",
      url: siteUrl + 'profile/'+"<?=$current_profile['use_id']?>" + '/library/album-image/action-pin-to-album',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if(response == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert('Errors Connection!!!');
        }
      }
    });
  });

</script>
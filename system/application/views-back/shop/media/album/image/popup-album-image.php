<!-- popup create album image -->
<div class="modal creatNewAlbum js-popup-album-img" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-size-xl modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div class="creatNewAlbum-title">
          <h4 class="modal-title">Tạo album</h4> <!-- tính sửa -->
          <div class="buttons-steps">
            <p class="style js-open-pop-img-from-lib">Ảnh từ thư viện</p>
            <label class="style">
              <span class="input-txt">Thêm ảnh</span>
              <input type="file" name="img_upload" multiple accept="image/*">
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
                  <input type="text" class="form-control" placeholder="Tên album" name="album_name" autocomplete="off">
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="2" placeholder="Thêm mô tả (tùy chọn)" name="album_des" autocomplete="off"></textarea>
                </div>
              </form>
            </div>
            <div class="showImagesAlbum">

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
                <span class="show-permision">Công khai</span>
              </label>
              <i class="fa fa-angle-down"></i>
            </p>
            <div class="permision-list">
              <ul class="item-check">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="album_permission" value="3" data-text="Chỉ mình tôi">
                    <span>Chỉ mình tôi</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="album_permission" value="1" data-text="Công khai" checked>
                    <span>Công khai</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-popup-album-cancel">Hủy</button>
            <button class="btn-share js-popup-album-img-create">Tạo</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<!-- popup select image in library -->
<div class="modal creatNewAlbum js-popup-select-library" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-size-xl modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header fixed-header-sm">
        <div class="creatNewAlbum-title">
          <h4 class="modal-title">Ảnh từ thư viện</h4>
          <div class="buttons-steps">
            <p class="style js-filter-content">Bài viết</p>
            <p class="style no-bg js-filter-upload">Tự đăng</p>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body fixed-body-sm">
        <div class="creatNewAlbum-content selectNewAlbumFromLibrary-content">
          <div class="showImagesAlbum block-content" data-page="1" style="display:flex">
            <?php foreach ($imageContents as $key => $item) {
              if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
                $image_title       = trim($item->img_library_title);
              } else {
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->name;
                $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
              }
              $class_css = $item->img_w > $item->img_h ? "img-vertical" : "img-horizontal";
              ?>
            <div class="col-item js-item-click-check" 
                data-check="<?=$item->id?>" 
                data-selected="false" 
                data-img="<?=$image_url?>"
                data-imgtitle="<?=$image_title?>"
                data-imgupdetect="<?=$item->img_up_detect?>">
              <div class="item">
                <div class="img">
                  <img src="<?=$image_url?>" class="up-img <?=$class_css?>" alt="">
                  <div class="icon-checked">
                    <img src="/templates/home/styles/images/svg/check.svg" alt="">
                    <!-- <img src="/templates/home/styles/images/svg/checked.svg" alt=""> -->
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <div class="showImagesAlbum block-upload" data-page="1" style="display:none">
            <?php foreach ($imageUploads as $key => $item) {
              if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
                $image_title       = trim($item->img_library_title);
              } else {
                $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->name;
                $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
              }
              $class_css = $item->img_w > $item->img_h ? "img-vertical" : "img-horizontal";
              ?>
            <div class="col-item js-item-click-check" 
                data-check="<?=$item->id?>" 
                data-selected="false" 
                data-img="<?=$image_url?>"
                data-imgtitle="<?=$image_title?>"
                data-imgupdetect="<?=$item->img_up_detect?>">
              <div class="item">
                <div class="img">
                  <img src="<?=$image_url?>" class="up-img <?=$class_css?>" alt="">
                  <div class="icon-checked">
                    <img src="/templates/home/styles/images/svg/check.svg" alt="">
                    <!-- <img src="/templates/home/styles/images/svg/checked.svg" alt=""> -->
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
            <button class="btn-cancle js-popup-select-library-cancel">Hủy</button>
            <button class="btn-share js-popup-select-library-select">Xác nhận</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<!-- popup menu in album -->
<div class="modal modalFilter js-popup-menu-album">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          <?php if($is_owns == true) { ?>
            <li class="js-act-edit-album"><a href="javascript:void(0)">Chỉnh sửa</a></li>
            <li class="js-act-set-top"><a href="javascript:void(0)">Đẩy lên đầu trang</a></li>
          <?php } ?>
            <li class=""><a href="javascript:void(0)">Chia sẻ</a></li>
          <?php if($is_owns == true) { ?>
            <li class="js-act-del-album"><a href="javascript:void(0)">Xóa album</a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="js-album_offset-process-menu-album">

      </div>

    </div>
  </div>
</div>

<div class="modal modalFilter js-popup-menu-item">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail js-thao-tac-html">
          
        </ul>
      </div>
      <div class="js-album_offset-process-menu-album">

      </div>

    </div>
  </div>
</div>

<!-- popup alert -->
<div class="modal modalFilter js-popup-alert">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="des-alert"><!-- append detail alert --></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-comfirm-cancel">Hủy</button>
            <button class="btn-share js-comfirm-delete">Xóa</button>
            <button class="btn-share js-comfirm-continue">Tiếp</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<!-- popup process -->
<div class="modal modalFilter js-popup-next">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="pt20">
          <div class="form-group">
            <input type="text" autocomplete="off" name="next_album_title" placeholder="Tên album" class="ten-bst-input">
          </div>
          <div class="form-group">
            <textarea class="form-control" rows="2" placeholder="Thêm mô tả (tùy chọn)" name="next_album_des" autocomplete="off"></textarea>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <button class="btn-cancle js-next-cancel">Hủy</button>
            <button class="btn-share js-next-process">Tạo</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<!-- append pop edit album -->
<div class="load-album-edit"></div>

<!-- append pop ghim -->
<div class="load-popup-ghim"></div>

<script type="text/template" id="item-img-selected">
<div class="col-item">
  <div class="item">
    <div class="img">
      <img src="{{src_img}}" class="up-img data-image-upload" alt=""
       data-check="{{data_check}}"
       data-index="{{data_index}}"
       data-imgUpDetect="{{data_imgUpDetect}}">
      <div class="action">
        <p class="act-setavatar" data-avatar="{{data_avatar}}" data-from="{{data_from}}" data-setavatar="false">
          <img src="/templates/home/styles/images/svg/album_ico_setting.svg" alt="">
        </p>
        <p class="act-close">
          <img src="/templates/home/styles/images/svg/album_ico_close.svg" alt="">
        </p>
      </div>
    </div>
    <div class="txt">
      <div class="form-group">
        <textarea {{data_disabled}} class="form-control" rows="2" placeholder="Tiêu đề (tùy chọn)">{{data_imgtitle}}</textarea>
      </div>
    </div>
  </div>
</div>
</script>

<script type="text/template" id="data-process-item-menu-album">
  <div class="data-current-album hidden"
    data-albumId="{{data_albumId}}"
    data-albumOffSet="{{data_albumOffSet}}">
  </div>
</script>
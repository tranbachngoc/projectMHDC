<!-- BEGIN::filter -->
<div class="col-md-2 md">
  <div class="search-filter">
    <div class="button-filter">Bộ lọc</div>
    <div class="search-filter-content">
      <div class="item">
        <?php
        $link_filter = $url_tab['image']
        . (!strictEmpty($_REQUEST['image_type']) ? '&image_type='.$_REQUEST['image_type'] : '' )
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' );
        ?>
        <h6 class="category">Ảnh thuộc:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['image_attr']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả mọi người</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_SHOP ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_attr='.FILTER_IMAGE_SHOP?>">Doanh nghiệp bạn theo dõi</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_FRIEND ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_attr='.FILTER_IMAGE_FRIEND?>">Bạn bè của bạn</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_GROUP ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_attr='.FILTER_IMAGE_GROUP?>">Nhóm của bạn</a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php
        $link_filter = $url_tab['image']
        . (!strictEmpty($_REQUEST['image_attr']) ? '&image_attr='.$_REQUEST['image_attr'] : '' )
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' );
        ?>
        <h6 class="category">Loại ảnh:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['image_type']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_CONTENT ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_type='.FILTER_IMAGE_TYPE_CONTENT?>">Ảnh thuộc bài viết</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_ALBUM ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_type='.FILTER_IMAGE_TYPE_ALBUM?>">Ảnh thuộc album</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_PRODUCT ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_type='.FILTER_IMAGE_TYPE_PRODUCT?>">Ảnh sản phẩm</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_LINK ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&image_type='.FILTER_IMAGE_TYPE_LINK?>">Ảnh liên kết</a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php
        $years = array_reverse(range(2016, date('Y')));
        $link_filter = $url_tab['image']
        . (!strictEmpty($_REQUEST['image_attr']) ? '&image_attr='.$_REQUEST['image_attr'] : '' )
        . (!strictEmpty($_REQUEST['image_type']) ? '&image_type='.$_REQUEST['image_type'] : '' );
        ?>
        <h6 class="category">Ngày đăng:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['year']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Ngày bất kỳ</a>
          </p>
          <?php foreach($years as $year) { ?>
          <p <?=!strictEmpty($_REQUEST['year']) && $_REQUEST['year'] == $year ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&year='.$year?>"><?=$year?></a>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal modalFilter" id="modalFilter">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Lọc tất cả</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="filter-cates accordion js-accordion">
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Ảnh thuộc
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_attr" value="" <?=strictEmpty($_REQUEST['image_attr']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả mọi người</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_attr" value="<?=FILTER_IMAGE_SHOP?>" <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_SHOP ? 'checked="checked"' : ''?>>
                    <span>Doanh nghiệp bạn theo dõi</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_attr" value="<?=FILTER_IMAGE_FRIEND?>" <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_FRIEND ? 'checked="checked"' : ''?>>
                    <span>Bạn bè của bạn</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_attr" value="<?=FILTER_IMAGE_GROUP?>" <?=!strictEmpty($_REQUEST['image_attr']) && $_REQUEST['image_attr'] == FILTER_IMAGE_GROUP ? 'checked="checked"' : ''?>>
                    <span>Nhóm của bạn</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Loại ảnh
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_type" value="" <?=strictEmpty($_REQUEST['image_type']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_type" value="<?=FILTER_IMAGE_TYPE_CONTENT?>" <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_CONTENT ? 'checked="checked"' : ''?>>
                    <span>Ảnh thuộc bài viết</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_type" value="<?=FILTER_IMAGE_TYPE_ALBUM?>" <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_ALBUM ? 'checked="checked"' : ''?>>
                    <span>Ảnh thuộc album</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_type" value="<?=FILTER_IMAGE_TYPE_PRODUCT?>" <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_PRODUCT ? 'checked="checked"' : ''?>>
                    <span>Ảnh sản phẩm</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="image_type" value="<?=FILTER_IMAGE_TYPE_LINK?>" <?=!strictEmpty($_REQUEST['image_type']) && $_REQUEST['image_type'] == FILTER_IMAGE_TYPE_LINK ? 'checked="checked"' : ''?>>
                    <span>Ảnh liên kết</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Ngày đăng
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                  <input type="radio" name="year" value="" <?=strictEmpty($_REQUEST['year']) ? 'checked="checked"' : ''?>>
                    <span>Ngày bất kỳ</span>
                  </label>
                </li>
              <?php foreach($years as $year) { ?>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="year" value="<?=$year?>" <?=!strictEmpty($_REQUEST['year']) && $_REQUEST['year'] == $year ? 'checked="checked"' : ''?>>
                    <span><?=$year?></span>
                  </label>
                </li>
              <?php }?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle js-reset-op" type="button">Đặt lại</button>
            <button class="btn-share js-redirect" type="button">Lọc kết quả</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>
<script>

$( document ).ready(function() {
  _this = $('input[name="image_attr"]:checked, input[name="image_type"]:checked, input[name="year"]:checked');
  for (var index = 0; index < _this.length; index++) {
    var element = _this[index];
    var txt = $(element).next().text();
    if(txt != ''){
      $(element).closest('.filter-cates-item').find('.show-cate-child').text(txt);
    } else {
      $(element).closest('.filter-cates-item').find('.show-cate-child').text('Lấy giá trị từ checkbox bên dưới');
    }
  }
})

$('.js-redirect').on('click', function(event) {
  var url = '<?=$url_tab['image']?>';
  var image_attr = $('#modalFilter').find('input[name="image_attr"]:checked').val();
  var image_type = $('#modalFilter').find('input[name="image_type"]:checked').val();
  var year = $('#modalFilter').find('input[name="year"]:checked').val();
  if(image_attr !== '') {
    url += '&image_attr='+image_attr;
  }
  if(image_type !== '') {
    url += '&image_type='+image_type;
  }
  if(year !== '') {
    url += '&year='+year;
  }
  window.location.replace(url);
})

$('.js-reset-op').on('click', function(event) {
  $('#modalFilter').find('input[name="image_attr"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="image_type"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="year"]:first').attr('checked', 'checked');
  $($('#modalFilter').find('.show-cate-child')[0]).text('Tất cả mọi người');
  $($('#modalFilter').find('.show-cate-child')[1]).text('Tất cả');
  $($('#modalFilter').find('.show-cate-child')[2]).text('Ngày bất kỳ');
})
</script>
<!-- End The Modal -->
<!-- END::filter  -->


<div class="col-md-10">
  <div class="row">
    <div class="col-xl-12">
      <div class="search-private liet-ke-hinh-anh">
        <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Hình ảnh</h3>
            <div class="title-right">
              <!-- <a href="">Xem tất cả</a> -->
            </div>
          </div>
          <div class="grid" id="detail">
            <?php if( count($searchs['data']) > 0 ) {
              foreach ($searchs['data'] as $key => $item) {
                $this->load->view('search/home/element/image-item', ['item'=>$item]);
              }
            } else {
              $this->load->view('search/home/element/empty-item');
            } ?>
          </div>
          <div class="btn-loadmore mt30 js-loading" style="display: none">
            <button>Đang tải thêm kết quả tìm kết ...</button>
          </div>
          <div class="btn-loadmore mt30 js-end" style="display: none">
            <button>Đã hết kết quả tìm kiếm</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
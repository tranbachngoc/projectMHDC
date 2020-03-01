<!-- BEGIN::filter -->
<div class="col-lg-2 col-md-3 md">
  <div class="search-filter">
    <div class="button-filter">Bộ lọc</div>
    <div class="search-filter-content">
      <div class="item">
        <?php
        $link_filter = $url_tab['company']
        . (!strictEmpty($_REQUEST['is_type']) ? '&is_type='.$_REQUEST['is_type'] : '' )
        . (!strictEmpty($_REQUEST['category']) ? '&category='.$_REQUEST['category'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <h6 class="category">Doanh nghiệp:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['is_follow']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả doanh nghiệp</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['is_follow']) && $_REQUEST['is_follow'] == FILTER_COMPANY_FOLLOW ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&is_follow='.FILTER_COMPANY_FOLLOW?>">Những doanh nghiệp bạn theo dõi</a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['company']
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['category']) ? '&category='.$_REQUEST['category'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <p class="category">Loại doanh nghiệp:</p>
        <div class="ml10">
          <p <?=strictEmpty($_REQUEST['is_type']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['is_type']) && $_REQUEST['is_type'] == FILTER_COMPANY_TYPE_MOST_FOLLOW ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&is_type='.FILTER_COMPANY_TYPE_MOST_FOLLOW?>">Nhiều người theo dõi</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['is_type']) && $_REQUEST['is_type'] == FILTER_COMPANY_TYPE_MOST_PRODUCT ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&is_type='.FILTER_COMPANY_TYPE_MOST_PRODUCT?>">Nhiều sản phẩm nhất</a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['company']
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['is_type']) ? '&is_type='.$_REQUEST['is_type'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <h6 class="category">Ngành hàng:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['category']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả</a>
          </p>
          <?php foreach($categories as $category) { ?>
          <p <?=!strictEmpty($_REQUEST['category']) && $_REQUEST['category'] == $category['cat_id'] ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&category='.$category['cat_id']?>"><?=$category['cat_name']?></a>
          </p>
          <?php } ?>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['company']
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['is_type']) ? '&is_type='.$_REQUEST['is_type'] : '' )
        . (!strictEmpty($_REQUEST['category']) ? '&category='.$_REQUEST['category'] : '' );
        ?>
        <h6 class="category">Địa điểm:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['province']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả</a>
          </p>
          <?php foreach($provinces as $province) { ?>
          <p <?=!strictEmpty($_REQUEST['province']) && $_REQUEST['province'] == $province['pre_id'] ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&province='.$province['pre_id']?>"><?=$province['pre_name']?></a>
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
      <form class="frm-filter">
      <div class="modal-header">
        <h4 class="modal-title">Lọc tất cả</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="filter-cates accordion js-accordion">
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Doanh nghiệp
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_follow" value="" <?=strictEmpty($_REQUEST['is_follow']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả doanh nghiệp</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_follow" value="<?=FILTER_COMPANY_FOLLOW?>" <?=!strictEmpty($_REQUEST['is_follow']) && $_REQUEST['is_follow'] == FILTER_COMPANY_FOLLOW ? 'checked="checked"' : ''?>>
                    <span>Những doanh nghiệp bạn theo dõi</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Loại doanh nghiệp
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_type" value="" <?=strictEmpty($_REQUEST['is_type']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_type" value="<?=FILTER_COMPANY_TYPE_MOST_FOLLOW?>" <?=!strictEmpty($_REQUEST['is_type']) && $_REQUEST['is_type'] == FILTER_COMPANY_TYPE_MOST_FOLLOW ? 'checked="checked"' : ''?>>
                    <span>Nhiều người theo dõi</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_type" value="<?=FILTER_COMPANY_TYPE_MOST_PRODUCT?>" <?=!strictEmpty($_REQUEST['is_type']) && $_REQUEST['is_type'] == FILTER_COMPANY_TYPE_MOST_PRODUCT ? 'checked="checked"' : ''?>>
                    <span>Nhiều sản phẩm nhất</span>
                  </label>
                </li>
              </ul>
            </div>
          </div>
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Ngành hàng:
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="category" value="" <?=strictEmpty($_REQUEST['category']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
                  </label>
                </li>
                <?php foreach($categories as $category) { ?>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="category" value="<?=$category['cat_id']?>" <?=!strictEmpty($_REQUEST['category']) && $_REQUEST['category'] == $category['cat_id'] ? 'checked="checked"' : ''?>>
                    <span><?=$category['cat_name']?></span>
                  </label>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Địa điểm:
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="province" value="" <?=strictEmpty($_REQUEST['province']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
                  </label>
                </li>
                <?php foreach($provinces as $province) { ?>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="province" value="<?=$province['pre_id']?>" <?=!strictEmpty($_REQUEST['province']) && $_REQUEST['province'] == $province['pre_id'] ? 'checked="checked"' : ''?>>
                    <span><?=$province['pre_name']?></span>
                  </label>
                </li>
                <?php } ?>
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
      </form>
    </div>
  </div>
</div>
<script>

$( document ).ready(function() {
  _this = $('input[name="is_follow"]:checked, input[name="is_type"]:checked, input[name="category"]:checked, input[name="province"]:checked');
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
  var url = '<?=$url_tab['company']?>';
  var is_follow = $('#modalFilter').find('input[name="is_follow"]:checked').val();
  var is_type = $('#modalFilter').find('input[name="is_type"]:checked').val();
  var category = $('#modalFilter').find('input[name="category"]:checked').val();
  var province = $('#modalFilter').find('input[name="province"]:checked').val();

  if(is_follow !== '') {
    url += '&type='+is_follow;
  }
  if(is_type !== '') {
    url += '&is_type='+is_type;
  }
  if(category !== '') {
    url += '&category='+category;
  }
  if(province !== '') {
    url += '&province='+province;
  }
  window.location.replace(url);
})
$('.js-reset-op').on('click', function(event) {
  $('#modalFilter').find('input[name="category"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="is_type"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="category"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="province"]:first').attr('checked', 'checked');
  $($('#modalFilter').find('.show-cate-child')[0]).text('Tất cả doanh nghiệp');
  $($('#modalFilter').find('.show-cate-child')[1]).text('Tất cả');
  $($('#modalFilter').find('.show-cate-child')[2]).text('Tất cả');
  $($('#modalFilter').find('.show-cate-child')[3]).text('Tất cả');
})
</script>
<!-- End The Modal -->
<!-- END::filter  -->

<div class="col-lg-7 col-sm-9">
  <div class="row">
    <div class="col-md-12 ">
      <div class="search-private">
        <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Doanh nghiệp</h3>
            <div class="title-right">
              <!-- <a href="">Xem tất cả</a> -->
            </div>
          </div>
          <div class="detail" id="detail">
            <?php if( count($searchs['data']) > 0 ) {
              foreach ($searchs['data'] as $key => $item) {
                $this->load->view('search/home/element/company-item', ['item'=>$item]);
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



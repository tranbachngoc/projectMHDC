<!-- BEGIN::filter -->
<div class="col-lg-2 col-md-3 md">
  <div class="search-filter">
    <div class="button-filter">Bộ lọc</div>
    <div class="search-filter-content">
      <div class="item">
        <?php
          $link_filter = $url_tab['personal'];
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
      <div class="modal-header">
        <h4 class="modal-title">Lọc tất cả</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="filter-cates accordion js-accordion">
          <!-- <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Cá nhân
              <br>
              <span class="show-cate-child">Tất cả</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="personal" value="" checked="checked">
                    <span>Tất cả</span>
                  </label>
                </li>
              </ul>
            </div>
          </div> -->
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
    </div>
  </div>
</div>
<script>

$( document ).ready(function() {
  _this = $('input[name="province"]:checked');
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
  var url = '<?=$url_tab['personal']?>';
  var province = $('#modalFilter').find('input[name="province"]:checked').val();
  if(province !== '') {
    url += '&province='+province;
  }
  window.location.replace(url);
})

$('.js-reset-op').on('click', function(event) {
  $('#modalFilter').find('input[name="province"]:first').attr('checked', 'checked');
  $($('#modalFilter').find('.show-cate-child')[0]).text('Tất cả');
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
            <h3 class="title-left">Cá nhân</h3>
            <div class="title-right">
              <!-- <a href="">Xem tất cả</a> -->
            </div>
          </div>
          <div class="detail" id="detail">
            <?php if( count($searchs['data']) > 0 ) {
              foreach ($searchs['data'] as $key => $item) {
                $this->load->view('search/home/element/personal-item', ['item'=>$item]);
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
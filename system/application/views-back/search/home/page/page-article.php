<?php 
$years = array_reverse(range(2016, date('Y')));
?>
<!-- BEGIN::filter -->
<div class="col-lg-2 col-md-3 md">
  <div class="search-filter">
    <div class="button-filter">Bộ lọc</div>
    <div class="search-filter-content">
      <div class="item">
        <?php 
        $link_filter = $url_tab['article']
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' );
        ?>
        <h6 class="category">Bài viết thuộc:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['type']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả bài viết</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_COMPANY ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&type='.FILTER_CONTENT_COMPANY?>">
              Bài viết doanh nghiệp
            </a>
          </p>
          <p <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_PERSONAL ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&type='.FILTER_CONTENT_PERSONAL?>">
              Bài viết cá nhân
            </a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['article']
        . (!strictEmpty($_REQUEST['type']) ? '&type='.$_REQUEST['type'] : '' );
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
              Bài viết thuộc
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="type" value="" <?=strictEmpty($_REQUEST['type']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả bài viết</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="type" value="<?=FILTER_CONTENT_COMPANY?>" <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_COMPANY ? 'checked="checked"' : ''?>>
                    <span>Bài viết doanh nghiệp</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="type" value="<?=FILTER_CONTENT_PERSONAL?>" <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_PERSONAL ? 'checked="checked"' : ''?>>
                    <span>Bài viết cá nhân</span>
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
  _this = $('input[name="type"]:checked, input[name="year"]:checked');
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
  var url = '<?=$url_tab['article']?>';
  var type = $('#modalFilter').find('input[name="type"]:checked').val();
  var year = $('#modalFilter').find('input[name="year"]:checked').val();
  if(type !== '') {
    url += '&type='+type;
  }
  if(year !== '') {
    url += '&year='+year;
  }
  window.location.replace(url);
})
$('.js-reset-op').on('click', function(event) {
  $('#modalFilter').find('input[name="type"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="year"]:first').attr('checked', 'checked');
  $($('#modalFilter').find('.show-cate-child')[0]).text('Tất cả bài viết');
  $($('#modalFilter').find('.show-cate-child')[1]).text('Ngày bất kỳ');
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
            <h3 class="title-left">Bài viết</h3>
            <div class="title-right">
              <!-- <a href="">Xem tất cả</a> -->
            </div>
          </div>
          <div class="detail" id="detail">
            <?php if( count($searchs['data']) > 0 ) {
              foreach ($searchs['data'] as $key => $item) {
                $this->load->view('search/home/element/article-item', ['item'=>$item]);
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



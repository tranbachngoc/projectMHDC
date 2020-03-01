<?php 
$years = array_reverse(range(2016, date('Y')));
?>

<!-- BEGIN::filter -->
<div class="col-md-2 md">
  <div class="search-filter">
    <div class="button-filter">Bộ lọc</div>
    <div class="search-filter-content">
      <div class="item">
        <?php 
        $link_filter = $url_tab['all']
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <h6 class="category">Bài viết thuộc:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['type']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả bài viết</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_COMPANY ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter .'&type='.FILTER_CONTENT_COMPANY?>">Bài viết doanh nghiệp</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['type']) && $_REQUEST['type'] == FILTER_CONTENT_PERSONAL ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter .'&type='.FILTER_CONTENT_PERSONAL?>">Bài viết cá nhân</a>
          </p>
          <!-- <p>
            <a href="">Bài viết từ nhóm</a>
          </p>
          <p>
            <a href="">Bài viết đã xem</a>
          </p> -->
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['all']
        . (!strictEmpty($_REQUEST['type']) ? '&type='.$_REQUEST['type'] : '' )
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <h6 class="category">Doanh nghiệp:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['is_follow']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Tất cả doanh nghiệp</a>
          </p>
          <p <?=!strictEmpty($_REQUEST['is_follow']) && $_REQUEST['is_follow'] == FILTER_COMPANY_FOLLOW ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter .'&is_follow='.FILTER_COMPANY_FOLLOW?>">Những doanh nghiệp bạn theo dõi</a>
          </p>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['all']
        . (!strictEmpty($_REQUEST['type']) ? '&type='.$_REQUEST['type'] : '' )
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['province']) ? '&province='.$_REQUEST['province'] : '' );
        ?>
        <h6 class="category">Ngày đăng:</h6>
        <div class="ml10 scroll-address">
          <p <?=strictEmpty($_REQUEST['year']) ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter?>">Ngày bất kì</a>
          </p>
          <?php foreach($years as $year) { ?>
          <p <?=!strictEmpty($_REQUEST['year']) && $_REQUEST['year'] == $year ? 'class="is-active"' : ''?>>
            <a href="<?=$link_filter.'&year='.$year?>"><?=$year?></a>
          </p>
          <?php } ?>
        </div>
      </div>
      <div class="item">
        <?php 
        $link_filter = $url_tab['all']
        . (!strictEmpty($_REQUEST['type']) ? '&type='.$_REQUEST['type'] : '' )
        . (!strictEmpty($_REQUEST['is_follow']) ? '&is_follow='.$_REQUEST['is_follow'] : '' )
        . (!strictEmpty($_REQUEST['year']) ? '&year='.$_REQUEST['year'] : '' )
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
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Bài viết thuộc:
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
        </div>
        <div class="filter-cates accordion js-accordion">
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Doanh nghiệp:
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="is_follow" value="" <?=strictEmpty($_REQUEST['is_follow']) ? 'checked="checked"' : ''?>>
                    <span>Tất cả</span>
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
        </div>
        <div class="filter-cates accordion js-accordion">
          <div class="filter-cates-item accordion-item">
            <div class="cate-parent accordion-toggle">
              Ngày đăng:
              <br>
              <span class="show-cate-child">lấy giá trị từ checkbox bên dưới</span>
            </div>
            <div class="cate-child accordion-panel">
              <ul class="mini-cate">
                <li>
                  <label class="checkbox-style-circle">
                    <input type="radio" name="year" value="" <?=strictEmpty($_REQUEST['year']) ? 'checked="checked"' : ''?>>
                    <span>Ngày bất kì</span>
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
        <div class="filter-cates accordion js-accordion">
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
<!-- End The Modal -->

<script>
$( document ).ready(function() {
  _this = $('input[name="type"]:checked, input[name="is_follow"]:checked, input[name="year"]:checked, input[name="province"]:checked');
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
  var url = '<?=$url_tab['all']?>';
  var type = $('#modalFilter').find('input[name="type"]:checked').val();
  var is_follow = $('#modalFilter').find('input[name="is_follow"]:checked').val();
  var year = $('#modalFilter').find('input[name="year"]:checked').val();
  var province = $('#modalFilter').find('input[name="province"]:checked').val();
  if(type !== '') {
    url += '&type='+type;
  }
  if(is_follow !== '') {
    url += '&is_follow='+is_follow;
  }
  if(year !== '') {
    url += '&year='+year;
  }
  if(province !== '') {
    url += '&province='+province;
  }
  window.location.replace(url);
})

$('.js-reset-op').on('click', function(event) {
  $('#modalFilter').find('input[name="type"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="is_follow"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="year"]:first').attr('checked', 'checked');
  $('#modalFilter').find('input[name="province"]:first').attr('checked', 'checked');
  $($('#modalFilter').find('.show-cate-child')[0]).text('Tất cả bài viết');
  $($('#modalFilter').find('.show-cate-child')[1]).text('Tất cả');
  $($('#modalFilter').find('.show-cate-child')[2]).text('Tất cả');
  $($('#modalFilter').find('.show-cate-child')[3]).text('Tất cả');
})
</script>
<!-- END::filter  -->

<div class="col-md-10">
  <div class="row">
    <div class="col-xl-7 col-lg-12 ">
      <div class="search-all">
        <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Bài viết</h3>
            <div class="title-right">
              <a href="<?=$url_tab['article']?>">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <?php if( count($searchs['data']['dataArticle']) > 0 ) {
              foreach ($searchs['data']['dataArticle'] as $key => $item) {
                $this->load->view('search/home/element/article-item', ['item'=>$item]);
              }
            } else {
              $this->load->view('search/home/element/empty-item');
            }?>
          </div>
        </div>
        <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Doanh nghiệp</h3>
            <div class="title-right">
              <a href="<?=$url_tab['company']?>">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <?php if( count($searchs['data']['dataCompany']) > 0 ) {
              foreach ($searchs['data']['dataCompany'] as $key => $item) {
                $this->load->view('search/home/element/company-item', ['item'=>$item]);
              }
            } else {
              $this->load->view('search/home/element/empty-item');
            } ?>
          </div>
        </div>
        <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Cá nhân</h3>
            <div class="title-right">
              <a href="<?=$url_tab['personal']?>">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <?php if( count($searchs['data']['dataPersonal']) > 0 ) {
              foreach ($searchs['data']['dataPersonal'] as $key => $item) {
                $this->load->view('search/home/element/personal-item', ['item'=>$item]);
              }
            } else {
              $this->load->view('search/home/element/empty-item');
            } ?>
          </div>
        </div>

        <!-- Sản Phẩm  -->
        <!-- <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Sản phẩm</h3>
            <div class="title-right">
              <a href="">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <div class="shop-product-items js-shop-product-items">
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/01.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                    <div class="ctv" data-toggle="modal" data-target="#congtacvien">
                      <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
                      <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
                    </div>
                  </div>
                </div>
                <div class="text">
                  <a href="">
                    <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                    <div class="giadasale">
                      <span class="dong">đ</span>250.000.000</div>
                    <div class="giachuasale">150.000.000</div>
                  </a>
                  <div class="sm-btn-show">
                    <img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/02.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                    <div class="ctv">
                      <a href="">
                        <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
                        <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
                      </a>
                    </div>
                  </div>
                  <div class="flash">
                    <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
                    <div class="time">99 ngày 21:03:00</div>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/03.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/04.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/05.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item border-bottom-none">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <!-- Coupon -->
        <!-- <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Coupon</h3>
            <div class="title-right">
              <a href="">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <div class="shop-product-items js-shop-product-items">
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/01.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                    <div class="ctv" data-toggle="modal" data-target="#congtacvien">
                      <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
                      <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
                    </div>
                  </div>
                </div>
                <div class="text">
                  <a href="">
                    <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                    <div class="giadasale">
                      <span class="dong">đ</span>250.000.000</div>
                    <div class="giachuasale">150.000.000</div>
                  </a>
                  <div class="sm-btn-show">
                    <img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/02.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                    <div class="ctv">
                      <a href="">
                        <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
                        <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
                      </a>
                    </div>
                  </div>
                  <div class="flash">
                    <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
                    <div class="time">99 ngày 21:03:00</div>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/03.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/04.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/05.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
              <div class="item border-bottom-none">
                <div class="img hovereffect">
                  <img class="img-responsive" src="/templates/home/styles/images/hinhanh/06.jpg" alt="">
                  <div class="action">
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
                      </a>
                    </p>
                    <p>
                      <a href="">
                        <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
                      </a>
                    </p>
                  </div>
                </div>
                <div class="text">
                  <p class="tensanpham two-lines">Tên sản phẩm_Demo text 2 dòng Tên sản phẩm_Demo text 2 dòng</p>
                  <div class="giadasale">
                    <span class="dong">đ</span>250.000.000</div>
                  <div class="giachuasale">150.000.000</div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <!-- Liên kết -->
        <!-- <div class="search-all-post">
          <div class="title">
            <h3 class="title-left">Liên kết</h3>
            <div class="title-right">
              <a href="">Xem tất cả</a>
            </div>
          </div>
          <div class="detail">
            <div class="list-videos js-list-videos">
              <div class="video">
                <a href="">
                  <div class="box-video">
                    <img src="/templates/home/styles/images/hinhanh/15.jpg" class="img" alt="">
                  </div>
                  <div class="text">
                    <h3>I love you baby</h3>
                    <p>aaaaaaaaaaaaaaaaaaaa</p>
                  </div>
                </a>
              </div>
              <div class="video">
                <a href="">
                  <div class="box-video">
                    <img src="/templates/home/styles/images/hinhanh/13.jpg" class="img" alt="">
                  </div>
                  <div class="text">
                    <h3>I love you baby</h3>
                    <p>aaaaaaaaaaaaaaaaaaaa</p>
                  </div>
                </a>
              </div>
              <div class="video">
                <a href="">
                  <div class="box-video">
                    <img src="/templates/home/styles/images/hinhanh/12.jpg" class="img" alt="">
                  </div>
                  <div class="text">
                    <h3>I love you baby</h3>
                    <p>aaaaaaaaaaaaaaaaaaaa</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div> -->

      </div>
    </div>
    <!-- <div class="col-xl-5 col-lg-12 ">
      <div class="search-all-post">
        <div class="title">
          <h3 class="title-left">Hình ảnh</h3>
          <div class="title-right">
            <a href="">Xem tất cả</a>
          </div>
        </div>
        <div class="detail">
          <div class="list-images">
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/16.jpg" alt="">
            </div>
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/17.jpg" alt="">
            </div>
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/14.jpg" alt="">
            </div>
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/18.jpg" alt="">
            </div>
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/12.jpg" alt="">
            </div>
            <div class="img">
              <img src="/templates/home/styles/images/hinhanh/11.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
      <div class="search-all-post">
        <div class="title">
          <h3 class="title-left">Video</h3>
          <div class="title-right">
            <a href="">Xem tất cả</a>
          </div>
        </div>
        <div class="detail">
          <div class="list-videos js-list-videos">
            <div class="video">
              <a href="">
                <div class="box-video">
                  <video id="video_1756" playsinline muted="true" autoplay="true">
                    <source src="http://azibai.net/video/5c3426d5d685315469216855c3426d5d68af.mp4#t=1" type="video/mp4">
                  </video>
                </div>
                <div class="text">
                  <h3>I love you baby</h3>
                  <p>aaaaaaaaaaaaaaaaaaaa</p>
                </div>
              </a>
            </div>
            <div class="video">
              <a href="">
                <div class="box-video">
                  <video id="video_1756" playsinline muted="true" autoplay="true">
                    <source src="http://azibai.net/video/5c3426d5d685315469216855c3426d5d68af.mp4#t=1" type="video/mp4">
                  </video>
                </div>
                <div class="text">
                  <h3>I love you baby</h3>
                  <p>aaaaaaaaaaaaaaaaaaaa</p>
                </div>
              </a>
            </div>
            <div class="video">
              <a href="">
                <div class="box-video">
                  <video id="video_1756" playsinline muted="true" autoplay="true">
                    <source src="http://azibai.net/video/5c3426d5d685315469216855c3426d5d68af.mp4#t=1" type="video/mp4">
                  </video>
                </div>
                <div class="text">
                  <h3>I love you baby</h3>
                  <p>aaaaaaaaaaaaaaaaaaaa</p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="search-all-post">
        <div class="title">
          <h3 class="title-left">Nhóm</h3>
          <div class="title-right">
            <a href="">Xem tất cả</a>
          </div>
        </div>
        <div class="detail">
          <div class="item">
            <div class="group">
              <div class="group-left">
                <div class="avata">
                  <img src="/templates/home/styles/images/hinhanh/16.jpg" alt="">
                </div>
                <div class="name">
                  <h4>Tên cá nhân</h4>
                  <p class="text-small">@subdomain
                    <br>2k người theo dõi</p>
                </div>
              </div>
              <div class="group-right">
                <span class="btn-join">Tham gia</span>
                <span class="icon-3dot">
                  <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                </span>
              </div>
            </div>
            <div class="financed">Được tài trợ</div>
          </div>
          <div class="item">
            <div class="group">
              <div class="group-left">
                <div class="avata">
                  <img src="/templates/home/styles/images/hinhanh/16.jpg" alt="">
                </div>
                <div class="name">
                  <h4>Tên cá nhân</h4>
                  <p class="text-small">@subdomain
                    <br>2k người theo dõi</p>
                </div>
              </div>
              <div class="group-right">
                <span class="favorite">
                  <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                </span>
                <span class="icon-3dot">
                  <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                </span>
              </div>
            </div>
            <div class="financed">Được tài trợ</div>
          </div>
          <div class="item border-bottom-none">
            <div class="group">
              <div class="group-left">
                <div class="avata">
                  <img src="/templates/home/styles/images/hinhanh/16.jpg" alt="">
                </div>
                <div class="name">
                  <h4>Tên cá nhân</h4>
                  <p class="text-small">@subdomain
                    <br>2k người theo dõi</p>
                </div>
              </div>
              <div class="group-right">
                <span class="favorite">
                  <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                </span>
                <span class="icon-3dot">
                  <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                </span>
              </div>
            </div>
            <div class="financed">Được tài trợ</div>
          </div>
        </div>
      </div>
      <div class="search-all-post">
        <div class="title">
          <h3 class="title-left">Bộ sưu tập</h3>
          <div class="title-right">
            <a href="">Xem tất cả</a>
          </div>
        </div>
        <div class="detail">
          <div class="list-collections">
            <div class="item">
              <div class="images">
                <div class="img">
                  <img src="/templates/home/styles/images/hinhanh/15.jpg" alt="">
                </div>
                <div class="img">
                  <img src="/templates/home/styles/images/hinhanh/14.jpg" alt="">
                </div>
                <div class="img">
                  <img src="/templates/home/styles/images/hinhanh/12.jpg" alt="">
                </div>
                <div class="img">
                  <img src="/templates/home/styles/images/hinhanh/11.jpg" alt="">
                </div>
              </div>
              <div class="text">
                <div class="name">
                  <div class="one-line tit">Bộ sưu tập 3</div>
                  <span>4 mục</span>
                </div>
                <div class="note">
                  <span class="icon-3dot">
                    <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</div>

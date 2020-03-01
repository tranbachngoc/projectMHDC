<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">

<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li>
            <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Bài viết chi nhánh</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="product-posted">
        <div class="product-posted-tit">
          <?php echo $user_shop->use_group == 3 ? 'BÀI VIẾT TỪ CHI NHÁNH' : 'BÀI VIẾT TỪ GIAN HÀNG' ?>
        </div>
        <form method="get" action="<?php echo base_url() .'page-business/list-news/' . $user_shop->use_id; ?>">
          <div class="product-posted-search">
            <div class="left">
              <div class="input-search">
                <img src="/templates/home/styles/images/svg/search.svg" alt="">
                <input type="text" name="news_title" value="<?php echo $_REQUEST['news_title'] ?>" class="form-control" placeholder="Tìm theo tên bài viết">
              </div>
            </div>
            <div class="right">
              <?php if(!empty($list_branch)) { ?>
              <div class="select-search">
                <select name="search_branch" id="search_branch">
                  <option value="">Tìm theo chi nhánh</option>
                  <?php foreach ($list_branch as $k_bran => $v_bran) { ?>
                  <option value="<?php echo $v_bran['user_id'] ?>" <?php echo (!empty($_REQUEST['search_branch']) && $v_bran['user_id'] == $_REQUEST['search_branch']) ? 'selected': '' ?>>
                    <?php echo $v_bran['shop_name'] ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <?php } ?>
              <div class="select-search">
                <select name="news_cate" id="news_cate">
                  <option value="">Tìm theo danh mục</option>
                  <?php if(!empty($list_cate)) { ?>
                  <?php foreach ($list_cate as $k_cate => $v_cate) { ?>
                  <option value="<?php echo $v_cate['cat_id'] ?>" <?php echo (!empty($_REQUEST['news_cate']) && $v_cate['cat_id'] == $_REQUEST['news_cate']) ? 'selected': '' ?>>
                    <?php echo $v_cate['cat_name'] ?>
                  </option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <script>
            $('select[name="news_cate"], select[name="search_branch"]').on('change', function () {
              $(this).closest('form').submit();
            })
          </script>
        </form>
        <div class="product-posted-content">
          <table class="parent-table">
            <tr>
              <th>
                <div class="tt-name-post">
                  <div class="selectArea">
                    <label class="checkbox-style">
                      <input class="selectAll" type="checkbox" name="checkall" value=""><span></span>
                    </label>
                    <div class="selectArea-selecttype">
                      <p data-toggle="dropdown" class="selectArea-selecttype-icon"><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                      <ul class="dropdown-menu selectArea-selecttype-list">
                        <li class="js-checkall-active" data-user-shop="<?php echo $user_shop->use_id; ?>" data-type="<?php echo $user_shop->use_group == 3 ? 'shop' : 'branch' ?>" data-status="1"><a href="javascript:void(0)">Kích hoạt</a></li>
                        <li class="js-checkall-deactive" data-user-shop="<?php echo $user_shop->use_id; ?>" data-type="<?php echo $user_shop->use_group == 3 ? 'shop' : 'branch' ?>" data-status="0"><a href="javascript:void(0)">Tắt kích hoạt</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="tt">Tên bài viết</div>
                </div>
              </th>
              <th class="tablet-none">Danh mục</th>
              <th class="tablet-none">Người đăng</th>
              <th class="tablet-none">Kích hoạt</th>
            </tr>
            <?php if (!empty($list_news)) { ?>
              <?php foreach ($list_news as $k => $v) { ?>
                <tr class="js-filter-item">
                  <td>
                    <label class="checkbox-position checkbox-style">
                      <input type="checkbox" name="checkall-item" value="<?=$v['not_id']?>"><span></span>
                    </label>
                    <div class="accordion js-accordion">
                      <div class="accordion-item">
                        <div class="accordion-toggle">
                          <div class="product-detail">
                            <div class="info">
                              <div class="img">
                                <?php
                                  $ogimage = site_url('/templates/home/styles/images/default/error_image_400x400.jpg');
                                  if (!empty($v['not_image']))
                                  {
                                    $image = $v['not_image'];
                                    $ogimage = $image;
                                  }
                                ?>
                                <img src="<?php echo $ogimage; ?>" alt="" onerror="error_image(this)">
                              </div>
                              <div class="name">
                                <?php
                                  $item_link = azibai_url() . '/tintuc/detail/' . $v['not_id'] . '/' . RemoveSign($v['not_title'])
                                ?>
                                <a class="js-open-link" target="_blank" href="<?php echo $item_link; ?>"><h3 class="two-lines"><?php echo $v['not_title']; ?></h3></a>
                                <p class="date">Người đăng: <?php echo $v['use_fullname'] ?><br>Ngày đăng <?php echo date('d-m-Y', $v['not_begindate']) ?><br>Lượt xem    <?php echo $v['not_view'] ?></p>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="accordion-panel product-detail-accordion">
                          <div class="tablet">
                            <table class="child-table">
                              <tr>
                                <td>Danh mục</td>
                                <td><?php echo $v['name_cate'] ?></td>
                              </tr>
                              <tr>
                                <td>Trạng thái</td>
                                <td class="js-trigger-change-status">
                                  <a href="javascript:void(0)"><?php echo $v['status'] == 1 ? 'Đã kích hoạt': 'Chưa kích hoạt' ?></a>
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>
                  </td>
                  <td class="tablet-none"><?php echo $v['name_cate'] ?></td>
                  <td class="tablet-none"><?php echo $v['use_fullname'] ?></td>
                  <td class="tablet-none">
                    <label class="checkbox-style-circle">
                        <input type="checkbox" data-user-shop="<?php echo $user_shop->use_id; ?>" data-type="<?php echo $user_shop->use_group == 3 ? 'shop' : 'branch' ?>" data-id="<?php echo $v['not_id'] ?>" class="js-not-status" value="1" <?php echo $v['status'] == 1 ? 'checked': '' ?>><span></span>
                    </label>
                  </td>
                </tr>
              <?php } ?>
            <?php } ?>
          </table>
        </div>

        <!-- pagination -->
        <?php echo $pagination ? $pagination : ''; ?>

      </div>
    </div>
  </section>
</main>


<footer id="footer" class="footer-border-top">
  <?php $this->load->view('e-azibai/common/common-html-footer'); ?>
  <?php $this->load->view('home/common/overlay_waiting')?>
  <script src="/templates/home/js/page_business.js"></script>
</footer>

<script type="text/javascript">

  $('.js-open-link').click(function () {
    window.open(this.href, '_blank');
  });

  $('.js-filter-item .js-trigger-change-status').click(function () {
    $(this).closest('.js-filter-item').find('.js-not-status').trigger('click');
  });

  $('.js-filter-item .js-not-status').change(function() {
    var element = this;
    var not_id = [$(this).attr('data-id')];
    var type = $(this).attr('data-type');
    var id_user_shop = $(this).attr('data-user-shop');
    var not_status = 0;
    if ($(this).is(":checked"))
    {
      not_status = 1;
    }

    $('.load-wrapp').show();
    $.ajax({
      type: 'POST',
      url: '<?=azibai_url("/home/api_affiliate/change_status_content_has_shared")?>',
      data: {list_not_id:not_id, status:not_status, type:type, user_id: id_user_shop},
      dataType: 'json',
      success: function (data) {
        var text = not_status == 1 ? 'Đã kích hoạt': 'Chưa kích hoạt' ;
        $($(element).closest('.js-filter-item').find('.js-trigger-change-status a')).text(text);

        if(data.status == 1) {
          alert("Thay đổi trạng thái thành công");
        } else {
          alert("Thanh đổi trạng thái thất bại");
        }
      },
      error: function (data) {
        alert('Có lỗi hệ thống xảy ra!');
      }
    }).always(function() {
      $('.load-wrapp').hide();
    });

  });

  var checking_all = false;
  var has_one_checkall = false
  var total_item = $('input[name="checkall-item"]').length;
  var count_item = 0;
  $('input[name="checkall"]').on('click', function () {
    if($(this).is(':checked')) {
      $.each($('input[name="checkall-item"]'), function (i, e) {
        $(e).prop('checked', true);
        checking_all = true;
        has_one_checkall = true;
        count_item = total_item;
      })
    } else {
      $.each($('input[name="checkall-item"]'), function (i, e) {
        $(e).prop('checked', false);
        checking_all = false;
        has_one_checkall = false;
        count_item = 0;
      })
    }
  })

  $('input[name="checkall-item"]').on('click', function () {
    // TH1: check all -> bỏ check 1 item
    if(checking_all == 1 && count_item == total_item && $(this).is(':checked') == false) {
      $('input[name="checkall"]').prop('checked', false);
      count_item = total_item - 1;
      checking_all = 0;
      has_one_checkall = 1;
    } else
    // TH2: uncheck all -> check 1 item còn lại chưa check
    if(checking_all == 0 && count_item == (total_item - 1) && $(this).is(':checked') == true) {
      $('input[name="checkall"]').prop('checked', true);
      count_item = total_item;
      checking_all = 1;
    } else
    // Th4: check và uncheck bình thường
    // 4.1 has_one_checkall = 1 // check all lần 1
    if(has_one_checkall == 1) {
      if($(this).is(':checked') == true) { // chua check
        count_item = count_item + 1;
      } else if($(this).is(':checked') == false) { // da check
        count_item = count_item - 1;
      }
    } else
    // 4.2 has_one_checkall = 0 // chưa check all => add item id vào list_accept
    if(has_one_checkall == 0) {
      if($(this).is(':checked') == true) { // chua check
        count_item = count_item + 1;
      } else if($(this).is(':checked') == false) { // da check
        count_item = count_item - 1;
      }
    }
  })

  $('.js-checkall-active, .js-checkall-deactive').click(function () {
    if(count_item > 0) {
      var type = $(this).attr('data-type');
      var id_user_shop = $(this).attr('data-user-shop');
      var not_status = $(this).attr('data-status');
      var not_ids = [];
      $.each($('input[name="checkall-item"]:checked'), function (i, e) {
        not_ids.push($(e).val());
      })
      var data = {list_not_id: not_ids, status:not_status, type:type, user_id: id_user_shop};
      $.ajax({
        type: 'POST',
        url: '<?=azibai_url("/home/api_affiliate/change_status_content_has_shared")?>',
        data: {list_not_id:not_ids, status:not_status, type:type, user_id: id_user_shop},
        dataType: 'json',
        success: function (data) {
          if(data.status == 1) {
            alert("Thay đổi trạng thái thành công");
            location.reload();
          } else {
            alert("Thanh đổi trạng thái thất bại");
          }
        },
        error: function (data) {
          alert('Có lỗi hệ thống xảy ra!');
        }
      }).always(function() {
        $('.load-wrapp').hide();
      });
    } else {
      alert('Chọn tối thiểu 1 bài viết');
    }
  })

</script>
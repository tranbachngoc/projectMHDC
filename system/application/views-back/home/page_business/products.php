<?php //dd($list_branch);die;
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
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt=""><?php echo $type_pro == 2 ? 'Phiếu mua hàng': 'Sản phẩm' ?> đã đăng</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="product-posted">
        <div class="product-posted-tit"><?php echo $type_pro == 2 ? 'PHIẾU MUA HÀNG': 'SẢN PHẨM' ?> ĐÃ ĐĂNG</div>
        <div class="product-posted-search">
          <div class="left">
            <a target="_blank"  href="<?php echo $type_pro == 2 ? base_url() .'coupon/add/' . $user['use_id'] : base_url() .'product/add/' . $user['use_id'] ?>" class="add-product"><img src="/templates/home/styles/images/svg/circle-plus.svg" class="mr05" width="23" alt="">Thêm <?php echo $type_pro == 2 ? 'phiếu mua hàng': 'sản phẩm' ?></a>
          </div>
          <div class="right">
            <div class="input-search">
              <img src="/templates/home/styles/images/svg/search.svg" alt="" class="js-search-button">
              <input type="text" name="pro_name" class="form-control" placeholder="Tìm theo tên <?php echo $type_pro == 2 ? 'phiếu mua hàng': 'sản phẩm' ?>" value="">
            </div>
            <div class="select-search">
              <select name="pro_cate" id="search_category">
                <option value="">Tìm theo danh mục</option>
                <?php if(!empty($list_cate)) { ?>
                  <?php foreach ($list_cate as $k_cate => $v_cate) { ?>
                    <option value="<?php echo $v_cate['cat_id'] ?>"><?php echo $v_cate['cat_name'] ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="product-posted-content">
          <table class="parent-table">
            <tr>
              <th>Tên <?php echo $type_pro == 2 ? 'Phiếu mua hàng': 'Sản phẩm' ?></th>
              <th class="tablet-none">Danh mục</th>
              <th class="tablet-none">Giá</th>
              <th class="tablet-none">Số lượng</th>
              <th class="tablet-none">Bán qua CTV</th>
              <th class="tablet-none">Kích hoạt</th>
              <?php if($user['use_group'] == 3) { ?>
              <th class="tablet-none">Chi nhánh</th>
              <?php } ?>
            </tr>
            <?php if (!empty($list_products)) { ?>
              <?php foreach ($list_products as $k => $v) { ?>
              <tr class="js-filter-item" data-search="<?=$v['pro_name']?>" data-cname="<?=$v['cat_name']?>">
                <td>
                  <div class="accordion js-accordion">
                    <div class="accordion-item">
                      <div class="accordion-toggle">
                        <div class="product-detail">
                          <label class="checkbox-style-circle">
                            <input type="checkbox" name="category" value="aaa"><span></span>
                          </label>
                          <div class="info">
                            <div class="img">
                              <?php
                                $ogimage = site_url('/templates/home/styles/images/default/error_image_400x400.jpg');
                                $pro_image = $v['pro_image'];
                                if (!empty($pro_image) && !empty($v['pro_dir']))
                                {
                                  $ogimage = $pro_image;
                                }
                              ?>
                              <img src="<?php echo $ogimage; ?>" alt="">
                            </div>
                            <div class="name">
                              <h3 class="two-lines"><?php echo $v['pro_name'] ?></h3>
                              <p class="date">Người đăng: <?php echo $v['pro_poster'] ?><br>Ngày đăng <?php echo date('d-m-Y', strtotime($v['created_date']))  ?><br>Lượt xem <?php echo $v['pro_view'] ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="accordion-panel product-detail-accordion">
                        <div class="tablet">
                          <table class="child-table">
                            <tr>
                              <td>Danh mục</td>
                              <td><?php echo trim($v['cat_name']) ?></td>
                            </tr>
                            <tr>
                              <td>Giá</td>
                              <td><?php echo number_format($v['pro_cost'],0,",","."); ?> VNĐ</td>
                            </tr>
                            <tr>
                              <td>Số lượng</td>
                              <td><?php echo $v['pro_instock'] ?></td>
                            </tr>
                            <tr>
                              <td>Trạng thái</td>
                              <td class="js-trigger-change-status">
                                <a href="javascript:void(0)"><?php echo $v['pro_status'] == 1 ? 'Đã kích hoạt': 'Chưa kích hoạt' ?></a>
                              </td>
                            </tr>
                            <tr>
                              <td>Bán qua CTV</td>
                              <td><?php echo $v['is_product_affiliate'] == 1 ? 'Có': 'Không' ?></td>
                            </tr>
                            <?php if($user['use_group'] == 3) { ?>
                            <tr>
                              <td>Chi nhánh</td>
                              <td><a class="js-send-branch" data-id="<?php echo $v['pro_id'] ?>" data-list='<?php echo json_encode($v['list_branchs']); ?>'>Chọn</a></td>
                            </tr>
                            <?php } ?>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="tablet-none"><?php echo trim($v['cat_name']) ?></td>
                <td class="tablet-none"><div class="text-bold text-red"><?php echo number_format($v['pro_cost'],0,",","."); ?> VNĐ</div></td>
                <td class="tablet-none"><div class="text-bold"><?php echo $v['pro_instock'] ?></div></td>
                <td class="tablet-none">
                    <label class="checkbox-style-circle">
                      <input type="checkbox" data-user-shop="<?php echo $user['use_id']; ?>" data-type="<?php echo $type_pro ?>" data-id="<?php echo $v['pro_id'] ?>" class="is_product_affiliate" name="is_product_affiliate" <?php echo $v['is_product_affiliate'] == 1 ? 'checked': '' ?> disabled="disabled" value="1"><span></span>
                    </label>
                </td>
                <td class="tablet-none">
                    <label class="checkbox-style-circle">
                      <input type="checkbox" data-user-shop="<?php echo $user['use_id']; ?>" data-type="<?php echo $user['use_group'] == 3 ? 'shop' : 'branch' ?>" data-id="<?php echo $v['pro_id'] ?>" class="pro_status" name="pro_status" <?php echo $v['pro_status'] == 1 ? 'checked': '' ?> value="1" ><span></span>
                    </label>
                </td>
                <?php if($user['use_group'] == 3) { ?>
                <td class="tablet-none"><a class="js-send-branch" data-id="<?php echo $v['pro_id'] ?>" data-list='<?php echo json_encode($v['list_branchs']); ?>'>Chọn</a></td>
                <?php } ?>
              </tr>
              <?php } ?>
            <?php } ?>
          </table>
        </div>
        <!-- pagination -->
        <?php echo $pagination ? $pagination : ''; ?>
        <!-- end pagination -->
      </div>
    </div>
  </section>
</main>


<!-- The Modal -->
<div class="modal listYourBranchs" id="listYourBranchs">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <form id="share_new_branch" method="POST">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Danh sách chi nhánh của bạn</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <input type="hidden" name="user_shop" value="<?php echo $user['use_id'] ?>">
            <input type="hidden" name="pro_id" class="js-send-pro-id">
            <ul>
              <?php if(!empty($list_branch)) { ?>
                <?php foreach ($list_branch as $k_bran => $v_bran) { ?>
                  <li class="mb10">
                    <label class="checkbox-style">
                      <input type="checkbox" name="list_bran[]" id="js-send-branch-<?php echo $v_bran['user_id'] ?>" class="js-send-branch-input" value="<?php echo $v_bran['user_id'] ?>">
                      <span><?php echo $v_bran['shop_name']; ?></span>
                    </label>
                  </li>
                <?php } ?>
              <?php } ?>
            </ul>
        </div>
        <div class="modal-footer">
          <div class="shareModal-footer">
            <div class="permision"></div>
            <div class="buttons-direct">
              <button class="btn-cancle">Hủy</button>
              <button class="btn-share js-btn-send-branch" type="button">Chia sẻ</button>
            </div>
          </div>
        </div>
      </form>
      <!-- End modal-footer -->
    </div>
  </div>
</div>
<!-- End The Modal -->


<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
<script src="/templates/home/js/page_business.js"></script>
</footer>



<script type="text/javascript">
  $('.js-send-branch').click(function ()
  {
    var list_send_branch = $(this).attr('data-list');
    $('#listYourBranchs .js-send-pro-id').val($(this).attr('data-id'));
    $('#listYourBranchs .js-send-branch-input').prop('checked', false);

    if(list_send_branch != '') {
      var list_send_branch = JSON.parse(list_send_branch);
      $.each(list_send_branch, function( index, value ) {
        $('#js-send-branch-'+ value).prop('checked', true);
      });
    }
    $('#listYourBranchs').modal('show');
  });

  $('.js-btn-send-branch').click(function(){
    $('.load-wrapp').show();
    $.ajax({
        type: 'POST',
        url: '<?=azibai_url("/home/api_affiliate/shop_share_product_to_branch")?>',
        data: $('#share_new_branch').serialize(),
        dataType: 'json',
        success: function (data) {
          if(data.status == 1) {
            alert('Chia sẻ sản phẩm thành công!');
            location.reload();
          } else {
            alert("Chia sẻ sản phẩm thất bại");
          }
        },
        error: function (data) {
            alert('Có lỗi hệ thống xảy ra!');
        }
    }).always(function() {
        $('.load-wrapp').hide();
    });
  });

  $('.js-filter-item .js-trigger-change-status').click(function () {
    $(this).closest('.js-filter-item').find('.pro_status').trigger('click');
  });

  $('.js-filter-item .pro_status').change(function() {
      var element = this;
      var pro_id = $(this).attr('data-id');
      var type = $(this).attr('data-type');
      var id_user_shop = $(this).attr('data-user-shop');
      var pro_status = 0;
      if ($(this).is(":checked"))
      {
        var pro_status = 1;
      }

      $('.load-wrapp').show();
      $.ajax({
        type: 'POST',
        url: '<?=azibai_url("/home/api_affiliate/change_status_product_post_by_self")?>',
        data: {list_pro_id:pro_id, status:pro_status, type:type, user_id: id_user_shop},
        dataType: 'json',
        success: function (data) {
          var text = pro_status == 1 ? 'Đã kích hoạt': 'Chưa kích hoạt' ;
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

</script>

<script>
	var cname = '';
	var search = '';
	$(document).ready(function(){
		$("input[name='pro_name']").on("keyup", function() {
			search = $(this).val().toLowerCase();

			filter_process(search, cname);
		});

		$("#search_category").on("change", function () {
			cname = $('#search_category option:selected').text().toLowerCase();
			$('#search_category option:selected').val() == '' ? cname = '' : '';
			search = $("input[name='pro_name']").val().toLowerCase();

			filter_process(search, cname);
		})

		function filter_process(search, cname) {
			if(search == '' && cname == '') {
				$(".js-filter-item").toggle(true);
			} else {
				if(cname == '') {
					$(".js-filter-item").filter(function(i, v) { // có key search
						$(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1);
					});
				} else if(cname != '') {
          $(".js-filter-item").filter(function(i, v) { // có key search
            $(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1 && $(v).attr('data-cname').toLowerCase().indexOf(cname) > -1);
					});
        }
			}
		}
	});
</script>

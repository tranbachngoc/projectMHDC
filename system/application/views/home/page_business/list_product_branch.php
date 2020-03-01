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
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt=""><?php echo $type_pro == 2 ? 'Phiếu mua hàng': 'Sản phẩm' ?> chờ duyệt</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="product-posted">  
        <div class="product-posted-tit"><?php echo $type_pro == 2 ? 'PHIẾU MUA HÀNG': 'SẢN PHẨM' ?> CHI NHÁNH CHỜ DUYỆT</div>
        <div class="product-posted-search">
          <div class="left">
            <div class="input-search"><img src="/templates/home/styles/images/svg/search.svg" alt=""><input type="text" name="pro_name" value="" class="form-control" placeholder="Tìm theo tên <?php echo $type_pro == 2 ? 'phiếu mua hàng': 'sản phẩm' ?>"></div>
          </div>
          <div class="right">
            <div class="select-search">
              <select name="search_branch" id="search_branch">
                <option value="">Tìm theo chi nhánh</option>
                <?php if(!empty($list_branch)) { ?>
									<?php foreach ($list_branch as $k_bran => $v_bran) { ?>
					  			<option value="<?php echo $v_bran['user_id'] ?>"><?php echo $v_bran['shop_name'] ?></option>
									<?php } ?>
								<?php } ?>
              </select>
            </div>
            <div class="select-search">
              <select name="search_category" id="search_category">
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
              <th class="tablet-none">Chia sẻ</th>
              <th class="tablet-none">Trang</th>
            </tr>
            <?php if (!empty($list_products)) { ?>
            	<?php foreach ($list_products as $k => $v) { ?>
	            <tr class="js-filter-item" data-search="<?=$v['pro_name']?>" data-cname="<?=$v['cat_name']?>" data-sname="<?=$v['shop_name']?>">
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
	                              <td><a href=""><?php echo $v['pro_status'] == 1 ? 'Đã kích hoạt': 'Chưa kích hoạt' ?></a></td>
	                            </tr>
	                            <tr>
	                              <td>Bán qua CTV</td>
	                              <td><?php echo $v['is_product_affiliate'] == 1 ? 'Có': 'Không' ?></td>
	                            </tr>
	                            <tr>
	                            	<td>Trang</td>
	                            	<td>
	                            	<label class="checkbox-style-circle">
					                    <input type="checkbox" value="1" data-user-shop="<?php echo $user['use_id']; ?>" data-type="<?php echo $type_pro ?>" data-id="<?php echo $v['pro_id'] ?>" class="js-choose-product"><span></span> 
					                </label>
					                </td>
	                            </tr>
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
	                    <input type="checkbox" value="1" data-user-shop="<?php echo $user['use_id']; ?>" data-type="<?php echo $type_pro ?>" data-id="<?php echo $v['pro_id'] ?>" class="js-choose-product"><span></span> 
	                </label>
	              </td class="tablet-none">
	            </tr>
							<?php } ?>
						<?php } ?>
          </table>
        </div>
        <!-- pagination -->
				<?=$pagination?>

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
	$('.js-choose-product').click(function(){
			var pro_id = $(this).attr('data-id');
			// var pro_type = $(this).attr('data-type');
			var id_user_shop = $(this).attr('data-user-shop');
	    $('.load-wrapp').show();
	    $.ajax({
	        type: 'POST',
	        url: '<?=azibai_url("/home/api_affiliate/shop_choose_product_branch")?>',
	        data: {pro_id:pro_id, user_id: id_user_shop},
	        dataType: 'json',
	        success: function (data) {
	            if (data.status == 1)
	            {
	            	alert("Lấy sản phẩm thành công!");
	              location.reload();
	            } else {
								alert("Lấy sản phẩm thất bại!");
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
	var sname = '';
	var cname = '';
	var search = '';
	$(document).ready(function(){
		$("input[name='pro_name']").on("keyup", function() {
			search = $(this).val().toLowerCase();

			filter_process(search, sname, cname);
		});

		$("#search_branch").on("change", function () {
			sname = $('#search_branch option:selected').text().toLowerCase();
			$('#search_branch option:selected').val() == '' ? sname = '' : '';
			search = $("input[name='pro_name']").val().toLowerCase();

			filter_process(search, sname, cname);
		})

		$("#search_category").on("change", function () {
			cname = $('#search_category option:selected').text().toLowerCase();
			$('#search_category option:selected').val() == '' ? cname = '' : '';
			search = $("input[name='pro_name']").val().toLowerCase();

			filter_process(search, sname, cname);
		})

		function filter_process(search, sname, cname) {
			if(search == '' && sname == '' && cname == '') {
				$(".js-filter-item").toggle(true);
			} else {
				if(sname == '' && cname == '') {
					$(".js-filter-item").filter(function(i, v) { // có key search
						$(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1);
					});
				} else if(sname == '' || cname == '') {
					$(".js-filter-item").filter(function(i, v) { // có key search và (chi nhánh hoặc danh mục)
						if(sname != '') {
							$(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1 && $(v).attr('data-sname').toLowerCase().indexOf(sname) > -1);
						}
						if(cname != '') {
							$(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1 && $(v).attr('data-cname').toLowerCase().indexOf(cname) > -1);
						}
					});
				} else if(sname != '' && cname != '') {
					$(".js-filter-item").filter(function(i, v) { // có key search và chi nhánh và danh mục
						$(v).toggle($(v).attr('data-search').toLowerCase().indexOf(search) > -1 && $(v).attr('data-sname').toLowerCase().indexOf(sname) > -1 && $(v).attr('data-cname').toLowerCase().indexOf(cname) > -1);
					});
				}
			}
		}
	});
</script>

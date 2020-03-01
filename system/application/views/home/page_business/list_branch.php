<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">

<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">
  <?php 
    $avatar_default  = site_url('media/images/avatar/default-avatar.png');
  ?>      
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Danh sách chi nhánh</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
        
      </div>
    </div>
    <div class="container">
      <div class="product-posted">  
        <div class="product-posted-tit">DANH SÁCH CHI NHÁNH</div>
        <div class="product-posted-search">
              <div class="left">
                <!-- <a href="" class="add-product"><img src="/templates/home/styles/images/svg/circle-plus.svg" class="mr05" width="23" alt="">Thêm chi nhánh</a> -->
              </div>
              <div class="right">
                <div class="input-search p05 text-center">Số lượng chi nhánh: <strong><?php echo !empty($list_bran) ? count($list_bran) : '0'; ?></strong></div>
              </div>
            </div>
        <div class="product-posted-content">
          <table class="parent-table">
            <tr>
              <th>Chi nhánh</th>
              <th class="tablet-none">Thông tin chi nhánh</th>
              <th class="tablet-none">Số cộng tác viên</th>
              <th class="tablet-none">Cấu hình</th>
              <th class="tablet-none">Nhắn tin</th>
            </tr>
            <?php if (!empty($list_bran)) { ?>
            	<?php foreach ($list_bran as $key => $value) { ?>
                <?php 
                  if ($value->domain != '') 
                  {
                    $linktoshop = 'http://' . $value->domain;
                  } 
                  else 
                  {
                    $linktoshop = '//' . $value->sho_link . '.' . domain_site;
                  }
                ?>
		            <tr>
		              <td>
		                <div class="accordion js-accordion">
		                  <div class="accordion-item">
		                    <div class="accordion-toggle">
		                      <div class="product-detail">

		                        <!-- <label class="checkbox-style-circle">
		                          <input type="checkbox" name="category" value="aaa"><span></span> 
		                        </label> -->
		                        <div class="info">
		                          <div class="img"><a href="<?php echo $linktoshop ?>"><img src="<?php echo !empty($value->sho_logo) ? $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $value->sho_dir_logo . '/' . $value->sho_logo : $avatar_default  ?>" alt=""></a></div>
		                          <div class="name">
		                            <h3 class="two-lines"><a href="<?php echo $linktoshop ?>"><?php echo $value->use_username; ?></a></h3>
		                            <p class="date">
		                            	<?php 
		                            		if (!empty($value->create_by)) 
		                            		{
		                            			echo 'Tạo bởi: Nhân viên - '. $value->create_by;
		                            		} else {
		                            			echo 'Tạo bởi: Gian hàng';
		                            		} 
		                            	?>
		                            </p>
		                          </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="accordion-panel product-detail-accordion">
		                      <div class="tablet">
		                        <table class="child-table">
		                          <tr>
		                            <td>Thông tin chi nhánh</td>
		                            <td>
		                            	<a href="<?php echo $linktoshop ?>"><?php echo $value->sho_name ?></a>
		                            	<br>
		                            	<?php echo $value->sho_email ?>
		                            	<br>
		                            	<?php echo $value->sho_mobile ?>
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>Số cộng tác viên</td>
		                            <td><?php echo $value->total_ctv ?></td>
		                          </tr>
		                          <tr>
		                            <td>Cấu hình</td>
		                            <td>
		                            	<img class="cursor-pointer js-setting-branch" data-id="<?php echo $value->use_id ?>" src="/templates/home/styles/images/svg/settings.svg" alt="">
		                            </td>
		                          </tr>
		                          <tr>
		                            <td>Nhắn tin</td>
		                            <td>
		                            	<img class="cursor-pointer" src="/templates/home/styles/images/svg/mess.svg" alt="">
		                            </td>
		                          </tr>
		                        </table>
		                      </div>                          
		                    </div>
		                  </div>
		                  
		                </div>
		              </td>
		              <td class="tablet-none">
		              	<a href="<?php echo $linktoshop ?>"><?php echo $value->sho_name ?></a>
                    	<br>
                    	<?php echo $value->sho_email ?>
                    	<br>
                    	<?php echo $value->sho_mobile ?>
		              </td>
		              <td class="tablet-none"><?php echo $value->total_ctv ?></td>
		              <td class="tablet-none">
		                <img class="cursor-pointer js-setting-branch" data-id="<?php echo $value->use_id ?>" src="/templates/home/styles/images/svg/settings.svg" alt="">
		              </td>
		              <td class="tablet-none">
		                <img class="cursor-pointer" src="/templates/home/styles/images/svg/mess.svg" alt="">
		              </td>
		            </tr>
        		<?php } ?>
        	<?php } ?>
          </table>
        </div>
        
      </div>        
    </div>
  </section>
</main>

<!-- The Modal -->
<div class="modal settingBranch" id="settingBranch">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thiết lập chi nhánh <span class="name_branch"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <form id="js-form-config-bran" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_branch" class="id_branch">
        <div class="creatBranch-content settingBranch-content">
          <?php if (!empty($master_rule)) { ?>
            <?php foreach ($master_rule as $key => $item) { ?>
              <p class="mb10">
                <label class="checkbox-style">
                  <input type="checkbox" class="shop_rule" name="shop_rule[]" value="<?php echo $item->id; ?>" id="shop_rule_<?php echo $item->id; ?>"><span><?php echo $item->content; ?></span>
                </label>
              </p>
              <?php if ($item->id == 50) { ?>
                <div class="shop_rule_bank">
                  <div class="form-group">
                    <label>Tên ngân hàng *</label>
                    <input type="text" name="namebank_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Chi nhánh / Phòng giao dịch *</label>
                    <input type="text" name="addbank_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Họ và tên chủ tài khoản *</label>
                    <input type="text" name="accountname_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Số tài khoản *</label>
                    <input type="text" name="accountnum_regis" class="form-control" maxlength="20"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                </div>
              <?php } else if ($item->id == 51) { ?>
                <div class="shop_rule_warehouse">
                  <div class="form-group">
                    <label>Tỉnh /  thành phố </label>
                    <select name="province_kho_shop" id="province_kho_shop" class="js-province form-control" required>
                        <option value="">Chọn Tỉnh/Thành Kho</option>
                        <?php foreach ($province as $provinceArray) { ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>">
                                  <?php echo $provinceArray->pre_name; ?>
                                </option>
                        <?php } ?>
                    </select>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Quận / Huyện</label>
                    <select name="district_kho_shop" id="district_kho_shop" class="js-district form-control" required>
                        <option value="">Chọn Quận / Huyện</option>
                    </select>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Địa chỉ kho hàng</label>
                    <input type="text" name="address_kho_shop" class="form-control"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        </div>
      </div>   
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle">Hủy</button>
            <button class="btn-share js-config-bran" type="button">Xong</button>
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

	$('body').on('change', '.js-province', function() {
	  var id_province = $(this).val();
	  $('.load-wrapp').show();
	  $.ajax({
	        type: "POST",
	        url: "/v-checkout/get-district",
	        data: {id_province: id_province},
	        dataType: "json",
	        success: function (data) {
	            var str = '<option value="">Chọn Quận/Huyện</option>';
	            if (data.error == false && data.result.length > 0) {
	              $.each(data.result, function( index, value ) {
	                str += '<option value="'+value.DistrictCode+'">'+value.DistrictName+'</option>';
	              });
	            }
	            $('.js-district').html(str);
	        }
	  }).always(function() {
	      $('.load-wrapp').hide();
	  });
	});

	$('.js-setting-branch').click(function () {
		var id_branch = $(this).attr('data-id');
		$('.load-wrapp').show();
		$.ajax({
		    type: "POST",
		    url: "/page-business/get-setting-branch",
		    data: {id_branch: id_branch},
		    dataType: "json",
		    success: function (data) {
		        if (data.error == false) {
		        	$('#settingBranch .id_branch').val(id_branch);
		        	$('#settingBranch .name_branch').text(data.response.sho_name);

		        	$('#settingBranch input[name="namebank_regis"]').val(data.response.namebank_regis);
		        	$('#settingBranch input[name="addbank_regis"]').val(data.response.addbank_regis);
		        	$('#settingBranch input[name="accountname_regis"]').val(data.response.accountname_regis);
		        	$('#settingBranch input[name="accountnum_regis"]').val(data.response.accountnum_regis);
		        	$('#settingBranch input[name="address_kho_shop"]').val(data.response.address_kho_shop);

		        	$('#province_kho_shop').val(data.response.sho_kho_province);

		        	var str = '<option value="">Chọn Quận/Huyện</option>';
		            if (data.response.list_district.length > 0) {
		              $.each(data.response.list_district, function( index, value ) {
		                str += '<option value="'+value.DistrictCode+'">'+value.DistrictName+'</option>';
		              });
		            }
		            $('.js-district').html(str);

		            $('#district_kho_shop').val(data.response.sho_kho_district);

		            if (data.response.rule.length > 0) {
		            	$.each(data.response.rule, function( index, value ) {
		                	$('#shop_rule_' + value).prop( "checked", true );
		              	});
		            }
		        	
					if ($('input#shop_rule_50').is(':checked')) {
					  $('.shop_rule_bank').fadeOut(0);
					  $('.shop_rule_warehouse input').removeAttr('required');
					  $('.shop_rule_warehouse select').removeAttr('required');
					} else {
					  $('.shop_rule_bank').fadeIn(0);
					  $('.shop_rule_bank input').attr('required','required');
					  $('.shop_rule_bank select').attr('required','required');
					}

					if ($('input#shop_rule_51').is(':checked')) {
					  $('.shop_rule_warehouse').fadeOut(0);
					  $('.address_kho_shop input').removeAttr('required');
					  $('.address_kho_shop select').removeAttr('required');
					} else {
					  $('.shop_rule_warehouse').fadeIn(0);
					  $('.address_kho_shop input').attr('required','required');
					  $('.address_kho_shop select').attr('required','required');
					}

					$('#settingBranch').modal('show');

		        }
		    }
		}).always(function() {
		  $('.load-wrapp').hide();
		});
	});

	$('input#shop_rule_50').change(function () {
      if ($(this).is(':checked')) {
          $('.shop_rule_bank').fadeOut(400);
          $('.shop_rule_warehouse input').removeAttr('required');
          $('.shop_rule_warehouse select').removeAttr('required');
      } else {
          $('.shop_rule_bank').fadeIn(400);
          $('.shop_rule_bank input').attr('required','required');
          $('.shop_rule_bank select').attr('required','required');
      }
  	});

	$('input#shop_rule_51').change(function () {
	  if ($(this).is(':checked')) {
	      $('.shop_rule_warehouse').fadeOut(400);
	      $('.address_kho_shop input').removeAttr('required');
	      $('.address_kho_shop select').removeAttr('required');
	  } else {
	      $('.shop_rule_warehouse').fadeIn(400);
	      $('.address_kho_shop input').attr('required','required');
	      $('.address_kho_shop select').attr('required','required');
	  }
	});

  $('.js-config-bran').click(function(){
      var error_cofig_bran = false;
      var id_branch = $('#js-form-config-bran .id_branch').val();
      $('#js-form-config-bran .js-msg-error').text('');
      if (!$('input#shop_rule_50').is(':checked')) 
      {
          // 250
          var namebank_regis = $.trim($('.shop_rule_bank input[name="namebank_regis"]').val());
          // 250 
          var addbank_regis = $.trim($('.shop_rule_bank input[name="addbank_regis"]').val());
          // 250
          var accountname_regis = $.trim($('.shop_rule_bank input[name="accountname_regis"]').val());
          // 20
          var accountnum_regis = $.trim($('.shop_rule_bank input[name="accountnum_regis"]').val());

          if (namebank_regis == '') 
          {
              error_cofig_bran = true;
              $('.shop_rule_bank input[name="namebank_regis"]').next('.js-msg-error').text('Bạn chưa nhập tên ngân hàng!'); 
          } 
          else if (namebank_regis.length > 250) 
          {
              $('.shop_rule_bank input[name="namebank_regis"]').next('.js-msg-error').text('Tên ngân hàng không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }
          

          if (addbank_regis == '') 
          {
              $('.shop_rule_bank input[name="addbank_regis"]').next('.js-msg-error').text('Bạn chưa nhập Chi nhánh / Phòng giao dịch!');
              error_cofig_bran = true; 
          } 
          else if (addbank_regis.length > 250)
          {
              $('.shop_rule_bank input[name="addbank_regis"]').next('.js-msg-error').text('Chi nhánh / Phòng giao dịch không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }

          if (accountname_regis == '') 
          {
              error_cofig_bran = true;
              $('.shop_rule_bank input[name="accountname_regis"]').next('.js-msg-error').text('Bạn chưa nhập họ và tên chủ tài khoản!');
          }
          else if (accountname_regis.length > 250)
          {
              $('.shop_rule_bank input[name="accountname_regis"]').next('.js-msg-error').text('Họ và tên chủ tài khoản không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }

          if (accountnum_regis == '') 
          {
              $('.shop_rule_bank input[name="accountnum_regis"]').next('.js-msg-error').text('Bạn chưa nhập số tài khoản!');
              error_cofig_bran = true; 
          }
          else if (accountnum_regis.length > 20)
          {
              $('.shop_rule_bank input[name="accountnum_regis"]').next('.js-msg-error').text('Số tài khoản không được quá 20 ký tự!');
              error_cofig_bran = true; 
          } 
      }

      if (!$('input#shop_rule_51').is(':checked')) 
      {
          var province_kho_shop = $.trim($('#province_kho_shop').val());
          var district_kho_shop = $.trim($('#district_kho_shop').val());
          var address_kho_shop = $.trim($('.shop_rule_warehouse input[name="address_kho_shop"]').val());

          if (province_kho_shop == '') 
          {
              $('#province_kho_shop').next('.js-msg-error').text('Bạn chưa chọn "Tỉnh / thành phố"!');
              error_cofig_bran = true; 
          }

          if (district_kho_shop == '') 
          {
              $('#district_kho_shop').next('.js-msg-error').text('Bạn chưa chọn "Quận / Huyện"!');
              error_cofig_bran = true; 
          }

          if (address_kho_shop == '') 
          {
              $('.shop_rule_warehouse input[name="address_kho_shop"]').next('.js-msg-error').text('Bạn chưa nhập địa chỉ kho hàng!');
              error_cofig_bran = true; 
          } 
          else if (address_kho_shop.length > 255)
          {
              $('.shop_rule_warehouse input[name="address_kho_shop"]').next('.js-msg-error').text('Địa chỉ kho hàng không được quá 255 ký tự!');
              error_cofig_bran = true;  
          }
      }

      if (!error_cofig_bran && id_branch > 0) 
      {
        $('.load-wrapp').show();
        $.ajax({
            type: 'POST',
            url: '/page-business/config-branch/' + id_branch,
            data: $('#js-form-config-bran').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.error_system) 
                {
                  $('#js-form-config-bran .js-msg-error-sytem').text('Cấu hình chi nhánh thất bại!');
                } 
                else
                {
                  alert('Cấu hình chi nhánh thành công');
                  location.reload();
                }
            },
            error: function (data) {
                alert('Error');
            }
        }).always(function() {
            $('.load-wrapp').hide();
        });
      }
      return false;
  });
</script>
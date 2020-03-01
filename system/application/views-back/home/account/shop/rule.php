<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php echo $this->lang->line('edit_shop_account_shop_rule_menu'); ?>
	    </h4>
	    <form name="frmEditShopRule" id="frmEditShopRule" method="post">


		<?php if ($shopid > 0) { ?>

		    <?php if ($successEditShopRuleAccount == false) { ?>

			<ul class="chinhsach list-group ">
			    <?php
			    if (isset($master_rule)) {
				$chinhsachcoban_first = true;
				$chinhsachbaohanh_first = true;
				$chinhsachmuahang_first = true;
				$chinhsachthanhtoan_first = true;
				$chinhsachvanchuyen_first = true;
				$chinhsachkhac_first = true;
				foreach ($master_rule as $key => $item) {
				    ?>
				    <?php if ($item->type == 1 && $chinhsachcoban_first == true) { ?>
		    		    <li class="chinhsach_title list-group-item active">Thông tin cơ bản</li>
					<?php
					$chinhsachcoban_first = false;
				    } else if ($item->type == 2 && $chinhsachbaohanh_first == true) {
					?>
		    		    <li class="chinhsach_title list-group-item active">Chính sách bảo hành</li>
					<?php
					$chinhsachbaohanh_first = false;
				    } else if ($item->type == 3 && $chinhsachmuahang_first == true) {
					?>
		    		    <li class="chinhsach_title list-group-item active">Chính sách đặt hàng, mua hàng</li>
					<?php
					$chinhsachmuahang_first = false;
				    } else if ($item->type == 4 && $chinhsachthanhtoan_first == true) {
					?>
		    		    <li class="chinhsach_title list-group-item active">Phương thức thanh toán</li>
					<?php
					$chinhsachthanhtoan_first = false;
				    } else if ($item->type == 5 && $chinhsachvanchuyen_first == true) {
					?>
		    		    <li class="chinhsach_title list-group-item active">Chính sách vận chuyển</li>
					<?php
					$chinhsachvanchuyen_first = false;
				    } else if ($item->type == 6 && $chinhsachkhac_first == true) {
					?>
		    		    <li class="chinhsach_title list-group-item active">Chính sách về sản phẩm khác</li>
					<?php
					$chinhsachkhac_first = false;
				    }
				    ?>
				    <li class="chinhsach_list list-group-item">
					<input type="checkbox" <?php
					if (isset($shop_rule) && in_array($item->id, $shop_rule)) {
					    echo 'checked="checked"';
					}
					?> value="<?php echo $item->id; ?>" name="shop_rule[]" id="shop_rule_<?php echo $item->id; ?>">
					<label><?php echo $item->content; ?></label>
				    </li>
				    <?php
				}
			    }
			    ?>
			</ul>
			<div class="form-group">    
			    <?php $this->load->view('home/common/tinymce'); ?>
			    <textarea class="editor form-control" name="txtContent"><?php echo $txtContent; ?></textarea>
			</div>


			<?php if (isset($imageCaptchaSendContactAccount)) { ?>
	    		<p><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:
	    		    <img src="<?php echo $imageCaptchaEditShopRuleAccount; ?>" width="151" height="30" /><br />
	    		    <input type="text" onkeypress="return submitenter(this, event)" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_shop', 1);" onblur="ChangeStyle('captcha_shop', 2);" />
	    		</p>              
			<?php } ?>
			<p class="text-center">  
			    <input type="button" onclick="CheckInput_EditShopRule();" name="submit_editshoprule" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="btn btn-azibai" />
			    <input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="btn btn-default" />
			</p>
			<input type="hidden" name="isEditShopRule" id="isEditShopRule" value=""/>
			<input type="hidden" name="current_captcha" id="current_captcha" value="<?php echo $captcha; ?>"/>
		    <?php } else { ?>
			<div class="bg-success text-center" style="padding: 15px">
			    <p><?php echo $this->lang->line('success_edit_shop_account'); ?></p>
			    <p><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>

			</div>
		    <?php } ?>
		<?php } else { ?>
    		<tr>
    		    <td> <div class="noshop"><?php echo $this->lang->line('noshop'); ?> <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div></td>
    		</tr>
		<?php } ?>
		</table>
	    </form>
	</div>
    </div>
</div>
<!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
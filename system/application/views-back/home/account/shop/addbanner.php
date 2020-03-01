<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
		<div class="col-md-9 col-sm-8 col-xs-12">
			<h4 class="page-header text-uppercase" style="margin-top:10px">
                THÊM QUẢNG CÁO
            </h4>
			<form enctype="multipart/form-data" method="post" id="addbanner" name="addbanner" class="form">
                  <p>Những ô có dấu sao là <font color="#FF0000"><b>*</b></font> bắt buộc phải nhập.</p>
				  <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font> Tên quảng cáo 
                        </div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <input type="text" maxlength="255" onblur="ChangeStyle('ub_name_0',2)" onfocus="ChangeStyle('ub_name_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="form-control" value="" name="ub_name" id="ub_name_0" alt="Tên banner" autocomplete="off">
						</div>
                        <div class="col-md-3 col-sm-12 col-xs-12"> </div>
				 </div>
				 <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font> Định dạng 
                        </div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <select onchange="changeBannerFormat(this.value)" size="1" name="ub_format" id="ub_format_0" alt="Định dạng Banner" class="form-control">
								<option value="1" title="Ảnh">Ảnh</option>
								<option value="2" title="Flash">Flash</option>
								<option value="3" title="HTML">HTML</option>
						  </select>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12"> </div>
				 </div>
				 <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font> Vị trí 
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12">
							<select  name="ub_type" id="ub_type_0" title="Loại banner" class="form-control" onchange="thong_bao_kich_thuoc_banner(this.value)">
								<option value="0" title="Chọn vị trí">-- Chọn vị trí -- </option>
								<option value="1" title="Phía trên">Phía trên</option>
								<option value="2" title="Bên trái">Bên trái</option>
								<option value="3" title="Bên phải">Bên phải</option>                         
						    </select>
							<div id="quydinhichtuocbanner" class="form_asterisk"> </div>
                        </div>
				 </div>
				 <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font> Ảnh banner
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file"  class="form-control" alt="Ảnh banner" id="ub_picture" name="isAddBannerisAddBanner" size="32">
							<div>(Dung lượng tối đa <font color="#ff0000">1 MB</font>)</div>						
							
							<img id="imgpreview" src="/images/img_not_available.png" alt="" class="img-responsive"  />
							
                        </div>
				 </div>
                      
                      <div class="row form-group form-inline">
					   <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font> Kích thước
                        </div>
						
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        	<input type="text" class="form-control" autocomplete="off" alt="Chiều rộng" id="ub_width_0" name="ub_width" value="0" maxlength="11">
                          x
                            <input type="text" class="form-control" autocomplete="off" alt="Chiều cao" id="ub_height_0" name="ub_height" value="0" maxlength="11">
                        </div>
						
                      </div>
					  
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							Nội dung HTML
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">                        	     
                            <textarea class="form-control"  name="ub_html" id="ub_html"></textarea>
                         </div>						
                      </div>
					  
                     <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							Liên kết (http://)
						</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">   
                        	<input type="text" maxlength="255" onblur="ChangeStyle('ub_link_0',2)" onfocus="ChangeStyle('ub_link_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="form-control" value="" name="ub_link" id="ub_link_0" alt="Liên kết" autocomplete="off">
                        </div>
                      </div>
					  
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Click vào mở ra</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">   
                        	<select size="1"  name="ub_target" id="ub_target_0" alt="Mở ra" class="form-control">
                            <option value="_blank" title="Trang mới">Trang mới</option>
                            <option value="_self" title="Hiện hành">Hiện hành</option>
                          </select>
                        </div>
                      </div>
                      
                     <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
							<font color="#FF0000"><b>*</b></font>Thứ tự</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" maxlength="255" onblur="ChangeStyle('ub_order_0',2)" onfocus="ChangeStyle('ub_order_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="form-control" value="1" name="ub_order" id="ub_order_0" title="Thứ tự" autocomplete="off"></div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Ngày bắt đầu</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        	<input type="date" maxlength="" value="" name="ub_str_start_date" id="ub_str_start_date" title="Ngày (yyyy/mm/dd)" autocomplete="off" class="form-control">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Ngày kết thúc</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        	<input type="date" maxlength="" value="" name="ub_str_end_date" id="ub_str_end_date" title="Ngày (yyyy/mm/dd)" autocomplete="off" class="form-control">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Kích hoạt banner</div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<input type="checkbox" checked="checked" value="1" name="ub_active" id="ub_active_0">
						</div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
						
						<font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?></div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                        	<img src="<?php echo $imageCaptchaAddBanner; ?>" width="151" height="30" />
						</div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                        	<input type="text" onkeypress="return submitenter(this,event)" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="form-control" onfocus="ChangeStyle('captcha_shop',1);" onblur="ChangeStyle('captcha_shop',2);" />
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="button" onclick="CheckInput_addbanner();" name="submit_addbanner" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="btn btn-azibai" />
                          <input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account/shop/addbanner')" class="btn btn-default" />
                        </div>
                      </div>
                    	<input type="hidden" name="isAddBanner" id="isAddBanner" value="" >
                        <input type="hidden" name="current_captcha" id="current_captcha" value="<?php echo $captcha;?>"/>
                   
                </form>
				
				<script>
					function readURL(input) {
						if (input.files && input.files[0]) {
							var reader = new FileReader();
							reader.onload = function (e) {
								$('#imgpreview').attr('src', e.target.result);
							}
							reader.readAsDataURL(input.files[0]);
						}
					}
					$("#ub_picture").change(function () {
						readURL(this);
					});
				</script>
	    
		</div>
	</div>	
</div>	
<?php $this->load->view('home/common/footer'); ?>
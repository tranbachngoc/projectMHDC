<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<script>
	
	function f_gold_pay_accept(){
		if(document.getElementById('check-regulations').checked==false)
		{
			alert("Bạn chưa đồng ý với điều khoản của gian hàng");
			return false;
		}
		document.forms["cartRegisterFormStep4"].submit();
		return true;		
	}
</script>
<div class="col-lg-9">
<?php if($tn_thanh_cong!=1) { ?>
<div class="classic-popup_eb">
    <div class="classic-popup-top_eb">
      <div class="right_eb">
        <div class="bg_eb"></div>
      </div>
    </div>
    <div class="classic-popup-main_eb">
      <div class="classic-popup-title_eb">
        <div class="fl_eb">Thanh Toán nạp Gold</div>
        
        <div class="c_eb"></div>
      </div>
      <div class="classic-popup-content_eb">
        <div class="content_eb" style="padding: 10px 20px;">
          <div id="idUserInfo" class="box-gradien_eb pBottom10_eb">
            <div class="title_eb">Thông tin khách hàng</div>
            <div class="content_eb" id="pTop10"><a onclick="history.go(-1)" style="float:right" class="blueButton_eb"><span><span>SỬA THÔNG TIN CÁ NHÂN</span></span></a>
              <div><strong>Tài khoản được nạp Gold: </strong><span class="cff9200_eb"><?php echo $userinfo->use_username; ?></span></div>
              <div class="mTop5_eb"><strong>Họ tên quý khách: </strong><span class="cff9200_eb"><?php echo $tn_ho_ten; ?></span></div>
              <div class="mTop5_eb"><strong>Điện thoại di động: </strong><span class="cff9200_eb"><?php echo $tn_dien_thoai; ?></span></div>
              <div class="mTop5_eb"><strong>Thời gian thu tiền: </strong><span class="cff9200_eb"><?php echo $tn_thoi_gian; ?> <?php echo $tn_ngay; ?></span></div>
              <div class="mTop5_eb"><strong>Địa điểm thu tiền của quý khách: </strong><span class="cff9200_eb"><?php echo $tn_dia_chi; ?></span></div>
              <div class="c_eb"></div>
              <form name="cartRegisterFormStep4" id="cartRegisterForm" method="post" action="<?php echo base_url(); ?>account/naptien/naptienthuchienthanhcong">
            	  <input name="soh_userid" type="hidden" value="<?php echo $userinfo->use_id; ?>" />
              		<input name="soh_username" type="hidden" value="<?php echo $userinfo->use_username; ?>" />
                    <input name="soh_phone" type="hidden" value="<?php echo $tn_dien_thoai ?>" />
                    <input name="soh_address" type="hidden" value="<?php echo $tn_dia_chi ?>" />
                    <input name="soh_province" type="hidden" value="<?php echo $tn_thanh_pho ?>" />                    
                     <input name="type" type="hidden" value="<?php echo $type; ?>" />
                     <input name="gold_money" type="hidden" value="<?php echo $gold_money; ?>" /> 
                     <input name="soh_ho_ten" type="hidden" value="<?php echo $tn_ho_ten; ?>" /> 
                       <input name="soh_am_pm" type="hidden" value="<?php echo $tn_thoi_gian; ?>" />    
                       <input name="soh_week" type="hidden" value="<?php echo $tn_ngay; ?>" />                    
              </form>
            </div>
          </div>
          <div id="paymentTypeInfo" class="box-gradien_eb pBottom10_eb pTop15_eb mTop10_eb">
            <div class="title_eb">Hình thức thanh toán: <span style="font-size: 12px; font-weight: normal; text-transform: none;">Thu tiền tận nơi.</span></div>
            <div class="content_eb">
              <div class="fl_eb"><a href="https://sohapay.com/" target="_blank" title="sohapay.com"><img width="136" height="55" border="0" src="<?php echo base_url();?>templates/home/images/costinfo.png"></a></div>
              <div class="fl_eb">
                <div class="mLeft25_eb">
                  <div>
                    <div>
                      <div class="mTop5_eb">Nhân viên azibai.com sẽ liên hệ trực tiếp với bạn và đến thu tiền tại địa chỉ bạn đã đăng ký với azibai.com</div>
                      <b style="color: red;">Chú ý:</b> Chỉ áp dụng với khách hàng ở các quận nội thành Hà Nội và Tp.Hồ Chí Minh.</div>
                  </div>
                </div>
              </div>
              <div class="c_eb"></div>
            </div>
          </div>
          <div class="box-gradien_eb mTop10_eb" id="box-gradien2">
            <div class="title_eb mTop10_eb mLeft10_eb">Thông tin dịch vụ</div>
            <div class="content_eb" id="pTop5">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="cart-finish_eb">
                <tbody>
                  <tr>
                    <th align="center" class="head_eb bRight_eb">Dịch vụ</th>
                    <th align="center" class="head_eb">Tổng giá trị thanh toán</th>
                  </tr>
                  <tr>
                    <td valign="top" align="center" style="font-size:16px;color:#00A0DC" class="item_eb bRight_eb">Nạp <font color="#F10000"><b> <?php echo number_format($gold_money, 0, '.', '.');  ?></b></font> VNĐ cho thành viên <font color="#F10000"><b><?php echo $userinfo->use_username; ?></b></font></td>
                    <td width="30%" valign="top" align="center" style="font-size:16px;color:#00A0DC" class="item_eb"><span id="bgAllPrice"><?php echo number_format($gold_money, 0, '.', '.');  ?></span> VNĐ</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="mTop10_eb" style="font-size: 16px;">
            <input type="checkbox" checked="checked" id="check-regulations" class="checkbox">
            <label for="check-regulations"><b>Tôi đã đọc và đồng ý với các <a href="<?php echo base_url(); ?>content/33" target="_blank">điều khoản</a> của azibai.com</b></label>
          </div>
           <div class="k_btn">
        <div class="k_btnleft"><a onclick="pay_cancel();" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
        <div class="k_btnright">            
            
            <div class="k_btnnaptien"><a onclick="history.go(-1)" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a></div>
            <div class="k_btnnaptien" style="width:120px"><a class="blueButton_eb mLeft10_eb" id="cart_pay_button"><span onclick="f_gold_pay_accept();"><span>THANH TOÁN</span></span></a></div>
              <div class="c_eb"></div>
           
        </div>
          </div>
          <div class="c_eb"></div>
        </div>
      </div>
    </div>
    <div class="classic-popup-bottom_eb">
      <div class="right_eb">
        <div class="bg_eb"></div>
      </div>
    </div>
  </div>
   <?php } else { ?>
                     <p class="text-center"><a href="<?php echo base_url(); ?>account/danhsachnaptien">Click vào đây để tiếp tục</a></p>
                     <div  style="width:700px; color:#0A9CCA; line-height:160%; padding-top:20px; padding-left:50px; text-align:left;  font-size:13px; font-weight:bold;">
                          Đơn đặt hàng nạp <font color="#FF0000"> <?php echo number_format($gold_money, 0, '.', '.');  ?> </font>VNĐ cho tài khoản <font color="#FF0000">  <?php echo $userinfo->use_username; ?></font> của bạn đã được lưu lại, hãy chủ động liên hệ với azibai.com hoặc chờ nhân viên azibai.com gọi điện xác nhận đơn hàng và tiến hành thu tiền  Nạp tiền cho quý khách!
							<br/>
						Cảm ơn bạn đã sử dụng dịch vụ của azibai.com !
                        </div>
  <?php } ?>
    </div>
        </div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

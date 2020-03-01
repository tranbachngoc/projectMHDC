<?php $this->load->view('home/common/header'); ?>
<div class="container">
  <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col-lg-9">
<script>
	function isInt(x) {
	  var y=parseInt(x);
	  if (isNaN(y)) return false;
	  return x==y && x.toString()==y.toString();
	}
	
	function validateForm(){
		if(jQuery('#ho_ten').val()=='')	{
			alert('Vui lòng nhập Họ tên!');
			return false;
		}	
		if(jQuery('#dien_thoai').val()=='')	{
			alert('Vui lòng nhập Số điện thoại!');
			return false;
		}			
		
		if(jQuery('#dia_chi').val()=='')	{
			alert('Vui lòng nhập Địa chỉ!');
			return false;
		}
		document.forms["cartRegisterFormStep4"].submit();
		return true;		
	}
</script>
<div class="classic-popup_eb">
    <div class="classic-popup-top_eb">
      <div class="right_eb">
        <div class="bg_eb"></div>
      </div>
    </div>
    <div class="classic-popup-main_eb">
      <div class="classic-popup-title_eb">
        <div class="fl_eb">Nhập thông tin cá nhân</div>
        
        
        <div class="c_eb"></div>
      </div>
      <div class="classic-popup-content_eb">
        <div class="content_eb">
          <div class="reg_cart_form_eb">
            <form name="cartRegisterFormStep4" id="cartRegisterForm" method="post" action="<?php echo base_url(); ?>account/naptien/buoc5sohapay">
              <div class="cartNewForm_eb">
                <div id="cError_eb"></div>
                <div class="infoInputLeft_eb">
                  <div class="newCustomerInfo_eb">
                    <div class="input_eb">Tài khoản: <font color="blue"><?php echo $userinfo->use_username; ?></font></div>
                    <div style="font-size:14px" class="description_eb"><font color="red">(Tài khoản người được nạp tiền)</font></div>
                  </div>
                  <div class="newCustomerInfo_eb mTop5_eb">
                    <div class="input_eb">Họ tên:
                      <input type="text" style="width: 209px;" id="ho_ten" name="ho_ten" value="<?php echo $userinfo->use_fullname; ?>">
                    </div>
                    <div class="description_eb">Vui lòng cho chúng tôi biết Họ tên của Quý khách</div>
                  </div>
                  <div class="newCustomerInfo_eb mTop5_eb">
                    <div class="input_eb">Điện thoại di động:
                      <input type="text" style="width: 121px;" id="dien_thoai" name="dien_thoai" value="<?php echo $userinfo->use_mobile; ?>" maxlength="20">
                    </div>
                    <div class="description_eb">Vui lòng nhập đúng số điện thoại di động</div>
                  </div>
                  <div class="newCustomerInfo_eb mTop5_eb">
                    <div class="input_eb">
                      <div class="fl">Địa chỉ:</div>
                      <textarea style="width:209px;height:80px" id="dia_chi" name="dia_chi" class="fr"></textarea>
                    </div>
                    <div class="c"></div>
                    <div class="description_eb">Vui lòng nhập đúng địa chỉ của quý khách để nhân viên azibai.com có thể tới thu tiền.</div>
                  </div>
                  <div class="newCustomerInfo_eb mTop5_eb">
                    <div class="input_eb">Thành phố:
                      <select id="thanh_pho" name="thanh_pho">
                        <option id="tp1"  value="Hà Nội">Hà Nội</option>
                        <option id="tp2" selected="selected" value="Hồ Chí Minh">Hồ Chí Minh</option>
                      </select>
                    </div>
                    <div class="description_eb">Vui lòng cho chúng tôi biết thành phố Quý khách đang sống</div>
                  </div>
                  <div class="newCustomerInfo_eb mTop5_eb">
                    <div class="input_eb">Thứ:
                      <select id="ngay" name="ngay">
                        <option id="t2" selected="" value="Thứ Hai">Thứ Hai</option>
                        <option id="t3" value="Thứ Ba">Thứ Ba</option>
                        <option id="t4" value="Thứ Tư">Thứ Tư</option>
                        <option id="t5" value="Thứ Năm">Thứ Năm</option>
                        <option id="t6" value="Thứ Sáu">Thứ Sáu</option>
                      </select>
                      Thời gian:
                      <select id="thoi_gian" name="thoi_gian">
                        <option id="b1" selected="" value="Sáng">Sáng</option>
                        <option id="b2" value="Chiều">Chiều</option>
                        <option id="b3" value="Tối">Tối</option>
                      </select>
                    </div>
                    <div class="description_eb">Vui lòng cho chúng tôi biết địa chỉ chính xác và thời gian Quý Khách có thể ở nhà.</div>
                  </div>
                  <div class="c_eb"></div>
                </div>
                <div class="infoInputRight_eb">
                  <div class="newLabel_eb">Số tiền nạp: <span style="color:blue"><?php echo $gold_money ?></span> VND</div>
                  <div class="mTop15_eb">
                    <div align="right" class="bgAllPrice_eb">Tổng tiền: <span style="color:red"><span id="bgAllPrice"><?php echo $gold_money ?></span> VNĐ</span></div>
                  </div>
                </div>
                <div class="c_eb"></div>
              </div>
              
               <input name="type" type="hidden" value="<?php echo $type; ?>" />
              <input name="gold_money" type="hidden" value="<?php echo $gold_money; ?>" />
            </form>
           <div class="k_btn">
                <div class="k_btnleft"><a href="<?php echo base_url();?>" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
                <div class="k_btnright">
                    <div class="k_btnnaptien"><a onclick="history.go(-1)" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a></div>
                    <div class="k_btnnaptien"><a onclick="return validateForm();" class="blueButton_eb mLeft10_eb"><span><span>TIẾP TỤC <b>»</b></span></span></a></div>
                    <div class="c_eb"></div>
                </div>
            </div>
            <div class="c_eb"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="classic-popup-bottom_eb">
      <div class="right_eb">
        <div class="bg_eb"></div>
      </div>
    </div>
  </div>
  </div>
    </div>
  </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

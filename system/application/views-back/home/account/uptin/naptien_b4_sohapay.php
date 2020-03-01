<?php $this->load->view('home/common/header'); ?>
<div class="container">
  <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col9-lg-9">
<script>
	jQuery(document).ready(function(){
	
	});
			
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
			alert('Vui lòng nhập số điện thoại di động!');
			return false;
		}
		
		document.forms["cartRegisterForm"].submit();
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
            <form name="cartRegisterForm" method="post" id="cartRegisterForm" action="<?php echo base_url();?>account/naptien/buoc5sohapay">
              <div class="k_naptiencontent">
                <div id="cError_eb"></div>
                <div class="infoInputLeft_eb">
                  <div class="guestInfo_eb">
                    <div class="newCustomerInfo_eb">
                      <div class="input_eb">Tài khoản: <font color="blue"><?php echo $this->session->userdata('sessionUsername'); ?></font></div>
                      <div style="font-size:14px" class="description_eb"><font color="red">(Tài khoản người được nạp tiền)</font></div>
                    </div>
                    <div class="newCustomerInfo_eb mTop5_eb">
                      <div class="input_eb">Họ tên:
                        <input type="text" style="width: 209px;" id="ho_ten" name="ho_ten" value="<?php echo $userinfo->use_fullname; ?>">
                      </div>
                      <div class="description_eb">Vui lòng cho chúng tôi biết Họ tên của Quý khách</div>
                    </div>
                    <div class="newCustomerInfo_eb mTop5_eb">
                      <div class="input_eb">Di động:
                        <input type="text" style="width: 121px;" id="dien_thoai" name="dien_thoai" value="<?php echo $userinfo->use_mobile ?>" maxlength="20" >
                      </div>
                      <div class="description_eb">Vui lòng nhập đúng số điện thoại di động</div>
                    </div>
                    <div class="c_eb"></div>
                  </div>
                </div>
                <div class="infoInputRight_eb">
                  <div class="newLabel_eb">Số tiền nạp: <span style="color:blue"><?php echo $gold_money; ?></span> VND</div>
                  <div class="mTop15_eb">
                    <div align="right" class="bgAllPrice_eb">Tổng tiền: <span style="color:red"><span id="bgAllPrice"><?php echo $gold_money; ?></span> VNĐ</span></div>
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
                    <div class="k_btnnaptien"><a onclick="return validateForm()" class="blueButton_eb mLeft10_eb"><span><span>TIẾP TỤC <b>»</b></span></span></a></div>
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

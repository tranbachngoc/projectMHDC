<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col-lg-9">
<script>
	jQuery(document).ready(function(){
	
	});
		
	function isInt(x) {
	  var y=parseInt(x);
	  if (isNaN(y)) return false;
	  return x==y && x.toString()==y.toString();
	}
	
	function validateForm(){
		if(jQuery('#gold_money').val()=='')	{
			alert('Vui lòng nhập số tiền cần nạp!');
			return false;
		}	
		if(!isInt(jQuery('#gold_money').val()))	{
			alert('Vui lòng nhập đúng định dạng số!');
			return false;
		}
		if(jQuery('#gold_money').val()<200000)	{
			alert('Vui lòng nhập số tiền từ 200.000 VND trở lên!');
			return false;
		}
		document.forms["soha-step3"].submit();
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
        <div class="fl_eb">Nhập số tiền muốn nạp</div>
       
        <div class="c_eb"></div>
      </div>
       <form method="post" name="soha-step3" action="<?php echo base_url();?>account/naptien/buoc4sohapay">
      <div class="classic-popup-content_eb">
        <div class="content_eb">
          <div class="reg_cart_form_eb">
            <div id="cError"></div>
            <div class="k_naptiencontent">
              <div style="text-align:center" class="gold-title">
               <span style="line-height:32px">Số tiền cần nạp:</span>
                    <input type="text" value="" id="gold_money" name="gold_money" >
                    <b style="color:red">VNĐ</b> </div>
                  <div style="text-align:center" class="paymentText_eb" id="mTop5">Mỗi lần nạp phải từ <font color="red"><b>200.000</b> VND</font> trở lên</div>
                </div>
                <div class="c"></div>
              </div>
            </div>
            <div class="clr"></div>
            <div class="k_btn">
                <div class="k_btnleft"><a href="<?php echo base_url();?>" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
                <div class="k_btnright">                
                <div class="k_btnnaptien"><a onclick="history.go(-1)" style="float:right" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a></div>
                <div class="k_btnnaptien"><a onclick="return validateForm();" style="float:right" class="blueButton_eb mLeft10_eb"><span><span>TIẾP TỤC <b>»</b></span></span></a></div>
            </div>
              <div class="c_eb"></div>
            </div>
            <div class="c_eb"></div>
          </div>
          <input type="hidden" name="type" value="<?php echo $type ?>"  />
           <input type="hidden" name="NganHangChuyenKhoan" value="<?php echo $NganHangChuyenKhoan ?>"  />
          </form>
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

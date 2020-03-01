<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col-lg-9">
<div class="classic-popup_eb">
    <div class="classic-popup-top_eb">
      <div class="right_eb">
        <div class="bg_eb"></div>
      </div>
    </div>
    <div class="classic-popup-main_eb">
      <div class="classic-popup-title_eb">
        <div class="fl_eb">Nhập số Gold muốn nạp qua hình thức chuyển khoản</div>
        
        <div class="c_eb"></div>
      </div>
      <div class="classic-popup-content_eb">
        <div class="content_eb">
          <div class="reg_cart_form_eb">
            <div id="cError"></div>
            <div class="k_naptiencontent">
              <div style="text-align:center" class="gold-title">
               <span style="line-height:32px">Số Gold cần nạp:</span>
                    <input type="text" value="2.000.000" id="gold_money" name="gold_money" onkeyup="f_mix_money(this);" onfocus="this.select()" onkeypress="return f_number_only(this, event)">
                    <b style="color:red">1 Gold ~ 1 VNĐ</b> </div>
                  <div style="text-align:center" class="paymentText_eb" id="mTop5">Mỗi lần nạp phải từ <font color="red"><b>200.000</b> Gold</font> trở lên</div>
                </div>
                <div class="c"></div>
              </div>
            </div>
            <div class="clr"></div>
            <div class="k_btn">
                <div class="k_btnleft"><a onclick="pay_cancel();" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
                <div class="k_btnright">                
                <div class="k_btnnaptien"><a onclick="history.go(-1)" style="float:right" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a></div>
                <div class="k_btnnaptien"><a href="<?php echo base_url();?>account/naptien/buoc4chuyenkhoan" style="float:right" class="blueButton_eb mLeft10_eb"><span><span>TIẾP TỤC <b>»</b></span></span></a></div>
            </div>
              <div class="c_eb"></div>
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

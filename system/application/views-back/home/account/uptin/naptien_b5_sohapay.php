<?php $this->load->view('home/common/header'); ?>
<div class="container">
  <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col-lg-9">
<div style="padding-top:5px" class="classic-popup-main_eb">
    <div class="classic-popup-title_eb">
      <div class="fl_eb">Thanh Toán nạp tiền</div>
      
      <div class="c_eb"></div>
    </div>
    <div class="classic-popup-content_eb">
      <div class="content_eb" style="padding-top:10px">
        <div id="idUserInfo" class="box-gradien_eb pBottom10_eb">
          <div class="title_eb">Thông tin khách hàng</div>
          <div class="content_eb" id="pTop10"><a onclick="history.go(-1)" style="float:right" class="blueButton_eb"><span><span>SỬA THÔNG TIN CÁ NHÂN</span></span></a>
            <div><strong>Tài khoản được nạp tiền: </strong><span class="cff9200_eb"><?php echo $userinfo->use_username ?></span></div>
            <div class="mTop5_eb"><strong>Họ tên quý khách: </strong><span class="cff9200_eb"><?php echo $userinfo->use_fullname ?></span></div>
            <div class="mTop5_eb"><strong>Điện thoại di động quý khách: </strong><span class="cff9200_eb"><?php echo $userinfo->use_mobile ?></span></div>
            <div class="c_eb"></div>
          </div>
        </div>
        <div id="paymentTypeInfo" class="box-gradien_eb pBottom10_eb pTop15_eb mTop10_eb">
          <div class="title_eb">Hình thức thanh toán: <span style="font-size: 12px; font-weight: normal; text-transform: none;">Thanh toán Online</span></div>
          <div class="content_eb">
            <div class="fl_eb"><a href="https://sohapay.com/" target="_blank" title="sohapay.com"><img border="0" src="<?php echo base_url()?>templates/home/images/logoSoha.png"></a></div>
            <div style="width:430px" class="fl_eb">
              <div class="mLeft25_eb">
                <div>
                  <div><strong style="color: red;">Chú ý:</strong> Quý khách phải có <b>thẻ Visa/Master</b> đã kích hoạt thanh toán online</div>
                  <div class="mTop5_eb">hoặc <b>thẻ ATM đã đăng kí sử dụng internet banking</b> với ngân hàng phát hành thẻ</div>
                </div>
                <div class="mTop10_eb">Thanh toán Online được đảm bảo bởi <a href="https://sohapay.com/" target="_blank" title="sohapay.com">SohaPay</a></div>
              </div>
            </div>
            <div class="c_eb"></div>
          </div>
        </div>
        <div class="box-gradien_eb mTop10_eb" id="box-gradien2">
          <div class="title_eb ">Thông tin dịch vụ</div>
          <div class="content_eb" id="pTop5">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="cart-finish_eb">
              <tbody>
                <tr>
                  <th align="center" class="head_eb bRight_eb">Dịch vụ</th>
                  <th align="center" class="head_eb">Tổng giá trị thanh toán</th>
                </tr>
                <tr>
                  <td valign="top" align="center" style="font-size:16px;color:#00A0DC" class="item_eb bRight_eb">Nạp <font color="#F10000"><b><?php echo $gold_money; ?> VND</b></font> tiền cho thành viên <font color="#F10000"><b><?php echo $userinfo->use_username; ?></b></font></td>
                  <td width="30%" valign="top" align="center" style="font-size:16px;color:#00A0DC" class="item_eb"><span id="bgAllPrice"><?php echo $gold_money; ?></span> VNĐ</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="mTop10_eb" style="font-size: 16px;padding-bottom:10px">
          <input type="checkbox" checked="checked" id="check-regulations" class="checkbox">
          <label for="check-regulations"><b>Tôi đã đọc và đồng ý với các <a href="#" target="_blank">điều khoản</a> của azibai.com</b></label>
        </div>
        <div class="k_btn">
        <div class="k_btnleft"><a onclick="pay_cancel();" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
        <form name="submitSohapay" id="submitSohapay" action="<?php echo base_url();?>naptien/submit_sohapay" method="post">  
        <div class="k_btnright">            
            
            <div class="k_btnnaptien"><a onclick="history.go(-1)" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a></div>
            <div class="k_btnnaptien" style="width:120px"><a class="blueButton_eb mLeft10_eb" id="cart_pay_button"><span onclick="document.forms['submitSohapay'].submit();"><span>THANH TOÁN</span></span></a></div>
              <div class="c_eb"></div>
           <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $gold_money; ?>">
        </div>
        </form>
        <div class="c_eb"></div>
      </div>
    </div>
  </div></div>
  </div>
    </div>
  </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

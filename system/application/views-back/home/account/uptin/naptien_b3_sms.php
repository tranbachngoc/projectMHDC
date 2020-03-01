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
        <div class="fl_eb">Nạp Gold bằng SMS</div>
        
        <div class="c_eb"></div>
      </div>
      <div class="classic-popup-content_eb">
        <div class="content_eb">
          <div style="width:auto" class="box-gradien_eb pBottom10_eb pTop15_eb mTop10_eb">
            <div style="font-size:12px;font-weight:normal;text-transform:none;" class="title_eb">
              <div style="margin-top:10px;"><span style="font-weight:bold;color:#034B8A">- Tỷ lệ nạp Gold:</span> <b>1</b> SMS ~ <font color="#c00"><b>7.000</b></font> Gold, Dùng điện thoại di động soạn tin nhắn <b>sms</b> với cú pháp: </div>
              <div class="paymentText_eb" style="text-align:center"> <span style="color:red;font-weight: bold;font-size:28px">STP ltngan </span> gửi <span style="color: red; font-weight: bold;font-size:28px">8701</span> (15.000VNĐ/sms).
                <div style="font-size:14px;margin-top:10px">Để nạp <font color="#c00"><b>7.000</b></font> Gold vào tài khoản <font color="#c00"><b>ltngan</b></font></div>
              </div>
              <div style="margin-top:20px;" class="paymentText_eb"> <a onclick="jQuery('#rule_sms_eb').toggle();"><b>- Xem quy định gửi tin nhắn:</b></a>
                <div id="rule_sms_eb" class="rule_sms_eb hidden_eb">
                  <ul class="paymentText_eb">
                    <li>Khách hàng không được gửi quá 3 tin nhắn có cùng nội dung với một số điện thoại trong thời gian 5 phút</li>
                    <li>Khách hàng không được gửi quá 30 tin nhắn có cùng nội dung với một số điện thoại trong thời gian 1 giờ</li>
                    <li>VMS, Sfone:  quy định định mức tiền của mỗi thuê bao là: 150k/ ngày</li>
                    <li>Khách hàng không được sử dụng các dịch vụ nội dung của một nhà cung cấp quá 150.000 đồng ( đã bao gồm thuế GTGT) trong ngày (từ 0h00:00 đến 23h59:59)</li>
                    <li>Nếu KH sử dụng quá hạn mức thì KH vẫn bị trừ tiền</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="k_btn">
            <div class="k_btnleft"><a onclick="pay_cancel();" class="blueButton_eb"><span><span>HỦY BỎ</span></span></a></div>
            <div class="k_btnright">                
                <div class="k_btnnaptien">
                    <a onclick="history.go(-1)" class="blueButton_eb"><span><span><b>«</b> QUAY LẠI</span></span></a>
                </div>
                <div class="k_btnnaptien">
                    <a onclick="pay_cancel();"  class="blueButton_eb mLeft10_eb"><span><span>KẾT THÚC</span></span></a>
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

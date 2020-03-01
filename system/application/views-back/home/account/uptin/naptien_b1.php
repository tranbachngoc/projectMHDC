<?php $this->load->view('home/common/header'); ?>
<div class="container">
  <div class="row">
<?php $this->load->view('home/common/left'); ?>
<div class="col-lg-9">
<div class="add_money_content">
    <div style="background-color: transparent;">
      <div id="popup-container">
          <div class="classic-popup-main_eb">
            <div class="classic-popup-title_eb">
              <div class="fl_eb">Nạp tiền vào tài khoản</div>              
              <div class="c_eb"></div>
            </div>
            <div class="classic-popup-content_eb">
              <div class="content_eb" style="padding:5px 10px 10px 10px">
                <div id="cError"></div>
                <div class="k_naptiencontent">
                  <div class="gold-right">
                    <div class="gold-title" style="font-size:18px">
                      <label for="radio_self">Nạp tiền vào tài khoản cá nhân (<a href="<?php echo base_url()."user/profile/".$this->session->userdata('sessionUser'); ?>" target="_blank" style="font-size: 20px; color: rgb(255, 0, 0);"><?php echo $this->session->userdata('sessionUsername') ?></a>)</label>
                    </div>
                    <ul>
                      <li>- Bạn đang có: <b class="ff5a00"><?php echo number_format(Counter_model::getBalance($this->session->userdata('sessionUser')), 0, ',', ',');  ?> VNĐ</b></li>
                      <li>- Nạp thêm tiền để có thể mua dịch vụ dễ dàng chỉ trong vài nhấp chuột</li>
                    </ul>
                  </div>
                  <div class="c"></div>
                </div>
                <div class="k_btn">
                <div class="k_btnnaptien" ><a class="blueButton_eb  mLeft10_eb" href="<?php echo base_url();?>"><span><span>HỦY</span></span></a></div>
                <div class="k_btnnaptien"><a id="fr" class="blueButton_eb  mLeft10_eb" href="<?php echo base_url();?>account/naptien/buoc2"><span><span>TIẾP TỤC <b>»</b></span></span></a></div>
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
    </div>
  </div>
</div>
<?php $this->load->view('home/common/footer'); ?>

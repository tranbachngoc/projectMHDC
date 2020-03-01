<?php if (!isset($oloadding)){ ?>
<div id="footer">
  <?php if ((trim($this->uri->segment(1)) == 'shop' && (trim($this->uri->segment(2)) == 'products' || trim($this->uri->segment(2)) == 'coupons')) || $this->uri->segment(1) == FALSE || $this->uri->segment(1) == 'contact') { ?>
    <?php $this->load->view('home/common/footer_social'); ?>
  <?php } ?>
    <div class="container">
    <div id="menu-footer">            
        <a href="/">Trang chủ</a>                    
        <a href="/content/5">Giới thiệu</a>
        <a href="/content/394">Quy chế hoạt động</a>
        <a href="/content/320">Chính sách bảo mật</a>
        <a href="/content/390">Quy trình giải quyết tranh chấp</a>
        <a href="/contact">Liên hệ</a>
    </div>

  <div class="copyright" style="font-size:small;">        
      <div class="row">
    <div class="col-sm-4 col-xs-12 hidden-xs">
        <p><strong>TRỤ SỞ CHÍNH</strong></p> 
        <i class="azicon14 icon-map-marker"></i> <?php echo settingAddress_1; ?> <br>
        <i class="azicon14 icon-mobile"></i> <?php echo settingPhone; ?> <br>
        <i class="azicon14 icon-email"></i> <?php echo settingEmail_1; ?>
    </div>
    <div class="col-sm-4 col-xs-12 hidden-xs">
        <p><strong>VĂN PHÒNG TẠI HÀ NỘI</strong></p> 
        <i class="azicon14 icon-map-marker"></i> Tầng 5, tòa nhà Vietcom, số 18 Nguyễn Chí Thanh, <br>Phường Ngọc Khánh, Quận Ba Đình, Hà Nội<br>
        <i class="azicon14 icon-mobile"></i> 0919575925 <br>
        <i class="azicon14 icon-email"></i> <?php echo settingEmail_1; ?>
    </div>
    <div class="col-sm-4 col-xs-12">
        <p><strong>TẢI ỨNG DỤNG</strong></p> 
        <p>Azibai.com đã có ứng dụng cho Mobile, Smart TV</p>
        <div class="row">
      <div class="col-xs-6">
          <a href="https://play.google.com/store/apps/details?id=com.azibai.android"><img class="img-responsive" src="<?php echo getAliasDomain('images/mobile-androi-app.png')?>" alt="Tải ứng dụng cho androi"/></a>
      </div>
      <div class="col-xs-6">
          <a href="https://itunes.apple.com/us/app/azibai/id1284773842?mt=8"><img class="img-responsive" src="<?php echo getAliasDomain('images/mobile-app-store.png')?>" alt="Tải ứng dụng cho iphone"/></a>
      </div>
        </div>
    </div>
      </div>
      <hr/>
      <div class="row"> 
    <div class="col-sm-12 col-xs-12">   
        <p class="logo-reg pull-right">
        <a href="http://online.gov.vn/WebsiteDisplay.aspx?DocId=32369" target="_blank">
        <img src="/images/dadangky.png" alt="da-dang-ky-bo-cong-thuong"/>
        </a>
        </p>
        <p>© 2016 - Bản quyền của Công ty TNHH Dịch Vụ Mọi Người Cùng Vui - Azibai.com
      <br>Giấy chứng nhận đăng ký kinh doanh số 0314300068 do Sở Kế hoạch và Đầu tư Tp. Hồ Chí Minh cấp ngày 24/03/2017.</p>

    </div>
      </div>

  </div>


    </div>
    <!-- footer -->
    
</div>
<?php }else{ ?>
<div id="footer" style="min-height: 5px;"></div>
<?php } ?>

</div><!-- end #all -->

<div id="aziload"  style="display: none;">
    <div class="loading_bg"></div>
    <span class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
    <div class="azimes"></div>
</div>
<?php 
  if(isset($js)) {
    echo $js;
  }else {
    echo '<script type="text/javascript" defer src="'.loadJs(array(
      'home/js/jquery-migrate-1.2.1.js',
      'home/js/bootstrap.min.js',
      'home/js/select2.full.min.js',
      'home/js/general.js',
      'home/js/jAlert-master/jAlert-v3.min.js',
      'home/js/jAlert-master/jAlert-functions.min.js',
      'home/js/bootbox.min.js',
      'home/js/js-azibai-tung.js',
      'home/js/jquery.autocomplete.js',
      'home/js/jquery.validate.js',
      'home/js/jquery-scrolltofixed-min.js'
    ),'asset/home/script.min.js').'"></script>';
  } 
?>
<?php $this->load->view('home/common/modal-mess'); ?>
</body>

</html>
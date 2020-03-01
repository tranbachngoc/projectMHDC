<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">
<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Đấu cổng vận chuyển</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="product-posted">
        <div class="product-posted-content">
          <div class="onlinePayment">
            <div class="onlinePayment-tt">Đấu cổng vận chuyển</div>
            <div class="onlinePayment-steps">
              <form id="frm_submit">
              <p>Để thực hiện đấu cổng vận chuyển</p>
              <div class="step">
                <p>Bước 1 : Nhập user_name (GHN)</p>
                <input type="text" name="user_name" value="<?=$data_config['user_name']?>" class="form-control">
              </div>
              <div class="step">
                <p>Bước 2 : Nhập secret_key (GHN)</p>
                <input type="text" name="secret_key" value="<?=$data_config['secret_key']?>" class="form-control">
              </div>
              <div class="text-center"><button class="btn-save" type="submit">Lưu</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  $("#frm_submit").on("submit", function (event) {
    event.preventDefault();
    a = $(this).find("input[name='user_name']").val();
    b = $(this).find("input[name='secret_key']").val();
    if (a == null || a == "" || b == null || b == "") {
      alert("Vui lòng nhập đầy đủ thông tin để cấu hình nhà vận chuyển");
      return false;
    } else {
      $.ajax({
        type: "post",
        url: "<?=base_url(). "home/api_affiliate/create_user_config_ghn/{$user_shop->use_id}"?>",
        data: $("#frm_submit").serialize(),
        dataType: "json",
        success: function (response) {
          if(response.err == false) {
            window.location.reload();
          }
          alert(response.mgs);
        },
        error: function () {
          alert("Lỗi kết nối");
        }
      });
    }
  })
</script>

<footer id="footer" class="footer-border-top">
  <?php $this->load->view('e-azibai/common/common-html-footer'); ?>
  <?php $this->load->view('home/common/overlay_waiting')?>
  <script src="/templates/home/js/page_business.js"></script>
</footer>
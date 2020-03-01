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
            <div class="onlinePayment-tt">Đấu cổng thanh toán trực tuyến</div>
            <div class="onlinePayment-steps">
              <p>Để thực hiện đấu cổng thanh toán trực tuyến bạn làm như sau:</p>
              <div class="step">
                <div class="step01" id="step-1">
                  <div class="input"><input class="input-file" name="fileUpload" type="file" accept=".html" ><p class="img">Bước 1* : Tải lên file xác thực <img src="/templates/home/styles/images/svg/upload.svg" class="ml10" width="20"></p></div>
                  <button class="js-xacthuc-file" style="display:none">Xác thực</button></div>
                <p class="small-text js-mess-next">( *Bắt buộc phải hoàn thành bước 1 bạn mới thực hiện được bước 2)</p>
              </div>
              <div id="step-2" style="<?=empty($data_config) ? "display:none" : ""?>">
              <form id="frm_submit">
                <div class="step">
                  <p>Bước 2 : Nhập merchant_id</p>
                  <input type="text" name="merchant_id" value="<?=$data_config['merchant_id']?>" class="form-control">
                </div>
                <div class="step">
                  <p>Bước 3 : Nhập merchant_pass</p>
                  <input type="text" name="merchant_pass" value="<?=$data_config['merchant_pass']?>" class="form-control">
                </div>
                <div class="step">
                  <p>Bước 4 : Nhập receiver</p>
                  <input type="text" name="receiver" value="<?=$data_config['receiver']?>" class="form-control">
                </div>
                <div class="text-center"><button class="btn-save">Lưu</button></div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  $("input[name='fileUpload']").on("change", function () {
    $(".js-xacthuc-file").show();
  });

  $(".js-xacthuc-file").on("click", function () {
    var file = $("input[name='fileUpload']")[0].files[0];
    var formData = new FormData();
    formData.append("fileUpload", file);

    $.ajax({
      type: "post",
      url: "<?=base_url() . "home/api_affiliate/upfile_config_nganluong/{$user_shop->use_id}"?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType:"json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.status == 1) {
          $("#step-2").show();
          $("#frm_submit").find("input[name='merchant_id']").val('');
          $("#frm_submit").find("input[name='merchant_pass']").val('');
          $("#frm_submit").find("input[name='receiver']").val('');
          html="Bạn vui lòng vào ngân lượng để nhận thông tin về merchant_id, merchant_pass, receiver để cung cấp cho azibai";
          $(".js-mess-next").html(html);
          alert("Xác thực thành công");
        } else {
          $("#step-2").hide();
          alert("Xác thực file thất bại");
        }

        $("#step-2").show();
        html="Bạn vui lòng vào ngân lượng để nhận thông tin về merchant_id, merchant_pass, receiver để cung cấp cho azibai";
        $(".js-mess-next").html(html);
      },
      error: function(err){
        $('.load-wrapp').show();
        alert("Lỗi kết nối!!!");
      },
    });
  })

  $("#frm_submit").on("submit", function (event) {
    event.preventDefault();
    a = $(this).find("input[name='merchant_id']").val();
    b = $(this).find("input[name='merchant_pass']").val();
    c = $(this).find("input[name='receiver']").val();
    if (a == null || a == "" || b == null || b == "" || c == null || c == "") {
      alert("Vui lòng nhập đầy đủ thông tin để cấu hình cổng thanh toán ngân lượng");
      return false;
    } else {
      $.ajax({
        type: "post",
        url: "<?=base_url(). "home/api_affiliate/create_user_config_nganluong/{$user_shop->use_id}"?>",
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
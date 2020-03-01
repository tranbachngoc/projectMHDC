<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>

<main class="cart-content main-content">
    <div class="breadcrumb">
       <div class="container">
          <ul>
             <li><a href="">Trang chủ azibai</a><img src="asset/images/svg/breadcrumb_arrow.svg" class="ml10" alt=""></li>
             <li>Thông tin giao hàng</li>
          </ul>
       </div>
    </div>
    <div class="container">
    	<?php
        if (!$this->session->userdata('sessionUser')) 
        {
          $this->load->view('home/checkout/receive/new');
        } 
    		else if (!empty($list_receive)) 
        {
    			$this->load->view('home/checkout/receive/list');
    		} 
        else 
        {
    			$this->load->view('home/checkout/receive/first');
    		}
    	?>
    </div>
</main>


<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
</footer>


<script type="text/javascript">
  $('body').on('change', '.js-province', function() {
      var id_province = $(this).val();
      $('.load-wrapp').show();
      $.ajax({
            type: "POST",
            url: "/v-checkout/get-district",
            data: {id_province: id_province},
            dataType: "json",
            success: function (data) {
                var str = '<option value="">Chọn Quận/Huyện</option>';
                if (data.error == false && data.result.length > 0) {
                  $.each(data.result, function( index, value ) {
                    str += '<option value="'+value.id+'">'+value.DistrictName+'</option>';
                  });
                }
                $('.js-district').html(str);
            }
      }).always(function() {
          $('.load-wrapp').hide();
      });
  });
</script>


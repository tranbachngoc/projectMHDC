<body class="trangcuahang trangcuahang-ver2">
  <div class="wrapper">
    <?php $this->load->view('shop/shop/common/header_menu');?>

    <!-- load layout body theo $detect_process -->
    <?php if(in_array($detect_process,['shop','affiliate-shop'])) { $this->load->view('shop/shop/body-layout-shop'); } ?>
    <?php if(in_array($detect_process,['product','coupon'])) {
      $this->load->view('shop/shop/body-layout-pro-coup');
      $this->load->view('shop/shop/common/overlay_waiting');
    } ?>

  </div>

</body>

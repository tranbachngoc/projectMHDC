<body class="trangcuahang trangcuahang-ver2">
  <div class="wrapper">
    <?php //$this->load->view('home/personal/affililate-shop/common/header_menu');?>
    <?php $this->load->view('shop/shop/common/header_menu');?>

    <!-- load layout body theo $detect_process -->
    <?php if(in_array($detect_process,['affiliate-shop'])) { $this->load->view('home/personal/affililate-shop/body-layout-afshop'); } ?>
    <?php if(in_array($detect_process,['product','coupon'])) {
      $this->load->view('home/personal/affililate-shop/body-layout-pro-coup');
      $this->load->view('home/personal/affililate-shop/common/overlay_waiting');
    } ?>

  </div>

</body>

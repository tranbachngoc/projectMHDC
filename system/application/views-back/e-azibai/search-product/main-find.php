<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
  <!-- Common Header -->
  <?php $this->load->view('e-azibai/common/common-head');?>
  <!-- END Common Header -->
  </head>
  <body>
    <div class="wrapper sanazibai trangcuahang-ver2">
      <header>
        <?php $this->load->view('e-azibai/common/common-html-header');?>
      </header>
      <main>
        <?php $this->load->view('e-azibai/search-product/html-main');?>
      </main>
      <footer id="footer" class="footer-border-top">
        <?php $this->load->view('e-azibai/common/common-html-footer');?>
      </footer>
    </div>
    <!-- Common Footer -->
    <?php $this->load->view('e-azibai/common/common-footer');?>
    <!-- END Common Footer -->

    <!-- Common js - function -->
    <?php $this->load->view('e-azibai/common/common-js');?>
    <!-- END Common js - function -->

    <!-- Load javascript on Category -->
    <?php $this->load->view('e-azibai/category/js-category');?>
    <!-- END Load javascript on Category -->

    <!-- Load POPUP -->
    <?php $this->load->view('e-azibai/common/common-popup-alert-cart');?>
    <?php $this->load->view('e-azibai/common/common-overlay-waiting');?>
    <?php $this->load->view('e-azibai/common/common-popup-af-commission');?>
    <!-- END Load POPUP -->
  </body>
</html>
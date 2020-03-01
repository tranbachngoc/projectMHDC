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
        <?php $this->load->view('e-azibai/home/html-main');?>
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

    <!-- Load javascript on Home -->
    <?php $this->load->view('e-azibai/home/js-home');?>
    <!-- END Load javascript on Home -->

    <!-- Load POPUP -->
    <?php $this->load->view('e-azibai/common/common-popup-alert-cart');?>
    <?php $this->load->view('e-azibai/common/common-overlay-waiting');?>
    <?php $this->load->view('e-azibai/common/common-popup-af-commission');?>
    <script src="/templates/home/styles/js/commission-aft.js"></script>
    <!-- END Load POPUP -->
  </body>
</html>
<?php
$this->load->view('home/common/header_new');
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
?>

<?php $this->load->view('shop/media/viewnode-media-body') ?>
<?php $this->load->view('shop/media/viewnode-media-footer') ?>

<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/styles/js/fixed_sidebar.js"></script>
<script src="/templates/home/styles/js/popup_dangtin.js"></script>

<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.min.js"></script>

<script type="text/javascript">
  var masonryOptions = {
    itemSelector: '.item',
    horizontalOrder: true
  }
  var $grid = $('.grid').masonry(masonryOptions);
  $grid.imagesLoaded().progress(function () {
    $grid.masonry('layout');
  });

</script>
</body>

</html>
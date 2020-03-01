<?php
$this->load->view('home/tintuc/quick-view/layout-body');
?>

<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.min.js"></script>

<script type="text/javascript">
  var masonryOptions = {
    itemSelector: '.item',
    horizontalOrder: true
  }
  var $grid = $('.grid').masonry(masonryOptions);
  $grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
  });
</script>
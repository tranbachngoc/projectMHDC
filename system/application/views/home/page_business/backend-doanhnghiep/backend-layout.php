<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id = (int)$this->session->userdata('sessionUser');

$this->load->view('home/common/header_new');

?>

<!-- CSS -->
<link rel="stylesheet" href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/coupon.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/font-awesome-4.7.0/css/font-awesome.css">

<main class="coupon">
  <div class="container">

    <?php echo $layout_extend ?>

  </div>
</main>

<!-- <footer id="footer">

</footer> -->


<?php $this->load->view('home/common/overlay_waiting'); ?>

<script src="/templates/home/styles/js/common.js"></script>
<script type="text/javascript">
  $('.show-pass').click(function () {
    $(this).find('img').attr('src', '/templates/home/styles/images/svg/eye_on.svg');
  });
</script>

</div>
</body>

</html>
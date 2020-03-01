<!DOCTYPE html>
<html>
<head>
  <title>Comment</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
  <link rel="stylesheet" href="/templates/home/styles/css/reset.css">
  <link rel="stylesheet" href="/templates/home/styles/css/base.css">
  <link rel="stylesheet" href="/templates/home/styles/css/slick.css">
	<link rel="stylesheet" href="/templates/home/styles/css/slick-theme.css">
  <link rel="stylesheet" href="/templates/home/css/comment.css">


  <script src="/templates/home/js/jquery.min.js"></script>
  <script type="text/javascript" src="/templates/home/boostrap/js/bootstrap.js"></script>
  <script type="text/javascript" defer src="/templates/home/js/comment.js"></script>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <script src="/templates/home/styles/js/countdown.js"></script>

  <script type="text/javascript">
        var website_url = '<?php echo base_url(); ?>';
        <?php echo $sHeader['config']; ?>
        var urlFile = '<?php echo $sHeader['url']; ?>'
  </script>
</head>
<body class="comment-page-inner">
  <div class="comment-page">
    <div class="comment-header">
      <a href="javascript:history.back(-1)">
        <img class="icon-img button-back" src="/templates/home/styles/images/svg/back.svg" alt="">
      </a>
      <h4>Danh sách bình luận</h4>
      <a href="<?=base_url();?>">
        <img class="icon-img button-home" src="/templates/home/styles/images/svg/home_black.svg" alt="">
      </a>
    </div>
    <div class="infomation-user-comment">
      <div class="infomation-user-comment-inner">
        <div class="avatar">
          <img src="<?=$infomation_user['avatar']?>">
        </div>
        <div class="infomation-inner">
          <h3><?=$infomation_user['use_fullname']?></h3>
        </div>
      </div>
      <a class="link-detail" href="<?=$infomation_user['detail_link']?>">Xem chi tiết tin</a>
    </div>
    <!-- Danh sách comment -->
    <?= $this->load->view('comment/block_page/list_comment'); ?>
    <!-- Thêm comment -->
    <?= $this->load->view('comment/block_page/add_comment'); ?>
  </div>
  <div class="modal commentModal modal-header-no-bg" id="modal-show-comment-images">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close close-comment-images">&times;</button>
        </div>
        <div class="modal-show-comment-images-bg">
          <div class="slider-img">
            <div class="js-slider-img">
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</body>
</html>

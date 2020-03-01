<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-category">
  <ul>
    <li class="<?=@$_REQUEST['affiliate'] == 'all' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=all')?>">Tất cả (<span class="text-bold"><?=$data_aff['total']['all']?></span>)</a></li>
    <?php if(!in_array($user_aff_level, [2,3])) { ?>
      <li class="<?=@$_REQUEST['affiliate'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=2')?>">Tổng đại lý (<span class="text-bold"><?=$data_aff['total']['lv2']?></span>)</a></li>
    <?php } ?>
    <?php if(!in_array($user_aff_level, [3])) { ?>
      <li class="<?=@$_REQUEST['affiliate'] == '3' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=3')?>">Đại lý (<span class="text-bold"><?=$data_aff['total']['lv3']?></span>)</a></li>
    <?php } ?>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=0&user_type=2')?>">Thành viên mới (<span class="text-bold"><?=$data_aff['total']['user_new']?></span>)</a></li>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/user?affiliate=0&user_type=1')?>">Thành viên đã mua (<span class="text-bold"><?=$data_aff['total']['user_buy']?></span>)</a></li>
    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url('/affiliate/invite')?>">Lời mời cộng tác (<span class="text-bold"><?=$data_aff['total']['user_buy']?></span>)</a></li>
  </ul>
</div>
<div class="affiliate-content">
  <div class="affiliate-content-member">
    <form id="frmSearch" method="POST">
    <div class="search">
      <div class="search-input">
        <input type="text" value="<?=$search?>" name="search_aff" class="form-control" placeholder="Nhập từ khóa" autocomplete="off">
        <img src="/templates/home/styles/images/svg/search.svg" class="icon-search" alt="">
      </div>
      <!-- <div class="search-category">
        <select name="" class="form-control" id="">
          <option value="">Loại thành viên</option>
        </select>
      </div>
      <div class="search-category search-state">
        <select name="" class="form-control" id="">
          <option value="">Thuộc ai</option>
        </select>
      </div> -->
      <div class="btn-search js-submit-search">Tìm kiếm</div>
    </div>
    </form>
    <div class="list-members moreBox-block js-append-data">
      <?php
      if(!empty($data_aff['users'])) {
        foreach ($data_aff['users'] as $key => $user) {
          $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-user', ['item'=>$user], FALSE);
        }
      } else {
        echo
        "<div class='item moreBox-item'>
          <div class='infor'>
            Không tìm thấy dữ liệu
          </div>
        </div>";
      }
      ?>
    </div>
  </div>
</div>

<?=$pagination?>

<?php $this->load->view('home/personal/affiliate/popup/popup-page-affilate-list-user-menu-action'); ?>

<script>
  $('.js-submit-search').on('click', function (e) {
    $('#frmSearch').attr('action', '<?=azibai_url()."/affiliate/user?affiliate=".$_REQUEST["affiliate"]."&page=1"?>');
    $('#frmSearch').submit();
  })

</script>
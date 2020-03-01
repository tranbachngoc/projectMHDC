<?php
	$this->load->view('home/common/header_new');
	$url = current_url();
	if($_REQUEST['affiliate']){
		$url .='?affiliate='.$_REQUEST['affiliate'];
	}
?>
<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">

<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Quản lý cộng tác viên</li>
				</ul>
				<?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
    	<div class="affiliate-category">
		  <ul>
		    <li class="<?=@$_REQUEST['affiliate'] == 'all' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=all")?>">Tất cả (<span class="text-bold"><?=$data_aff['total']['all']?></span>)</a></li>
			<li class="<?=@$_REQUEST['affiliate'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=1")?>">Nhà phân phối (<span class="text-bold"><?=$data_aff['total']['lv1']?></span>)</a></li>
			<li class="<?=@$_REQUEST['affiliate'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=2")?>">Tổng đại lý (<span class="text-bold"><?=$data_aff['total']['lv2']?></span>)</a></li>
			<li class="<?=@$_REQUEST['affiliate'] == '3' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=3")?>">Đại lý (<span class="text-bold"><?=$data_aff['total']['lv3']?></span>)</a></li>
		    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '2' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=0&user_type=2")?>">Thành viên thường (<span class="text-bold"><?=$data_aff['total']['user_new']?></span>)</a></li>
		    <li class="<?=@$_REQUEST['affiliate'] == '0' && @$_REQUEST['user_type'] == '1' ? 'active' : ''?>"><a href="<?=azibai_url("/page-business/listaffiliate/{$user_shop->use_id}?affiliate=0&user_type=1")?>">Thành viên đã mua (<span class="text-bold"><?=$data_aff['total']['user_buy']?></span>)</a></li>
		  </ul>
		</div>
		<div class="affiliate-content">
		  <div class="affiliate-content-member">
		    <form action="<?=$url?>" method="POST">
		    <div class="search">
		      <div class="search-input">
		        <input type="text" value="<?=$search?>" name="search_aff" class="form-control" placeholder="Nhập từ khóa">
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
		      <button class="btn-search js-submit-search">Tìm kiếm</button>
		    </div>
		    </form>
		    <div class="list-members moreBox-block js-append-data">
		      <?php
		      	if(!empty($data_aff['users'])) {
		      		foreach ($data_aff['users'] as $key => $user) {
			          $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-user', ['item'=>$user], FALSE);
			        }
		      	}else {
		      		echo '<p>Bạn chưa có cộng tác viên</p>';
		      	}
		        
		      ?>
		    </div>
		  </div>
		</div>

		<?=$pagination?>
    </div>
  </section>
</main>

<footer id="footer" class="footer-border-top">
	<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
</footer>
<?php $this->load->view('home/page_business/popup/popup-page-affilate-list-user-menu-action'); ?>

<script src="/templates/home/js/page_business.js"></script>
<script>
  $('.js-submit-search').on('click', function (e) {
    $('#frmSearch').attr('action', '<?=azibai_url()."/affiliate/user{$user_shop->use_id}?affiliate={$_REQUEST['affiliate']}&page=1"?>');
    $('#frmSearch').submit();
  })

</script>
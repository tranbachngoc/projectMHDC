<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">

<script src="/templates/home/styles/js/common.js"></script>

<main class="sanphamchitiet">      
      <section class="main-content">
        <div class="breadcrumb control-board">
          <div class="container">
            <ul>
              <li><img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Bài viết chi nhánh</li>
            </ul>
            <?php $this->load->view('home/page_business/common/menu_left'); ?>
          </div>
        </div>
        <div class="container">
          <div class="product-posted">  
            <div class="product-posted-tit">BÀI VIẾT CHI NHÁNH CHỜ DUYỆT</div>
            <form method="get" action="<?php echo base_url() .'page-business/list-news-branch/' . $user_shop->use_id; ?>">
		        <div class="product-posted-search">
		          <div class="left">
		            <div class="input-search"><img src="/templates/home/styles/images/svg/search.svg" alt=""><input type="text" name="search_name" value="<?php echo $_REQUEST['search_name'] ?>" class="form-control" placeholder="Tìm theo tên bài viết"></div>
		          </div>
		          <div class="right">
		            <div class="select-search">
		              <select name="search_branch" id="search_branch">
		                <option value="">Tìm theo chi nhánh</option>
		                <?php if(!empty($list_bran)) { ?>
							<?php foreach ($list_bran as $k_bran => $v_bran) { ?>
							  <option value="<?php echo $v_bran->use_id ?>"<?php echo (!empty($_REQUEST['search_branch']) && $v_bran->use_id == $_REQUEST['search_branch']) ? 'selected': '' ?>><?php echo $v_bran->sho_name ?></option>
							<?php } ?>
						<?php } ?>
		              </select>
		            </div>
		            <div class="select-search">
		              <select name="search_category" id="search_category">
		                <option value="">Tìm theo danh mục</option>
		                <?php if(!empty($list_cate)) { ?>
							<?php foreach ($list_cate as $k_cate => $v_cate) { ?>
							  <option value="<?php echo $v_cate->cat_id ?>"<?php echo (!empty($_REQUEST['search_category']) && $v_cate->cat_id == $_REQUEST['search_category']) ? 'selected': '' ?>><?php echo $v_cate->cat_name ?></option>
							<?php } ?>
						<?php } ?>
		              </select>
		            </div>
		          </div>
		        </div>
		    </form>
            <div class="product-posted-content">
              <table class="parent-table">
                <tr>
                  <th>Tên bài viết</th>
                  <th class="tablet-none">Danh mục</th>
                  <th class="tablet-none">Người đăng</th>
                  <th class="tablet-none">Trang</th>
                </tr>
                <?php if (!empty($list_news)) { ?>
                	<?php foreach ($list_news as $k => $v) { ?>
	                <tr>
	                  <td>
	                    <div class="accordion js-accordion">
	                      <div class="accordion-item">
	                        <div class="accordion-toggle">
	                          <div class="product-detail no-checkbox">
	                            <div class="info">
	                              <div class="img">
	                              	<?php                                  
	                                  $ogimage = site_url('/templates/home/styles/images/default/error_image_400x400.jpg'); 
	                                  if (!empty($v->not_image)) 
	                                  {
	                                    $image = $v->not_image;
	                                  } 
	                                  else if(!empty($v->not_image1)) 
	                                  {
	                                    $image = $v->not_image1;
	                                  }

	                                  if (!empty($image)) 
	                                  {
	                                    $check_http = explode(':', $image)[0];
	                                      if ($check_http == 'http' || $check_http == 'https') {
	                                          $ogimage = $image;
	                                      } else {
	                                          $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $v->not_dir_image . '/' . $image;
	                                      }
	                                  }
	                                ?>
	                                <img src="<?php echo $ogimage; ?>" alt="">
	                              </div>
	                              <div class="name">
	                              	<?php 
	                              		$item_link = azibai_url() . '/tintuc/detail/' . $v->not_id . '/' . RemoveSign($v->not_title)
	                              	?>
	                                <a class="js-open-link" target="_blank" href="<?php echo $item_link; ?>"><h3 class="two-lines"><?php echo $v->not_title; ?></h3></a>
	                                <p class="date">Chi nhánh: <?php echo $v->sho_name ?></p>
	                              </div>
	                            </div>
	                          </div>
	                        </div>
	                        <div class="accordion-panel product-detail-accordion">
	                          <div class="tablet">
	                            <table class="child-table">
	                              <tr>
	                                <td>Ngày đăng</td>
	                                <td><?php echo date('d-m-Y', $v->not_begindate) ?></td>
	                              </tr>
	                              <tr>
	                                <td>Lượt xem</td>
	                                <td><?php echo $v->not_view ?></td>
	                              </tr>
	                              <tr>
	                                <td>Danh mục</td>
	                                <td><?php echo $v->name_cate ?></td>
	                              </tr>
	                              <tr>
	                              	<td>Người đăng</td>
	                              	<td><?php echo $v->use_fullname ?></td>
	                              </tr>
	                              <tr>
	                              	<td>Trang</td>
	                              	<td>
	                              		<label class="checkbox-style-circle">
					                        <input type="checkbox" data-user-shop="<?php echo $user_shop->use_id; ?>" data-id="<?php echo $v->not_id ?>" class="js-choose-content"><span></span> 
					                    </label>
	                              	</td>
	                              </tr>
	                            </table>
	                          </div>                          
	                        </div>
	                      </div>
	                      
	                    </div>
	                  </td>
	                  <td class="tablet-none"><?php echo $v->name_cate ?></td>
	                  <td class="tablet-none"><?php echo $v->use_fullname ?></td>
	                  <td class="tablet-none">
	                    <label class="checkbox-style-circle">
	                        <input type="checkbox" data-user-shop="<?php echo $user_shop->use_id; ?>" data-id="<?php echo $v->not_id ?>" class="js-choose-content"><span></span> 
	                      </label>
	                  </td>
	                </tr>
		            <?php } ?>
		        <?php } ?>
              </table>
            </div>

            <!-- pagination -->
			<?php echo $pagination ? $pagination : ''; ?>

          </div>        
        </div>
      </section>
    </main>


<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
<script src="/templates/home/js/page_business.js"></script>
</footer>

<script type="text/javascript">
	
	$('.js-open-link').click(function(){
		window.open(this.href, '_blank');
	});

	$('.js-choose-content').click(function() {
		var not_id = $(this).attr('data-id');
      	var id_user_shop = $(this).attr('data-user-shop');
	    $('.load-wrapp').show();
	    $.ajax({
	        type: 'POST',
	        url: '/page-business/choose-content-branch',
	        data: {not_id:not_id, id_user_shop: id_user_shop},
	        dataType: 'json',
	        success: function (data) {
	            alert(data.sms);
	            if (!data.error) 
	            {
	              location.reload();
	            }
	        },
	        error: function (data) {
	            alert('Có lỗi hệ thống xảy ra!');
	        }
	    }).always(function() {
	        $('.load-wrapp').hide();
	    });
	});
</script>



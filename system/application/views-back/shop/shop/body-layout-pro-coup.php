<main>
	<section class="main-content">
		<div class="container">
			<?php $this->load->view('shop/shop/common/shop_banner');?>

			<div class="sidebarsm">
  				<div class="gioithieu">
				  <?php $this->load->view('shop/news/elements/menu_left_items') ?>
				</div>
			</div>
      		<?php // $this->load->view('shop/shop/common/sidebar_menu');?>
		</div>
		<div class="danh-muc-san-pham">
			<!-- <div class="container">
				<div class="text-center">
					<select class="danh-muc-san-pham-tit" name="" id="">
						<option value="">danh mục sản phẩm</option>
						<option>danh mục sản phẩm1</option>
						<option>danh mục sản phẩm2</option>
						<option>danh mục sản phẩm3</option>
						<option>danh mục sản phẩm5</option>
						<option>danh mục sản phẩm6</option>
					</select>
				</div>
				<ul class="danh-muc-san-pham-slider js-danh-muc-san-pham-slider">
					<li>
						<a href="">
							<div class="img">
								<img src="/templates/home/styles/images/hinhanh/01.jpg" alt="">
							</div>
							<div class="text">
								<p class="two-lines">
									<strong>Danh mục demo danh mục demo Danh mục demo danh mục demo Danh mục demo danh mục</strong>
								</p>
								<p class="soluong-sp">9 sản phẩm</p>
							</div>
						</a>
					</li>
					<li>
						<div class="img">
							<img src="/templates/home/styles/images/hinhanh/02.jpg" alt="">
						</div>
						<div class="text">
							<p class="two-lines">
								<strong>Danh mục demo danh mục demo Danh mục demo danh mục demo Danh mục demo danh mục</strong>
							</p>
							<p class="soluong-sp">9 sản phẩm</p>
						</div>
					</li>
					<li>
						<div class="img">
							<img src="/templates/home/styles/images/hinhanh/03.jpg" alt="">
						</div>
						<div class="text">
							<p class="two-lines">
								<strong>Danh mục demo danh mục demo Danh mục demo danh mục demo Danh mục demo danh mục</strong>
							</p>
							<p class="soluong-sp">9 sản phẩm</p>
						</div>
					</li>
					<li>
						<div class="img">
							<img src="/templates/home/styles/images/hinhanh/04.jpg" alt="">
						</div>
						<div class="text">
							<p class="two-lines">
								<strong>Danh mục demo danh mục demo Danh mục demo danh mục demo Danh mục demo danh mục</strong>
							</p>
							<p class="soluong-sp">9 sản phẩm</p>
						</div>
					</li>
					<li>
						<div class="img">
							<img src="/templates/home/styles/images/hinhanh/05.jpg" alt="">
						</div>
						<div class="text">
							<p class="two-lines">
								<strong>Danh mục demo danh mục demo Danh mục demo danh mục demo Danh mục demo danh mục</strong>
							</p>
							<p class="soluong-sp">9 sản phẩm</p>
						</div>
					</li>
				</ul>
			</div> -->
		</div>
		<div class="shop-product">
			<div class="container">
				<!-- bộ filter -->
				<?php $this->load->view('shop/shop/element/shop_slash_pro_coup');?>
				<!-- END bộ filter -->

				<div class="shop-product-items">
          <?php foreach ($items as $key => $item) { ?>
						<?php $this->load->view('shop/shop/ajax_html/item-shop-slash-pro-coup', ['item'=>$item]);?>
					<?php } ?>
				</div>

				<div class="icon-add bg-white load-more-item">
					<span>
						<img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
					</span>
				</div>
			</div>

		</div>

	</section>

</main>
<script>
  var page = 1;

  $('.load-more-item').on('click', function(event){
    $('.load-wrapp').show();
    page++;
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: window.location.href,
      data: {page: page, filter : is_filter, price_from: price_from, price_to: price_to, decreased: decreased, sort: sort},
      success: function (result) {
				// $loadding.addClass('hidden');
        
				if(result){
          try {
            result = JSON.parse(result);
            $('.shop-product-items').append(result.html);
          } catch (e) {
            $('.shop-product-items').append(result);
            currentArr = $(".shop-product-items .item").get();
          }
        }
        $('.load-wrapp').hide();
      }
    }).always(function() {

    });
    return false;
	});
</script>
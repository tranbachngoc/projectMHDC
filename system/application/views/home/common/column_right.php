
<?php if($listShop && $this->uri->segment(2) != 'detail') { ?>
	<div class="panel panel-default fixtoscroll">
		<div class="panel-heading">      
			<div class="input-group">
				<input id="keySearch" type="text" class="form-control" placeholder="Tìm gian hàng" aria-describedby="basic-addon1" onkeyup="myFunction();">
				<span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
			</div>
		</div>    
		<div class="panel-body listSearchShop" style="height:calc(100vh - 128px); overflow: auto;">        
			<ul id="listSearch" class="listshop list-unstyled">
				<?php
				foreach ($listShop as $shop) {
					if ($shop->domain != '') {
						$linktoshop = 'http://' . $shop->domain;
					} else {
						$linktoshop = '//' . $shop->sho_link . '.' . domain_site;
					}
					if($shop->sho_logo){
						$shoplogo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
					} else {
						$shoplogo = 'media/shop/logos/defaults/default-logo.png';
					}		    
					?>
					<li>
						<a href="<?php echo $linktoshop ?>">
							<span>
								<!-- <span style="background:url(<?php echo $shoplogo ?>) no-repeat center center / cover"> -->
									<span data-src="<?php echo $shoplogo ?>" style="background: no-repeat center center / cover" class="lazy">
									
								</span> 
							</span>                                  
							<?php echo trim($shop->sho_name); ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<script>
	$('.lazy').lazy({appendScroll: $(".listSearchShop")});
	function myFunction() {
		var input, filter, ul, li, a, i;
		input = document.getElementById("keySearch");
		filter = input.value.toUpperCase();
		ul = document.getElementById("listSearch");
		li = ul.getElementsByTagName("li");
		for (i = 0; i < li.length; i++) {
			a = li[i].getElementsByTagName("a")[0];
			if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";

			}
		}
		$('.lazy').lazy();
	}
	</script>
<?php } ?>

<?php if($list_news && $this->uri->segment(2) == 'detail'){ ?>
	<div class="listnewfeed">
		<ul class="list-unstyled">
			<?php
			foreach ($list_news as $k => $item) {
				if($k < 100) {
					$item_link = base_url() . 'tintuc/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);                
					if (strlen($item->not_image) > 10):
						$item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;
					else : 
						$item_image = site_url('media/images/noimage.png');
					endif;
					$number = 10;
					$content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $item->not_title)));
					$item_title = $content;
					$array = explode(" ", $content);
					if (count($array) <= $number) {
						$item_title = $content;
					}
					array_splice($array, $number);
					$item_title = implode(" ", $array) . "...";
					?>
					<li>
						<a href="<?php echo $item_link ?>">  
							<img class="pull-left img-circle" src="<?php echo $item_image ?>" alt=""/>
							<span style="display: block; height: 50px; overflow: hidden"><?php echo $item_title ?></span>
						</a>                    
					</li>
				<?php }        
		} ?>
		</ul>
	</div>
<?php } ?>
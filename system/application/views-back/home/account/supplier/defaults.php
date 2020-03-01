<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-12' : 'col-md-9' ?> col-xs-12">
	    <h2 class="page-title text-uppercase text-center">Sản phẩm nhà cung cấp sỉ, lẻ</h2>
	    <div style="width:100%; overflow-y: auto;"> 
		<form name="frmAccountPro" id="frmAccountPro" action="<?php echo $link; ?>" method="post" >
		    <table class="table table-bordered afBox">
			<thead>
			    <tr>
				<td colspan="7" class="form-inline">
				    <div class="form-group">
					<select name="cat" id="cat" class="form-control">
					    <option class="text-primary" value="0">--Chọn ngành nghề--</option>
					    <?php foreach ($cat_level_0 as $catitem) { ?>
    					    <option value="<?php echo $catitem->cat_id; ?>"><?php echo $catitem->cat_name; ?></option>
					    <?php } ?>
					</select>
					<input class="form-control" type="text" name="q" value="<?php echo $filter['q']; ?>" placeholder="Từ khóa ...">
					<input class="form-control" placeholder="Giá từ" type="text" name="pf" value="<?php echo $filter['pf']; ?>"/>
					<input class="form-control" placeholder="Giá đến" type="text" name="pt" value="<?php echo $filter['pt']; ?>"/>
					<button type="submit" class="btn btn-default1 form-control"><i class="fa fa-search"></i></button>
				    </div>
				    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
				    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
				</td>
			    </tr>
			    <tr>
				<th width="5%" class="aligncenter hidden-xs">STT</th>
				<th width="3%" class="aligncenter hidden-xs">
				    <input type="checkbox" onclick="DoCheck(this.checked, 'frmAccountPro', 0)" value="0" id="checkall" name="checkall"></th>
				<th width="10%" class="text-center">Hình ảnh
				</th>
				<th width="40%" class="text-center">Tên sản phẩm <br />
				    <a href="<?php echo $sort['name']['asc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				    <a href="<?php echo $sort['name']['desc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				</th>
				<th class="text-center" width="15%">Giá<br />
				    <a href="<?php echo $sort['price']['asc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				    <a href="<?php echo $sort['price']['desc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				</th>
				<th class="text-center hidden-xs">Danh mục<br />
				    <a href="<?php echo $sort['cat']['asc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				    <a href="<?php echo $sort['cat']['desc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				</th>
				<th class="text-center ">Gian hàng<br />
				    <a href="<?php echo $sort['shop']['asc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				    <a href="<?php echo $sort['shop']['desc']; ?>">
					<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
					     style="cursor:pointer;" alt=""/>
				    </a>
				</th>
			    </tr>
			</thead>
			<tbody>
			    <?php
			    foreach ($products as $k => $product):
				$protocol = 'http://'; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				$domainName = $_SERVER['HTTP_HOST'];
				$link_shop = $protocol . $product['linkshop'] . '.' . $domainName;
				if ($product['domain'] != '') {
				    $link_shop = $protocol . $product['domain'];
				}
				if ($product['pro_type'] == 2) {
				    $pro_type = 'coupon';
				} else {
				    if ($product['pro_type'] == 0) {
					$pro_type = 'product';
				    }
				}
				?>
    			    <tr id="af_row_<?php echo $product['pro_id']; ?>">
    				<td class="hidden-xs"><?php echo $num + $k + 1; ?></td>
    				<td class="aligncente hidden-xs">
    				    <input type="checkbox" onclick="DoCheckOne('frmAccountPro')"
    					   value="<?php echo $product['pro_id']; ?>"
    					   id="checkone" name="checkone[]">
    				</td>
    				<td>
					<?php
					$filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product['pro_dir'] . '/thumbnail_1_' . explode(',', $product['pro_image'])[0];
					if (explode(',', $product['pro_image'])[0] != '') { //file_exists($filename) && $filename != ''
					    ?>
					    <img width="80" src="<?php echo $filename; ?>" />
					<?php } else { ?>
					    <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
					<?php } ?>

    				</td>
    				<td><a target="_blank"
    				       href="<?php echo $link_shop . '/shop/' . $pro_type . '/detail' . '/' . $product['pro_id'] . '/' . RemoveSign($product['pro_name']); ?>"><?php echo $product['pro_name']; ?></a>
    				</td>
    				<td align="right"><span
    					class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' đ'; ?></span>
    				</td>
    				<td class=" hidden-xs"><a target="_blank"
    							  href="<?php echo $link_shop . '/product/cat/'; ?><?php echo $product['pro_category']; ?>/<?php echo RemoveSign($product['cName']); ?>"><?php echo $product['cName']; ?></a>
    				</td>
    				<td class="">
    				    <a target="_blank" href="<?php echo $link_shop . '/shop'; ?>"><?php echo $product['nameshop']; ?></a>
    				</td>
    			    </tr>
			    <?php endforeach; ?>
			    <?php if (count($products) <= 0) { ?>
    			    <tr>
    				<td colspan="6" align="center">
    				    <div class="nojob">Không có sản phẩm nào!</div>
    				</td>
    			    </tr>
			    <?php } ?>
			</tbody>
		    </table>
		</form>
		<div class="text-center">
		    <?php echo $pager; ?>
		</div>
	    </div>
	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
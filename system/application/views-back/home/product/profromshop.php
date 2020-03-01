<?php $this->load->view('home/common/account/header'); ?>
<?php
    $str = '';
    if($this->uri->segment(2) == 'profromshop') $str = 'Sản phẩm';
    elseif($this->uri->segment(2) == 'coufromshop') $str = 'Coupon';
?>

<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
		.table-xs, .table-xs thead, .table-xs tbody, .table-xs th, .table-xs tr, .table-xs td {
	    display: block; 
	}
	.table-xs { border: none !important;}
	.table-xs thead tr {
	    position: absolute;
	    top: -9999px;
	    left: -9999px;
	} 
	.table-xs tr { 
	    border: none !important; 
	    border-bottom: 1px solid #eee !important;
	    margin-bottom: 20px;
	}
	.table-xs td {
	    border: 1px solid #eee !important;
	    border-bottom: none !important; 
	    position: relative;
	    padding-left: 140px !important;
	}
	.table-xs td:before {    
	    background: #fdfdfd;
	    position: absolute;
	    left: 0; top:0; bottom:0;
	    width: 132px;  padding: 8px;
	    border-right:1px solid #eee;
	    white-space: nowrap; text-align: right;
	}
	.table-xs td:nth-of-type(1):before { content: "STT"; }
	.table-xs td:nth-of-type(2):before { content: "Hình ảnh"; }
	.table-xs td:nth-of-type(3):before { content: "Tên sản phẩm"; }
	.table-xs td:nth-of-type(4):before { content: "Giá bán"; }
	.table-xs td:nth-of-type(5):before { content: "Của gian hàng"; }
	.table-xs td:nth-of-type(6):before { content: ""; }

    }
</style>

<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div id="af_products" class="col-lg-9 col-md-9 col-sm-8">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php if ($this->uri->segment(2) == 'profromshop') { ?> Chọn sản phẩm từ gian hàng  <?php } else { ?> Chọn coupon từ gian hàng <?php } ?>
	    </h4>

	    <?php
	    if ($this->uri->segment(3) == 'products') {
		$col = 9;
	    } else {
		$col = 10;
	    }
	    ?> 

	    <form name="frmAccountPro" id="frmAccountPro" action="<?php echo $link; ?>" method="post" >
		<div class="panel panel-default">
		    <div class="panel-body">
			<div class="row">
			    <div class="col-sm-4">		    
				<div class="form-group">
				    <?php if ($this->uri->segment(3) != 'myproducts') { ?>
    				    <div class="select_div" id="category_pro_0">
    					<select id="cat_pro_0"  onchange="check_postCategoryProduct(this.value,0,'<?php echo base_url(); ?>');" name="cat_pro_0" class="form_control_cat_select form-control">
    					    <option class="text-primary" value="">--Chọn danh mục tìm kiếm--</option>
						<?php
						if (isset($childcat)) {
						    foreach ($childcat as $item) {
							?>
	    					    <option <?php echo $item->cat_id == $filter['cat_pro_0'] ? 'selected="selected"' : ''; ?> value="<?php echo $item->cat_id; ?>" <?php echo (isset($arra_cat[0]) && $arra_cat[0] == $item->cat_id) ? 'selected="selected"' : ''; ?> ><?php echo $item->cat_name; ?><?php
							    if ($item->child_count > 0) {
								echo ' >';
							    }
							    ?>	
	    					    </option>
						    <?php } ?>
						<?php } ?>
    					</select>
    				    </div>
    				    <div class="select_div" id="category_pro_1"></div>
    				    <div class="select_div" id="category_pro_2"></div>
    				    <div class="select_div" id="category_pro_3"></div>
    				    <div class="select_div" id="category_pro_4"></div>
				    <?php } ?>
				</div>               
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">
				    <select name="product_type" id="product_type" class="form-control" style="width: 100%">
					<?php if ($this->uri->segment(2) == 'profromshop') { ?>
    					<option <?php echo ($filter['product_type'] == 0) ? 'selected = "selected"' : ''; ?> value="0">Sản phẩm</option>
					<?php } ?>
					<?php if (serviceConfig == 1) { ?>
    					<option <?php echo ($filter['product_type'] == 1) ? 'selected = "selected"' : ''; ?> value="1">Dịch vụ</option>
					<?php } ?>
					<?php if ($this->uri->segment(2) == 'coufromshop') { ?>
    					<option <?php echo ($filter['product_type'] == 2) ? 'selected = "selected"' : ''; ?> value="2">Coupon</option>
					<?php } ?>
				    </select>
				</div>
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">
				    <input class="inputfilter_account form-control " type="text" name="q" value="<?php echo $filter['q']; ?>" placeholder="Từ khóa ...">
				</div>                
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">
				    <?php $priceType = array('1' => 'Giá', '2' => 'Hoa hồng (số tiền)', '3' => 'Hoa hồng(%'); ?>
				    <select name="price_type" class="form-control">
					<?php foreach ($priceType as $k => $val) { ?>
    					<option <?php echo $filter['price_type'] == $k ? 'selected="selected"' : ''; ?> value="<?php echo $k; ?>"><?php echo $val; ?></option>
					<?php } ?>
				    </select>
				</div>
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">
				    <input placeholder="Từ" class="form-control " type="text" name="pf" value="<?php echo $filter['pf']; ?>"/>
				</div>
			    </div>

			    <div class="col-sm-4">
				<div class="form-group">
				    <input placeholder="Đến" class="form-control " type="text" name="pt" value="<?php echo $filter['pt']; ?>"/>
				</div>
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">    
				    <div class="checkbox">
					<label>
					    <input type="checkbox" name="garantee" id="garantee" value="1" <?php
					    if ($filter['garantee'] == 1) {
						echo 'checked="checked"';
					    }
					    ?> /> Gian hàng bảo đảm
					</label>
				    </div>
				</div>
			    </div>

			    <div class="col-sm-4">    
				<div class="form-group">
				    <button type="submit" class="btn btn-azibai ">Tìm kiếm</button>
				    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
				    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
				</div>
			    </div>

			</div>
		    </div>
		</div>
	    </form> 

	    <?php if (count($products) > 0) { ?>

		<?php if ($this->session->flashdata('sessionSuccess')) { ?>
		    <div class="message success" >
			<div class="alert alert-success">
			    <?php echo $this->session->flashdata('sessionSuccess'); ?>
			    <button type="button" class="close" data-dismiss="alert">×</button>
			</div>
		    </div>
		<?php } ?>

    	    <table class="table table-bordered afBox table-xs">
    		<thead>
    		    <tr>
    			<th width="40" >STT</th>
    			<th width="100" >Hình ảnh</th>
    			<th>Tên <?php echo $str; ?></th>			    
    			<th width="150">Giá bán<br />
    			    <a href="<?php echo $sort['price']['asc']; ?>">
    				<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
    				     style="cursor:pointer;" alt=""/>
    			    </a>
    			    <a href="<?php echo $sort['price']['desc']; ?>">
    				<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
    				     style="cursor:pointer;" alt=""/>
    			    </a>
    			</th>
    			<th><?php echo $str; ?> của gian hàng<br />
    			    <a href="<?php echo $sort['shop']['asc']; ?>">
    				<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
    				     style="cursor:pointer;" alt=""/>
    			    </a>
    			    <a href="<?php echo $sort['shop']['desc']; ?>">
    				<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
    				     style="cursor:pointer;" alt=""/>
    			    </a>
    			</th> 
    			<th width="100"></th>
    		    </tr>	 
    		</thead>

    		<tbody>
			<?php
			foreach ($products as $k => $product):
			    $stt++;
			    ?>  
			    <tr id="af_row_<?php echo $product['pro_id']; ?>">                    
				<td><?php echo $stt + $num; ?> </td>
				<td class="img_prev">				
				    <?php
				    $protocol = "http://"; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				    $duoi = '.' . $_SERVER['HTTP_HOST'] . '/';
				    $proimg = explode(',', $product['pro_image']);
				    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product['pro_dir'] . '/thumbnail_1_' . $proimg[0];
				    $imglager = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product['pro_dir'] . '/thumbnail_3_' . $proimg[0];
				    if ($proimg[0] != '') { //file_exists($filename) && 
					?>
	    			    <a rel="tooltip" data-placement="auto right" data-toggle="tooltip" data-html="true" data-original-title="<img src='<?php echo $imglager; ?>' />">
	    				<img src="<?php echo $filename ?>" alt = "" class="img-responsive"/>
	    			    </a>
				    <?php } else { ?>
	    			    <img src="<?php echo base_url(); ?>media/images/noimage.png" alt = "" class="img-responsive"/>
				    <?php } ?>
				</td>

				<td align="left">
				    <a target="_blank" href="<?php echo $protocol . $product['linkshop'] . $duoi ?>shop/product/detail/<?php echo $product['pro_id']; ?>/<?php echo RemoveSign($product['pro_name']); ?>"><?php echo $product['pro_name']; ?></a>
				</td> 

				<td align="right" class="">
				    <span class="product_price"><?php echo number_format($product['pro_cost'], 0, ",", ".") . ' đ'; ?></span>
				    <?php if ($product['af_amt'] > 0 || $product['af_rate'] > 0) { ?>
	    			    <p>Hoa hồng: 
	    				<span class="product_price_green">
						<?php
						if ($product['af_amt'] > 0) {
						    echo number_format($product['af_amt'], 0, ',', '.') . ' đ';
						} elseif ($product['af_rate'] > 0) {
						    echo $product['af_rate'] . '%';
						}
						?>
	    				</span>
	    			    </p>
				    <?php } ?>
				    <p>Tồn kho: <span class="product_price_green">
					    <?php echo $product['pro_instock']; ?>
					</span>
				    </p>
				</td>

				<td class="">
				    <a href="<?php echo $protocol . $product['linkshop'] . $duoi . 'shop'; ?>"><?php echo $product['nameshop']; ?></a>
				</td>

				<td>
				    <?php if ($product['isselect'] == true) { ?>
	    			    <a id="catid_<?php echo $product['pro_category']; ?>" class="chooseItem selected" href="javascript:void(0);" title="Hủy chọn bán">
	    				<img src="<?php echo base_url(); ?>templates/home/images/public.png" style="cursor:pointer;" border="0"  alt="Hủy chọn bán"/>
	    			    </a>
				    <?php } else { ?> 
	    			    <button type="button" class="btn btn-azibai" data-toggle="modal" data-target="#myModalProduct" onclick="getProduct(<?php echo $product['pro_id']; ?>);"> <?php if (isset($factory_bran) && in_array($product['pro_id'], $factory_bran)) { ?>Thêm <?php } else { ?> Chọn bán <?php } ?></button>
				    <?php } ?>				                               
				</td>                       
			    </tr>                        
			<?php endforeach; ?>  
    		</tbody>
    	    </table>
	    <?php } else { ?>
		<?php if ($this->uri->segment(2) == 'profromshop') { ?>
		    <?php if ($filter['no_store'] == 1) { ?>
	    	    <div class="nojob alert alert-info">Không có sản phẩm nào!</div>
		    <?php } else { ?>
	    	    <div class="nojob alert alert-info">
	    		Không có <?php echo $str; ?> nào từ Gian hàng công ty bạn!
	    	    </div>
		    <?php } ?>
		<?php } ?>                        
	    <?php } ?>

	    <?php echo $pager; ?>		          
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade prod_detail_modal" id="myModalProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabelProduct">
	<form action="/home/product/ajaxclone" method="post">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
	                <h4 class="modal-title" id="myModalLabel">CHỌN BÁN</h4>
	            </div>
	            <div class="modal-body"> 
	                <div class="form-group">
	                    <div class="col-lg-3 col-xs-4">Số lượng:</div>	
	                    <div class="col-lg-9 col-xs-8">
							<div class="input-group">							    
							    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Nhập số lượng..." />
							</div>
	                    </div>
	                </div>	                
	            </div>
	            <div class="modal-footer">
	            	<input type="hidden" name="protype" id="<?php echo ($this->uri->segment(2) == 'profromshop') ? 0 : 2; ?>">
	            	<input type="hidden" name="proid" id="proid">
	            	<button type="submit" class="btn btn-azibai">Lưu</button>
	            	<button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
	            </div>
	        </div>
	    </div>
    </form>	
</div>

<script>
	function getProduct(pro_id) {
		if (pro_id > 0) {
			$('#proid').val(pro_id);
		} else {
			return false;
		}
	}
    
    function Showhomepage(siteUrl, ishome, id){
        // console.log(data);
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"account/affiliate/myproducts",
            dataType: 'json',
            data: {ishome: ishome, proid:id},
            success: function (data) {
                if(data == '1'){
                    location.reload();
                }else{
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
</script>

<?php $this->load->view('home/common/footer'); ?>



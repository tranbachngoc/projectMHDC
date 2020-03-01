<?php $this->load->view('home/common/account/header'); ?>
<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
	table.table-azibai td:nth-of-type(1):before { content: "STT"; }
	table.table-azibai td:nth-of-type(2):before { content: "Hình ảnh"; }
	table.table-azibai td:nth-of-type(3):before { content: "Tên sản phẩm"; }
	table.table-azibai td:nth-of-type(4):before { content: "Giá bán"; }
	table.table-azibai td:nth-of-type(5):before { content: "Của gian hàng"; }
	table.table-azibai td:nth-of-type(6):before { content: "Chọn bán"; }
    }
</style>

<div class="container-fluid">
    <div class="row">
		<?php $this->load->view('home/common/left'); ?>	
		<?php $segment = $this->uri->segment(4); ?>
		<div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php echo ($segment == 'product') ? 'SẢN PHẨM' : 'COUPON'; ?> ĐÃ CHỌN
            </h4>
	    <form name="frmAccountPickup" id="frmAccountPickup" action="<?php echo base_url() .'account/affiliate/depot/' . $segment ?>" method="post">
		<div class="panel panel-default">
		    <div class="panel-body">
                        <div class="col-sm-4 col-xs-12">
                            <input type="text" name="search" class="form-control" placeholder="Nhập tên sản phẩm..." value="<?php echo $keyword; ?>">
                        </div>
                        <div class="col-sm-3 col-xs-12" id="category_pro_0">
                            <select id="cat_pro_0" name="category0" class="form-control form_control_cat_select">
                                <option value="0"> -- Lọc theo danh mục --</option>
                                <?php if (isset($catlevel0) && count($catlevel0) > 0) {
                                    foreach ($catlevel0 as $item) { ?>
                                        <option
                                            value="<?php echo $item->cat_id; ?>" <?php echo ($srcat == $item->cat_id) ? 'selected="selected"' : ''; ?>><?php echo $item->cat_name; ?></option>
                                        <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-xs-12" id="">
                            <select id="cat_pro_0" name="liststore" class="form-control form_control_cat_select">
                                <option value="0"> -- Lọc theo gian hàng --</option>
                                <?php if (isset($listShop) && count($listShop) > 0) {
                                    foreach ($listShop as $item) { ?>
                                        <option
                                            value="<?php echo $item->sho_id; ?>" <?php echo ($srstore == $item->sho_id) ? 'selected="selected"' : ''; ?>><?php echo $item->sho_name; ?></option>
                                        <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-xs-12">
                            <span class="input-group-btn">
                                <button class="btn btn-azibai" type="submit">Tìm kiếm</button>
                            </span>
                        </div> 
                    </div>
		</div>
		
		<ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="<?php echo ($segment == 'product') ? 'active' : '' ?>">
				<a href="/account/affiliate/depot/product">Sản phẩm</a>
		    </li>
		    <li role="presentation" class="<?php echo ($segment == 'coupon') ? 'active' : '' ?>">
				<a href="/account/affiliate/depot/coupon">Coupon</a>
		    </li>
		</ul>
                <?php if(count($products) > 0){ ?>
		<br>
		<div style="width:100%; overflow-y: auto;">
		    <table class="table table-bordered table-azibai">                        
			<thead>
			    <th width="40">STT</th>
			    <th width="100">Hình ảnh</th>
			    <th>Tên sản phẩm</th>
			    <th width="150">Giá bán</th>
			    <th width="200">Của gian hàng</th>
			    <th width="100">Chọn bán</th>
			</thead>
			<tbody>
                        <?php 
                        foreach ($products as $key => $product) {
                            $group_id = (int)$this->session->userdata('sessionGroup');
                            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $domainName = $_SERVER['HTTP_HOST'];
                            $link_shop = $protocol . $product->sho_link .'.'. $domainName;
                            if($product->domain != ''){
                                $link_shop = $protocol . $product->domain;
                            }
                            $proimg = explode(',', $product->pro_image);
                            $filename = 'media/images/product/'. $product->pro_dir .'/thumbnail_1_'. $proimg[0];
                            $pro_name = $product->pro_name;
                            $link_detail = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                        ?>
                            <tr>
                                <td><?php echo $stt + $key; ?></td>

                                <td>
                                    <img width="100" src="<?php echo DOMAIN_CLOUDSERVER . $filename; ?>" alt="" class="img-responsive" style="margin: 0 auto;">
                                </td>

                                <td>
                                    <a target="_blank" href="<?php echo $link_detail; ?>"><?php echo $pro_name; ?></a>
                                </td>

                                <td class="text-right">
                                    <div class="product_price"><?php echo number_format($product->pro_cost, 0, ",", ".") .' đ';?></div> 
                                    <div>Hoa hồng: 
                                        <span class="product_price_green"> 
                                            <?php
                                                if ($product->af_amt > 0) {
                                                    echo number_format($product->af_amt, 0, ',', '.').' đ';
                                                } elseif ($product->af_rate > 0) {
                                                    echo $product->af_rate . '%';
                                                }
                                            ?>
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <a target="_blank" href="<?php echo $link_shop .'/shop'; ?>"><?php echo $product->sho_name; ?></a>
                                </td>

                                <td>
                                    <a id="catid_<?php echo $product->pro_id; ?>" class="chooseItem" href="javascript:void(0);" title="Chọn bán" onclick="pickup(<?php echo $product->pro_id; ?>, '<?php echo $segment; ?>');">
                                        <span class="btn btn-azibai">Hủy chọn bán</span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>				
                        </tbody>
                    </table>
                <?php if(isset($linkPage)) {  echo $linkPage; } ?>
		</div>
                <?php 
                
                }else{
                    echo '<div class="nodata" style="border: 1px solid #ccc; border-top: none; padding: 10px;">Không có dữ liệu</div>';
                }?>
	    </form>
	</div>
    </div>    
</div>    
<script>
    function pickup(proid = 0, type = ''){
        $.ajax({
            // url: siteUrl + 'home/affiliate/ajaxpickup',
            url: '/account/affiliate/ajax_pickup',
            type: "POST",
            data: {product_id: proid},
            dataType: 'text',
            success: function (res) {
                // alert(res);
                // console.log(res);
                if (res == '2') {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Bỏ chọn bán thành công!!',
                        'theme': 'red',
                        'btns': {
                            'text': 'Ok', 'theme': 'green', 'onClick': function (e, btn) {
                                e.preventDefault();
                                window.location.href = siteUrl + 'home/affiliate/depot/' + type;
                            }
                        }
                    });
                } else {
                    alert('Có lỗi xảy ra!');
                }
            },
            error: function() {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }
</script>
<?php $this->load->view('home/common/footer'); die; ?>


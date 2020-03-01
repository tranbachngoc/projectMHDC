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
    .fadeInUp { margin-top: 12% !important;}
    input[type=number]::-webkit-inner-spin-button { 
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
        <h4 class="page-header text-uppercase" style="margin-top:10px">TÌM & CHỌN SẢN PHẨM BÁN</h4>
	    <form name="frmAccountPickup" id="frmAccountPickup" action="<?php echo base_url() .'account/affiliate/pickup/'. $segment; ?>" method="post">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row" style="margin-bottom: 10px;">
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

                             <div class="col-sm-6 col-xs-12">
                                <input type="text" name="search" class="form-control" placeholder="Nhập tên sản phẩm..." value="<?php echo $keyword; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-xs-12">
                                <select id="" name="sr_commission" class="form-control form_control_cat_select">
                                    <option value="1" <?php if($filter['unit'] && $filter['unit'] == 1){ echo 'selected'; } ?>>Giá</option>
                                    <option value="2" <?php if($filter['unit'] && $filter['unit'] == 2){ echo 'selected'; } ?>>Hoa hồng(tiền)</option>
                                    <option value="3" <?php if($filter['unit'] && $filter['unit'] == 3){ echo 'selected'; } ?>>Hoa hồng(%)</option>
                                </select>
                            </div>

                            <div class="col-sm-3 col-xs-12">					
                                <input class="form-control padding-bottom" type="number" name="df" value="<?php echo $filter['df']; ?>" placeholder="Từ" autocomplete="off">
                            </div>

                            <div class="col-sm-3 col-xs-12">					
                                <input class="form-control padding-bottom" type="number" name="dt" value="<?php echo $filter['dt']; ?>" placeholder="Đến" autocomplete="off">
                            </div>                        

                            <div class="col-sm-2 col-xs-12">
                                <span class="input-group-btn">
                                    <button class="btn btn-azibai" type="submit">Tìm kiếm</button>
                                </span>
                            </div>
                        </div>  
                    </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="<?php echo ($segment == 'product') ? 'active' : '' ?>">
                        <a href="/account/affiliate/pickup/product">Sản phẩm</a>
                    </li>
                    <li role="presentation" class="<?php echo ($segment == 'coupon') ? 'active' : '' ?>">
                        <a href="/account/affiliate/pickup/coupon">Coupon</a>
                    </li>
                </ul>		
                <br>
                <div style="width:100%; overflow-y: auto;">
                    <?php
                    if(count($products) > 0){
                    ?>
                    <table class="table table-bordered table-azibai">                        
                        <thead>
                            <th width="40">STT</th>
                            <th width="100">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th width="200">Giá bán</th>
                            <th>Của gian hàng</th>
                            <th width="100">Chọn bán</th>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($products as $key => $product){
                            $group_id = (int)$this->session->userdata('sessionGroup');
                            $protocol = 'http://'; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $domainName = $_SERVER['HTTP_HOST'];
                            $link_shop = $protocol . $product->sho_link .'.'. $domainName;

                            if($product->domain != ''){
                                $link_shop = $protocol . $product->domain;
                            }

                            if ($product->pro_image != '') {
                                $proimg = explode(',', $product->pro_image);			    
                                $filename = DOMAIN_CLOUDSERVER .'media/images/product/'. $product->pro_dir .'/thumbnail_1_'. $proimg[0];
                            } else {
                                $filename = 'media/images/no_photo_icon.png';
                            }
                            $link_detail = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                            ?>
                            <tr>
                                <td><?php echo $stt + $key; ?></td>
                                <td>
                                    <img width="100" src="<?php echo $filename; ?>" alt="" class="img-responsive" style="margin: 0 auto;">
                                </td>
                                <td>
                                    <a target="_blank" href="<?php echo $link_detail; ?>"><?php echo $product->pro_name; ?></a>
                                </td>
                                <td align="right">
                                    <div class="product_price"><?php echo number_format($product->pro_cost, 0, ",", ".") .' đ';?></div> 
                                    <div>Hoa hồng: <span class="product_price_green"> 
                                    <?php                                    
                                        if ($product->af_amt > 0) {
                                            echo number_format($product->af_amt, 0, ',', '.').' đ';
                                        } elseif ($product->af_rate > 0) {
                                            echo $product->af_rate . '%';
                                        }
                                    ?> 
                                    </div>
                                </td>

                                <td>
                                    <a target="_blank" href="<?php echo $link_shop; ?>/shop"><?php echo $product->sho_name; ?></a>
                                </td>

                                <td>
                                    <a id="select_id_<?php echo $product->pro_id; ?>" class="chooseItem" href="javascript:void(0);" title="Chọn bán" onclick="pickup_pro(<?php echo $product->pro_id; ?>, '<?php echo $segment; ?>');">
                                        <span class="btn btn-azibai">Chọn bán</span>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
		    </table>
            <?php } else{  echo '<div class="none_record"><p class="text-center">Không có đơn hàng nào</p></div>';
             } ?>
		</div>
	    </form>

        <?php if(isset($linkPage)) { echo $linkPage; } ?>

	    </div>
    </div>    
</div>

<script>
    function pickup_pro(proid = 0, type = ''){
        $.ajax({
            // url: siteUrl + 'home/affiliate/ajaxpickup',
            url: '/account/affiliate/ajax_pickup',
            type: "POST",
            data: {product_id: proid},
            dataType: 'text',
            success: function (res) {
                // alert(res);
                // console.log(res);
                if(res == '1'){
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Chọn bán thành công!!',
                        'theme': 'blue',
                        'btns': {
                            'text': 'Ok', 'theme': 'green', 'onClick': function (e, btn) {
                                e.preventDefault();
                                window.location.href = siteUrl + 'home/affiliate/pickup/' + type;
                            }
                        }
                    });
                } else if (res == '2') {
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


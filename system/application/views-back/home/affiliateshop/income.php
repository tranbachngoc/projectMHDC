<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
		table.table-azibai td:nth-of-type(1):before { content: "STT"; }
		table.table-azibai td:nth-of-type(2):before { content: "Mã ĐH"; }
		table.table-azibai td:nth-of-type(3):before { content: "Tên sản phẩm"; }
		table.table-azibai td:nth-of-type(4):before { content: "Giá bán"; }
		table.table-azibai td:nth-of-type(5):before { content: "Số lượng"; }
		table.table-azibai td:nth-of-type(6):before { content: "Hoa hồng"; }
		table.table-azibai td:nth-of-type(7):before { content: "Cập nhật"; }
		table.table-azibai td:nth-of-type(8):before { content: "Trạng thái"; }	
    }
	@media screen and (max-width: 767px){
		.panel-body [class*="col-"]{ margin:10px 0;}
	}
</style>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>

	<?php $segment = $this->uri->segment(4); ?>

	<div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                ĐƠN HÀNG <?php echo ($segment == 'product') ? 'SẢN PHẨM' : 'COUPON' ?>
            </h4>
	    <div class="panel panel-default">
		<div class="panel-body">
		    <form action="#" method="post" class="form" style="margin:0">
			<div class="row">
				<div class="col-sm-2 col-xs-12">
                                    <select name="month_fitter" autocomplete="off" class="form-control">
                                        <option value="">-Chọn tháng-</option>
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option <?php
                                        if ($filter['month_fitter'] && $filter['month_fitter'] > 0 && $filter['month_fitter'] == $i) {
                                            echo 'selected = "selected"';
                                        } elseif ($filter['month_fitter'] == "" && date('n') == $i) {
                                            //echo 'selected = "selected"';
                                        }
                                        ?> value="<?php echo $i; ?>">Tháng <?php echo $i; ?></option>
                                    <?php } ?>
                                    </select>
				</div>
                                <div class="col-sm-2 col-xs-12">
                                    <select name="year_fitter" autocomplete="off" class="form-control">
                                        <?php for ($i = date('Y',time()); $i >= date('Y',time()) - 10 ; $i--) { ?>
                                            <option <?php
                                            if ($filter['year_fitter'] && $filter['year_fitter'] > 0 && $filter['year_fitter'] == $i) {
                                                echo 'selected = "selected"';
                                            }
                                            ?> value="<?php echo $i; ?>">Năm <?php echo $i; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>

				<div class="col-sm-2 col-xs-12">
                                    <select name="status" autocomplete="off" class="form-control">
                                        <option value="">Tất cả</option>
                                        <?php foreach ($status as $sta): ?>
                                            <option
                                                value="<?php echo $sta['status_id']; ?>" <?php echo ($filter['status'] == $sta['status_id']) ? 'selected="selected"' : ''; ?>><?php echo $sta['text']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
				</div>
				<div class="col-sm-2 col-xs-12">					
                                    <input class="form-control padding-bottom" type="text" name="df" value="<?php echo $filter['df']; ?>" placeholder="Giá từ" autocomplete="off">
				</div>
				<div class="col-sm-2 col-xs-12">					
                                    <input class="form-control padding-bottom" type="text" name="dt" value="<?php echo $filter['dt']; ?>" placeholder="Đến" autocomplete="off">
				</div>
				<div class="col-sm-2 col-xs-12">
                                    <button type="submit" class="btn btn-azibai btn-block"><i class="fa fa-search fa-fw"></i>&nbsp;Tìm kiếm</button>
                                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
				</div>
			</div>
		    </form>	
		</div>
	    </div>

	    <div style="width:100%; overflow-y: auto;">
                <?php
                if(count($orders) > 0){
                ?>
                <div class="text-right">
                    <b>Tổng hoa hồng nhận được: <span class="product_price"><?php echo number_format($tonghh,0,',','.') ?> đ</span></b>
                </div>
                <br/>
		<table class="table table-bordered table-azibai">                        
		    <thead>                            
			<tr>
			    <th>STT</th>
			    <th>Hình ảnh</th>
			    <th>Mã ĐH</th>
			    <th>Tên sản phẩm</th>
			    <th>Đơn giá</th>
			    <th>Trạng thái</th>
			    <th>Hoa hồng</th>
			    <th>SL</th>
			    <th width="100">Hoa hồng thực nhận</th>
			</tr>
		    </thead>

		    <tbody>
			<?php 
                        $tonghhpage = 0;
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        foreach ($orders as $key => $items){
                            if ($items->af_rate > 0 || $items->af_amt > 0) {
                                if ($items->af_rate > 0):
                                    $hoahong = 1 - ($items->af_rate / 100);
                                    $moneyShop = ($items->shc_total) - ($hoahong * $items->qty);
                                    if ($items->em_discount > 0):
                                        //$hh_giasi = ($order['shc_total'])*(1-($hoahong / 100));
                                        //$moneyShop = ($items->shc_total) * (1 - ($hoahong / 100));
                                    endif;
                                else:
                                    $hoahong = $items->af_amt;
                                    $moneyShop = $items->shc_total - ($hoahong * $items->qty); 
                                    endif;
                            } else {
                                
                            }
                            $moneyShop = $items->shc_total;
                            $dongia = $moneyShop / $items->qty;
                            if ($items->pro_type == 2) {
                                $pro_type = 'coupon';
                            } else {
                                if ($items->pro_type == 0) {
                                    $pro_type = 'product';
                                }
                            }
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $items->pro_dir . '/thumbnail_1_' . explode(',',$items->pro_image)[0];
                            if($items->shc_dp_pro_id > 0){
                                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $items->pro_dir . '/thumbnail_1_' . $quycach[$items->shc_dp_pro_id];
                                
                                if($items->dp_color != ''){
                                    $chitietsp = 'Màu: ' . $items->dp_color . '<br/>';
                                }
                                if($items->dp_size != ''){
                                    $chitietsp .= 'Kích thước: ' . $items->dp_size . '<br/>'; 
                                }
                                if($items->dp_material != ''){
                                    $chitietsp .= 'Chất liệu: ' . $items->dp_material . '<br/>';
                                }
                            }
                            
                        ?>
			<tr>
			    <td><?php echo $stt + $key ?></td>
                            <td class="text-center" style="vertical-align: middle;">
				<a rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="auto right" data-original-title="<img src='<?php echo $filename; ?>'/>">
				    <img width="80" src="<?php echo $filename; ?>" style="width:60px;">
				</a>
                                <?php if($chitietsp != ''){ echo '<p>'.$chitietsp.'</p>';} ?>
			    </td>
                            <td class="text-center">
                                <a href="<?php echo base_url(); ?>account/affiliate/order/<?php echo $items->id?>" target="_blank" style="color: #00f">
				    <?php echo $items->id?>
                                </a>
			    </td>
                            <td width="200">
				<a href="<?php echo $protocol . $linkShopAff . '/affiliate/' . $pro_type . '/detail/' . $items->pro_id . '/' . RemoveSign($items->pro_name); ?>" target="_blank"><?php echo $items->pro_name?></a>
			    </td>
			    <td align="right">
                                <span class="product_price"><?php echo number_format($items->pro_price_original,0,',','.')?> đ</span>
                                <?php if ($items->pro_price_rate > 0 || $items->pro_price_amt > 0):?>
                                    <br/>Khuyến mãi:
                                    <?php if ($items->pro_price_rate > 0):?>
                                        <span><?php echo number_format($items->pro_price_rate, 0, ",", "."); ?> %</span>
                                    <?php else: ?>
                                        <span><?php echo number_format($items->pro_price_amt, 0, ",", "."); ?> đ</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <br/>Giảm qua CTV:
                                <?php
                                if ($items->affiliate_discount_amt > 0) {
                                    $giamqctv = number_format($items->affiliate_discount_amt, 0, ",", ".") . ' đ';
                                } else {
                                    $giamqctv = $items->affiliate_discount_rate . ' %';
                                }
                                ?>
                                <span style="color: #a30abd;">
                                    <?php echo $giamqctv ?>
                                </span>
			    </td>
			    <td align="center"><?php echo $items->pState?> </td>
			    <td align="center">
                                <span class="product_price_green"> 
				<?php
                                if ($items->af_amt > 0) {
                                    echo number_format($items->af_amt, 0, ',', '.').' đ';
                                } elseif ($items->af_rate > 0) {
                                    echo $items->af_rate . '%';
                                }
                                ?>
                                </span>
			    </td>
			    <td align="center"><?php echo $items->shc_quantity?></td>
			    <td align="right">
                                <?php
                                if ($items->af_amt > 0) {
                                    $hoahongnhan = $items->af_amt * $items->shc_quantity;
                                } elseif ($items->af_rate > 0) {
                                    $hoahongnhan = $items->pro_price * $items->shc_quantity * ($items->af_rate / 100);
                                }
                                $tonghhpage += $hoahongnhan;
                                ?>
                                <span class="product_price"><?php echo number_format($hoahongnhan, 0, ',', '.').' đ';?></span>
			    </td>
			</tr>
                        <?php } ?>
                        <tr class="text-right"><td colspan="9">Tổng hoa hồng nhận được trên trang: <span class="product_price"><?php echo number_format($tonghhpage, 0, ',', '.').' đ';?></span></td></tr>
                    </tbody>
		</table>
                <?php if(isset($linkPage)) { echo $linkPage; }?>
                <?php
                }
                else{
                    echo '<div class="none_record"><p class="text-center">Không có đơn hàng nào</p></div>';
                }
                ?>
	    </div>
	</div>
    </div>    
</div>
<style>
    td{vertical-align: middle !important;}
</style>
<?php $this->load->view('home/common/footer'); ?>


<style>
    @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
	table.table-azibai td:nth-of-type(1):before { content: "STT"; }
	table.table-azibai td:nth-of-type(2):before { content: "Hình ảnh"; }
	table.table-azibai td:nth-of-type(3):before { content: "Tên sản phẩm"; }
	table.table-azibai td:nth-of-type(4):before { content: "Số lượng"; }
	table.table-azibai td:nth-of-type(5):before { content: "Đơn giá(VNĐ)"; }
	table.table-azibai td:nth-of-type(6):before { content: "Doanh số(VNĐ)"; }
	table.table-azibai td:nth-of-type(7):before { content: "Danh mục"; }	
    }
</style>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>

	<?php $segment = $this->uri->segment(4); ?>

	<div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                THỐNG KÊ THEO <?php echo ($segment == 'product') ? 'SẢN PHẨM' : 'COUPON' ?>
            </h4>

	    <div class="panel panel-default">
		<div class="panel-body">
		    <form class="form-inline" action="" style="margin-bottom:0px" method="post">
			Lọc doanh số từ ngày:
			<input type="date" class="form-control" id="datefrom" name="datefrom" value="<?php echo $datefrom ?>">
			<br class="visible-xs">
			Đến ngày:
			<input type="date" class="form-control" id="dateto" name="dateto" value="<?php echo $dateto ?>">
			<br class="visible-xs">                            
			<button type="submit" class="btn btn-azibai">Thực hiện</button>
		    </form>	
		</div>
	    </div>
            
	    <?php if(count($products) > 0){ ?>
            <div style="width:100%; overflow-y: auto;">
                <div class="text-right">
                    <b>Tổng doanh số bán hàng: <span class="product_price"><?php echo number_format($doanhso,0,',','.') ?> đ</span></b>
                </div>
                <br/>
		<table class="table table-bordered table-azibai">
		    <thead>
			<tr>
			    <th class="text-center" width="40">STT</th>
			    <th class="text-center" width="100">
				Hình ảnh
			    </th>
			    <th class="text-center" width="450">
				Tên sản phẩm
			    </th>
			    <th class="text-center" width="80">
				SL
			    </th>
			     <th class="text-center" width="150">
				Đơn giá
			    </th>
			    <th class="text-center" width="150">
				Doanh số
			    </th>
			    <th class="text-center" width="200">
				Danh mục
			    </th>
			</tr>
		    </thead>
		    <tbody>
                        <?php
                        $dspage = 0;
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        foreach ($products as $key => $item){
                            if ($item->af_rate > 0 || $item->af_amt > 0) {
                                if ($item->af_rate > 0):
                                    $hoahong = $item->af_rate;
                                    $moneyShop = ($item->shc_total) * (1 - ($hoahong / 100));
                                    if ($item->em_discount > 0):
                                        //$hh_giasi = ($order['shc_total'])*(1-($hoahong / 100));
                                        $moneyShop = ($item->shc_total) * (1 - ($hoahong / 100));
                                    endif;
                                else:
                                    $hoahong = $item->af_amt;
                                    $moneyShop = $item->shc_total - ($hoahong * $item->qty); 
                                    endif;
                            } else {
                                $moneyShop = $item->shc_total;
                            }
                            $dongia = $moneyShop / $item->qty;
                            if ($item->pro_type == 2) {
                                $pro_type = 'coupon';
                            } else {
                                if ($item->pro_type == 0) {
                                    $pro_type = 'product';
                                }
                            }
                            
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/thumbnail_1_' . explode(',',$item->pro_image)[0];
                            $linkShopAff = $item->sho_link . '.' . domain_site;
                            if ($item->domain != '') {
                                $linkShopAff = $item->domain;
                            }
                        ?>
			<tr>
			    <td class="text-center"><?php echo $stt + $key ?></td>
			    <td>
				<a rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="auto right" data-original-title="<img src='<?php echo $filename; ?>'/>">
				    <img width="80" src="<?php echo $filename; ?>">
				</a>
			    </td>
			    <td>                                            
				<a target="_blank" class="" href="<?php echo $protocol . $linkShopAff . '/affiliate/' . $pro_type . '/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name); ?>">
                                <?php echo $item->pro_name?>
                                </a>
			    </td>
			    <td align="center"><?php echo $item->sl;?></td>
			    <td align="right">
                                <?php echo number_format($item->doanhso/$item->sl, 0, ",", ".")?> đ
                            </td>
			    <td align="right">
				<a href="/account/affiliate/statistic/detail/<?php echo $item->pro_id;?>" class="dso">
                                    <?php echo number_format($item->doanhso, 0, ",", ".");?> đ
                                </a>
			    </td>
			    <td>
                                <?php echo $item->cat_name?>
                            </td>
			</tr>
                            <?php $dspage += $item->doanhso;?>
                        <?php } ?>
		        <tr class="text-right"><td colspan="9">Tổng danh số bán được trên trang: <span class="product_price"><?php echo number_format($dspage, 0, ',', '.').' đ';?></span></td></tr>
                    </tbody>
		</table>
                <?php if(isset($linkPage)) { echo $linkPage; }?>
	    </div>
            <?php } else{ echo '<div class="text-center">Không có dữ liệu</div>'; } ?>
	</div>
    </div>
</div>
<style>
tr td {
    vertical-align: middle !important;
}
</style>
<?php $this->load->view('home/common/footer'); ?>


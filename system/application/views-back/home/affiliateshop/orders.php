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
		<table class="table table-bordered table-azibai">                        
		    <thead>                            
			<tr>
			    <th width="40">STT</th>
			    <th width="80">Mã đơn</th>
			    <th>Tên sản phẩm</th>
                            <th width="150">Đơn giá</th>
			    <th width="100">Số lượng</th>
			    <th width="100">Hoa hồng</th>
			    <th width="100">Trạng thái</th>
			</tr>
		    </thead>

		    <tbody>
			<?php 
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $domainName = $_SERVER['HTTP_HOST'];
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
                                $moneyShop = $items->shc_total;
                            }
                            $dongia = $moneyShop / $items->qty;
                            if ($items->pro_type == 2) {
                                $pro_type = 'coupon';
                            } else {
                                if ($items->pro_type == 0) {
                                    $pro_type = 'product';
                                }
                            }
                        ?>
			<tr>
			    <td><?php echo $stt + $key ?></td>
			    <td>
                                <a href="<?php echo base_url(); ?>account/affiliate/order/<?php echo $items->id?>" target="_blank" style="color: #00f">
				    <?php echo $items->id?>
                                </a>
			    </td>
			    <td>
                    <?php 
                        if($items->domain != '') {
                            $link_sp = $protocol.$items->domain. '/shop/' . $pro_type . '/detail/' . $items->pro_id . '/' . RemoveSign($items->pro_name);
                        }else {
                            $link_sp = $protocol.$items->sho_link.'.'.$domainName. '/shop/' . $pro_type . '/detail/' . $items->pro_id . '/' . RemoveSign($items->pro_name);
                        } 
                    ?>
				<a href="<?php echo $link_sp; ?>" target="_blank"><?php echo $items->pro_name?></a>
			    </td>
			    <td align="right">
                                <span class="product_price"><?php echo number_format($items->pro_price_original,0,',','.')?> đ</span>
			    </td>
			    <td align="center"><?php echo $items->shc_quantity?></td>
			    <td align="right">
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
			    <td align="center"><?php echo $items->pState?> </td>
			</tr>
                        <?php } ?>				
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
<?php $this->load->view('home/common/footer'); ?>


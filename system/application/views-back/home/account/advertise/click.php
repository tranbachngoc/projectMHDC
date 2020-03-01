<?php $this->load->view('home/common/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header" style="margin-top:10px">THỐNG KÊ LƯỢT CLICK QUẢNG CÁO</h4>
	    <div id="panel_user_order" class="panel panel-default">

		<div class="content">
		    <div class="vas_">
			<div class="tableprice">
			    <div class="table-responsive  tb-grid">
				<table class="table table-bordered">
				    <tbody>
				    <thead>
				    <th>STT</th>
				    <th class="text-center">Tiêu đề</th>
				    <th class="text-center">Hình ảnh</th>
				    <th class="text-center">Vị trí</th>

				    <th class="text-center">Tổng lượt click</th>
				    </thead>
				    <?php $stt = 1;
				    foreach ($totalclick as $item) { ?>
    				    <tr>
    					<td class="titlebig"><?php echo $stt; ?></td>
    					<td><?php echo $item->adv_title; ?></td>
    					<td class="text-center">
    					    <img width="200" src="<?php echo base_url(); ?>media/banners/<?php echo $item->adv_dir; ?>/<?php echo $item->adv_banner; ?>" />
    					    <br>
    					    <a href="<?php echo base_url(); ?>media/banners/<?php echo $item->adv_dir; ?>/<?php echo $item->adv_banner; ?>" target="_blank">Xem ảnh đầy đủ</a>
    					    <br>
    					    <a href="<?php echo $item->adv_link; ?>" target="_blank">Liên kết Banner</a>
    					</td>
    					<td class="text-center">- <?php echo $item->title; ?><br>
    					    -
    <?php if ($item->adv_page == "home") {
	echo "Trang chủ danh mục";
    } ?><?php if ($item->adv_page == "product_sub") {
	echo "Trang chủ Affiliate";
    } ?>
    					</td>

    					<td class="text-center"><?php echo $item->total; ?></td>
    				    </tr>
					<?php $stt ++;
				    } ?>
<?php if (count($totalclick) == 0) { ?>
    				    <tr>
    					<td colspan="5" align="center">Không có dữ liệu.</td>

    				    </tr>
<?php } ?>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
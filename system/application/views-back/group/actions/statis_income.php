<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Thống kê thu nhập các hàng</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->                    
                    
                    <div class="table-responsive">
                        <div class="panel panel-default">
                        	<div class="panel-body" style="padding: 15px 20px;">
                    	 		<?php if(count($sc_shop_grt) > 0) { ?>
                    	 			<div class="row">
                    	 				<?php foreach ($sc_shop_grt as $key => $value) { ?>
                                                    <div class="col-sm-6" style="margin-bottom: 20px;">
				                                <div style="border: 1px solid #eee; padding: 10px;">
				                                    <div class="pull-left" style="">
				                                        <div class="fix1by1 img-circle">
				                                            <?php
				                                            if(file_exists('media/group/logos/'.$items->grt_dir_logo.'/'.$items->grt_logo) && $items->grt_logo != ''){
				                                                $logo = '/media/group/logos/'.$items->grt_dir_logo.'/'.$items->grt_logo;
				                                            } else {
				                                                $logo = '/images/community_join.png';
				                                            } ?>
				                                            <a href="#" class="c" style="background:url('<?php echo $logo ?>') no-repeat center / auto 100%;"></a>
				                                        </div>
				                                    </div>

				                                    <div style="padding: 18px 0 18px 70px; background: url(/images/community_join.png) no-repeat left/ auto 70%;">
				                                    	<a href="/grouptrade/<?php echo $value->order_group_id; ?>/detail_statis_income/<?php echo $value->order_saler; ?>">
				                                        <div class="title-ellipsis">
				                                            <?php echo $value->shopname ?>
				                                            <p><i>Tổng doanh thu: </i><span style="color: red;"><span><?php echo number_format($value->total, 0, ",", "."); ?> đ</span></p>
				                                            <input type="hidden" name="sho_id_<?php echo $value->order_saler; ?>" id="sho_id_<?php echo $value->order_saler; ?>" value="<?php echo $value->order_saler; ?>">
				                                        </div>
				                                        </a>
				                                    </div>
				                                </div>
				                            </div>
                    	 				<?php } ?>	
                    	 			</div>
                    	 		<?php } else { ?>
                    	 			<div class="row">
                    	 				<span>Chưa có dữ liệu...</span>
                    	 			</div>
                    	 		<?php } ?>
                        	 	
                        	</div>
                        </div>
                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>   
<?php $this->load->view('group/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8">
                <h2 class="page-title">THỐNG KÊ CỘNG TÁC VIÊN</h2>
				<?php if ($shopid > 0  ) { ?>
				<div style="width:100%; overflow: auto">
					<table class="table table-bordered">
						<?php if(count($orders) > 0){ ?>
						<tr>
							<td width="5%" class="aligncenter">STT</td>
							<td>Số tiền
								<a href="<?php echo $sort['amount']['asc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
								<a href="<?php echo $sort['amount']['desc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
							</td>
							<td>Trạng thái
								<a href="<?php echo $sort['status']['asc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
								<a href="<?php echo $sort['status']['desc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
							</td>
							<td>Ngày tạo
								<a href="<?php echo $sort['creatdate']['asc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
								<a href="<?php echo $sort['creatdate']['desc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
							</td>
							<td>Ngày tạo
								<a href="<?php echo $sort['paydate']['asc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
								<a href="<?php echo $sort['paydate']['desc']; ?>">
									<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
										 style="cursor:pointer;" alt=""/>
								</a>
							</td>
							<td>Mô tả</td>
						</tr>
						<?php foreach ($orders as $k => $order): ?>
							<tr>
								<td><?php echo $num + $k + 1; ?></td>
								<td>
					<span
						class="product_price"><?php echo number_format($order['commission'], 0, ",", ".") . ' VNĐ'; ?></span>
								</td>
								<td><?php echo $order['status']; ?></td>
								<td><?php echo $order['created_date']; ?></td>
								<td><?php echo $order['payment_date']; ?></td>
								<td><?php echo $order['description']; ?></td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="6">
								<form action="<?php echo $link; ?>" method="post" class="form-inline">
									<select name="status" autocomplete="off">
										<option value="">Tất cả</option>
										<?php foreach ($status as $sta): ?>
											<option
												value="<?php echo $sta['id']; ?>" <?php echo ($filter['status'] == $sta['id']) ? 'selected="selected"' : ''; ?>><?php echo $sta['text']; ?></option>
										<?php endforeach; ?>
									</select>

									<label for="df">Ngày từ:</label>
									<input class="inputfilter_account" type="text" id="df" name="df"
										   value="<?php echo $filter['df']; ?>" placeholder="yyyy-mm-dd"
										   autocomplete="off"/>
									<label for="df">Đến: </label>
									<input class="inputfilter_account" type="text" name="dt" id="dt"
										   value="<?php echo $filter['dt']; ?>" placeholder="yyyy-mm-dd"
										   autocomplete="off"/>
									<button type="submit" class="sButton"></button>
									<input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
									<input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
								</form>
							</td>
						</tr>
						<?php }else{?>
							<tr>
								<td colspan="6" align="center">
									<div class="nojob"><span>Không có dữ liệu thống kê!</span></div>
								</td>
							</tr>
						<?php }?>

					</table>
					
				</div>
				<?php }else{?>
					<div class="noshop">
						Bạn chưa cài đặt Gian hàng, vui lòng cài đặt <a href="<?php echo base_url(); ?>account/shop">tại đây</a> để sử dụng tính năng này
					</div>
				<?php }?>
				<div class="pagination">
                    <?php echo $pager; ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
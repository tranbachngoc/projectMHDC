<?php $this->load->view('home/common/header'); ?>
<div class="container-fluid">
    <div class="row">

	<?php $this->load->view('home/common/left'); ?>

        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header" style="margin-top: 10px;"> THÊM GIAN HÀNG VÀO D2</h4>
	    <?php if ($updatesuccess == 1) { ?> 
			<div class="alert alert-success alert-dismissible fade in" role="alert"> 
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span></button> 
				<h4>Bạn đã cập nhật gian hàng vào D2 thành công.</h4> 
				<p>
					<a class="btn btn-default" href="/account/flatformd2/joinshop/">
						<i class="fa fa-arrow-left fa-fw"></i> Về danh sách</a>
					<a class="btn btn-azibai" title=" Xem gian hàng " target="_blank"
					   href="//<?php echo $shop->fl_link .'.'. domain_site ?>/flatform/news">
						<i class="fa fa-eye fa-fw"></i> Xem gian hàng
					</a>
				</p>				
			</div>    	    
	    <?php } else { ?> 	    
    	    <form method="post">

    		<div class="row">
			<?php
			foreach ($listshopchild as $key => $value) {
			    if ($key > 0 && $key % 2 == 0)
				echo '</div><div class="row">';
			    ?>
			    <div class="col-xs-6" style="margin-bottom: 20px;">
				<div class="checkbox">
				    <label>
					<input type="checkbox" name="check[]" <?php echo (in_array($value->sho_user, $check)) ? 'checked' : '' ?> value="<?php echo $value->sho_user ?>">
					<strong>Gian hàng:</strong> <?php echo $value->sho_name ?>
				    </label>
				</div>
				<div style=" margin-left: 20px;">
				    <strong>Liên kết:</strong> 
				    <a href="<?php echo $value->domain ? 'http://' . $value->domain : '//' . $value->sho_link . '.' . domain_site ?>" target="_blank"><?php echo $value->domain ? $value->domain : $value->sho_link . '.' . domain_site ?></a>
				</div>				
			    </div>			
			<?php } ?>	
    		</div>
		<br>
    		<div class="form-group">
    		    <button type="submit" class="btn btn-azibai">Thêm gian hàng</button>
    		    <input type="hidden" name="update" value="1">
    		</div>
    	    </form>
	    <?php } ?>
	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
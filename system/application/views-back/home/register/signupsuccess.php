<?php $this->load->view('home/common/header_new'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css"
      media='screen'/>
<script src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>
<div>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
	    <br>	    
	    <?php if ($signupsuccess == true) { ?>
	    <div class="panel panel-default">
    		<div class="panel-body">
    		    <br>
    		    <div class="tile_Register"><h4><span>Chúc mừng thành viên mới!!</span></h4></div>
    		    <div class="wrap_regis">
    			<div class="form-group text-center">
    			    <p>Chào <span><?php echo $fullname; ?></span>,</p>
    			    <p>Tài khoản của bạn đã sẵn sàng, bạn có thể sử dụng ngày bây giờ.</p>
                    <p><small>Để sử dụng các tính năng gian hàng trên Azibai, bạn nên cập nhật đầy đủ thông tin các thông tin ở bước sau.</small></p>
    			</div>
    			<div class="form-group">			
    			    <div class="row">								 
    				<div class="col-xs-12 text-right">
    				    <div style="height: 8px"></div>
    				    <a href="<?php echo base_url() .'account/shop'; ?>" class="btn btn-azibai" style="background-color:#008C8C" ><i class="fa fa-arrow-right fa-fw"></i> Tiếp theo</a>
    				</div>    
    			    </div>
    			</div>

    		    </div>
    		</div>
    	    </div>
	    <?php } ?>     	    
        </div>
    </div>
</div>

<?php $this->load->view('home/common/footer_new'); ?>
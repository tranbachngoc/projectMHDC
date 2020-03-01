<?php $this->load->view('flatform/common/header_shop'); ?>

<div class="container" role="main">
    <br>
    <ol class="breadcrumb">
        <li><a href="#">Trang chủ</a></li>
        <li class="active">Liên hệ</li>
    </ol>
    
    <!--div class="row text-center">
	<div class="col-sm-12">
	    <h2><?php echo $shop->fl_name ?></h2>
	    <p><?php echo $shop->fl_desc ?></p>
	    <br>
	</div>
	<div class="col-sm-4 col-xs-12">
	    <p><span class="iconcontact"><i class="fa fa-map-marker fa-fw"></i></span></p>
	    <p><?php echo $address ?></p>
	</div>
	<div class="col-sm-4 col-xs-12">
	    <p><span class="iconcontact"><i class="fa fa-phone fa-fw"></i></span></p>
	    <p><?php echo $shop->fl_mobile . ' - ' . $shop->fl_hotline ?></p>
	</div>
	<div class="col-sm-4 col-xs-12">
	    <p><span class="iconcontact"><i class="fa fa-envelope-o fa-fw"></i></span></p>
	    <p><?php echo $shop->fl_email ?></p>
	</div>
    </div> 
    <hr-->
    <?php if ($successContact == 1) { ?>
        <div class="alert alert-success" role="alert">
            <strong>Rất tốt!</strong> Bạn đã gửi liên hệ thành công. Chúng tôi sẽ liên hệ lại với bạn theo thông tin mà bạn đã cung cấp. Cảm ơn bạn!
        </div>
    <?php } else { ?> 

         
        <div class="row">       

            <div class="col-sm-6 col-xs-12">
		<h2>Gửi thư liên hệ</h2>
                <form class="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php echo form_error('contact_fullname'); ?>
                        <input name="contact_fullname" type="text" class="form-control" id="contact_fullname" placeholder="Họ và Tên" value="<?php echo $contact_fullname ?>">
                    </div>
                    <div class="form-group">
                        <?php echo form_error('contact_email'); ?>
                        <input name="contact_email" type="email" class="form-control" id="contact_email" placeholder="Email" value="<?php echo $contact_email ?>">
                    </div>
                    <div class="form-group">
                        <?php echo form_error('contact_phone'); ?>
                        <input name="contact_phone" type="text" class="form-control" id="contact_phone" placeholder="Số điện thoại" value="<?php echo $contact_phone ?>">
                    </div>
                    <div class="form-group">
                        <?php echo form_error('contact_address'); ?>
                        <input name="contact_address" type="text" class="form-control" id="contact_address" placeholder="Địa chỉ" value="<?php echo $contact_address ?>">
                    </div>
                    <div class="form-group">
                        <?php echo form_error('contact_subject'); ?>
                        <input name="contact_subject" type="text" class="form-control" id="contact_subject" placeholder="Vấn đề liên hệ" value="<?php echo $contact_subject ?>">
                    </div>
                    <div class="form-group">
                        <?php echo form_error('contact_content'); ?>
                        <textarea name="contact_content"  class="form-control" id="contact_content" placeholder="Nhập nội dung cần liên hệ" rows="8"><?php echo $contact_content ?></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Gửi email</button>
                        <button type="reset" class="btn btn-default">Nhập lại</button>
                        <input name="contact_submit" type="hidden" value="1">
                    </div>
                </form>

            </div>
            <div class="col-sm-6 col-xs-12">
		<h2>Xem địa điểm</h2>
		<?php echo $headerjs.$headermap.$onload.$map; ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php $this->load->view('flatform/common/footer'); ?>
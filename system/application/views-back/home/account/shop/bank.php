<?php $this->load->view('home/common/account/header'); ?>
<?php $group_id = (int) $this->session->userdata('sessionGroup'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Thông tin tài khoản ngân hàng</h4>
	    <div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
			  
			    <?php if ($successEditBank == false) { ?>
    			    <form name="frmBank" method="post" class="form">
    				<div class="form-group">

    				    <div class="input-group">
    					<span class="input-group-addon" id="basic-addon1"><i class="fa fa-university fa-fw"></i></span>

    					<input type="text" value="<?php
					    if (isset($user->bank_name)) {
						echo $user->bank_name;
					    }
					    ?>" name="namebank_regis" id="namebank_regis" placeholder="Tên ngân hàng"
    					       class="form-control" <?php
						   if (!empty($user->bank_name) || $checked == false) {
						       echo "readonly";
						   }
						   ?> />
    				    </div>
    				</div>
    				<div class="form-group">
    				    <div class="input-group">
    					<span class="input-group-addon" id="basic-addon2"><i class="fa fa-map-marker fa-fw"></i></span>

    					<input type="text" value="<?php
					    if (isset($user->bank_add)) {
						echo $user->bank_add;
					    }
					    ?>" name="addbank_regis" id="addbank_regis" placeholder="Thuộc chi nhánh nào?"
    					       class="form-control" <?php
						   if (!empty($user->bank_add) || $checked == false) {
						       echo "readonly";
						   }
						   ?>/>
    				    </div>
    				</div>
    				<div class="form-group">
    				    <div class="input-group">
    					<span class="input-group-addon" id="basic-addon3"><i class="fa fa-user fa-fw"></i></span>


    					<input type="text" value="<?php
					    if (isset($user->account_name)) {
						echo $user->account_name;
					    }
					    ?>" name="accountname_regis" id="accountname_regis"
    					       placeholder="Họ và tên chủ tài khoản"
    					       class="form-control" <?php
						   if (!empty($user->account_name) || $checked == false) {
						       echo "readonly";
						   }
						   ?>/>
    				    </div>
    				</div>
    				<div class="form-group">
    				    <div class="input-group">
    					<span class="input-group-addon" id="basic-addon2"><i class="fa fa-hashtag fa-fw"></i></span>

    					<input type="text"
    					       value="<?php
						   if (isset($user->num_account) && $user->num_account > 0) {
						       echo $user->num_account;
						   }
						   ?>" name="accountnum_regis" id="accountnum_regis"
    					       placeholder="Số tài khoản"
    					       class="form-control" <?php
						   if (!empty($user->num_account) || $checked == false) {
						       echo "readonly";
						   }
						   ?>/>
    				    </div>
    				</div>
				    <?php if (empty($user->num_account)) { ?>
					<div class="form-group">
					    <button id="btn_bank" class="btn btn-primary">Cập nhật</button>
					    <button class="btn btn-danger">Hủy</button>
					</div>
				    <?php } else { ?>
					<div class="clearfix"></div>
					<div class="form-group">Để thay đổi thông tin tài khoản Ngân Hàng, vui lòng 
					    liên hệ với azibai để được hỗ trợ.
					    Điện thoại: <a href="tel:<?php echo settingPhone ?>"><strong><?php echo settingPhone ?></strong></a>  - Hotline: <a href="tel:<?php echo settingMobile ?>"><strong><?php echo settingMobile ?></strong></a>
					</div>
				    <?php } ?>
    				<div class="clearfix"></div>
    			    </form>
			    <?php } else { ?>
    			    <div class="text-center">
    				<p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để
    					tiếp tục</a></p>
    				Cập nhật thông tin tài khoản ngân hàng thành công!
    			    </div>
			    <?php } ?>
			</div>
	    </div>
	</div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
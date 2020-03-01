<?php $this->load->view('home/common/account/header'); ?>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <br>
	    <?php if ($successRegister == false) { ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php echo base_url() . 'register/affiliate/user/' . $uid ?>" name="frmVeryfy" id="frmVeryfy" method="post" style="margin-bottom:0">   		
                            <br>
                            <div class="tile_Register">
                                <h4><span>Đăng ký tài khoản Affiliate</span></h4>
                            </div>
                            <div class="wrap_regis">
                                <?php if ($this->session->flashdata('_sessionErrorLogin')) { ?>
                                <div class="message success">
                                    <div class="alert alert-danger">
                                        <small><?php echo $this->session->flashdata('_sessionErrorLogin'); ?></small>
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                    </div>
                                </div>
                                <?php } ?>
                                <div id="box_regis_1" style="padding: 20px;"> 
                                    <br>                                
                                    <input type="tel" name="phone_num" id="phone_num" placeholder="Số điện thoại" class="input_form_custom form-control" onblur="checkMobile(this.value, '<?php echo base_url(); ?>', 'phone_num')" autocomplete="off" required>  
                                    <br>
                                    <div class="text-center">
                                        <small> Bằng cách bấm vào nút đăng ký, bạn đã đồng ý với các <a href="<?php echo base_url() . 'content/29'; ?>" target="_blank" style="color: #4471ff">Điều khoản và Điều kiện</a> của Azibai </small>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <input type="submit" value="Nhận mã kích hoạt" class="btn btn-azibai btn-block" autofocus="">
                                    </div>
                                    <br>
                                </div>
                            </div>
                            
                        </form>                    
                    </div>
                </div>
            <?php } else { ?> 
                <div class="row wrap_regis">
                    <p>Chúc mừng bạn đã đăng ký thành công</p>
                </div>
	    <?php } ?>
            <br>
        </div>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>

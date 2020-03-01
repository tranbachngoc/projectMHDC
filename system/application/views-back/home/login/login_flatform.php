<?php $this->load->view('home/common/header'); ?>
<?php
if ($_SERVER['HTTP_REFERER'] != base_url() . "login") {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}
?>
<script>
    function submitSearchTintuc() {
	var keyword = document.getElementById('keyword').value;
	var url = '<?php echo base_url(); ?>tintuc/search/keyword/' + keyword;
	window.location = url;
	return true;
    }
    function submitenterQ(myfield, e, baseUrl) {
	var keycode;
	if (window.event)
	    keycode = window.event.keyCode;
	else if (e)
	    keycode = e.which;
	else
	    return true;

	if (keycode == 13) {
	    submitSearchTintuc();
	    return false;
	} else
	    return true;
    }
    function submitenter(myfield, e)
    {
	var keycode;
	if (window.event)
	    keycode = window.event.keyCode;
	else if (e)
	    keycode = e.which;
	else
	    return true;
	if (keycode == 13)
	{
	    myfield.form.submit();
	    return false;
	} else
	    return true;
    }
</script>


<div id="main" class="container-fluid">
    <div class="row">
	<div class="col-xs-12 col-sm-4 col-sm-offset-4">
	    <br>
	    <?php if (isset($successLogin) && $successLogin == false) { ?>
		<?php if (isset($validLogin) && $validLogin == true) { ?>
		<?php } else { ?>
		    <?php
		    if (isset($errorLogin) && $errorLogin == true) {
			echo $this->lang->line('error_message_defaults');
		    }
		    ?>
		    <div class="panel panel-default">
			<div class="panel-body">		    
			    <form name="frmLoginPage" method="post" id="frmLoginPage" class="" role="form" style="margin-bottom:0">
				<div class="text-center" style="margin: 25px auto">
				    <img src="<?php echo site_url('images/icon-youraccount.png') ?>" style="width:100px;height:100px;"/>
				</div>
				
				<?php if ($this->session->flashdata('_sessionErrorLogin')){ ?>
	                <div class="message success">
	                    <div class="alert alert-danger">
	                        <?php echo $this->session->flashdata('_sessionErrorLogin'); ?>
	                        <button type="button" class="close" data-dismiss="alert">×</button>
	                    </div>
	                </div>
	            <?php } ?>	

				<div class="form-group">
				    <input placeholder="<?php //echo $this->lang->line('username_defaults'); ?> Tên đăng nhập / Email / Điện thoại" type="text" onKeyPress="return submitenter(this, event)" name="UsernameLogin" id="UsernameLogin" maxlength="35" class="input_form_custom form-control" onkeyup="BlockChar(this, 'AllSpecialChar')" onblur="lowerCase(this.value, 'UsernameLogin');" />
				</div>
				<div class="form-group">
				    <input placeholder="<?php echo $this->lang->line('password_defaults'); ?>" type="password" onKeyPress="return submitenter(this, event)" name="PasswordLogin" id="PasswordLogin" maxlength="35" class="input_form_custom form-control" />
				</div>
				<div class="error" style="color:red;">
				    <?php
				    if ($this->session->flashdata('_sessionErrorLogin')) {
					echo $this->session->flashdata('_sessionErrorLogin');
				    }
				    ?>                                                                
				</div>
				<br>
				<div class="form-group">
				    <div class="row">
					<div class="col-xs-7">
					    <a class="small forgot_password" href="<?php echo base_url(); ?>forgot">Bạn quên mật khẩu?</a>
					    <br>
					    <a class="small register_account" href="<?php echo base_url(); ?>register/account"> Đăng ký tài khoản</a>
					</div>    
					<div class="col-xs-5 text-right">
					    <div style="height: 8px"></div>
					    <input type="button" onclick="CheckInput_Login_Page();" name="submit_login" value="<?php echo $this->lang->line('button_login_defaults'); ?>" class="btn btn-azibai" autofocus />
					</div>    
				    </div> 
				</div> 
				<div class="form-group hidden">			    
				    <div style="border-top: 1px solid#888; padding-top:15px; font-size:95%" >
					<p>Nếu bạn chưa có tài khoản trên <a href="http://www.azibai.com"><strong>www.azibai.com</strong></a>, bạn có thể <a href="<?php echo base_url(); ?>register"><strong>đăng ký miễn phí</strong></a> một tài khoản cho mình. Nếu bạn không thể đăng nhập vào <a href="http://www.azibai.com"><strong>www.azibai.com</strong></a> vì lí do quên mật khẩu, bạn có thể sử dụng chức năng <a href="<?php echo base_url(); ?>forgot"><strong>lấy lại mật khẩu</strong></a> tự động của <a href="http://www.azibai.com"><strong>www.azibai.com</strong></a> hoặc bạn vui lòng liên hệ với chúng tôi để được hỗ trợ.</p>
				    </div>
				</div>
			    </form> 
			</div>
		    </div>
				    
		<?php } ?>
	    <?php } else { ?>
		<p class="text-center"><a href="<?php echo $prevurl; ?>">Click vào đây để tiếp tục</a></p>
		<ul class="huongdanlogin">
			<?php
			$contentFooter = Counter_model::getArticle(thongbao_login);
			echo html_entity_decode($contentFooter->not_detail);
			?>
		    <li>
			<font color="#FF0000"><b> Nếu không hệ thống sẽ đưa bạn về trang trước trong 3 giây </b></font>
		    </li>
		</ul>
	    <?php } ?>
	</div>
    </div>				
</div> 
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($siteGlobal) && $siteGlobal->sho_style !='style3'){ ?>
<!--BEGIN: Right-->
<?php $yahoos = $siteGlobal->sho_yahoo;
	  $skypes = $siteGlobal->sho_skype;
	  $ayahoo = explode(",",$yahoos);
	  $askype = explode(",",$skypes);
?>

<?php if($ayahoo[0]!="" || $askype[0]!="" ) : ?>
<div class="module">
	<h4 class="module-title">Hỗ trợ trực tuyến</h4>
	<div class="module-content">
		<?php foreach($ayahoo as $item) {?>
		<?php
		//set konfigurasi awal
		//$id = "tiennhamhong"; //Ubah sesuai Yahoo ID anda
		$online = $URLRoot."templates/shop/default/images/online.png"; 
		$offline = $URLRoot."templates/shop/default/images/offline.png";
			if(!empty($item)) {
				$buka = fopen("http://opi.yahoo.com/online?u=" . $item . "&m=t", "r") or die ("<img src='http://opi.yahoo.com/online?u=" . $item . "&m=g&t=2'/>");
				while ($baca = fread($buka, 2048)) {
					$status .= $baca;
				}
				fclose($buka);
			}
		?>
		<!-- <div class="normal" style="padding: 5px;"> <a rel="nofollow" href="ymsgr:SendIM?<?php echo $item?>">
			<?php if($status == $item." is ONLINE"){ ?>
			<span class="k_onlinesupporticon"><img style="margin-right:5px;" src="<?php echo $online;?>"></span><span class="k_onlinesupport">Hỗ trợ kinh doanh</span>
			<?php } else {?>
			<span class="k_onlinesupporticon"><img style="margin-right:5px;" src="<?php echo $offline;?>"></span><span class="k_onlinesupport">Hỗ trợ kinh doanh</span>
			<?php }?>
			</a> </div>
		<div style="clear:both"></div> -->
		<?php }?>
		<?php foreach($askype as $item) { ?>
			<div class="normal" style="padding: 5px;"> <a rel="nofollow" href="skype:<?php echo $item?>?chat"> <span class="k_onlinesupporticon"><img style="margin-right:5px;" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/skype.png"></span><span class="k_onlinesupport">Hỗ trợ kinh doanh</span> </a> </div>
		<?php }?>
		<?php ?>
	</div>
</div>
<?php endif;?>


<?php if(isset($module) && $module == 'top_lastest_ads'){ ?>
	<?php $this->load->view('shop/raovat/top_lastest'); ?>
<?php } ?>

<?php if(isset($module) && $module == 'top_lastest_product'){ ?>
	<?php $this->load->view('shop/product/top_lastest'); ?>
<?php } ?>

<?php if(isset($bannerrights) && count($bannerrights) >0) { ?>
<div class="module">
	<h4 class="module-title"><?php echo $this->lang->line('title_advertise_right_detail_global'); ?></h4>
	<div class="module-content">
            <div class="right_banner">
                <?php foreach($bannerrights as $item){?>
                    <?php if($item->banner_type == 1){?>
                    <div style="text-align:center"> <a target="<?php echo $item->target;?>" href="http://<?php echo $item->link;?>" alt="<?php echo $item->banner_name;?>"> <img width="190" src="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>"/> </a> </div>
                    <?php }elseif($item->banner_type == 2){
                        $height = (190/$item->banner_width)*$item->banner_height;
                    ?>
                    <div style="text-align:center">
                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:190px; height:<?php echo $height;?>px;" id="FlashID_Banner">
                            <param name="movie" value="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" />
                            <param name="quality" value="high" />
                            <param name="wmode" value="opaque" />
                            <param name="swfversion" value="6.0.65.0" />
                            <param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
                            <!--[if !IE]>-->
                            <object type="application/x-shockwave-flash" style="width:190px; height:<?php echo $height;?>px;" data="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" class="banner_flash">
                                    <!--<![endif]-->
                                    <param name="quality" value="high" />
                                    <param name="wmode" value="opaque" />
                                    <param name="swfversion" value="6.0.65.0" />
                                    <param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
                                    <div>
                                            <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                                            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                                    </div>
                                    <!--[if !IE]>-->
                            </object>
                            <!--<![endif]-->
                        </object>
                    <!--	<script type="text/javascript"> swfobject.registerObject("FlashID_Banner");</script> -->
                    </div>
                    <?php }else{?>
                    <div style="width:190px; margin-left:5px;"> <a target="<?php echo $item->target;?>" href="<?php echo $item->link;?>"> <?php echo htmlspecialchars_decode(html_entity_decode($item->content));?> </a> </div>
                    <?php } ?>
                <?php } ?>
            </div>
	</div>
</div>
<?php } ?>
<?php if($this->session->userdata('sessionUser')==0): ?>

        <div class="module">
            <h4 class="module-title"><i class="fa fa-user  fa-fw" aria-hidden="true"></i> Đăng nhập</h4>
            <div class="module-content">
                <form id="frmLoginPage" class="login-gianhang form" name="frmLoginPage" action="/login" method="post" onsubmit="checkForm(this.name, arrCtrlLogin); return false;">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" title="Tên đăng nhập..." class="form-control" placeholder="Tên đăng nhập..." name="UsernameLogin" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" title="Mật khẩu" placeholder="Mật khẩu..." class="form-control" name="PasswordLogin" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="checkbox" id="remember_password" name="remember_password" value="1">
                            <label for="remember_password">Ghi nhớ đăng nhập</label>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block style_<?php echo $siteGlobal->sho_style ?>" value="Đăng nhập">
                        </div>
                    </div>

                    <div class="lost_password"><a class="text_link" href="<?php echo $mainURL; ?>forgot" rel="nofollow">Bạn quên mật khẩu?</a></div>
                    <input type="hidden" name="user_login" value="login">
                </form>
            </div>

        </div>
<?php else : ?>
        <div class="module">
            <h4 class="module-title"><i class="fa fa-user fa-fw" aria-hidden="true"></i> Đăng xuất</h4>
            <div class="module-content">
                <div class="content_login">
                    <p> Chào, <?php echo $this->session->userdata('sessionUsername'); ?></p>
                    <div> <a class="btn btn-primary style_<?php echo $siteGlobal->sho_style ?>" href="<?php echo getAliasDomain('logout'); ?>">Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php endif;?>
<!--END Right-->
<?php } ?>

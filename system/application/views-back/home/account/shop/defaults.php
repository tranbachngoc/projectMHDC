<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/modcoder_excolor/jquery.modcoder.excolor.js"></script>
        <SCRIPT TYPE="text/javascript">
            function submitenter(myfield, e) {
                var keycode;
                if (window.event) keycode = window.event.keyCode;
                else if (e) keycode = e.which;
                else return true;
                if (keycode == 13) {
                    CheckInput_EditShop();
                    return false;
                }
                else
                    return true;
            }
            $(function () {
                $("#link_shop").blur(function() {
                    if($(this).val().length < 5) {
                        $.jAlert({
                            'title': 'Yêu cầu nhập',
                            'content': 'Bạn nhập tối thiểu 5 ký tự!',
                            'theme': 'default',
                            'btns': {
                                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                    e.preventDefault();
                                    document.getElementById("link_shop").focus();
                                    return false;
                                }
                            }
                        });
                    }
                });
            })
        </SCRIPT>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">   
            <?php if ((int)$this->session->userdata('sessionGroup') == 2){
                $req =  ''; 
            } else {
                $req =  '<b>*</b>';
            }
            $protocol = 'http://';//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $duoi = '.'. $_SERVER['HTTP_HOST'] .'/';
            $Shoplink = $link_shop . $duoi .'shop';
            if($domain_shop != ''){
                $Shoplink = $domain_shop .'/shop';
            } ?>
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php if ((int)$this->session->userdata('sessionGroup') < 2) { ?>
                    Nâng cấp lên gian hàng
                <?php } else { ?>
                    <?php echo $this->lang->line('title_shop_account'); ?>
                <?php } ?>
            </h4>
            <?php
            if ($shopactive && $shopactive == 1) {
                ?>
                <div class="message success">
                    <div class="alert" style="background-color: #fbf69b; border-color: #fbf69b;">
                        Gian hàng của bạn hiện không hoạt động. Mọi thắc mắc liên hệ hotline để được hỗ trợ!
                    </div>
                </div>
                <?php
            } else {
                if ($flash_message) {
                ?>
                <div class="message success">
                    <div class="alert alert-success">
                        <?php echo $flash_message; ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
                <?php
            }
            ?>
            <form name="frmEditShop" id="frmEditShop" method="post" enctype="multipart/form-data" class="form-horizontal">
                <?php if ($successEditShopAccount == false) { ?>                    
                    <?php if ((int)$this->session->userdata('sessionGroup') >= 2) { ?>
                        <!-- <?php if ((int)$this->session->userdata('sessionGroup') == 3) { ?>
                            <div style="width:100%; margin: 15px auto; text-align: center" class="alert alert-success" role="alert">Bạn được tạo 1 tài khoản Cộng tác viên miễn phí. <a class="text-success" href="<?php echo base_url() .'logout?storeid='. (int)$this->session->userdata('sessionUser');?>">Click vào đây!</a>
                            </div>
                        <?php } ?> -->
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label">
                                <span>Link xem cửa hàng</span>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <a style="color:#F00; text-decoration:underline;" target="_blank" href="<?php echo $protocol . $Shoplink; ?>"> <?php echo $Shoplink; ?></a>
                            </div>                            
                        </div>
                    <?php } ?>
                    <?php if ($sho_status == 0) { ?>
                        <?php if ((int)$this->session->userdata('sessionGroup') >= 2) { ?>
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span style="color:#004B7A; line-height:170%; font-weight:bold;">
                                    <?php $contentFooter = Counter_model::getArticle(32);
                                    echo html_entity_decode($contentFooter->not_detail); ?>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
			    <font color="#FF0000"><?php echo $req; ?></font> Danh mục ngành
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <select name="hd_category_id" id="hd_category_id" class="form-control">
                                <option value="">--Chọn danh mục nghề nghiệp--</option>
                                <?php foreach ($category as $cat_item) { ?>
                                    <?php if ($category_shop == $cat_item->cat_id) { ?>
                                        <option value="<?php echo $cat_item->cat_id; ?>" selected="selected"><?php echo $cat_item->cat_name; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $cat_item->cat_id; ?>"><?php echo $cat_item->cat_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <!--<div id="hoidap_0">
		<select id="hd_select_0" class="form_control_hoidap_select form-control2" onclick="check_edit_gian_hang_cate(this.value,0,'<?php /*echo base_url(); */ ?>');">
			<option value=""> --Chọn danh mục nghề nghiệp-- </option>
			<?php
                            /*		if(isset($catlevel0)){
                                    foreach($catlevel0 as $item){
                                    */ ?>
		<?php /*if($cat_getcategory0!="") { */ ?>
		<?php /*if($category_pro == $item->cat_id){ */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" selected="selected" ><?php /*echo $item->cat_name; */ ?></option>
		<?php /*if($item->child_count >0){echo ' >';}*/ ?>
		<?php /*}else { */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" ><?php /*echo $item->cat_name; */ ?></option >
		<?php
                            /*		}*/ ?>
		<?php /*} else { */ ?>
		<?php /*if( $cat_parent_parent_0 -> parent_id == $item->cat_id){ */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" selected="selected" ><?php /*echo $item->cat_name; */ ?></option>
		<?php /*}  else { */ ?>
		<option value="<?php /*echo $item->cat_id;*/ ?>"><?php /*echo $item->cat_name;*/ ?>
		<?php /*if($item->child_count >0){echo ' >';}*/ ?>
		</option>
		<?php /*}}}}*/ ?>
		</select>
		</div>
		<div id="hoidap_1">
		<?php /*if(isset($cat_level_1)){ */ ?>
		<select name="category_pro" id="category_proaa" class="selectcategory_formpost_edit form-control"  onclick="check_edit_gian_hang_cate(this.value,1,'<?php /*echo base_url(); */ ?>');" >
		<?php
                            /*		foreach($cat_level_1 as $item){
                                    */ ?>
		<?php /*if( $cat_parent_parent -> parent_id == $item->cat_id){ */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" selected="selected" ><?php /*echo $item->cat_name; */ ?></option

		>
		<?php /*} else { if(isset($category_pro) && $category_pro == $item->cat_id) { */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" selected="selected" ><?php /*echo $item->cat_name; */ ?></option>
		<?php /*} else { */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" ><?php /*echo $item->cat_name; */ ?></option>

		<?php /*} } } */ ?>
		</select>
		<?php /*}*/ ?>
		</div>
		<div id="hoidap_2">
		<?php /*if(isset($cat_level_2)){ */ ?>
		<select name="category_pro" id="category_pro_edit" class="selectcategory_formpost_edit form-control" onblur="getManAndCategory4Search_edit('<?php /*echo base_url(); */ ?>');" onclick="check_edit_gian_hang_cate(this.value,2,'<?php /*echo base_url(); */ ?>');" >
		<?php
                            /*		foreach($cat_level_2 as $item){
                                    */ ?>
		<?php /*if(isset($category_pro) && $category_pro == $item->cat_id){ */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" selected="selected"><?php /*echo $item->cat_name; */ ?></option>
		<?php /*} else { */ ?>
		<option value="<?php /*echo $item->cat_id; */ ?>" ><?php /*echo $item->cat_name; */ ?></option>
		<?php /*} } */ ?>
		</select>
		<?php /*}*/ ?>
		</div>
		<input type="hidden" id="hd_category_id" name="hd_category_id" value="<?php /*echo $category_pro ; */ ?>"/>-->
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <?php echo form_error('category_pro'); ?>
                        </div>
                    </div>

                    <?php if ((int)$this->session->userdata('sessionGroup') >= 2) { ?>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font color="#FF0000"><?php echo $req; ?>
                                </font><?php echo $this->lang->line('logo_shop_account'); ?>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div style=" display:<?php if ($logo_shop == 'default-logo.png' || $logo_shop == ''){ echo "block";} else { echo "none";} ?>; padding-top:10px;" id="vavatar_input1">
                                    <div class="col-lg-12">
                                        <!--                                                    <span class="btn btn-primary btn-file">-->
                                        <!--                                                       Chọn File <i class="fa fa-upload" aria-hidden="true"></i>-->
                                        <input type="file" name="logo_shop" id="logo_shop"
                                            class="inputimage_formpost" style="float: left"/>
                                        <!--                                                    </span>-->
                                        <input class="btn btn-danger" type="button" onclick="resetBrowesIimgQ_shop('logo_shop');" value="Hủy" style="padding: 0px 12px; "/>

                                    </div>
                                    <p style="padding-left:12px;">
                                        <span class="text-warning"><i class="fa fa-info-circle"></i> Dung lượng logo <= 500KB, chiều rộng 120px, chiều cao 120px
                                        </span>
                                    </p>
                                    <input type="hidden" name="logo_shop_hiden" id="logo_shop_hiden" value="<?php echo $logo_shop; ?>"/>
                                </div>

                                <div style=" display:<?php if ($logo_shop == 'default-logo.png' || $logo_shop == '') { echo "none";} else { echo "block"; } ?>" id="img_vavatar_input1">
                                    <div style="float:left;">
                                        <img src="<?php echo DOMAIN_CLOUDSERVER; ?>media/shop/logos/<?php if (isset($dir_logo_shop)) { echo $dir_logo_shop; } ?>/<?php if (isset($logo_shop)) { echo $logo_shop; } ?>" border="0" height="50" style="margin-top:3px;"/>
                                    </div>
                                    <div style="float:left;" class="xoa_hinh_nay">
                                        <img style="margin-top:7px;" src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này " onclick=" return delete_img_ajax_and_shop('<?php echo base_url(); ?>account/shop/','<?php echo $shop_id_q; ?>','sho_id','sho_logo','tbtt_shop','sho_dir_logo','1','<?php echo $logo_shop; ?>','<?php echo $dir_banner_shop; ?>');"/>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><span style="color: #FF0000; "><?php echo $req; ?>
                                </span><?php echo $this->lang->line('banner_shop_account'); ?>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div style="display:<?php if ($banner_shop == 'default-banner.jpg' || $banner_shop == '' ) { echo "block";
                                } else { echo "none"; } ?>; padding-top:10px;" id="vavatar_input2">
                                    <div class="col-lg-12">
                                        <input type="file" name="banner_shop" id="banner_shop"  class="inputimage_formpost" style="float: left"/>
                                        <input class="btn btn-danger" type="button" onclick="resetBrowesIimgQ_shop('banner_shop');" value="Hủy" style="padding: 0px 12px; "/>
                                    </div>
                                    <p style="padding-left:12px;">
                                        <span class="text-warning"><i class="fa fa-info-circle"></i>Dung lượng banner <= 1MB, chiều rộng lớn hơn 1000px, chiều cao lớn hơn 120px</span>
                                    </p>
                                    <input type="hidden" name="banner_shop_hiden" id="banner_shop_hiden"
                                           value="<?php echo $banner_shop; ?>"/>
                                </div>

                                <div style=" display:<?php if ($banner_shop == 'default-banner.jpg' || $banner_shop == '') { echo "none"; } else { echo "block"; } ?>; padding-top:10px;" id="img_vavatar_input2">
                                    <div style="float:left;">
                                        <?php if (isset($banner_shop)) { ?>
                                            <?php
                                            if (strtolower(substr($banner_shop, -4)) == '.swf') {
                                                $height = 200;
                                                ?>
                                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                                        style="width:400px; height:<?php echo $height ?>px;"
                                                        id="FlashID_Banner">
                                                    <param name="movie"
                                                           value="<?php echo DOMAIN_CLOUDSERVER(); ?>media/shop/banners/<?php echo $dir_banner_shop; ?>/<?php echo $banner_shop; ?>"/>
                                                    <param name="quality" value="high"/>
                                                    <param name="wmode" value="opaque"/>
                                                    <param name="swfversion" value="6.0.65.0"/>
                                                    <param name="expressinstall"
                                                           value="<?php echo base_url(); ?>templates/shop/style1/images/expressInstall.swf"/>
                                                    <!--[if !IE]>-->
                                                    <object type="application/x-shockwave-flash"
                                                            style="width:210px; height:<?php echo $height ?>px;"
                                                            data="<?php echo DOMAIN_CLOUDSERVER(); ?>media/shop/banners/<?php echo $dir_banner_shop; ?>/<?php echo $banner_shop; ?>"
                                                            class="banner_flash"><!--<![endif]-->
                                                        <param name="quality" value="high"/>
                                                        <param name="wmode" value="opaque"/>
                                                        <param name="swfversion" value="6.0.65.0"/>
                                                        <param name="expressinstall"
                                                               value="<?php echo base_url(); ?>templates/shop/style1/images/expressInstall.swf"/>
                                                        <div>
                                                            <h4>Content on this page requires a newer version of
                                                                Adobe Flash Player.</h4>

                                                            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/></a></p>
                                                        </div>
                                                        <!--[if !IE]>--></object>
                                                    <!--<![endif]-->
                                                </object>
                                                <!--<script type="text/javascript">swfobject.registerObject("FlashID_Banner"); </script>-->
                                            <?php } else { ?>
                                                <img
                                                    src="<?php echo DOMAIN_CLOUDSERVER; ?>media/shop/banners/<?php if (isset($dir_banner_shop)) {
                                                        echo $dir_banner_shop;
                                                    } ?>/<?php if (isset($banner_shop)) {
                                                        echo $banner_shop;
                                                    } ?>" border="0" width="300"/>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div style="float:left; " class="xoa_hinh_nay">
                                        <img style="margin-top:7px;" src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này " onclick=" return delete_img_ajax_and_shop('<?php echo base_url(); ?>account/shop/','<?php echo $shop_id_q; ?>','sho_id','sho_banner','tbtt_shop','sho_dir_banner','2','<?php echo $banner_shop; ?>','<?php echo $dir_banner_shop; ?>');"/>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                            </div>
                        </div>

                        <div class="row" style="display:none;">
                            <div class="col-md-3 col-sm-4 col-xs-12">Hình nền gian hàng</div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="col-lg-3">
                                    <input type="file" name="bgimg_shop" id="bgimg_shop" class="inputimage_formpost"/>
                                </div>
                                <div class="col-lg-3">
                                    <input class="btn btn-danger" type="button" onclick="resetBrowesIimgQ('bgimg_shop');" value="Hủy"/>
                                </div>
                                <div style=" display:<?php if ($bg_img_shop != 'defaults.png' && $bg_img_shop != '') {
                                    echo "none";
                                } else {
                                    echo "block";
                                } ?>; padding-top:10px;" id="vavatar_input3">
			                        <span class="div_helppost"><font style="color:#F00; font-weight:bold;"> Dung lượng hình nền <= 2MB
                                        </font></span> <br/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('bg_help_text_banner'); ?>',270,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost"/>
                                </div>
                                <div style=" display:<?php if ($bg_img_shop == 'defaults.png' || $bg_img_shop == '') { echo "none";} else {echo "block";} ?>; padding-top:10px;" id="img_vavatar_input3">
                                    <div style="float:left;">
                                        <img src="<?php echo base_url(); ?>media/shop/bgs/<?php if (isset($sho_dir_bging)) {
                                                echo $sho_dir_bging;
                                            } ?>/<?php if (isset($bg_img_shop)) {
                                                echo $bg_img_shop;
                                            } ?>" border="0" height="80" width="80" style="margin-top:3px;"/>
                                    </div>
                                    <div style="float:left; " class="xoa_hinh_nay">
                                        <img style="margin-top:7px;" src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này "
                                             onclick=" return delete_img_ajax_and_shop('<?php echo base_url(); ?>account/shop/','<?php echo $shop_id_q; ?>','sho_id','sho_bgimg','tbtt_shop','sho_dir_bging','3','<?php echo $bg_img_shop; ?>','<?php echo $sho_dir_bging; ?>');"/>
                                    </div>
                                </div>
                                <div style="clear:both; padding-top:10px;">
                                </div>
                                <input type="checkbox" onchange="setValChk('bg_repeat_x');"
                                       value="<?php if (isset($bg_repeat_x)) {
                                           echo $bg_repeat_x;
                                       } else {
                                           echo 0;
                                       } ?>" id="bg_repeat_x"
                                       name="bg_repeat_x" <?php if (isset($bg_repeat_x) && (int)$bg_repeat_x == 1) {
                                    echo 'checked="checked"';
                                } ?>/><span class="list_post">Lặp hình nền theo chiều rộng</span><br/>
                                <input type="checkbox" onchange="setValChk('bg_repeat_y');"
                                       value="<?php if (isset($bg_repeat_y)) {
                                           echo $bg_repeat_y;
                                       } else {
                                           echo 0;
                                       } ?>" id="bg_repeat_y"
                                       name="bg_repeat_y" <?php if (isset($bg_repeat_y) && (int)$bg_repeat_y == 1) {
                                    echo 'checked="checked"';
                                } ?>/><span class="list_post">Lặp hình nền theo chiều cao</span>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label">
                                <font color="#FF0000"><?php echo $req; ?></font> 
				<?php echo $this->lang->line('link_shop_account'); ?>
                            </div>
			    <div class="col-md-9 col-sm-8 col-xs-12">
				<div class="row">
				    <div class="col-md-4 col-sm-6 col-xs-5">
					 <input type="text" name="link_shop" id="link_shop" pattern=".{5,}" value="<?php
						   $email_user = explode('@', $link_shop);
						   if(isset($link_shop) && $email_user[1] == ''){ echo $link_shop; } ?>" maxlength="50" class="form-control text-right inputlinkshop_formpost"
						   onblur="check_link_shopq('<?php echo base_url(); ?>account/',this.value,'<?php echo $this->session->userdata('sessionUser') ?>');"/>
				    </div>
				    <div class="col-md-8 col-sm-6 col-xs-7">
					<span style="display: block; margin-top: 5px"><?php echo $duoi .'shop'; ?></span>
				    </div>
				    <div class="col-xs-12">
					    <p> <?php echo form_error('link_shop'); ?></p>
                        <p>
                            <span class="text-warning"><i class="fa fa-info-circle"></i>
                                    Đây là địa chỉ shop online của doanh nghiệp trên azibai.com. <br>Ví dụ: <strong>http://thoitrang.azibai.com/</strong>
                            </span>
                        </p>
				    </div>
			    
                        </div>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
			    <font color="#FF0000"><?php echo $req; ?></font> Tên gian hàng
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="name_shop" id="name_shop" value="<?php if (isset($name_shop)) { echo $name_shop;} ?>" maxlength="80" class="input_formpost  form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditShop','name_shop');"
                                   onfocus="ChangeStyle('name_shop',1)"
                                   onblur="ChangeStyle('name_shop',2)"/>
                            <?php echo form_error('name_shop'); ?>
                        </div>
                    </div>
                    <?php if ((int)$this->session->userdata('sessionGroup') >= 2) { ?>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                    color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('descr_shop_account'); ?>
                                
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <input type="text" name="descr_shop" id="descr_shop"
                                       value="<?php if (isset($descr_shop)) {
                                           echo $descr_shop;
                                       } ?>" maxlength="80" class="input_formpost  form-control"
                                       onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_shop',1)"
                                       onblur="ChangeStyle('descr_shop',2)"/>
                            
                                <?php echo form_error('descr_shop'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('address_shop_account'); ?>
                            gian hàng
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="address_shop" id="address_shop"
                                   value="<?php if (isset($address_shop)) {
                                       echo $address_shop;
                                   } ?>" maxlength="80" class="input_formpost  form-control"
                                   onfocus="ChangeStyle('address_shop',1)" onblur="ChangeStyle('address_shop',2)"/>
                        </div>
                        <div class="col-xs-12">
                            <?php echo form_error('address_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                color="#FF0000"><?php echo $req; ?></font> Tỉnh/TP gian hàng
                        </div>

                        <div class="col-md-3 col-sm-8 col-xs-12">
                            <select name="province_shop" id="province_shop"
                                    class="selectprovince_formpost form-control">
                                <option value="">Chọn Tỉnh/Thành</option>
                                <?php foreach ($province as $provinceArray) { ?>
                                    <?php if (isset($province_shop) && $province_shop == $provinceArray->pre_id) { ?>
                                        <option value="<?php echo $provinceArray->pre_id; ?>"
                                                selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                    <?php } else { ?>
                                        <option
                                            value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_shop'); ?>
                        </div>
		    </div>
                    <div class="form-group">
			<div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('district_account_label_edit_account'); ?>               
                        </div>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                            <select name="district_shop" id="district_shop"
                                    class="selectprovince_formpost form-control">
                                <option value="">Chọn Quận/Huyện</option>
                                <?php
                                if ($shop_district) {
                                    foreach ($shop_district as $vals):
                                        if ($vals->DistrictCode == $district_shop) {
                                            $district_selected = "selected='selected'";
                                        } else {
                                            $district_selected = '';
                                        }
                                        echo '<option value="' . $vals->DistrictCode . '" ' . $district_selected . '>' . $vals->DistrictName . '</option>';
                                    endforeach;
                                }
                                ?>
                            </select>
                        
                            <?php echo form_error('district_shop'); ?>
                        </div>
                    </div>
                    <?php if ((int)$this->session->userdata('sessionGroup') == 3 && $sho_package['id'] >= 3) { ?>
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-3 col-xs-12"><font color="#FF0000"><b></b></font>Azi-Branch - Mở chi nhánh trực tuyến:-->
<!--                            </div>-->
<!--                            <div class="col-sm-9 col-xs-12">-->
<!--                                <div class="more-provinces">-->
<!--                                    <select style="min-height: 180px;" multiple name="more_provinces[]"-->
<!--                                            id="more_provinces" class="form-control">-->
<!--                                        --><?php //foreach ($area as $key => $pro): ?>
<!--                                            --><?php //if ($key != $province_shop): ?>
<!--                                                <option --><?php //if (in_array($key, $more_provinces)) echo 'selected="selected"'; ?>
<!--                                                    value="--><?php //echo $key ?><!--">--><?php //echo $pro ?><!--</option>-->
<!--                                            --><?php //endif; ?>
<!--                                        --><?php //endforeach; ?>
<!--                                    </select>-->
<!---->
<!--                                    <p><a class="btn btn-default1" id="uncheck_provinces">Bỏ chọn</a><a class="btn btn-default1" id="allcheck_provinces">Chọn hết</a></p>-->
<!--                                    <p>Ghi chú: Giữ Ctrl + Click trái chuột để chọn nhiều tỉnh thành</p>-->
<!--                                    <script type="text/javascript">-->
<!--                                        jQuery('#uncheck_provinces').click(function () {-->
<!--                                            jQuery('select#more_provinces option').removeAttr("selected");-->
<!--                                        });-->
<!--                                        jQuery('#allcheck_provinces').click(function () {-->
<!--                                            jQuery('select#more_provinces option').attr("selected","selected");-->
<!--                                        });-->
<!--                                    </script>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-3 col-xs-12">-->
<!--                            </div>-->
<!--                        </div>-->
                    <?php } ?>
                    <?php if ((int)$this->session->userdata('sessionGroup') != 2) { ?>
                        <!---dia chi kho hang-->
                        <div class="form-group">
			    <div class="col-md-3 col-sm-4 col-xs-12 control-label"></div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div class="form_text">
                                    <div class="text-success">
                                        <input type="checkbox" value="1" name="check_kho" id="check_kho" <?php echo $khaibaoKho?>>
                                        <label for="check_kho">Đánh dấu nhanh nếu địa chỉ công ty trùng địa chỉ kho</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                    color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('address_shop_account'); ?>
                                Kho
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <input required="required" type="text" name="address_kho_shop" id="address_kho_shop"
                                       value="<?php echo ($address_kho_shop) ? $address_kho_shop : '' ?>" maxlength="80"
                                       class="input_formpost  form-control" <?php echo $khaibaoKho?>/>
                            
                                <?php echo form_error('address_kho_shop'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                    color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('province_shop_account'); ?>
                                Kho
                            </div>
                            <div class="col-md-3 col-sm-8 col-xs-12">
                                <select name="province_kho_shop" id="province_kho_shop"
                                        class="selectprovince_formpost form-control" <?php echo $khaibaoKho?>>
                                    <option value="">Chọn Tỉnh/Thành Kho</option>
                                    <?php foreach ($province as $provinceArray) { ?>
                                        <?php if (isset($province_kho_shop) && $province_kho_shop == $provinceArray->pre_id) { ?>
                                            <option value="<?php echo $provinceArray->pre_id; ?>"
                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } else { ?>
                                            <option
                                                value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('province_shop'); ?>
                            </div>
                            </div>
			    <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font
                                    color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('district_account_label_edit_account'); ?>
                                Kho
                            </div>
                            <div class="col-md-3 col-sm-8 col-xs-12">
                                <select name="district_kho_shop" id="district_kho_shop"
                                        class="selectprovince_formpost form-control" <?php echo $khaibaoKho; ?>>
                                    <option value="">Chọn Quận/Huyện</option>
                                    <?php foreach ($kho_district as $districtArray) { ?>
                                        <?php if (isset($district_kho_shop) && $district_kho_shop == $districtArray->DistrictCode) { ?>
                                            <option value="<?php echo $districtArray->DistrictCode; ?>"
                                                    selected="selected"><?php echo $districtArray->DistrictName; ?></option>
                                        <?php } else { ?>
                                            <option
                                                value="<?php echo $districtArray->DistrictCode; ?>"><?php echo $districtArray->DistrictName; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            
                                <?php echo form_error('district_kho_shop'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!---dia chi kho hang-->
                    <?php if ((int)$this->session->userdata('sessionGroup') != 2) { ?>
                        <!-- <div class="form-group">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label"><font color="#FF0000"><?php echo $req; ?></font>
                                Loại gian hàng
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <?php $shopTypeList = array('0' => 'Bán lẻ', '1' => 'Bán sỉ', '2' => 'Vừa sỉ vừa lẻ');

                                ?>
                                <select name="shop_type" id="shop_type" class="selectprovince_formpost form-control">
                                    <?php foreach ($shopTypeList as $k => $val) { ?>
                                        <?php if (isset($shop_type) && $shop_type == $k) { ?>
                                            <option value="<?php echo $k; ?>"
                                                    selected="selected"><?php echo $val; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $k; ?>"><?php echo $val; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('shop_type'); ?>
                            </div>                            
                        </div> -->
                    <?php } ?>
                    <?php /*
                    <!--danh muc nganh-->
                    <div class="form-group">
                        <div class="col-sm-3 col-xs-12"><font color="#FF0000"><?php echo $req; ?></font>
                            Danh mục ngành :
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <?php $shopcatList = array('1' => 'Mua gì', '2' => 'Giải trí', '3' => 'Ăn gì', '4' => 'Ở đâu');

                            ?>
                            <select name="sho_cat_style" id="sho_cat_style"
                                    class="selectprovince_formpost form-control2">
                                <option value=""> --Chọn danh mục--</option>
                                <?php
                                foreach ($shopcatList as $k => $val)
                                {
                                    if ($k==$sho_cat_style) {
                                       ?><option selected value="<?php echo $k; ?>" <?php echo $selected ?>><?php echo $val; ?></option><?php
                                    }
                                    else
                                    {
                                 ?>
                                    <option value="<?php echo $k; ?>" <?php echo $selected ?>><?php echo $val; ?></option>
                                <?php }
                                } ?>
                            </select>
                            <?php echo form_error('sho_cat_style'); ?>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <?php echo form_error('sho_cat_style'); ?>
                        </div>
                    </div>
                    */ ?>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">
                            <font color="#FF0000"><?php echo $req; ?></font>                            
                            Số di động
                        </div>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                            <input type="text" name="mobile_shop" id="mobile_shop"
                                   value="<?php if (isset($mobile_shop)) {
                                       echo $mobile_shop;
                                   } ?>" maxlength="20" class="inputphone_formpost form-control"
                                   onfocus="ChangeStyle('mobile_shop',1)" onblur="ChangeStyle('mobile_shop',2)"/>

                            <p><img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                    onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');"
                                    onmouseout="hideddrivetip();"
                                    class="img_helppost"/>
                                <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                                <?php echo form_error('phone_shop'); ?></p>
                        </div>
		    </div>
		    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"> <?php echo $this->lang->line('phone_shop_account'); ?>
                            bàn
                        </div>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                            <input type="text" name="phone_shop" id="phone_shop"
                                   value="<?php if (isset($phone_shop)) {
                                       echo $phone_shop;
                                   } ?>" maxlength="20" class="inputphone_formpost form-control"
                                   onfocus="ChangeStyle('phone_shop',1)" onblur="ChangeStyle('phone_shop',2)"/>

                            <p><img src="<?php echo base_url(); ?>templates/home/images/help_post.gif"
                                    onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');"
                                    onmouseout="hideddrivetip();"
                                    class="img_helppost"/>
                                <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                                <?php echo form_error('mobile_shop'); ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"> Số Fax</div>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                            <input type="text" name="fax_shop" id="fax_shop" value="<?php if (isset($shop_fax)) {
                                echo $shop_fax;
                            } ?>" maxlength="50" class="input_formpost form-control">
			    <?php echo form_error('fax_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
			<div class="col-md-3 col-sm-4 col-xs-12 control-label">
			    <?php echo $this->lang->line('skype_shop_account'); ?>
			</div>
			<div class="col-md-9 col-sm-8 col-xs-12">
			    <input type="text" name="skype_shop" id="skype_shop"
				   value="<?php if (isset($skype_shop)) {
				       echo $skype_shop;
				   } ?>" maxlength="50" class="input_formpost  form-control"
				   onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_shop',1)"
				   onblur="ChangeStyle('skype_shop',2)"/>
			    <?php echo form_error('skype_shop'); ?>
			</div>			
		    </div>

		    
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label"><?php echo $this->lang->line('website_shop_account'); ?>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input placeholder="http://www.azibai.com" type="text" name="website_shop"
                                   id="website_shop" maxlength="100" value="<?php if (isset($website_shop)) {
                                echo $website_shop;
                            } ?>" class="input_formpost  form-control" onkeyup="BlockChar(this,'SpecialChar')"
                                   onfocus="ChangeStyle('website_shop',1)" onblur="ChangeStyle('website_shop',2)"/>
                        
                            <?php echo form_error('website_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Video trang chủ</div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="shop_video" id="shop_video" maxlength="100"
                                   value="<?php if (isset($shop_video)) {
                                       echo $shop_video;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')"
                                   placeholder="https://www.youtube.com/watch?v=pJwRsAUyGag"/>
                       
				<?php echo form_error('youtube_shop'); ?>
                        </div>
                    </div>
                    <!--                    <div class="form-group">-->
                    <!--                        <div class="col-sm-3 col-xs-12">Link Youtube video:</div>-->
                    <!--                        <div class="col-sm-9 col-xs-12">-->
                    <!--                            <input placeholder="https://www.youtube.com/watch?v=PFqu-mU-QzE" type="text"-->
                    <!--                                   name="shop_video" id="shop_video" maxlength="100"-->
                    <!--                                   value="--><?php //if (isset($shop_video)) {
//                                       echo $shop_video;
//                                   } ?><!--" class="input_formpost  form-control"-->
                    <!--                                   onkeyup="BlockChar(this,'SpecialChar')"/>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-sm-3 col-xs-12">-->
                    <!--                            --><?php //echo form_error('website_shop'); ?>
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Facebook</div>
                        <div class="col-md-9 col-sm-8  col-xs-12">
                            <input type="text" name="facebook_shop" id="facebook_shop" maxlength="100"
                                   value="<?php if (isset($facebook_shop)) {
                                       echo $facebook_shop;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')"
                                   placeholder="https://facebook.com/azibai"/>
                        
                            <?php echo form_error('facebook_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4  col-xs-12 control-label">Twitter</div>
                        <div class="col-md-9 col-sm-8  col-xs-12">
                            <input type="text" name="twitter_shop" id="twitter_shop" maxlength="100"
                                   value="<?php if (isset($twitter_shop)) {
                                       echo $twitter_shop;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')"
                                   placeholder="https://twitter.com/azibai"/>
                        
                            <?php echo form_error('twitter_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Kênh Youtube</div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="youtube_shop" id="youtube_shop" maxlength="100"
                                   value="<?php if (isset($youtube_shop)) {
                                       echo $youtube_shop;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')"
                                   placeholder="https://youtube.com/azibai"/>
                        
                            <?php echo form_error('youtube_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Google Plus</div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="google_plus_shop" id="google_plus_shop" maxlength="100"
                                   value="<?php if (isset($google_plus_shop)) {
                                       echo $google_plus_shop;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')"
                                   placeholder="https://plus.google.com/+AzibaiGlobal"/>
                       
                            <?php echo form_error('google_plus_shop'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4 col-xs-12 control-label">Vimeo</div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="text" name="vimeo_shop" id="vimeo_shop" maxlength="100"
                                   value="<?php if (isset($vimeo_shop)) {
                                       echo $vimeo_shop;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')" placeholder="https://vimeo.com/azibai"/>
                        
                            <?php echo form_error('vimeo_shop'); ?>
                        </div>
                    </div>
                    <?php if ((int)$this->session->userdata('sessionGroup') >= 2) { ?>
                        <div class="form-group" style="<?php if ($this->session->userdata('sessionGroup') == 2) {
                            echo 'display:none;';
                        } ?>">
                            <div class="col-md-3 col-sm-4 col-xs-12 control-label">
				<font color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('style_shop_account'); ?>
			    </div>
                            <div class="col-md-9 col-sm-8 col-xs-12">
                                <div style="display:none">
                                    <select name="style_shop" id="style_shop" class="selectstyle_formpost">
                                        <?php foreach ($style as $styleArray) { ?>
                                            <option
                                                value='<?php echo $styleArray; ?>' <?php if (isset($style_shop) && $styleArray == $style_shop) {
                                                echo 'selected="selected"';
                                            } elseif (isset($style_shop) && $style_shop == '' && $styleArray == 'style2') {
                                                echo 'selected="selected"';
                                            } ?>><?php echo ucfirst(strtolower($styleArray)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <script language="javascript">
                                    document.onclick = check;
                                    jQuery(document).ready(function () {
                                    });
                                    function check(e) {
                                        var evt = (e) ? e : event;
                                        var theElem = (evt.srcElement) ? evt.srcElement : evt.target;
                                        while (theElem != null) {
                                            if (theElem.id == "office-location") {
                                                jQuery('#office-location').remove();
                                                jQuery("#popup-style-image").css("display", "none");
                                                break;
                                            }
                                            else {
                                                break;
                                            }
                                        }
                                    }
                                    function closepop() {
                                        jQuery('#office-location').remove();
                                        jQuery("#popup-style-image").css("display", "none");
                                    }
                                    function popstyles() {
                                        jQuery("#popup-style-image").css("display", "block");

                                        var overlayLayer = jQuery("<div id='office-location'></div>").addClass('modal-overlay'); //THIS HAS THE OVERLAY CLASS OF CSS - SO IT SHOULD HAVE A OPACITY SET AND IT DOES

                                        jQuery('#main_container').after(overlayLayer);

                                        jQuery('<div id="content-for-overlay" style="background-color: #000000;"></div>').appendTo(overlayLayer); /// CONTENT IS ALSO HAS OPACITY BUT ITS WRONG

                                        jQuery('#office-location').css("opacity", 0.8).fadeIn();

                                        jQuery('#content-for-overlay').css("opacity", 1);
                                    }
                                    function selstyle(styleid) {
                                        jQuery('#style_shop').val(styleid);
                                        jQuery('#style_shop_1').val(styleid);
                                        jQuery('#current_style').html('<img class="img-responsive   " src="<?php echo base_url(); ?>templates/home/images/templates/' + styleid + '.png"/><p style="font-size:14px; font-weight: bold; margin-top: 10px;">Giao diện lựa chọn</p>');
                                    }
                                </script>
                                <!--                                <div>
                                    <?php if ($style_shop) { ?>
                                        <img width="150" src="<?php echo base_url(); ?>templates/home/images/templates/<?php echo $style_shop ?>.png"/>
                                    <?php } ?>
                                </div>-->
                                <div id="popup-style-image" class="popup-style-image" style="display: block">
                                    <!--                                    <div style="text-align: right"><img style="cursor:pointer" onclick="closepop();" src="<?php echo base_url(); ?>templates/home/images/close_x.png"/></div>-->
                                    <div id="current_style"
                                         style="text-align:center; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #000;">
                                        <?php if ($style_shop) { ?>
                                            <img class="img-responsive"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/<?php echo $style_shop ?>.png"/>
                                        <?php } else { ?>
                                            <img class="img-responsive"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/style2.png"/>
                                        <?php } ?>
                                        <p style="font-size:14px; font-weight: bold; margin-top: 10px;">Giao diện
                                            lựa chọn</p>
                                    </div>
                                    <div id="list_style" class="row">
                                        <div class="col-xs-6 col-sm-2 layout_style">
                                            <img class="img-responsive" style="cursor:pointer"
                                                 onclick="selstyle('default')"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/default.png"/>

                                            <p style="font-size:14px; font-weight: bold; margin-top: 10px; text-align:center;">
                                                Gian hàng 1</p>
                                        </div>
                                        <div class="col-xs-6 col-sm-2 layout_style">
                                            <img class="img-responsive" style="cursor:pointer"
                                                 onclick="selstyle('style1')"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/style1.png"/>

                                            <p style="font-size:14px; font-weight: bold; margin-top: 10px; text-align:center;">
                                                Gian hàng 2</p>
                                        </div>
                                        <div class="col-xs-6 col-sm-2 layout_style">
                                            <img class="img-responsive" style="cursor:pointer"
                                                 onclick="selstyle('style2')"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/style2.png"/>

                                            <p style="font-size:14px; font-weight: bold; margin-top: 10px; text-align:center;">
                                                Giải trí</p>
                                        </div>
                                        <div class="col-xs-6 col-sm-2 layout_style">
                                            <img class="img-responsive" style="cursor:pointer"
                                                 onclick="selstyle('style3')"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/style3.png"/>

                                            <p style="font-size:14px; font-weight: bold; margin-top: 10px; text-align:center;">
                                                Nhà hàng</p>
                                        </div>
                                        <div class="col-xs-6 col-sm-2 layout_style">
                                            <img class="img-responsive" style="cursor:pointer"
                                                 onclick="selstyle('style4')"
                                                 src="<?php echo base_url(); ?>templates/home/images/templates/style4.png"/>

                                            <p style="font-size:14px; font-weight: bold; margin-top: 10px; text-align:center;">Khách sạn
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="style_shop_1" id="style_shop_1"
                                       value="<?php echo $style_shop; ?>"/>
                                <!--                                <input type="button" name="select_shop_style" value="<?php echo $this->lang->line('select_shop_layout_style'); ?>" onclick="popstyles();" class="button_form_large"/>-->
                                <!--                                <img src="<?php echo base_url(); ?>templates/home/images/icon_view_logo.gif" onmouseover="ddrivetip_image_1('<?php echo base_url(); ?>templates/home/images/templates/');" onmouseout="hideddrivetip();"
                                     class="img_helppost"/>
                                <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('style_tip_help'); ?>',180,'#F0F8FF');" onmouseout="hideddrivetip();"
                                     class="img_helppost"/>-->
                            </div>
                        </div>
                        <div class="row" style="display:none">
                            <div class="col-md-3 col-sm-4  col-xs-12 control-label">Màu nền gian hàng:</div>
                            <div class="col-md-9 col-sm-8  col-xs-12">
                                <input type="hidden" name="colorpickertest" id="colorpickertest" value=""/>
                                <input type="text" name="colorpicker" id="colorpicker" readonly="readonly"
                                       maxlength="100" class="input_formpost  form-control"
                                       value="<?php echo $bg_color_shop; ?>" onkeyup="BlockChar(this,'SpecialChar')"
                                       onfocus="ChangeStyle('colorpicker',1)"
                                       onblur="ChangeStyle('colorpicker',2)"/>
                            </div>
                        </div>
                        <div class="row" style="display:none">
                            <div class="col-md-3 col-sm-4  col-xs-12 control-label"></div>
                            <div class="col-md-9 col-sm-8  col-xs-12">
                                <div class="saleoff_shop form-control"><input type="checkbox" name="saleoff_shop"
                                                                              id="saleoff_shop"
                                                                              value="<?php if (isset($saleoff_shop)) {
                                                                                  echo $saleoff_shop;
                                                                              } ?>" <?php if (isset($saleoff_shop) && (int)$saleoff_shop == 1) {
                                        echo 'checked="checked"';
                                    } ?> /><?php echo $this->lang->line('saleoff_shop_account'); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($imageCaptchaEditShopAccount)) { ?>
                        <div class="form-group">
                            <div class="col-md-3 col-sm-4  col-xs-12 control-label"><font
                                    color="#FF0000"><?php echo $req; ?></font> <?php echo $this->lang->line('captcha_main'); ?>
                                :
                            </div>
                            <div class="col-md-9 col-sm-8  col-xs-12">
                                <img src="<?php echo $imageCaptchaEditShopAccount; ?>" height="30"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <input type="text" onkeypress="return submitenter(this,event)" name="captcha_shop"
                                       id="captcha_shop" value="" maxlength="10"
                                       class="inputcaptcha_form  form-control"/>
                                <?php echo form_error('captcha_shop'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ((int)$this->session->userdata('sessionGroup') < 3) { ?>
                        <!--<div class="form-group">
	<div class="col-sm-3 col-xs-12">
	Nội quy gian hàng
	</div>
	<div class="col-sm-9 col-xs-12">
	<div class="osX">
	<div id="Panel_3" style="width:100%; height:185px; font-size:12px; overflow:auto;">
	<div style="padding:5px;">
	<?php $contentFooter = Counter_model::getArticle(noi_quy_gian_hang);
                        echo html_entity_decode($contentFooter->not_detail); ?>
	</div>
	</div>
	</div>
	</div>
	</div>
    -->
                        <!--<div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div style="clear:both; padding-top:10px; padding-left:8px;">
                            <input type="checkbox" id="checkDongY" name="checkDongY" onclick="checkekdieuKienThanhCong();" /> <span style="color:#FF0000; font-weight:bold;"> Đồng ý điều khoản trên </span>
                            </div>
                        </div>
                        <script>
                        function checkekdieuKienThanhCong()
                        {
                        var checked = jQuery('#checkDongY').is(':checked');

                        if(checked==true)
                        {
                        jQuery('.checkdongy').css('display','block');
                        }
                        else
                        {
                        jQuery('.checkdongy').css('display','none');
                        }
                        }
                        </script>
                        </div>-->
                    <?php } ?>


                    <!--START add by Vietnguyen-->
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4  col-xs-12 control-label">SEO mô tả</div>
                        <div class="col-md-9 col-sm-8  col-xs-12">
                            <textarea name="sho_description" id="sho_description"
                                      rows="4" maxlength="255"
                                      class="input_formpost  form-control"
                                      onkeyup="BlockChar(this,'SpecialChar')"
                                      placeholder="Nhập mô tả seo gian hàng tại đây"><?php if (isset($sho_description)) {
                                    echo $sho_description;
                                } ?></textarea>
                        
                            <?php echo form_error('sho_description'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-sm-4  col-xs-12 control-label">SEO từ khóa</div>
                        <div class="col-md-9 col-sm-8  col-xs-12">
                            <input type="text" name="sho_keywords" id="sho_keywords" maxlength="255"
                                   value="<?php if (isset($sho_keywords)) {
                                       echo $sho_keywords;
                                   } ?>" class="input_formpost  form-control"
                                   onkeyup="BlockChar(this,'SpecialChar')" placeholder="VD: Tên gian hàng, ten gian hang"/>
                        
                            <?php echo form_error('sho_keywords'); ?>
                        </div>
                    </div>
                    <!--END by Vietnguyen-->

                    <div class="form-group">
                        <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                            <?php if ((int)$this->session->userdata('sessionGroup') == 2){ ?>
                                <!--                                <input type="button" onclick="CheckInput_EditShopQ();" name="submit_editshop"-->
                                <!--                                       value="--><?php //echo $this->lang->line('button_update_shop_account'); ?><!--"-->
                                <!--                                       class="btn btn-primary"/>-->
                                <button class="btn btn-primary  btn-block" name="submit_editshop" type="submit">Cập nhật</button>
                            <?php } else { ?>
                                <input type="button" onclick="CheckInput_EditShop();" name="submit_editshop"
                                       value="<?php echo $this->lang->line('button_update_shop_account'); ?>"
                                       class="btn btn-azibai btn-block"/>
                            <?php } ?>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <input type="button" name="cancle_editshop"
                                   value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>"
                                   onclick="ActionLink('<?php echo base_url(); ?>account')"
                                   class="btn btn-default btn-block"/>
                        </div>

                    </div>
                    <input type="hidden" name="isPostShopAccount" value="1"/>
                    <input type="hidden" name="isEditShop" id="isEditShop" value=""/>
                    <input type="hidden" name="current_captcha" id="current_captcha"
                           value="<?php echo $captcha; ?>"/>
                <?php } else { ?>
                    <div class="form-group text-center">
                        <p><?php echo $this->lang->line('success_edit_shop_account'); ?></p>
                        <p class="text-center"><a href="<?php echo base_url(); ?>account/shop">Click vào đây để tiếp tục</a></p>
                    </div>
                <?php } ?>
            </form>
            <?php
            }
            ?>
        </div>
        <!--  <script type="text/javascript">
              jQuery('document').ready(function () {
                  // running ExColor
                  jQuery('#colorpicker').modcoder_excolor();
              });
          </script>-->
        <!--END RIGHT-->
    </div>
</div>
<script type="text/javascript">
    $("#province_shop").change(function () {
        if ($("#province_shop").val()) {
            var package = '<?php echo $sho_package['id']?>';
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#province_shop").val()},
                cache: true,
                success: function (response) {
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('district_shop', json, "");
                        delete json;
                        if (package == 1 || package == 2) {
                            document.getElementById("more_provinces").innerHTML = "";
                        } else {
                            areaFilter(package);
                        }
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
    });

    $("#province_kho_shop").change(function () {
        if ($("#province_kho_shop").val()) {
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#province_kho_shop").val()},
                cache: true,
                success: function (response) {
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('district_kho_shop', json, "");
                        delete json;
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
    });

    $("#check_kho").on('click', function () {
        $("#address_kho_shop").val($("#address_shop").val());
        $("#province_kho_shop").val($("#province_shop").val());

        $("#district_kho_shop").html($("#district_shop").html());
        $("#district_kho_shop").val($("#district_shop").val());
    });

    function emptySelectBoxById(eid, value, filterId) {
        if (value) {
            var text = "";
            $.each(value, function (k, v) {
                //display the key and value pair
                if (filterId) {
                    if (k != "" && k != filterId) {
                        text += "<option value='" + k + "'>" + v + "</option>";
                    }
                } else {
                    if (k != "") {
                        text += "<option value='" + k + "'>" + v + "</option>";
                    }
                }

            });
            document.getElementById(eid).innerHTML = text;
            delete text;
        }
    }

    function areaFilter(shop_package) {
        $.ajax({
            url: siteUrl + 'home/account/getProvincesByArea',
            type: "POST",
            data: {user_province_put: $("#province_shop").val(), shop_package: shop_package},
            cache: true,
            success: function (response) {
                if (response) {
                    var _json = JSON.parse(response);
                    emptySelectBoxById('more_provinces', _json, $("#province_shop").val());
                    delete _json;
                }
            },
            error: function () {

            }
        });
    }
</script>
<?php $this->load->view('home/common/footer'); ?>

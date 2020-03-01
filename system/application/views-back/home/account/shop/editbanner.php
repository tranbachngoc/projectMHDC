<?php $this->load->view('home/common/account/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jquery-ui-1.8.18.custom.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jquery-ui-1.8.18.custom.css" />
<script language="javascript">
	function changeBannerFormat(val){
		if(val ==1){
			jQuery('#banner_image').css('display','table-row');
			jQuery('#banner_size').css('display','none');
			jQuery('#banner_html').css('display','none');
		}
		if(val ==2){
			jQuery('#banner_image').css('display','table-row');
			jQuery('#banner_size').css('display','table-row');
			jQuery('#banner_html').css('display','none');
		}
		if(val ==3){
			jQuery('#banner_image').css('display','none');
			jQuery('#banner_size').css('display','none');
			jQuery('#banner_html').css('display','table-row');
		}
	}
	jQuery(document).ready(function($){
		$today = new Date();
		jQuery('#ub_str_start_date').datepicker({ minDate: $today});
		jQuery('#ub_str_end_date').datepicker({ minDate: $today});
	});
	function parseDate(input) {
	  var parts = input.match(/(\d+)/g);
	  return new Date(parts[0], parts[1]-1, parts[2]);
	}
</script>
<SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   CheckInput_editbanner();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>

<?php if($updateBanner!=1){ ?>
    <div class="col-lg-9 col-md-9 col-sm-8">
	<table class="table table-bordered" width="100%" cellpadding="0" cellspacing="0">
    	<tr>
        	<td>
            	<div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc" style="text-transform:uppercase">
				<?php echo $this->lang->line('add_new').' banner'; ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
        	<td class="k_fixpaddingie" valign="top"  >
            	<div class="content" align="center" style="margin:0; padding: 0">
            	<form enctype="multipart/form-data" method="post" id="editbanner" name="editbanner" class="form">
                  <table cellpadding="3" cellspacing="3">
                    <tbody>
                      <tr>
                        <td class="form_name"></td>
                        <td class="form_text"><font class="form_text_note">Những ô có dấu sao (<font class="form_asterisk">*</font>) là bắt buộc phải nhập.</font></td>
                      </tr>
                      <tr>
                        <td class="list_post"><font class="form_asterisk">* </font>Tên banner :</td>
                        <td class="form_text">
                        	<input type="text" maxlength="255" onblur="ChangeStyle('ub_name_0',2)" onfocus="ChangeStyle('ub_name_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="input_formpost" style="width:250px;" value="<?php if(isset($banner)){echo $banner->banner_name;}?>" name="ub_name" id="ub_name_0" alt="Tên banner" autocomplete="off">
                        </td>
                      </tr>
                        <tr>
                        <td class="list_post"><font class="form_asterisk">* </font>Loại banner :</td>
                        <td class="form_text">
                        	<select size="1" style="width:px" name="ub_type" id="ub_type_0" title="Loại banner" class="selectsex_formpost" onchange="thong_bao_kich_thuoc_banner(this.value)">
                            <option <?php if(isset($banner) && $banner->banner_position == 1){echo "selected='selected'";}?> value="1" title="Phía trên">Phía trên</option>
                            <option <?php if(isset($banner) && $banner->banner_position == 2){echo "selected='selected'";}?> value="2" title="Bên trái">Bên trái</option>
                            <option <?php if(isset($banner) && $banner->banner_position == 3){echo "selected='selected'";}?> value="3" title="Bên phải">Bên phải</option>
                            
                          </select>
                        </td>
                      </tr>
                      <tr>
                      	<td>
                        </td>
                        <td>
                        <div id="quydinhichtuocbanner" class="form_asterisk" style="font-weight:bold;">
                        	 <?php if(isset($banner) && $banner->banner_position == 1){echo "Kích thước chuẩn cho vị trí banner phía trên  chiều dài 550px và chiều cao 270px";}?> 
                        	<?php if(isset($banner) && $banner->banner_position == 2){echo "Kích thước chuẩn cho vị trí banner bên trái  chiều dài 190px";}?>
                             <?php if(isset($banner) && $banner->banner_position == 3){echo "Kích thước chuẩn cho vị trí banner bên phải  chiều dài 190px";}?>
                        
                         </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="list_post">Định dạng Banner :</td>
                        <td class="form_text">
                        	<select onchange="changeBannerFormat(this.value)" size="1" style="width:px" name="ub_format" id="ub_format_0" alt="Định dạng Banner" class="selectsex_formpost">
                            <option <?php if(isset($banner) && $banner->banner_type == 1){echo "selected='selected'";}?> value="1" title="Ảnh">Ảnh</option>
                            <option <?php if(isset($banner) && $banner->banner_type == 2){echo "selected='selected'";}?> value="2" title="Flash">Flash</option>
                            <option <?php if(isset($banner) && $banner->banner_type == 3){echo "selected='selected'";}?> value="3" title="HTML">HTML</option>
                          </select>
                        </td>
                      </tr>
                      <tr id="banner_image" style="display: <?php if(isset($banner) && $banner->banner_type == 3){ echo 'none';}else{echo 'table-row';}?>;">
                        <td class="list_post"><font class="form_asterisk">*</font> Ảnh banner:</td>
                        <td class="form_text">
                        	<input type="file" class="inputimage_formpost" title="Ảnh banner" id="ub_picture" name="ub_picture" size="32">
                          (Dung lượng tối đa <font color="#ff0000">1 MB</font>) 
                          	<input type="hidden" id="filename" name="filename" value="<?php if($banner->banner_type !=3){ echo $banner->content;}?>"/>
                            <br/>
                            
                        <?php if($banner->banner_type == 1){?>
                                    <img width="210" src="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $banner->content; ?>"/>
                                <? }elseif($banner->banner_type == 2){ 
                                    $height = (210/$banner->banner_width)*$banner->banner_height;
                                    ?>
                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:210px; height:<?php echo $height?>px;" id="FlashID_Banner">
                                  <param name="movie" value="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $banner->content; ?>" />
                                  <param name="quality" value="high" />
                                  <param name="wmode" value="opaque" />
                                  <param name="swfversion" value="6.0.65.0" />
                                  <param name="expressinstall" value="<?php echo base_url(); ?>templates/shop/style1/images/expressInstall.swf" />
                                  <!--[if !IE]>--><object type="application/x-shockwave-flash" style="width:210px; height:<?php echo $height?>px;" data="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $banner->content; ?>" class="banner_flash"><!--<![endif]-->
                                  <param name="quality" value="high" />
                                  <param name="wmode" value="opaque" />
                                  <param name="swfversion" value="6.0.65.0" />
                                  <param name="expressinstall" value="<?php echo base_url(); ?>templates/shop/style1/images/expressInstall.swf" />
                                  <div>
                                    <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                                  </div>
                                  <!--[if !IE]>--></object><!--<![endif]-->
                                </object>
                                <!--suppress JSAnnotator -->
                            <script type="text/javascript"><!-- swfobject.registerObject("FlashID_Banner"); //--></script>
    
                                <? }else{ $this->load->helper('text');?>
                                    <a title="<?php echo strip_tags(htmlspecialchars_decode(html_entity_decode($banner->content)));?>"><?php echo word_limiter(htmlspecialchars_decode(html_entity_decode($banner->content)),8);?></a>          
                                <? }?>
                                
                        </td>
                      </tr>
                      <tr style="display: <?php if(isset($banner) && $banner->banner_type == 2){ echo 'table-row';}else{echo 'none';}?>" id="banner_size">
                        <td class="list_post"><font class="form_asterisk">*</font> Kích thước :</td>
                        <td class="form_text">
                        	<input type="text" class="form_control" autocomplete="off" title="Chiều rộng" id="ub_width_0" name="ub_width" value="<?php if(isset($banner) && $banner->banner_type == 2){ echo $banner->banner_width;} ?>" style="width: 50px;" maxlength="11">
                          x
                            <input type="text" class="form_control" autocomplete="off" title="Chiều cao" id="ub_height_0" name="ub_height" value="<?php if(isset($banner) && $banner->banner_type == 2){ echo $banner->banner_height;} ?>" style="width: 50px;" maxlength="11">
                        </td>
                      </tr>
                      <tr style="display: <?php if(isset($banner) && $banner->banner_type == 3){ echo 'table-row';}else{echo 'none';}?>;" id="banner_html">
                        <td class="list_post">Nội dung HTML :</td>
                        <td colspan="2">
                        	<?php $this->load->view('admin/common/tinymce'); ?>     
                            <textarea style="width: 500px; height:300px;" name="ub_html" id="ub_html">	
                            <?php if(isset($banner) && $banner->banner_type == 3){ echo $banner->content;} ?>
                            </textarea>
                         </td>
                      </tr>
                      <tr>
                        <td class="list_post">Liên kết (http://) :</td>
                        <td class="form_text">
                        	<input type="text" maxlength="255" onblur="ChangeStyle('ub_link_0',2)" onfocus="ChangeStyle('ub_link_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="input_formpost" style="width:250px;" value="<?php if(isset($banner)){echo $banner->link;}?>" name="ub_link" id="ub_link_0" title="Liên kết" autocomplete="off">
                        </td>
                      </tr>
                      <tr>
                        <td class="list_post">Mở ra :</td>
                        <td class="form_text">
                        	<select size="1" style="width:px" name="ub_target" id="ub_target_0" title="Mở ra" class="selectsex_formpost">
                            <option <?php if(isset($banner) && $banner->target == '_blank'){echo "selected='selected'";}?> value="_blank" title="Trang mới">Trang mới</option>
                            <option <?php if(isset($banner) && $banner->target == '_self'){echo "selected='selected'";}?> value="_self" title="Hiện hành">Hiện hành</option>
                          </select>
                        </td>
                      </tr>                    
                      <tr>
                        <td class="list_post"><font class="form_asterisk">* </font>Thứ tự :</td>
                        <td class="form_text"><input type="text" maxlength="255" onblur="ChangeStyle('ub_order_0',2)" onfocus="ChangeStyle('ub_order_0',1)" onkeyup="BlockChar(this,'SpecialChar')" class="input_formpost" style="width:50px;" value="<?php echo $banner->order_num;?>" name="ub_order" id="ub_order_0" title="Thứ tự" autocomplete="off"></td>
                      </tr>
                      <tr>
                        <td class="list_post">Ngày bắt đầu :</td>
                        <td class="form_text">
                        	<input type="text" maxlength="" style="width:80px; height:px" value="<?php if($banner->start_date != '0000-00-00 00:00:00'){echo $banner->start_date;}?>" name="ub_str_start_date" id="ub_str_start_date" title="Ngày (yyyy/mm/dd)" autocomplete="off" class="input_formpost">
                        </td>
                      </tr>
                      <tr>
                        <td class="list_post">Ngày kết thúc :</td>
                        <td class="form_text">
                        	<input type="text" maxlength="" style="width:80px; height:px" value="<?php if($banner->end_date != '0000-00-00 00:00:00'){echo $banner->end_date;}?>" name="ub_str_end_date" id="ub_str_end_date" title="Ngày (yyyy/mm/dd)" autocomplete="off" class="input_formpost">
                        </td>
                      </tr>
                      <tr>
                        <td class="list_post">Kích hoạt banner :</td>
                        <td class="form_text"><input type="checkbox" onclick="changeChkValue(this);" <?php if($banner->published){echo "checked='checked'";}?> value="<?php echo $banner->published;?>" name="ub_active" id="ub_active_0"></td>
                      </tr>
                      <tr>
                        <td class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td class="form_text">
                        	<img src="<?php echo $imageCaptchaEditBanner; ?>" width="151" height="30" /><br />
                        	<input type="text" onkeypress="return submitenter(this,event)" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_shop',1);" onblur="ChangeStyle('captcha_shop',2);" />
                        </td>
                      </tr>
                      <tr>
                        <td class="list_post"></td>
                        <td class="form_text">
                          <input type="button" onclick="CheckInput_editbanner();" name="submit_addbanner" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="button_form" />
                          <input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account/shop/addbanner')" class="button_form" />
                        </td>
                      </tr>
                    	<input type="hidden" value="" name="isEditBanner" id="isEditBanner">
                        <input type="hidden" name="current_captcha" id="current_captcha" value="<?php echo $captcha;?>"/>
                    </tbody>
                  </table>
                </form>
                </div>
            </td>
        </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
</td>
<?php } else { ?>
<td valign="top">
<table class="table table-bordered success_post" width="100%" cellpadding="0" cellspacing="0">
 	<tr>
        	<td>
            	<div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc" style="text-transform:uppercase">
				<?php echo $this->lang->line('add_new').' banner'; ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        
    	<tr>
  				<td class="k_fixpaddingie" valign="middle"   align="center" height="100">
                           <p class="text-center"><a href="<?php echo base_url(); ?>account/shop/listbanner">Click vào đây để tiếp tục</a></p>
                            Bạn đã cập nhật thông tin thành công
						</td>
     </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
        
          </table>
    </div>
<?php } ?>
<!--END: RIGHT-->
</div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
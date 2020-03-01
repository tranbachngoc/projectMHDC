<?php $this->load->view('home/common/account/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8">
	<table class="table table-bordered" width="100%"  cellpadding="0" cellspacing="0">
        <tr>
        	<td valign="top" >
            	<table class="table table-bordered" width="100%" cellpadding="0" class="quantrigianhangtable" cellspacing="0">
    	<tr>
        	<td>
            	<div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc" style="text-transform:uppercase">
				<?php echo 'Danh sách banner'; ?>
               
                </div>
                 
                <div class="fr"></div>
                <div style="float:right;" class="add-banner"><img src="<?php echo base_url(); ?>templates/home/images/add.gif"/> <a href="<?php echo base_url(); ?>account/shop/addbanner">Thêm mới</a></div>
                </div>
            </td>
        </tr>
        <tr>
        	<td valign="top"  >
            	<table width="100%" style="border: 1px solid #E5E3E6;">
                    <tr style="background-color:#F1F8FF">
                        <th  style="border:1px solid #E5E3E6;" align="center">STT</th>
                        <th style="border:1px solid #E5E3E6;">Banner</th>
                        <th style="border:1px solid #E5E3E6;">Tên Banner</th>
                        <th style="border:1px solid #E5E3E6;">Loại Banner</th>
                        <th style="border:1px solid #E5E3E6;">Vị trí Banner</th>
                        <th style="border:1px solid #E5E3E6;">Thứ tự sắp xếp</th>
                        <th style="border:1px solid #E5E3E6;">Ngày bắt đầu</th>
                        <th style="border:1px solid #E5E3E6;">Ngày kết thúc</th>
                        <th style="border:1px solid #E5E3E6;">Trạng thái</th>
                        <th style="border:1px solid #E5E3E6;">Sửa/Xóa</th>
                    </tr>
                    <?php if(isset($banners)){
                        foreach($banners as $key=>$item){
                    ?>
                        <tr>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php echo ($key+1);?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;">
                                <?php if($item->banner_type == 1){?>
                                    <img width="210" src="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $item->content; ?>"/>
                                <? }elseif($item->banner_type == 2){ 
                                    $height = (210/$item->banner_width)*$item->banner_height;
                                    ?>
                                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:210px; height:<?php echo $height?>px;" id="FlashID_Banner">
                                  <param name="movie" value="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $item->content; ?>" />
                                  <param name="quality" value="high" />
                                  <param name="wmode" value="opaque" />
                                  <param name="swfversion" value="6.0.65.0" />
                                  <param name="expressinstall" value="<?php echo base_url(); ?>templates/shop/style1/images/expressInstall.swf" />
                                  <!--[if !IE]>--><object type="application/x-shockwave-flash" style="width:210px; height:<?php echo $height?>px;" data="<?php echo base_url(); ?>media/shop/banners/<?php echo $shop_dir; ?>/<?php echo $item->content; ?>" class="banner_flash"><!--<![endif]-->
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
                                <script type="text/javascript"><!-- swfobject.registerObject("FlashID_Banner"); //--></script>
    
                                <? }else{ $this->load->helper('text');?>
                                    <a title="<?php echo strip_tags(htmlspecialchars_decode(html_entity_decode($item->content)));?>"><?php echo word_limiter(htmlspecialchars_decode(html_entity_decode($item->content)),8);?></a>          
                                <? }?>
                                
                            </td>
                            <td style="border:1px solid #E5E3E6;"><?php echo $item->banner_name?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php if($item->banner_type == 1){echo 'Ảnh';}elseif($item->banner_type == 2){echo 'Flash';}else{echo 'Html';}?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php if($item->banner_position == 1){echo 'Phía trên';}elseif($item->banner_position == 2){echo 'Bên trái';}elseif($item->banner_position == 3){echo 'Bên phải';}else{echo 'Phía dưới';}?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php echo $item->order_num?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php if($item->start_date !='0000-00-00 00:00:00'){echo $item->start_date;}?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;"><?php if($item->end_date !='0000-00-00 00:00:00'){echo $item->end_date;}?></td>
                            <td style="border:1px solid #E5E3E6; text-align:center;">
                                <?php if($item->published){?>
                                <img src="<?php echo base_url(); ?>templates/home/images/active_1.gif"/>
                                <? }else{?>
                                <img src="<?php echo base_url(); ?>templates/home/images/active_0.gif"/>
                                <? }?>
                            </td>
                            <td style="border:1px solid #E5E3E6; text-align:center;">
                                <img style="cursor:pointer" onclick="ActionLink('<?php echo base_url(); ?>account/shop/banner/edit/<?php echo $item->id?>')" src="<?php echo base_url(); ?>templates/home/images/edit.gif"/> / 
                                <img style="cursor:pointer" src="<?php echo base_url(); ?>templates/home/images/delete.gif" onclick="ActionLink('<?php echo base_url(); ?>account/shop/banner/delete/<?php echo $item->id?>')"/>
                            </td>
                        </tr>
                    <?php } }?>
                    </table>
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
        </tr>
    </table>
    </div>
</div>
    </div>
<!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<script>
jQuery(document).ready(function() {
	jQuery(".chitietup").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
});
</script>
<div class="col-lg-9">
<table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
      <div class="tile_modules tile_modules_blue">
      <div class="fl"></div>
      <div class="fc">
      DANH SÁCH TỰ ĐỘNG UP TIN
      </div>
      <div class="fr"></div>
      </div>
      </td>
    </tr>
    <tr>
      <td class="k_fixpaddingie"   valign="top" >
      
      
       <table width="100%"  height="29" cellspacing="0" cellpadding="0" border="0" align="center" >
                    <tbody><tr>
                     <td width="5%" class="title_boxads_1">
                          STT                   
                        </td>
                           <td width="30%" class="title_boxads_1">
                           Tin                     
                        </td>
                        <td width="15%" class="title_boxads_1">
                           Loại                     
                        </td>
                        <td width="15%" class="title_boxads_1">
                           Số Lượng 
                        </td>
                        <td width="15%" class="title_boxads_1">
                           Lịch Thứ Ngày
                        </td>
                         <td width="10%" class="title_boxads_1">
                           Lịch Giờ
                        </td>
                        <td width="15%" class="title_boxads_1 title_boxads_2" >&nbsp;
                       
                        </td>
                    </tr>
                    <?
                       
					   $stt=1;
					    foreach($lichup as $row){ 
						$loaiTin = "Sản Phẩm ";
						$url = "";
						if($row->type=="2"){
							$loaiTin = "Rao Vặt";
							$url = "";
						}
					?>
                    
                    <tr id="DivRowReliableAds" style="background:#F1F9FF">
                        <td class="line_boxads_1">
                                <? echo $stt++;?>                
                        </td>
                        <td class="line_boxads_1" style="text-align:left">
                              <a href="<? echo $url; ?>"><? echo $row->title;?>                           </a>
                        </td>
                         <td class="line_boxads_1">
                                       <? echo $loaiTin;?>                
                        </td>
                         <td class="line_boxads_1" >
                                   <? echo $row->so_lan_up ;?>                 
                        </td>
                        <td class="line_boxads_1" >
                                   <? echo $row->thu;?>                 
                        </td>
                        <td class="line_boxads_1" >
                                   <? echo $row->gio;?>                 
                        </td>
                         <td class="line_boxads_1" >
                                        <a href="<?php echo base_url(); ?>account/chitietup/<? echo $row->id;?>   " class="chitietup"> Chi Tiết  </a>     
                        </td>
                    </tr>
                    
                    <?
					   }
					?>
                </tbody></table>
      
      
      
      
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
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

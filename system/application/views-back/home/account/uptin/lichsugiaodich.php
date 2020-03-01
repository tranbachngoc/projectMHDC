<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<script>
jQuery(document).ready(function() {
	jQuery("#chitietup").fancybox({
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
<table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td>
      <div class="tile_modules tile_modules_blue">
      <div class="fl"></div>
      <div class="fc">
      LỊCH SỬ GIAO DỊCH
      </div>
      <div class="fr"></div>
      </div>
      </td>
    </tr>
    <tr>
      <td height="30"><b>Tổng số tiền đã nạp - Tổng số tiền đã dùng = Tổng số tiền trong tài khoản của bạn</b></td>
    </tr>
      <tr>
      <td height="30" ><b><?php echo formatMoney($add); ?> - <?php echo formatMoney($subtract); ?> = <span style="color:red;"><? echo formatMoney($balance) ?> VNĐ</span></b></td>
    </tr>
 
    <tr>
      <td   valign="top">
      
      
            <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list title_list1">STT</td>
                                      
                                        <td class="title_list" width="130">
                                            Username
                                           
                                        </td>
                                          <td class="title_list" width="130">
                                            Số Tiền
                                        	</td>
                                        <td class="title_list">
                                          Loại Tiền
                                        </td>
                                        <td class="title_list">
                                           Ghi Chú
                                        </td>
                                        <td width="90" class="title_list">
                                           Trạng Thái
                                        </td>
                                        <td width="130" class="title_list title_list2">
 Ngày Phát Sinh
                                        </td>
                                       
                                    </tr>
                                   
                                    <?php foreach($lichsugiaodich as $key=>$row){ 
									
									if($row->prefix=="+"){
										$row->prefix =  "Thêm Vào";
									}else{
										$row->prefix =  "Giảm Trừ";
									}
									?>
                                    <tr style="background:#<?php if($key % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $key; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $key; ?>',<?php echo $key; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $key; ?>',<?php echo $key; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo ($key+1); ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                       <?php echo   $row->use_username; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                       <?php echo   formatMoney($row->amount); ?> VNĐ
                                        </td>
                                        <td class="detail_list">
                                            <?php echo   $row->type; ?>
                                        </td>
                                             <td class="detail_list detail_list2">
                                           <?php echo   $row->comment; ?>
                                        </td>
                                          <td class="detail_list">
                                           <?php echo   $row->prefix ; ?>
                                        </td>                                          
                                       
                                        <td class="detail_list detail_list3" style="text-align:center;"><?php echo   $row->date_time; ?></td>
                                    </tr>
                                    <?php } ?>
                                
                                    <tr>
                                        <td class="show_page" colspan="9"><?php echo $linkPage; ?></td>
                                    </tr>
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
    </div>
        </div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

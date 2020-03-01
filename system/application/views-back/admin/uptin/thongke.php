<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<script type="text/javascript">
function submitForm(){
	$keyword = jQuery("#keyword").val();
	$type = jQuery("#type").val();	
	$month=jQuery("#month").val();
	$day=jQuery("#day").val();
	$year=	jQuery("#year").val();

	$url = "<?php echo base_url(); ?>administ/uptin/thongke";
	if(!CheckBlank($keyword)){
		$url=$url+'/keyword/'+$keyword;
	}
	if(!CheckBlank($type)){
		$url=$url+'/type/'+$type;
	}
		if(!CheckBlank($day)){
		$url=$url+'/day/'+$day;
	}
		if(!CheckBlank($year)){
		$url=$url+'/year/'+$year;
	}
		if(!CheckBlank($month)){
		$url=$url+'/month/'+$month;
	}

	window.location.href=$url; 
}
</script>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                     <form name="frmUser" id="frmUser" method="post" action="<?php echo base_url(); ?>administ/uptin/thongke">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <!--BEGIN: Item Menu-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                         
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Thống Kê Giao Dịch </td>
                                        <td width="55%" height="67" class="item_menu_right">
                                          
                                        </td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="250" align="left">
                                          Username <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" />
                                        </td>
                                        <td width="220" align="left">Loại 
                                            <select name="type" id="type" class="select_search">
                                              <option value="">Tất Cả</option>
                                          <? foreach($loaigiaodich as $row){
											 	 $sel = ""; 
										 		 if($selType ==$row->id)
										  			  $sel = "selected='selected'";
										  ?>
                                                <option value="<? echo $row->id; ?>" <? echo $sel;?>><? echo $row->type; ?></option>
                                                
                                           <? } ?>
                                               
                                            </select>
                                        </td> <td id="DivDateSearch_2" width="60" align="left">Ngày Tháng</td>
                                           <td id="DivDateSearch_2" width="60" align="left">
                                            <select name="day" id="day" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_4" width="60" align="left">
                                            <select name="month" id="month" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_6" width="60" align="left">
                                            <select name="year" id="year" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="submitForm()" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                       
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                      
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
                                          Thao tác
                                        </td>
                                        <td class="title_list">
                                           Ghi Chú
                                        </td>
                                        <td width="90" class="title_list">
                                           Trạng Thái
                                        </td>
                                        <td width="130" class="title_list">
 Ngày Phát Sinh
                                        </td>
                                       
                                    </tr>
                                   <?php $idDiv = 1; ?>
                                    <?php foreach($giaodich as $row){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                       <?php echo   $row->use_username; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                       <?php echo   $row->amount; ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php echo   $row->type; ?>
                                        </td>
                                        <td class="detail_list">
                                        <input name="xoa" value="Xóa" type="button" onclick="confirmDelete(<?php echo $row->id; ?>);" />
                                            
                                        </td>
                                             <td class="detail_list">
                                           <?php echo   $row->comment; ?>
                                        </td>
                                          <td class="detail_list">
                                           <?php echo   $row->prefix; ?>
                                        </td>
                                          
                                       
                                        <td class="detail_list" style="text-align:center;"><?php echo   $row->date_time; ?></td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                             
                                    <tr>
                                        <td class="show_page" colspan="9"><?php echo $linkPage; ?></td>
                                    </tr>
                                </table>
                                <!--END Content-->
                            </td>
                        </tr>
                      
                    </table>
                      </form>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
<script type="text/javascript">
function confirmDelete(id){
	var key = randomString();
	var ans = prompt("Vui lòng nhập mã xác nhận sau:"+key);
	if(ans == key) deleteGiaodich(id);
	else alert("Bạn chưa nhập mã xác nhận hoặc đã hủy yêu cầu!")
}
function randomString() {
	var chars = "abcdefghiklmnopqrstuvwxyz";
	var string_length = 6;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function deleteGiaodich(id){	
	jQuery.post("<?php echo base_url(); ?>administ/uptin/xoagiaodich", { id: id },
                function(data) {
				if(data=='0'){
					window.location.reload()						
				}
				if(data=='1'){		
				   window.location.reload()
				}
									
		});
	
}

</script>

    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
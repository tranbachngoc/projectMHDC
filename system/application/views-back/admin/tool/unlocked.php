<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <!--BEGIN: Item Menu-->
                                
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center">
                               <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/tool/unlocked/search/','keyword')"  />
                                        </td>
                                       
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="if(document.getElementById('keyword').value!='') window.location='<?php echo base_url(); ?>administ/tool/unlocked/search/'+document.getElementById('keyword').value; else alert('Vui lòng nhập từ khóa!');" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        
                                       
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmNotify" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmNotify',0)" />
                                        </td>
                                        <td class="title_list">
                                           IP bị khóa
                                            
                                        </td>
                                         <td width="80" class="title_list">
                                            Mở khóa
                                        </td>                                   
                                       
                                        <td width="300" class="title_list">
                                            Trình duyệt
                                        </td>
                                        <td width="200" class="title_list">
                                            Ngày bị khóa                                         
                                        </td>
                                       
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; $sTT=1 ?>
                                    <?php if(count($unlockeds)>0): ?>
                                    <?php foreach($unlockeds as $unlocked){ ?>

                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $unlocked->session_id; ?>" onclick="DoCheckOne('frmNotify')" />
                                        </td>
                                        <td class="detail_list" >
                                          <?php echo $unlocked->ip_address ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center">
                                                                                    
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo base_url(); ?>administ/tool/unlocked/delete/<?php echo $unlocked->session_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                           
                                        </td>
                                       
                                        <td class="detail_list" style="text-align:center;">
                                         <?php echo $unlocked->user_agent ?> 
                                           
                                        </td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $unlocked->last_activity); ?></b></td>
                             
                                    </tr>
                                    <?php $idDiv++; $sTT++; ?>
                                    <?php } ?>
                                    <?php else: ?>
                                     <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                       <td colspan="6" style="padding-top:10px; font-size:14px; text-align:center;">Không có dữ liệu!</td>
                                    </tr>
                                    <?php endif; ?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                    </tr>
                                </table>
                                <!--END Content-->
                            </td>
                        </tr>
                        </form>
                    </table>
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
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
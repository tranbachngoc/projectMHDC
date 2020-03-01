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
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <a href="<?php echo base_url(); ?>administ/system/payment">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/information-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('payment_title'); ?></td>
                                        
                                        <td width="55%" height="67" class="item_menu_right">
                                            
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/system/payment')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_EditPayment()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_save.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('save_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                            
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
                            <td align="center" valign="top">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    
                                    <tr>
                                        <td width="20" height="20" class="corner_lt_post"></td>
                                        <td height="20" class="top_post"></td>
                                        <td width="20" height="20" class="corner_rt_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="left_post"></td>
                                        <td align="center" valign="top">
                                            <!--BEGIN: PAYMENT INFO-->
                                            <form method="POST" id="payment_info">
                                            <table>
                                                <tr>
                                                    <td width="50%" valign="top" nowrap="nowrap">
                                                        <div class="payment-title">
                                                            <label>Thanh toán qua Cổng Thanh Toán Ngân Lượng</label>
                                                        </div>
                                                        <div class="<?php echo ($payment->info_nganluong) ? '' : 'none' ?>" id="div_pm_type3">
                                                            <input type="text" style="width: 200px;" value="<?php echo $payment->info_nganluong ?>" name="info_nganluong" class="form_control">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" valign="top" nowrap="nowrap">
                                                        <div  class="payment-title">
                                                            <label for="pm_type_id2">Thanh toán khi nhận hàng</label>
                                                        </div>
                                                        <div class="<?php echo ($payment->info_cod) ? '' : 'none' ?>" id="div_pm_type2">
                                                            <textarea style="width: 700px; height: 200px;" name="info_cod" class="form_control"><?php echo $payment->info_cod ?></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" valign="top" nowrap="nowrap">
                                                        <div  class="payment-title"
                                                            <label for="pm_type_id4">Chuyển khoản qua Ngân hàng</label>
                                                        </div>
                                                        <div class="<?php echo ($payment->info_bank) ? '' : 'none' ?>" id="div_pm_type4">

                                                            <?php $this->load->view('admin/common/tinymce'); ?>
                                                            <textarea style="width: 700px; height: 400px;" name="info_bank" class="form_control">
                                                                <?php
                                                                $vovel = array("&curren;");
                                                                echo html_entity_decode(str_replace($vovel, "#", $payment->info_bank));
                                                                ?>
                                                            </textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            </form>
                                            <!--END: PAYMENT INFO-->
                                        </td>
                                        <td width="20" class="right_post">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" height="20" class="corner_lb_post"></td>
                                        <td height="20" class="bottom_post"></td>
                                        <td width="20" height="20" class="corner_rb_post"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
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


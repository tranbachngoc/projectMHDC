<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<style>
.red_money {
    float: right;
}
.red_money {
    color: #CC0000;
    font-weight: bold;
}    
</style>
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
                                            <a href="<?php echo base_url(); ?>administ/recharge">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $page['title'] ?></td>
                                        <td width="55%" height="67" class="item_menu_right"></td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <?php  if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){ ?>
                            <tr>
                                <td height="5">
                                    <div class="message success" onclick="this.classList.add('hidden')">
                                        <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                                            <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php  } ?>
                       
                            <tr>
                                <td align="center" valign="top">
                                    <?php echo $service_charts; ?>
                                </td>
                            </tr>
                    </table>
                    <!--END Main-->
                </td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
    <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top"><!--BEGIN: Main-->

                    <form action="" method="post">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td>
                                    <!--BEGIN: Item Menu-->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="5%" height="67" class="item_menu_left"><img src="<?php echo base_url(); ?>templates/admin/images/item_addadvertise.gif" border="0" /></td>
                                            <td width="40%" height="67" class="item_menu_middle">Chỉnh sửa</td>
                                            <td width="55%" height="67" class="item_menu_right">
                                                <a class="btn btn-default" href="<?php echo base_url(); ?>administ/advertiseconfig"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Quay lại</a>
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
                                            <td align="center" valign="top"><!--BEGIN: Content-->
                                                <form name="frmAddAdvertise" method="post" enctype="multipart/form-data">
                                                    <table width="100%" class="form_main" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td colspan="2" height="30" class="form_top"></td>
                                                        </tr>
                                                        <?php if($successEdit == false){ ?>
                                                            <tr>
                                                                <td width="150" valign="top" class="list_post">
                                                                    <span style="color: #FF0000; "><b>*</b></span> <label for="title_adv"><?php echo $this->lang->line('title_title_add'); ?>:</label>
                                                                </td>
                                                                <td align="left">
                                                                    <input type="text" name="title_adv" id="title_adv" value="<?php echo $title_adv; ?>" maxlength="80" class="form-control"  />
                                                                    <span class="text-danger"><?php echo form_error('title_adv'); ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="150" valign="top" class="list_post">
                                                                    <span style="color: #FF0000; "><b>*</b></span> <label for="price_adv">Giá:</label>
                                                                </td>
                                                                <td align="left">
                                                                    <input type="text" name="price_adv" id="price_adv" value="<?php echo $price_adv; ?>" maxlength="80" class="form-control"  />
                                                                    <span class="text-danger"> <?php echo form_error('price_adv'); ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="150" valign="top" class="list_post">
                                                                    <label for="type_adv">Trang:</label>
                                                                </td>
                                                                <td align="left">
                                                                    <input type="text" name="type_adv" id="type_adv" value="<?php echo $type_adv; ?>" maxlength="80" class="form-control"  />
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_add'); ?>:</td>
                                                                <td align="left" style="padding-top:7px;"><input type="checkbox" name="status" id="status" value="1" <?php echo ($status == 1) ? 'checked="checked"' : '' ; ?>  /></td>
                                                            </tr>

                                                        <?php }else{ ?>
                                                            <tr class="success_post">
                                                                <td colspan="2"><p class="text-center"><a href="<?php echo base_url().'administ/advertiseconfig' ?>">Click vào đây để tiếp tục</a></p>
                                                                    <?php echo $this->lang->line('success_add'); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <td colspan="2" height="30" class="form_bottom"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Cập nhật</button> <button class="btn btn-danger" type="reset"><i class="fa fa-times"></i> Hủy</button></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                                <!--END Content--></td>
                                            <td width="20" class="right_post"></td>
                                        </tr>

                                        <tr>
                                            <td width="20" height="20" class="corner_lb_post"></td>
                                            <td height="20" class="bottom_post"></td>
                                            <td width="20" height="20" class="corner_rb_post"></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                    </form>

                    <!--END Main--></td>
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
        </table></td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>

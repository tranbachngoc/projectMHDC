<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php
$cat_type = $this->uri->segment(5);
if ($cat_type == 1) {
    $url = '/service';
} elseif ($cat_type == 2) {
    $url = '/coupon';
} else {
    $url = '';
}
?>
<tr>
    <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top"><!--BEGIN: Main-->

                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td><!--BEGIN: Item Menu-->

                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left"><img src="<?php echo base_url(); ?>templates/admin/images/item_editcategory.gif" border="0" /></td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_edit'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right"><?php if ($successEdit == false) { ?>

                                                <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url() . 'administ/category' . $url; ?>')" onmouseover="ChangeStyleIconItem('icon_item_1', 1)" onmouseout="ChangeStyleIconItem('icon_item_1', 2)">
                                                    <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="icon_item" id="icon_item_2" onclick="CheckInput_EditCategory()" onmouseover="ChangeStyleIconItem('icon_item_2', 1)" onmouseout="ChangeStyleIconItem('icon_item_2', 2)">
                                                    <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_save.png" border="0" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('save_tool'); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            <?php } else { ?>
                                                <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/category/add')" onmouseover="ChangeStyleIconItem('icon_item_2', 1)" onmouseout="ChangeStyleIconItem('icon_item_2', 2)">
                                                    <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            <?php } ?></td>
                                    </tr>
                                </table>

                                <!--END Item Menu--></td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="20" height="20" class="corner_lt_post"></td>
                                        <td height="20" class="top_post"></td>
                                        <td width="20" height="20" class="corner_rt_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="left_post"></td>
                                        <td align="left" valign="top"><!--BEGIN: Content-->
                                            <form name="frmEditCategory" method="post" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <?php if ($successEdit == false) {
                                                        ?>

                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Chọn Danh Mục Cha:</td>
                                                            <td align="left"><input type="hidden" name="parent_id" id="parent_id" value="<?php echo $parent_id; ?>"/>
                                                                <input type="hidden" name="cat_index" id="cat_index" value="<?php echo $cat_index; ?>"/>
                                                                <input type="hidden" name="cat_level" id="cat_level" value="<?php echo $cat_level; ?>"/>
                                                                <div id="parent_0" style="float: left; display: inline;">
                                                                    <select id="cat_select_0" onchange="check_cat_edit_pr(this.value, 0, '<?php echo base_url() . 'administ/'; ?>',<?php echo $cat_type ?>);">
                                                                        <option value="0-<?php echo $next_index; ?>">Thư mục gốc</option>
                                                                        <?php
                                                                        if (isset($catlevel0)) {
                                                                            foreach ($catlevel0 as $item) {
                                                                                ?>
                                                                                <option <?php
                                                                                if (isset($parent_id_0) && $parent_id_0 == $item->cat_id) {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?> value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?>
                                                                                        <?php
                                                                                        if ($item->child_count > 0) {
                                                                                            echo ' >';
                                                                                        }
                                                                                        ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div id="parent_1" style="float: left; display: inline; margin-left: 15px;">
                                                                    <?php if (isset($catlevel1)) { ?>
                                                                        <select id="cat_select_1" onchange="check_cat_edit_pr(this.value, 1, '<?php echo base_url() . 'administ/'; ?>',<?php echo $cat_type ?>);">
                                                                            <option value="0-<?php echo $next_index; ?>">Thư mục gốc</option>
                                                                            <?php foreach ($catlevel1 as $item) { ?>
                                                                                <option <?php
                                                                                if (isset($parent_id_1) && $parent_id_1 == $item->cat_id) {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?> value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?>
                                                                                        <?php
                                                                                        if ($item->child_count > 0) {
                                                                                            echo ' >';
                                                                                        }
                                                                                        ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    <?php } ?>
                                                                </div>
                                                                <div id="parent_2" style="float: left; display: inline; margin-left: 15px;">
                                                                    <?php if (isset($catlevel2)) { ?>
                                                                        <select id="cat_select_2" onchange="check_cat_edit_pr(this.value, 2, '<?php echo base_url() . 'administ/'; ?>',<?php echo $cat_type ?>);">
                                                                            <option value="0-<?php echo $next_index; ?>">Thư mục gốc</option>
                                                                            <?php foreach ($catlevel2 as $item) { ?>
                                                                                <option <?php
                                                                                if (isset($parent_id_2) && $parent_id_2 == $item->cat_id) {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?> value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?>
                                                                                        <?php
                                                                                        if ($item->child_count > 0) {
                                                                                            echo ' >';
                                                                                        }
                                                                                        ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    <?php } ?>
                                                                </div>
                                                                <div id="parent_3" style="float: left; display: inline; margin-left: 15px;">
                                                                    <?php if (isset($catlevel3)) { ?>
                                                                        <select id="cat_select_3" onchange="check_cat_edit_pr(this.value, 3, '<?php echo base_url() . 'administ/'; ?>',<?php echo $cat_type ?>);">
                                                                            <option value="0-<?php echo $next_index; ?>">Thư mục gốc</option>
                                                                            <?php foreach ($catlevel3 as $item) { ?>
                                                                                <option <?php
                                                                                if (isset($parent_id_3) && $parent_id_3 == $item->cat_id) {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?> value="<?php echo $item->cat_id; ?>"><?php echo $item->cat_name; ?>
                                                                                        <?php
                                                                                        if ($item->child_count > 0) {
                                                                                            echo ' >';
                                                                                        }
                                                                                        ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    <?php } ?>
                                                                </div>
                                                                <div id="parent_4" style="float: left; display: inline; margin-left: 15px;">

                                                                </div>
                                                            </td>
                                                        </tr>

                                                                                                                                                                                                <!--<tr>
                                                                                                                                                                                                        <td style="width:25%" valign="top" class="list_post">Hình đại diện:</td>
                                                                                                                                                                                                        <td align="left" style="padding-top:7px;"><input type="file" name="image_category" id="image_category"  /></td>
                                                                                                                                                                                                </tr>-->
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_edit'); ?>:</td>
                                                            <td align="left"><input type="text" name="name_category" id="name_category" value="<?php echo $name_category; ?>" maxlength="60" class="input_formpost" onkeyup="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('name_category', 1)" onblur="ChangeStyle('name_category', 2)" />
                                                                <?php echo form_error('name_category'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"></font> <?php echo $this->lang->line('descr_edit'); ?>:</td>
                                                            <td align="left"><input type="text" name="descr_category" id="descr_category" value="<?php echo $descr_category; ?>"  class="input_formpost" onkeyup="BlockChar(this, 'SpecialChar')" onfocus="ChangeStyle('descr_category', 1)" onblur="ChangeStyle('descr_category', 2)" />
                                                                <?php echo form_error('descr_category'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Keyword:</td>
                                                            <td align="left">
                                                                <input type="text" name="keyword" id="keyword"
                                                                       value="<?php echo $keyword ?>" class="input_formpost"
                                                                       >
                                                                       <!--<input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="255" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" />-->

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Thẻ H1:</td>
                                                            <td align="left">
                                                                <input type="text" name="h1tag" id="h1tag" value="<?php echo $h1tag ?>" class="input_formpost">
                                                                <!--<input type="text" name="h1tag" id="h1tag" value="<?php echo $h1tag; ?>" maxlength="255" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('h1tag',1)" onblur="ChangeStyle('h1tag',2)" />--></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Phí(%):</td>
                                                            <td align="left"><input type="text" name="cat_fee" id="cat_fee" value="<?php echo $cat_fee; ?>" maxlength="255" class="input_formpost"  /></td>
                                                        </tr>
                                                        <tr class="">
                                                            <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"></font> <?php echo $this->lang->line('image_edit'); ?>:</td>
                                                            <td align="left" valign="top">
                                                                <!--post image category-->    
                                                                <input type="file" name="image_category" id="image_category" class="input_formpost" />
                                                                <?php echo form_error('image_category'); ?>
                                                                <br>
                                                                <?php if ($image_category != "") { ?>
                                                                    <img id="imgpreview" src="<?php echo DOMAIN_CLOUDSERVER . '/media/images/categories/' . $image_category ?>" alt="" style="width:200px; height:200px" />
                                                                <?php } else { ?>
                                                                    <img id="imgpreview" src="/images/img_not_available.png" alt="" style="width:200px; height:200px" />
                                                                <?php } ?>
                                                                <input type="hidden" name="image_category_old" id="image_category_old" value="<?php $image_category ?>" />																													    
                                                                <script>
                                                                    function readURL(input) {
                                                                        if (input.files && input.files[0]) {
                                                                            var reader = new FileReader();
                                                                            reader.onload = function (e) {
                                                                                $('#imgpreview').attr('src', e.target.result);
                                                                            }
                                                                            reader.readAsDataURL(input.files[0]);
                                                                        }
                                                                    }
                                                                    $("#image_category").change(function () {
                                                                        readURL(this);
                                                                    });
                                                                </script>
                                                                <!--post image category-->  	
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('order_edit'); ?>:</td>
                                                            <td align="left"><input type="text" name="order_category" id="order_category" value="<?php
                                                                if ($order_category != '') {
                                                                    echo $order_category;
                                                                } else {
                                                                    echo '1';
                                                                }
                                                                ?>" maxlength="4" class="inputorder_formpost" onkeyup="BlockChar(this, 'NotNumbers')" onfocus="ChangeStyle('order_category', 1)" onblur="ChangeStyle('order_category', 2)" />
                                                                <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('order_tip_help'); ?>', 155, '#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <?php echo form_error('order_category'); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post"><?php echo $this->lang->line('status_edit'); ?>:</td>
                                                            <td align="left" style="padding-top:7px;"><input type="checkbox" name="active_category" id="active_category" value="1" <?php
                                                                if ($active_category == '1') {
                                                                    echo 'checked="checked"';
                                                                }
                                                                ?> /></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Danh mục nóng:</td>
                                                            <td align="left" style="padding-top:7px;"><input type="checkbox" name="cat_hot" id="cat_hot" value="1"  <?php
                                                                if ($cat_hot == 1) {
                                                                    echo 'checked';
                                                                }
                                                                ?> /></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:25%" valign="top" class="list_post">Danh mục dịch vụ:</td>
                                                            <td align="left" style="padding-top:7px;">
                                                                <input type="checkbox" name="cat_service" id="cat_service" value="1"  <?php
                                                                if ($cat_service == 1) {
                                                                    echo 'checked';
                                                                }
                                                                ?>  />
                                                            </td>
                                                        </tr>

                                                    <?php } else { ?>
                                                        <tr class="success_post">
                                                            <td colspan="2"><p class="text-center"><a href="<?php echo base_url() . 'administ/category' ?>">Click vào đây để tiếp tục</a></p>
                                                                <?php echo $this->lang->line('success_edit'); ?></td>
                                                        </tr>
                                                    <?php } ?>
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

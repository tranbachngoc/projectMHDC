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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/item_addcategory.gif" border="0" />
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_add'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url().'administ/category'.$url1.'/add'; ?>')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
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
                                            <!--BEGIN: Content-->
                                            <form name="frmAddCategory" method="post">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td style="width:10%"  valign="top" class="list_post">Chọn Danh Mục Cha:</td>
                                                        <td align="left" class="parent_cat">
                                                            <input type="hidden" name="parent_id" id="parent_id" value=""/>
                                                            <input type="hidden" name="cat_index" id="cat_index" value="<?php echo $next_index;?>"/>
                                                            <input type="hidden" name="cat_level" id="cat_level" value="0"/>
                                                            <div id="parent_0" style="float: left; display: inline; margin-left: 0" class="parent_cat_select" >
                                                                <select id="cat_select_0" size="10">
                                                                    <option>Thư mục gốc</option>
                                                                    <?php if(!empty($categories_parent)){ ?>
                                                                        <?php foreach($categories_parent as $item){ ?>
                                                                            <option value="<?php echo $item['id'] ?>" title="<?php echo $item['name'];?>"><?php echo $item['name'];?></option>
                                                                        <?php }?>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <tr class="k_displaynone">
                                                        <td style="width:25%" valign="top" class="list_post"><?php echo $this->lang->line('image_add'); ?>:</td>
                                                        <td align="left">
                                                            <select name="image_category" id="image_category" class="selectimage_formpost" onchange="ShowImage('image_category','DivShowImage', '<?php echo base_url(); ?>templates/home/images/category')">
                                                                <option value=""><?php echo $this->lang->line('select_image_add'); ?></option>
                                                                <?php foreach($image as $imageArray){ ?>
                                                                    <option value="<?php echo $imageArray; ?>" <?php if($imageArray == $image_category){echo 'selected="selected"';} ?>><?php echo $imageArray; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span id="DivShowImage"></span>
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help_add'); ?>',205,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                            <?php echo form_error('image_category'); ?>
                                                            <?php if($image_category != ''){ ?>
                                                                <script>ShowImage('image_category','DivShowImage', '<?php echo base_url(); ?>templates/home/images/category');</script>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Tên danh mục liên kết:</td>
                                                        <td align="left">
                                                            <input type="text" name="name" id="name" value="<?php echo @$name ?>" class="input_formpost"/>
                                                            <?php echo form_error('name'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"></font> Đường dẫn danh mục liên kết:</td>
                                                        <td align="left">
                                                            <input type="text" name="slug" id="slug" value="<?php echo @$slug; ?>"/>
                                                            <?php echo form_error('slug'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Thứ tự:</td>
                                                        <td align="left">
                                                            <input type="text" name="order_category" id="odering" value="<?php echo @$odering;  ?>" />
                                                            <?php echo form_error('order_category'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" valign="top" class="list_post">Trạng thái :</td>
                                                        <td align="left" style="padding-top:7px;">
                                                            <input type="checkbox" name="active_category" id="active_category" checked="checked" value="1" <?php //if($active_category == '1'){echo 'checked="checked"';} ?> />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" valign="top" class="list_post">Danh mục HOT :</td>
                                                        <td align="left" style="padding-top:7px;">
                                                            <input type="checkbox" name="cat_hot" id="cat_hot" value="1"  <?php if($cat_hot == '1'){echo 'checked';} ?> />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            <!--END Content-->
                                        </td>
                                        <td width="20" class="right_post"></td>
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
<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php $url  = $this->uri->segment(3);
      $url1 = '/'.$url;
 ?>
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
                                            <a href="<?php echo base_url(); ?>administ/category">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/home-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_defaults').' '.$url; ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmCategory')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
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
                                            <div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/category?rebuild=1')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/save.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap">Build Cache</td>
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
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/category/search/name/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/category/',1)" class="select_search">

                                                <option value="name"><?php echo $this->lang->line('name_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/category/',1)" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/category/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>
                                            </select>
                                        </td>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/category/',2)" alt="<?php echo $this->lang->line('filter_tip'); ?>" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmCategory" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table style="table-layout: fixed; width: 100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" class="title_list">STT</td>
                                        <td width="1%" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmCategory',0)" />
                                        </td>
                                        <td width="10%" class="title_list k_displaynone">
                                            <?php echo $this->lang->line('image_list'); ?>
                                        </td>
                                        <td width="25%" class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                        </td>
                                        <td width="15%" class="title_list">
                                            <?php echo $this->lang->line('descr_list'); ?>
                                        </td>
                                        <td width="15%"  class="title_list">
                                            Keyword
                                        </td>
                                         <td width="10%" class="title_list">
                                            Thẻ H1
                                        </td>
                                        <td width="5%" class="title_list">
                                            <?php echo $this->lang->line('order_list'); ?>
                                        </td>
                                        <td width="4%" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                        <td  width="5%" class="title_list">
                                            <?php echo $this->lang->line('id_list'); ?>
                                        </td>
                                    </tr>
                                    <?php $idDiv = 1; ?>
                                    <?php
                                    foreach($category as $categoryArray){
                                        if (($url == 'service' && $categoryArray->cate_type == 1) || ($url == 'coupon' && $categoryArray->cate_type == 2) || ($url == '' && $categoryArray->cate_type == 0)){
                                        ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $categoryArray->cat_id; ?>" onclick="DoCheckOne('frmCategory')" />
                                        </td>
                                        <td class="detail_list k_displaynone" style="text-align:center;">
                                            <?php if (!empty($categoryArray->cat_image)){ ?>
                                                <img  src="<?php echo base_url(); ?>templates/home/images/category/<?php echo $categoryArray->cat_image; ?>" border="0" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list">

                                            <a class="menu" href="<?php echo base_url(); ?>administ/category/edit/<?php echo $categoryArray->cat_id; ?>/<?php echo $categoryArray->cate_type; ?>" alt="<?php echo $this->lang->line('edit_tip'); ?>">
                                            <?php $pre = 'cat_leve'.$categoryArray->cat_level.'q'; ?>
                                            <span class="<?php echo $pre; ?>">
                                                <?php echo $categoryArray->cat_name; ?>
                                                </span>
                                            </a>

                                        </td>
                                        <td class="detail_list">
                                            <?php echo $categoryArray->cat_descr; ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php echo $categoryArray->keyword; ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php echo $categoryArray->h1tag; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <b><?php echo $categoryArray->cat_order; ?></b>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($categoryArray->cat_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatusCat('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $categoryArray->cat_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatusCat('<?php echo $statusUrl; ?>/status/active/id/<?php echo $categoryArray->cat_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $categoryArray->cat_id; ?>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } }?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="8"><?php //echo $linkPage; ?></td>
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
<script>
    function ActionStatusCat(isAddress) {
        alert("Cập nhập thành công! Khi cập nhật xong toàn bộ danh mục, vui lòng Build cache để hệ thống cập nhật lại!");
        window.location.href = isAddress;
    }
</script>
<?php $this->load->view('admin/common/footer'); ?>
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
                                            <a href="<?php echo base_url(); ?>administ/category">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/home-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Danh mục gian hàng</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                         
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/shop/danhmuc/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/shop/danhmuc/search/name/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/danhmuc/',1)" class="select_search">
                                               
                                                <option value="name">Danh mục</option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/danhmuc/',1)" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/danhmuc/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>
                                            </select>
                                        </td>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/danhmuc/',2)" alt="<?php echo $this->lang->line('filter_tip'); ?>" />
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
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>                                     
                                        <td width="60" class="title_list k_displaynone">
                                            <?php echo $this->lang->line('image_list'); ?>
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                           
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('descr_list'); ?>
                                        </td>
                                        <td class="title_list">
                                            Keyword
                                        </td>
                                         <td class="title_list">
                                            Thẻ H1
                                        </td>
                                        <td width="90" class="title_list">
                                            <?php echo $this->lang->line('order_list'); ?>
                                           
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('id_list'); ?>
                                            
                                        </td>
                                          <td width="60" class="title_list">
                                          
                                        Xóa
                                        </td>
                                    </tr>                                    
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($category as $categoryArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $idDiv++; ?></b></td>
                                      
                                        <td class="detail_list k_displaynone" style="text-align:center;">
                                            <img  src="<?php echo base_url(); ?>templates/home/images/category/<?php echo $categoryArray->cat_image; ?>" border="0" />
                                        </td>
                                        <td class="detail_list">
                                        
                                            <a class="menu" href="<?php echo base_url(); ?>administ/shop-danhmuc/edit/<?php echo $categoryArray->cat_id; ?>" alt="<?php echo $this->lang->line('edit_tip'); ?>">
                                            <?php $pre = 'cat_leve0q'; if($categoryArray->cat_level == 1){$pre = 'cat_leve1q';} if($categoryArray->cat_level == 2){$pre = 'cat_leve2q';}?>
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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $categoryArray->cat_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $categoryArray->cat_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $categoryArray->cat_id; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                        <a href="<?php echo base_url(); ?>administ/shop/danhmuc/delete/<?php echo $categoryArray->cat_id;  ?>">
                                           <img  src="<?php echo base_url(); ?>templates/home/images/icon_remove_small1.gif" />
                                           </a>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
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
<?php $this->load->view('admin/common/footer'); ?>
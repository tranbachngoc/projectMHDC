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
                                        <td width="5%" height="67" class="item_menu_left text-center">
                                            <a href="<?php echo $filterSr; ?>">
                                            	<img src="<?php echo base_url(); ?>templates/home/icons/black/icon-report.png" border="0" style="width: 40px;"/>
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Báo cáo sản phẩm</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActDel('frmReport')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/contact/search/title/keyword/','keyword')"  />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo $filterSr; ?>',1)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                <option value="title" <?php if($filtersearch == 'title'){ echo 'selected'; } ?>><?php echo $this->lang->line('title_search_defaults'); ?></option>
                                                <option value="username" <?php if($filtersearch == 'username'){ echo 'selected'; } ?>><?php echo $this->lang->line('username_search_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo $filterSr; ?>',1)" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/contact/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="datereply">Ngày đăng</option>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_1" width="10" align="center"><b>:</b></td>
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
                                        <script>OpenTabSearch('0',0);</script>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo $filterSr; ?>',2)" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmReport" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmReport',0)" />
                                        </td>
                                        <td class="title_list">
                                            Sản phẩm
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('username_contact_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
<!--                                        <td width="100" class="title_list">
                                            Người báo cáo
                                        </td>-->
                                        <td width="" class="title_list">
                                            id bài viết
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>id/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="" class="title_list">
                                            Ngày đăng
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="150" class="title_list">
                                            Số lượt báo cáo
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>id/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="150" class="title_list">
                                            Hành động
                                        </td>
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1;?>
                                    <?php foreach($reports as $listreport){ 
                                        $a = 'http://'.domain_site.'/'.$listreport->pro_category.'/'.$listreport->pro_id.'/'.RemoveSign($listreport->pro_name);
                                        ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $listreport->id; ?>" onclick="DoCheckOne('frmReport')" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo $a; ?>" target="_blank" alt="<?php echo $listreport->pro_name; ?>">
                                                <?php echo $listreport->pro_name; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $listreport->use_id; ?>" alt="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $listreport->use_username; ?>
                                            </a>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('fullname_tip_defaults') ?>&nbsp;<?php echo $listreport->use_fullname; ?><br /><?php echo $this->lang->line('email_tip_defaults') ?>&nbsp;<?php echo $listreport->use_email; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                        </td>
<!--                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $listreport->byuser; ?>
                                        </td>-->
                                        <td class="detail_list" style="text-align:center;">
                                            <b><?php echo $listreport->pro_id; ?></b>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo date('d-m-Y', $listreport->pro_begindate); ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php echo $listreport->cntReport; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <a href="<?php echo $filterSr; ?>detail/<?php echo $listreport->pro_id; ?>"><b>Xem và xử lý</b>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php }?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="10"><?php echo $linkPage; ?></td>
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
    function ActDel(formName){
        alert('Bạn không thể thực hiện chức năng này');
    }
</script>
<?php $this->load->view('admin/common/footer'); ?>
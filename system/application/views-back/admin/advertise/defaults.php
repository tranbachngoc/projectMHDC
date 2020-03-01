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
                                            <a href="<?php echo base_url(); ?>administ/advertise">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/megaphone-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_defaults'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmAdvertise')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/advertise/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/advertise/end')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expiry.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('end_tool'); ?></td>
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/advertise/search/title/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/advertise/',1)" class="select_search">
                                    <!--            <option value="0"><?php //echo $this->lang->line('search_by_search'); ?></option>-->
                                                <option value="title"><?php echo $this->lang->line('title_search_defaults'); ?></option>
                                                <option value="link"><?php echo $this->lang->line('link_search_defaults'); ?></option>
                                                <option value="advertiser"><?php echo $this->lang->line('advertiser_search_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/advertise/',1)" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/advertise/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="begindate"><?php echo $this->lang->line('begindate_search'); ?></option>
                                                <option value="enddate"><?php echo $this->lang->line('enddate_search'); ?></option>
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>
                                                <option value="header"><?php echo $this->lang->line('header_search_defaults'); ?></option>
                                                <option value="footer"><?php echo $this->lang->line('footer_search_defaults'); ?></option>
                                                <option value="left"><?php echo $this->lang->line('left_search_defaults'); ?></option>
                                                <option value="right"><?php echo $this->lang->line('right_search_defaults'); ?></option>
                                                <option value="top"><?php echo $this->lang->line('top_search_defaults'); ?></option>
                                                <option value="bottom"><?php echo $this->lang->line('bottom_search_defaults'); ?></option>
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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/advertise/',2)" alt="<?php echo $this->lang->line('filter_tip'); ?>" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmAdvertise" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAdvertise',0)" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('title_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('advertiser_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>advertiser/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>advertiser/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            Hình ảnh
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('link_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>link/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>link/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>

                                        <td width="80" class="title_list">
                                            <?php echo $this->lang->line('position_list'); ?> / Danh mục
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>position/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>position/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="90" class="title_list">
                                            <?php echo $this->lang->line('order_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>order/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>order/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('begindate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('enddate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($advertise as $advertiseArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $advertiseArray->adv_id; ?>" onclick="DoCheckOne('frmAdvertise')" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url() ?>administ/advertise/edit/<?php echo $advertiseArray->adv_id; ?>" alt="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $advertiseArray->adv_title; ?>
                                            </a>
                                            <?php if(file_exists("media/banners/".$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner) && $advertiseArray->adv_banner != '' && get_mime_by_extension("media/banners/".$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner) && stristr(strtolower(get_mime_by_extension($advertiseArray->adv_banner)), 'image/')){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                            <?php }elseif(file_exists("media/banners/".$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner) && $advertiseArray->adv_banner != '' && get_mime_by_extension("media/banners/".$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner) && stristr(strtolower(get_mime_by_extension($advertiseArray->adv_banner)), 'shockwave-flash')){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('banner_flash_defaults'); ?>',75,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
											<?php }else{ ?>
											<img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('none_banner_defaults'); ?>',100,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
											<?php } ?>
                                        </td>
                                        <td class="detail_list">
                                            <b><?php echo $advertiseArray->adv_fullname; ?></b>
                                            <br>
                                            Username: <a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $advertiseArray->use_id; ?>"><?php echo $advertiseArray->use_username; ?></a>
                                            <br>Phone: <b><?php echo $advertiseArray->use_mobile; ?></b>
                                            <br>Email: <?php echo $advertiseArray->use_email; ?>


                                        </td>
                                        <td class="detail_list">
                                            <img src="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" width="200" />
                                            <br> <br>
                                            <a class="menu" href="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" target="_blank">Xem ảnh</a>
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo prep_url($advertiseArray->adv_link); ?>" target="_blank"><?php echo $advertiseArray->adv_link; ?></a>
                                        </td>

                                        <td class="detail_list" style="text-align:center;">
    <?php if($advertiseArray->adv_page == "home"){ ?>- <?php echo $advertiseArray->cat_name; ?>
                                            <br>
                                            - <?php echo $advertiseArray->pre_name; ?>
                                            <br>
        <?php } ?>
                                            <?php if($advertiseArray->adv_position == 1){ ?>
                                            <?php echo $this->lang->line('header_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 2){ ?>
                                            <?php echo $this->lang->line('footer_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 3){ ?>
                                            <?php echo $this->lang->line('left_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 4){ ?>
                                            <?php echo $this->lang->line('right_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 5){ ?>
                                            <?php echo $this->lang->line('top_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 6){ ?>
                                            <?php echo $this->lang->line('center1_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 7){ ?>
                                            <?php echo $this->lang->line('center2_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 8){ ?>
                                            <?php echo $this->lang->line('center3_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 9){ ?>
                                            <?php echo $this->lang->line('slide_add') ?>
                                            <?php }elseif($advertiseArray->adv_position == 10){ ?>
                                            <?php echo $this->lang->line('header') ?>
                                            <?php }elseif($advertiseArray->adv_position == 11){ ?>
                                            <?php echo $this->lang->line('header1') ?>
                                            <?php }elseif($advertiseArray->adv_position == 12){ ?>
                                            <?php echo $this->lang->line('top1_add'); }
											else if($advertiseArray->adv_position == 13) {
												echo $this->lang->line('top2_add');
											} else  if($advertiseArray->adv_position == 14) {
                                                echo $this->lang->line('bottom1_add');
                                            } else  if($advertiseArray->adv_position == 15) {
                                                echo $this->lang->line('bottom2_add');
											} else  {?>
                                            <?php echo $this->lang->line('bottom_defaults') ?>
                                            <?php }?>
                                            <br>
                                            <br>
                                            <?php if($advertiseArray->adv_page == "home"){ ?><a class="menu" target="_blank" href="<?php echo base_url(); ?><?php echo $advertiseArray->cat_id; ?>/<?php echo RemoveSign($advertiseArray->cat_name); ?>">Xem banner hiển thị tại Danh mục</a> <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <b><?php echo $advertiseArray->adv_order; ?></b>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($advertiseArray->adv_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $advertiseArray->adv_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $advertiseArray->adv_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $advertiseArray->adv_begindate); ?></b></td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $advertiseArray->adv_enddate); ?></b></td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
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
<?php $this->load->view('admin/common/footer'); ?>
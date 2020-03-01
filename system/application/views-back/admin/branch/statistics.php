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
                                                <a href="<?php echo base_url(); ?>administ/branch/statistical">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo "Thống kê gian hàng"; ?></td>
                                            <td width="55%" height="67" class="item_menu_right">
                                                <?php if(false):?>
                                                    <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmUser')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                                    <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                                <?php endif;?>
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
                                    <form action="<?php echo $link; ?>" method="post" class="">
                                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>

                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="160" align="left">
                                                    <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/user/alluser/search/username/keyword/','keyword')" />
                                                </td>
                                                <td width="120" align="left">
                                                    <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/user/alluser/',1)" class="select_search">
                                                        <option value="saler"><?php echo $this->lang->line('username_search'); ?></option>
                                                    </select>
                                                </td>
                                                <?php $getallaf = $this->uri->segment(3); ?>
                                                <td align="left">
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/branch/<?php echo $getallaf; ?>/',1)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
                                                </td>
                                                <!---->
                                                <td width="115" align="left">
                                                    <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/branch/<?php echo $getallaf; ?>/',2)" class="select_search">
                                                    <option value=""><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                    <option value="statisticaldate"><?php echo $this->lang->line('payment_title_search'); ?></option>
                                                    </select>
                                                </td>
                                                <td id="DivDateSearch_1" width="100" align="center"><b>Từ ngày:</b></td>
                                                <td id="DivDateSearch_2" width="60" align="left">
                                                    <select name="day" id="day" class="select_datesearch">
                                                        <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                        <?php for($day = 1; $day <= 31; $day++){ ?>
                                                            <?php if($day != $daypost) { ?>
                                                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $day; ?>" selected><?php echo $day;?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                                <td id="DivDateSearch_4" width="60" align="left" style="display: block !important;">
                                                    <select name="month" id="month" class="select_datesearch" >
                                                        <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                        <?php for($month = 1; $month <= 12; $month++){ ?>
                                                            <?php if($month != $monthpost) { ?>
                                                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $month; ?>" selected><?php echo $month;?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>

                                                </td>
                                                <td id="DivDateSearch_5" width="10" align="center" ><b>-</b></td>
                                                <td id="DivDateSearch_6" width="60" align="left">
                                                    <select name="year" id="year" class="select_datesearch" >
                                                        <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                        <?php for($year = 2000; $year <= 2050; $year++){ ?>
                                                            <?php if($year != '20'.$yearpost) { ?>
                                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $year; ?>" selected><?php echo $year;?></option>
                                                            <?php }} ?>
                                                    </select>
                                                </td>
                                                <td id="DivDateSearch_7" width="10" align="center"><b>-</b></td>
                                                <td id="DivDateSearch_8" width="60" align="left">
                                                </td>
                                                <td id="DivDateSearch_9" width="40" align="center"><b>Đến :</b></td>
                                                <td id="DivDateSearch_10" width="60" align="left">
                                                    <select name="tday" id="tday" class="select_datesearch">
                                                        <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                        <?php for($day = 1; $day <= 31; $day++){ ?>
                                                            <?php if($day != $tdaypost) { ?>
                                                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $day; ?>" selected><?php echo $day;?></option>
                                                            <?php }} ?>
                                                    </select>
                                                </td>
                                                <td id="DivDateSearch_11" width="10" align="center"><b>-</b></td>
                                                <td id="DivDateSearch_12" width="60" align="left">
                                                    <select name="tmonth" id="tmonth" class="select_datesearch">
                                                        <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                        <?php for($month = 1; $month <= 12; $month++){ ?>
                                                            <?php if($month != $tmonthpost) { ?>
                                                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $month; ?>" selected><?php echo $month;?></option>
                                                            <?php }} ?>
                                                    </select>
                                                </td>
                                                <td id="DivDateSearch_13" width="10" align="center"><b>-</b></td>
                                                <td id="DivDateSearch_14" width="60" align="left">
                                                    <select name="tyear" id="tyear" class="select_datesearch">
                                                        <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                        <?php for($year = 2000; $year <= 2050; $year++){ ?>
                                                            <?php if($year != '20'.$tyearpost) { ?>
                                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $year; ?>" selected><?php echo $year;?></option>
                                                            <?php }} ?>
                                                    </select>
                                                </td>
                                                <?php 	$getallaf = $this->uri->segment(3); ?>
                                                <script>OpenTabSearch('0',0);</script>
                                                <td width="25" align="right">
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/branch/statistical/',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <!--END Search-->
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <form name="frmUser" method="post">
                                <tr>
                                    <td>
                                        <!--BEGIN: Content-->
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="25" class="title_list">STT</td>
                                                <td width="20" class="title_list">
                                                    <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmUser',0)" />
                                                </td>
                                                <td class="title_list">
                                                    <?php echo $this->lang->line('username_list'); ?>
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    Người giới thiệu
                                                </td>
                                                <td class="title_list">
                                                    <?php echo $this->lang->line('fullname_list'); ?>
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>fullname/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td class="title_list">
                                                    <?php echo $this->lang->line('email_list'); ?>
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td width="90" class="title_list">
                                                    <?php echo $this->lang->line('group_list'); ?>
                                                </td>
                                                <td width="60" class="title_list">
                                                    <?php echo $this->lang->line('status_list'); ?>
                                                </td>
                                                <td width="120" class="title_list">Sản phẩm gian hàng</td>
                                                <td width="120" class="title_list">Doanh số gian hàng
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                                <td width="150" class="title_list">
                                                    <?php echo $this->lang->line('regisdate_list'); ?>
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>revenue/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                    <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>revenue/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                                </td>
                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $kk = 0;
                                            ?>
                                            <?php foreach($shop as $k=>$item){ ?>
                                                <tr style="background:#<?php if($k % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $k; ?>">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $sTT; ?></b></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $item->use_id; ?>" <?php if($userLogined == $item->use_id){echo 'disabled="disabled"';} ?> onclick="DoCheckOne('frmUser')" />
                                                    </td>
                                                    <td class="detail_list">
                                                        <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $item->use_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                            <?php echo $item->use_username; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php if($item->parent_id > 0):?>
                                                            <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $item->parent_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                                <?php echo $parent[$k]->use_username; ?>
                                                            </a>
                                                        <?php endif;?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php echo $item->use_fullname; ?>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('address_tip_defaults'); ?>&nbsp;<?php echo $item->use_address; ?><br /><?php echo $this->lang->line('phone_tip_defaults') ?>&nbsp;<?php echo $item->use_phone; ?><br /><?php echo $this->lang->line('yahoo_tip_defaults') ?>&nbsp;<?php echo $item->use_yahoo; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                                    </td>
                                                    <td class="detail_list">
                                                        <a class="menu" href="mailto:<?php echo $item->use_email; ?>">
                                                            <?php echo $item->use_email; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                            <span style="color:#009900; font-weight:bold;">
                                                                Gian hàng
                                                            </span>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php if($item->use_status == 1){ ?>
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" border="0" title="Đã kích hoạt" />
                                                        <?php }else{ ?>
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" border="0" title="Chưa kích hoạt" />
                                                        <?php } ?>
                                                    </td>
                                                    <td align="center">
                                                        <a style="text-decoration: underline;" href="<?php echo base_url().'administ/branch/statistical?uid='.$item->use_id; ?>">Sản phẩm</a> </td>
                                                    <?php
                                                        $getisFilter = $this->uri->segment(7);
                                                    	$gettokey = $this->uri->segment(9);
                                                    	if($getisFilter != '' && $gettokey !='')
                                                        {
                                                            $statisticaldate = '/#statisticaldate';
                                                        }
                                                    ?>
                                                    <td align="center"><a style="text-decoration: underline;" href="<?php echo base_url().'administ/branch/statistics/'.$item->use_id .'/statisticaldate/key/isFilter/'.$getisFilter.'/tokey/'.$gettokey.$statisticaldate ?>"><?php echo number_format($item->showcarttotal,0,",",".") ?> đ</a> </td>
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo date('d/m/Y', $item->use_regisdate); ?></b></td>
                                                </tr>

                                            <?php $sTT++; } ?>
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
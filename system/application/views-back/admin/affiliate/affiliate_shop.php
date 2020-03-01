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
                                                <a href="<?php echo base_url(); ?>administ/affiliate/shop">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo "Thống kê Affiliate"; ?></td>
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
                                                <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                                                       placeholder="...">
                                            </td>
                                            <td width="120" align="left">
                                                <select name="qt" autocomplete="off" class="select_search">
                                                    <?php foreach($searchBox as $val):?>
                                                        <option value="<?php echo $val['id'];?>" <?php if ($filter['qt'] == $val['id']){ echo 'selected="selected"';}?>><?php echo $val['text']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td align="left">
                                                <input
                                                    class="searchBt" type="submit" value=""/>
                                            </td>
                                            <!---->
                                            <td width="115" align="left">
                                                <select name="sort" id="filter" onchange="Ac_filter()" autocomplete="off" class="select_search" >
                                                    <option value=""><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                    <?php foreach($statusBox as $val):?>
                                                        <option value="<?php echo $val['id'];?>" <?php if ($filter['sort'] == $val['id']){ echo 'selected="selected"';}?>><?php echo $val['text']; ?></option> 
                                                    <?php endforeach; ?>       
                                                </select>
                                            </td>
                                            
                                        <td id="DivDateSearch_1" width="10" align="center"><b> Từ&nbsp;&nbsp; </b></td>
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
                                        <td id="DivDateSearch_9" width="10" align="center" style="display:none" ><b> Đến&nbsp;&nbsp; </b></td>
                                        <td id="DivDateSearch_10" width="60" align="left" style="display:none">
                                            <select name="tday" id="tday" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_11" width="10" align="center" style="display:none"><b>-</b></td>
                                        <td id="DivDateSearch_12" width="60" align="left" style="display:none">
                                            <select name="tmonth" id="tmonth" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_13" width="10" align="center" style="display:none"><b>-</b></td>
                                        <td id="DivDateSearch_14" width="60" align="left" style="display:none">
                                            <select name="tyear" id="tyear" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>
                                        <td width="25" align="right">
                                            <input class="searchBt" type="submit" value=""/>
                                        </td>
                                        </tr>
                                    </table>
                                    </form>

                                    <!--END Search-->
                                </td>
                            </tr>
                            <script>OpenTabSearch('0',0);</script>
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
                                                    <a href="<?php echo $sort['username']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['username']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td class="title_list">
                                                    Người giới thiệu
                                                </td>
                                                <td class="title_list">
                                                    <?php echo $this->lang->line('fullname_list'); ?>
                                                    <a href="<?php echo $sort['name']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['name']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td class="title_list">
                                                    <?php echo $this->lang->line('email_list'); ?>
                                                    <a href="<?php echo $sort['email']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['email']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="90" class="title_list">
                                                    <?php echo $this->lang->line('group_list'); ?>
                                                    <a href="<?php echo $sort['group']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['group']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="60" class="title_list">
                                                    <?php echo $this->lang->line('status_list'); ?>
                                                </td>
                                                <td width="120" class="title_list">Sản phẩm AF</td>
                                                <td width="120" class="title_list">Doanh số AF
                                                    <a href="<?php echo $sort['doanhso']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['doanhso']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" 
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="125" class="title_list">
                                                    <?php echo 'Ngày đăng ký'; ?>
                                                    <a href="<?php echo $sort['creatdate']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['creatdate']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>

                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $kk = 0; ?>
                                            <?php foreach($shop as $k=>$item){ ?>
                                                <tr style="background:#<?php if($k % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $k; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $k; ?>',<?php echo $k; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $num + $k +1; ?></b></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $item['use_id']; ?>" <?php if($userLogined == $item['use_id']){echo 'disabled="disabled"';} ?> onclick="DoCheckOne('frmUser')" />
                                                    </td>
                                                    <td class="detail_list">
                                                        <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $item['use_id']; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                            <?php echo $item['use_username']; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php if($item['parent_id'] > 0):?>
                                                        <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $item['parent_id']; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                            <?php echo $item['pUsername']; ?>
                                                        </a>
                                                        <?php endif;?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php echo $item['use_fullname']; ?>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('address_tip_defaults'); ?>&nbsp;<?php echo $item['use_address']; ?><br /><?php echo $this->lang->line('phone_tip_defaults') ?>&nbsp;<?php echo $item['use_phone']; ?><br /><?php echo $this->lang->line('yahoo_tip_defaults') ?>&nbsp;<?php echo $item['use_yahoo']; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                                    </td>
                                                    <td class="detail_list">
                                                        <a class="menu" href="mailto:<?php echo $item['use_email']; ?>">
                                                            <?php echo $item['use_email']; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php if($item['use_group'] == 4){ ?>
                                                        <span style="color:#F00; font-weight:bold;">
											<?php }elseif($item['use_group'] == 3){ ?>
                                                            <span style="color:#009900; font-weight:bold;">
											<?php }elseif($item['use_group'] == 2){ ?>
                                                                <span style="color:#06F; font-weight:bold;">
											<?php }else{ ?>
                                                                    <span style="font-weight:normal;">
											<?php } ?>
                                            <?php echo $item['gro_name']; ?>
											</span>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php if($item['use_status'] == 1){ ?>
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png"  style="cursor:pointer;"  border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                                        <?php }else{ ?>
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" style="cursor:pointer;"  border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                                        <?php } ?>
                                                    </td>
                                                    <td align="center"><a style="text-decoration: underline;" href="<?php echo base_url().'administ/affiliate?uid='.$item['use_id'].'&st=1'; ?>">Sản phẩm</a> </td>
                                                    <td align="center">
                                                    <?php if($frdate != 0 && $tdate != 0){ ?>
                                                        <a style="text-decoration: underline;" href="<?php echo base_url().'administ/affiliate/statistics/'.$item['use_id'].'/frkey/'.$frdate.'/tokey/'.$tdate; ?>"><?php echo $item['TongDS']; ?> </a>
                                                    <?php }else{ ?>
                                                        <a style="text-decoration: underline;" href="<?php echo base_url().'administ/affiliate/statistics/'.$item['use_id']; ?>"><?php echo $item['TongDS']; ?> </a>
                                                    <?php } ?> 
                                                    </td>       
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $item['use_regisdate']; ?></b></td>

                                                </tr>

                                            <?php } ?>
                                            <!---->
                                            <tr>
                                                <td class="show_page" colspan="10"><?php echo $pager; ?></td>
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
<?php if($frdate != 0 && $tdate != 0){ 
    $fday = (int)date('d',$frdate);
    $fmonth = (int)date('m',$frdate);
    $fyear = (int)date('Y',$frdate);
    $tday = (int)date('d',$tdate);
    $tmonth = (int)date('m',$tdate);
    $tyear = (int)date('Y',$tdate);

    ?> 
    <script> 
        document.getElementById('DivDateSearch_1').style.display = "";
        document.getElementById('DivDateSearch_2').style.display = "";
        document.getElementById('DivDateSearch_3').style.display = "";
        document.getElementById('DivDateSearch_4').style.display = "";
        document.getElementById('DivDateSearch_5').style.display = "";
        document.getElementById('DivDateSearch_6').style.display = "";
        //to date
        document.getElementById('DivDateSearch_9').style.display = "";
        document.getElementById('DivDateSearch_10').style.display = "";
        document.getElementById('DivDateSearch_11').style.display = "";
        document.getElementById('DivDateSearch_12').style.display = "";
        document.getElementById('DivDateSearch_13').style.display = "";
        document.getElementById('DivDateSearch_14').style.display = ""; 

        var fd = <?php echo "$fday"; ?>;
        var fm = <?php echo "$fmonth"; ?>;
        var fy = <?php echo "$fyear"; ?>;
        var td = <?php echo "$tday"; ?>;
        var tm = <?php echo "$tmonth"; ?>;
        var ty = <?php echo "$tyear"; ?>; 

        //From day
        var sel1 = document.getElementById('day');
        var opts1 = sel1.options;
        for(var opt1, i = 0; opt1 = opts1[i]; i++) {
            if(opt1.value == fd) {
                sel1.selectedIndex = i;
                break;
            }
        }
        var sel2 = document.getElementById('month');
        var opts2 = sel2.options;
        for(var opt2, j = 0; opt2 = opts2[j]; j++) {
            if(opt2.value == fm) {
                sel2.selectedIndex = j;
                break;
            }
        }

        var sel3 = document.getElementById('year');
        var opts3 = sel3.options;
        for(var opt3, k = 0; opt3 = opts3[k]; k++) {
            if(opt3.value == fy) {
                sel3.selectedIndex = k;
                break;
            }
        }

        //To day
        var sel4 = document.getElementById('tday');
        var opts4 = sel4.options;
        for(var opt4, m = 0; opt4 = opts4[m]; m++) {
            if(opt4.value == td) {
                sel4.selectedIndex = m;
                break;
            }
        }
        var sel5 = document.getElementById('tmonth');
        var opts5 = sel5.options;
        for(var opt5, n = 0; opt5 = opts5[n]; n++) {
            if(opt5.value == tm) {
                sel5.selectedIndex = n;
                break;
            }
        }

        var sel6 = document.getElementById('tyear');
        var opts6 = sel6.options;
        for(var opt6, p = 0; opt6 = opts6[p]; p++) {
            if(opt6.value == ty) {
                sel6.selectedIndex = p;
                break;
            }
        }

    </script>
<?php } ?>
<script type="text/javascript">    
    function Ac_filter()
    {   
        var isFilter = ''; 
        isFilter =  document.getElementById('filter').value;
        if(isFilter == 'logindate'){
            if(document.getElementById('DivDateSearch_2').style.display == "none"
                || document.getElementById('DivDateSearch_4').style.display == "none"
                || document.getElementById('DivDateSearch_6').style.display == "none"
                || document.getElementById('DivDateSearch_10').style.display == "none"
                || document.getElementById('DivDateSearch_12').style.display == "none"
                || document.getElementById('DivDateSearch_14').style.display == "none"){
                document.getElementById('DivDateSearch_1').style.display = "";
                document.getElementById('DivDateSearch_2').style.display = "";
                document.getElementById('DivDateSearch_3').style.display = "";
                document.getElementById('DivDateSearch_4').style.display = "";
                document.getElementById('DivDateSearch_5').style.display = "";
                document.getElementById('DivDateSearch_6').style.display = "";
                //to date
                document.getElementById('DivDateSearch_9').style.display = "";
                document.getElementById('DivDateSearch_10').style.display = "";
                document.getElementById('DivDateSearch_11').style.display = "";
                document.getElementById('DivDateSearch_12').style.display = "";
                document.getElementById('DivDateSearch_13').style.display = "";
                document.getElementById('DivDateSearch_14').style.display = "";                
            }
        }   
    }
</script>
<?php $this->load->view('admin/common/footer'); ?>
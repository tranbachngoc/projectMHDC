<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/admin/css/datepicker.css" rel="stylesheet" />	
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/ajax.js"></script>
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
                                            <a href="<?php echo base_url(); ?>administ/hoidap">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_ads.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Theo dõi hỏi đáp</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                         <?php /*?>   <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmHds')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            </div><?php */?>
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/hoidap/theodoi/search/title/keyword/','keyword')"  />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/hoidap/theodoi/',1)" class="select_search">
                                              <!--  <option value="0"><?php //echo $this->lang->line('search_by_search'); ?></option>-->
                                                <option value="title"><?php echo $this->lang->line('title_search_defaults'); ?></option>
                                                <option value="username"><?php echo $this->lang->line('username_search_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/hoidap/theodoi',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                           <?php /*?> <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/hoidap/theodoi/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                          
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>
                                            </select><?php */?>
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
                                          <?php /*?>  <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/hoidap/',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" /><?php */?>
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmHds" method="post">
                        <input type="hidden" name="type_action" value="hoidap"
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                      <?php /*?>  <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmHds',0)" />
                                        </td><?php */?>
                                        <td class="title_list" width="100">
                                        	Thành viên theo dõi
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('title_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                         <td width="115" class="title_list">
                                            <?php echo $this->lang->line('poster_list'); ?>
                                            
                                        </td>
                                        <td width="220" class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                      
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('begindate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>up_date/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>up_date/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($hds as $hdsArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                      <?php /*?>  <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $hdsArray->hds_id; ?>" onclick="DoCheckOne('frmHds')" />
                                        </td> <?php */?>                                       
                                       <td class="detail_list">
                                       <?php $danhsach_theo_doi=explode(",",$hdsArray->hds_theo_doi);  ?>  
                                       <?php
									   for($i=0;$i<=count($danhsach_theo_doi);$i++)
									   {
										  // echo $danhsach_theo_doi[$i];
										   if($danhsach_theo_doi[$i]!="")
										   {
											   if($i==1)
											   {
											   echo "<a href='".base_url()."user/profile/".$danhsach_theo_doi[$i]."' target='_blank'>".Counter_model::getUSerIdNameToID($danhsach_theo_doi[$i])."</a>";
											   }
											   else
											   {
												      echo ",<a href='".base_url()."user/profile/".$danhsach_theo_doi[$i]."' target='_blank'>".Counter_model::getUSerIdNameToID($danhsach_theo_doi[$i])."</a>";
											   }
										   }
									   }
									   //echo $hdsArray->hds_theo_doi;
									  //var_dump($danhsach_theo_doi);
									   //echo count($danhsach_theo_doi);
									   
									    ?>
                                                                      
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>hoidap/<?php echo $hdsArray->hds_category; ?>/<?php echo $hdsArray->hds_id; ?>/<?php echo RemoveSign($hdsArray->hds_title); ?>" target="_blank" title="<?php echo $this->lang->line('view_tip'); ?>">
                                                <?php echo $hdsArray->hds_title; ?>
                                            </a>
                                            <span style="color:#0C0; font-style:italic;">(<?php echo $hdsArray->hds_view; ?>)</span>
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $hdsArray->hds_user; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $hdsArray->use_username; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>administ/hoidap/cat/edit/<?php echo $hdsArray->cat_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $hdsArray->cat_name; ?>
                                            </a>
                                        </td>
                                        
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $hdsArray->up_date; ?></b></td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="9"><?php echo $linkPage; ?></td>
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
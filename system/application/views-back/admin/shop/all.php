<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<!--suppress JSAnnotator -->
    <SCRIPT TYPE="text/javascript">
<!--
function dateHethang(value)
{
	jQuery('.'+value).css('display','block');

};
function updategianhangnoibat(value)
{
	if(document.getElementById('ngay_ket_thuc_'+value).value=="")
	{
		alert("Bạn chưa chọn ngày");
		return false;
	}
	jQuery('.poupngayhethan_'+value).css('display','none');
	 window.location.href="<?php echo base_url(); ?>administ/shop/dambao/"+value+"/"+document.getElementById('ngay_ket_thuc_'+value).value;
}

</SCRIPT>
<?php  ///// chuyen cau truc link gian hang qua dang subdomain //////
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
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
                                            <a href="<?php echo base_url(); ?>administ/shop<?php  if($getallaf == 'af'){ echo '/af'; }else{ echo "/all"; } ?>">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/home-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">
                                            <?php 	$getallaf = $this->uri->segment(3);
                                            if ($getallaf == 'af'){
                                                echo 'Tất cả gian hàng Afiliate';
                                            }else{
                                                echo 'Tất cả gian hàng';
                                            }
                                            ?>
                                        </td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <!--<div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmShop')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/icon_delete.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php /*echo $this->lang->line('delete_tool'); */?></td>
                                                    </tr>
                                                </table>
                                            </div>-->
                                            <!--<div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php /*echo base_url(); */?>administ/shop/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/icon_add.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php /*echo $this->lang->line('add_tool'); */?></td>
                                                    </tr>
                                                </table>
                                            </div>-->
                                            <!--<div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/shop/end')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
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
                                            </div>-->
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/shop/<?php echo $getallaf; ?>/search/name/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/<?php echo $getallaf; ?>/',1)" class="select_search">
                                              <!--  <option value="0"><?php //echo $this->lang->line('search_by_search'); ?></option>-->
                                                <option value="name">Tên gian hàng</option>
                                                <option value="link"><?php echo $this->lang->line('link_search_defaults'); ?></option>
                                                <option value="saler"><?php echo $this->lang->line('saler_search_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/<?php echo $getallaf; ?>/',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/<?php echo $getallaf; ?>/',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="begindate"><?php echo $this->lang->line('regisdate_search'); ?></option>
                                                <option value="active">Đã kích hoạt</option>
                                                <option value="deactive">Chưa kích hoạt</option>
                                                <option value="shopfee"><?php echo $this->lang->line('shop_fee'); ?></option>
                                                <option value="shopfree"><?php echo $this->lang->line('shop_free'); ?></option>

                                                <option value="package"><?php echo $this->lang->line('shop_package'); ?></option>

                                               <!-- <option value="enddate"><?php echo $this->lang->line('enddate_search'); ?></option>
                                                <option value="saleoff"><?php echo $this->lang->line('saleoff_search_defaults'); ?></option>
                                                <option value="notsaleoff"><?php echo $this->lang->line('not_saleoff_search_defaults'); ?></option>-->
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
                                        <td id="DivDateSearch_15" width="10" align="center" style="display:none"><b>-</b></td>
                                        <td id="DivDateSearch_16" width="60" align="left" style="display:none">
                                            <select name="package" id="package" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('package_search'); ?></option>
                                                <?php $this->load->view('admin/common/package'); ?>
                                            </select>
                                        </td>
                                        <script>OpenTabSearch('0',0);</script>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/<?php echo $getallaf; ?>/',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
                                        </td>


                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmShop" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmShop',0)" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('shop_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            Người giới thiệu
                                        </td>
                                        <td width="160" class="title_list">
                                            <?php echo $this->lang->line('link_shop_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>link/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>link/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('saler_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>saler/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>saler/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="120" class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>

                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('regisdate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <!--<td width="125" class="title_list">
                                            <?php echo $this->lang->line('enddate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>-->
                                        <td width="125" class="title_list">
                                       		Xem sản phẩm
                                        </td>
                                        <td width="70" class="title_list">
                                            Cho phép tự giao
                                        </td>
                                        <td width="125" class="title_list">
                                            Cấu hình giảm giá
                                        </td>
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; $kk=0; ?>
                                    <?php foreach($shop as $shopArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $shopArray->sho_id; ?>" onclick="DoCheckOne('frmShop')" />
                                        </td>
                                        <td class="detail_list">
                                            <a target="_blank" class="menu" href="<?php echo $protocol . $shopArray->sho_link .'.'. $domainName; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $shopArray->sho_name; ?>
                                            </a>
                                            <span style="color:#0C0; font-style:italic;">(<?php echo $shopArray->sho_view; ?>)</span>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('address_tip_defaults'); ?>&nbsp;<?php echo $shopArray->sho_address; ?><br /><?php echo $this->lang->line('phone_tip_defaults'); ?>&nbsp;<?php echo $shopArray->sho_phone; ?><br /><?php echo $this->lang->line('email_tip_defaults'); ?>&nbsp;<?php echo $shopArray->sho_email; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                            <?php if($shopArray->sho_saleoff == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/saleoff_shop.gif" height="12" border="0" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list">
                                         <a target="_blank" class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $parent[$kk]->use_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $parent[$kk]->use_username; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <a target="_blank" class="menu" href="<?php echo base_url().$shopArray->sho_link; ?>" target="_blank" title="<?php echo $this->lang->line('view_shop_defaults'); ?>">
                                                <?php echo $shopArray->sho_link; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <a target="_blank" class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $shopArray->use_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $shopArray->use_username; ?>
                                            </a>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('email_tip_defaults'); ?>&nbsp;<?php echo $shopArray->use_email; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="detail_list">
                                                <?php echo $shopArray->cat_name; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($shopArray->sho_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $shopArray->sho_id; ?>/<?php echo $shopArray->sho_user; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $shopArray->sho_id; ?>/<?php echo $shopArray->sho_user; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>

                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $shopArray->sho_begindate); ?></b></td>
                                       <!-- <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $shopArray->sho_enddate); ?></b></td>-->
                                        <td class="detail_list" style="text-align:center;"><a href="<?php echo base_url() ?>administ/shop/<?php if($getallaf == 'af') echo "danhsachsanphamaf"; else{ echo "danhsachsanpham"; } ?>/<?php echo $shopArray->sho_user; ?>"> Xem (<?php if($getallaf == 'all') echo Counter_model::countUserBussinesAll($shopArray->sho_user,"tbtt_product","pro_user"); else echo Counter_model::countUserBussinesAll($shopArray->sho_user,"tbtt_product_affiliate_user","use_id"); ?> sản phẩm) </a></td>

                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($shopArray->sho_shipping == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/shipping/deactive/id/<?php echo $shopArray->sho_id; ?>/<?php echo $shopArray->sho_user; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/shipping/active/id/<?php echo $shopArray->sho_id; ?>/<?php echo $shopArray->sho_user; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td width="5%" class="detail_list" style="text-align:center;"><a href="<?php echo base_url() ?>administ/shop/configdiscount_rate/<?php echo $shopArray->sho_user; ?>" class="menu" data-toggle="tooltip" data-placement="top" title="Click vào để sửa"><?php echo $shopArray->sho_discount_rate; ?>%</a>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; $kk++; ?>
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
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
<?php $this->load->view('admin/common/footer'); ?>
<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php $url =  $this->uri->segment(4).'/';
if ($url == 'service/'){
    $title = 'dịch vụ';
}elseif($url == 'coupon/'){
    $title = 'coupon';
}else{
    $title = '';
}
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
                                            <a href="<?php echo base_url().'administ/showcart/allorder/'.$url; ?>">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Tất cả Đơn hàng <?php echo $title; ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <!--<div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmShowcart')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search"  onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url().'administ/showcart/allorder/'.$url.'search/name/keyword'; ?>','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url().'administ/showcart/allorder/'.$url; ?>',1)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                <option value="orderid">Mã đơn hàng</option>
                                                <option value="buyer">Người mua</option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url().'administ/showcart/allorder/'.$url; ?>',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url().'administ/showcart/allorder/'.$url; ?>',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="buydate"><?php echo $this->lang->line('buydate_search_defaults'); ?></option>
                                                <!--<option value="process"><?php echo $this->lang->line('process_search_defaults'); ?></option>
                                                <option value="notprocess"><?php echo $this->lang->line('notprocess_search_defaults'); ?></option>-->
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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url().'administ/showcart/allorder/'.$url; ?>',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmShowcart" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmShowcart',0)" />
                                        </td>
                                        <td class="title_list">
                                            Mã đơn hàng
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>orderid/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="170" class="title_list">
                                           Thời gian đặt hàng
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                           Phương thức thanh toán                                           
                                        </td>
                                        <td class="title_list">
                                           Nhà vận chuyển
                                        </td>
                                        <td class="title_list">
                                           Số lượng                                             
                                        </td>
                                        <td class="title_list">
                                           Tổng giá                                             
                                        </td>
                                        <td class="title_list">
                                           Đơn hàng Affiliate                                           
                                        </td>
                                         <td width="120" class="title_list">
                                            Người mua
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>buyer/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>buyer/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($showcart as $showcartArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $showcartArray->shc_id; ?>" onclick="DoCheckOne('frmShowcart')" />
                                        </td>
                                        <td class="detail_list">
                                            <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id;  ?>"><?php echo $showcartArray->id; ?></a>
                                        </td>
                                        <td class="detail_list">
                                             <?php echo date("d-m-Y H:i:s",$showcartArray->date); ?>
                                        </td>
                                        <td class="detail_list">
                                           <?php if($showcartArray->payment_method == "info_nganluong"){
											   echo 'Cổng thanh toán Ngân Lượng';
											}?>
                                            <?php if($showcartArray->payment_method == "info_cod"){
											   echo 'Thanh toán khi nhận hàng';
											}?>
                                            <?php if($showcartArray->payment_method == "info_bank"){
											   echo 'Chuyển khoản qua Ngân hàng';
											}?>
                                        </td>
                                        <td class="detail_list">
                                        	<?php
                                            if($showcartArray->shipping_method == 'GHN'){
											   echo 'Giao hàng nhanh';
											}
                                            if($showcartArray->shipping_method == 'VTP'){
                                                echo 'Viettel Post';
                                            }
                                            if($showcartArray->shipping_method == 'SHO'){
                                                echo 'Shop Giao';
                                            }
                                            ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                         <a href="<?php echo base_url(); ?>administ/showcart/detail/<?php echo $showcartArray->id;  ?>"><?php echo $showcartArray->quantity; ?> sản phẩm</a></td>
                                         
                                         <td class="detail_list" style="text-align:right;">
                                         <span style="color:#F00; font-weight:bold;"><?php echo number_format($showcartArray->total,0,",","."); ?> đ </span></td>
                                         <td class="detail_list" style="text-align:center;">
                                         <?php if($showcartArray->af_id > 0){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png"  style="cursor:pointer;" border="0"  />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" style="cursor:pointer;" border="0"  />
                                            <?php } ?>                                                                                  
                                        </td>
                                        <td class="detail_list" style="text-align:center;"><a href="<?php echo base_url(); ?>administ/user/edit/<?php echo $showcartArray->order_user; ?>"><?php echo $showcartArray->use_username; ?></a></td>
                                        
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                                    <!---->
                                    <tr>
                                        <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
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
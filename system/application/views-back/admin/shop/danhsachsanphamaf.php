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
                                            <a href="<?php echo base_url(); ?>administ/shop/all">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Gian hàng - <?php echo Counter_model::getUSerShopNameToID($this->uri->segment(4)); ?> ( <?php echo Counter_model::countUserBussinesAll((int)$this->uri->segment(4),"tbtt_product_affiliate_user","use_id"); ?> sản phẩm )</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmProduct')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                          <?php /*?>  <img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" /><?php */?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php //echo $this->lang->line('delete_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/product/end')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <?php /*?><img src="<?php echo base_url(); ?>templates/admin/images/icon_expiry.png" height="27" border="0" /><?php */?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php //echo $this->lang->line('end_tool'); ?></td>
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/shop/danhsachsanpham/<?php 	echo $this->uri->segment(4)."/" ;?>search/name/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/shop/danhsachsanpham/<?php 	echo $this->uri->segment(4)."/" ;?>',1)" class="select_search">
                                               <option value="name">Tên sản phẩm</option>                                             
                                               
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/shop/danhsachsanpham/<?php 	echo $this->uri->segment(4)."/" ;?>',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                      
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmProduct" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmProduct',0)" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('product_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="130" class="title_list">
                                            <?php echo $this->lang->line('cost_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>

                                        <td width="130" class="title_list">
                                            Hoa hồng AF
                                        </td>

                                        <td width="130" class="title_list">
                                            Giảm thêm AF
                                        </td>

                                   
                                        <td width="130" class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                          <!--<td width="60" class="title_list">
                                            <?php /*echo $this->lang->line('vip_list'); */?>
                                        </td>-->
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('begindate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                       <?php /*?> <td width="125" class="title_list">
                                            <?php echo $this->lang->line('enddate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td><?php */?>
                                       <!-- <td  width="80" class="title_list">
                                        Xóa
                                        </td>-->
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($product as $productArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $productArray->pro_id; ?>" onclick="DoCheckOne('frmProduct')" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name); ?>/admin" target="_blank" title="<?php echo $this->lang->line('view_tip'); ?>">
                                                <?php echo $productArray->pro_name; ?>
                                            </a>
                                            <span style="color:#0C0; font-style:italic;">(<?php echo $productArray->pro_view; ?>)</span>
                                        </td>
                                        <td class="detail_list">
                                            <font color="#FF0000"><b><span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $productArray->pro_currency; ?></b></font>
                                            <script type="text/javascript">FormatCost('<?php echo $productArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                                        </td>

                                        <td class="detail_list">
                                            <?php
                                            if($productArray->af_amt > 0) echo number_format($productArray->af_amt, 0, ",", ".")  ." đ";
                                            if($productArray->af_rate > 0) echo $productArray->af_rate ." %";
                                            ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php
                                            if($productArray->af_dc_amt > 0) echo number_format($productArray->af_dc_amt , 0, ",", ".")." đ";
                                            if($productArray->af_dc_rate > 0) echo $productArray->af_dc_rate ." %";
                                            ?>
                                        </td>
                                        <td class="detail_list">
                                            <?php echo $productArray->cat_name; ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($productArray->pro_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <!--<td class="detail_list" style="text-align:center;">
                                            <?php /*if($productArray->pro_vip == 1){ */?>
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/active.png" onclick="ActionStatus('<?php /*echo $statusUrl; */?>/vip/deactive/id/<?php /*echo $productArray->pro_id; */?>')" style="cursor:pointer;" border="0" title="<?php /*echo $this->lang->line('deactive_vip'); */?>" />
                                            <?php /*}else{ */?>
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php /*echo $statusUrl; */?>/vip/active/id/<?php /*echo $productArray->pro_id; */?>')" style="cursor:pointer;" border="0" title="<?php /*echo $this->lang->line('active_vip'); */?>" />
                                            <?php /*} */?>
                                        </td>-->
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $productArray->pro_begindate); ?></b></td>
                                      <?php /*?>  <td class="detail_list" style="text-align:center;">
                                            <input type="text" name="DivEnddate_<?php echo $idDiv; ?>" id="DivEnddate_<?php echo $idDiv; ?>" value="<?php echo date('d-m-Y', $productArray->pro_enddate); ?>" readonly="readonly" class="set_enddate" />
                                            <script type="text/javascript">
                                                $(function() {
                                                                $("#DivEnddate_<?php echo $idDiv; ?>").datepicker({showOn: 'button',
                                                                buttonImage: '<?php echo base_url(); ?>templates/admin/images/calendar.gif',
                                                                buttonImageOnly: true,
                                                                buttonText: '<?php echo $this->lang->line('set_enddate_tip'); ?>',
                                                                dateFormat: 'dd-mm-yy',
                                                                minDate: new Date(2008, 1-1, 1),
                                                                maxDate: '+10y',
                                                                onClose: function(){
                                                                        setEndDate(<?php echo $productArray->pro_id; ?>, document.getElementById('DivEnddate_<?php echo $idDiv; ?>').value, '<?php echo base_url(); ?>', 'product');
                                                                    }
                                                                });
                			                                 });
                                            </script>
                                        </td><?php */?>
                                        
                                         <!--<td class="detail_list" style="text-align:center;">
                                     		 <a href="<?php /*echo base_url(); */?>administ/shop/danhsachsanpham/<?php /*	echo $this->uri->segment(4) ;*/?>/delete/<?php /*echo $productArray->pro_id;  */?>">
                                           <img  src="<?php /*echo base_url(); */?>templates/home/images/icon_remove_small1.gif" />
                                           </a>
                                        </td>-->
                                        
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
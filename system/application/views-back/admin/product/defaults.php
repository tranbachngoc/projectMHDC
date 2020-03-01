<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/admin/css/datepicker.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/bootstrap.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/admin/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/bootstrap-tree.js"></script>
<script>
    function admin_Anhang(id, active){
        var id_cat = jQuery("#shop_category_"+id).val();
        if(active == 1){
            if(id_cat == 0 ){
                alert('Vui lòng chọn danh mục ngành nghề!');
                return false;
            }
        }
        jQuery.ajax({
                type: "post",
                url:"<?php echo base_url(); ?>" + 'administ/product/anhang',
                cache: false,
                data:{id: id, active:active, id_cat:id_cat},
                success: function(data){
                    switch (data){
                        case '0':
                            alert('Không thành công !');
                         break;
                        case '1':
                            $('#myModal_'+id).modal('hide');
                            location.reload();
                            break;
                         case '2':
                             location.reload();
                         break;
                    }
                }
        });
}
</script>
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
                                        <?php
                                            $pro_type = $this->uri->segment(2);
                                            if ($pro_type != 'product'){
                                                $url = $pro_type .'/';
                                            }
                                        ?>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <a href="<?php echo base_url().'administ/' . $url . 'product'; ?>">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">
                                            <?php
                                            if ($pro_type == 'product'){
                                                echo 'Sản phẩm';
                                            }elseif ($pro_type == 'service'){
                                                echo 'Dịch vụ';
                                            }elseif ($pro_type == 'coupon'){
                                                echo 'Coupon';
                                            }
                                             ?>

                                        </td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmProduct')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <!--<div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/product/end')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
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
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/'.$url.'product/',1)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                <option value="name"><?php echo $this->lang->line('name_search_defaults'); ?></option>
                                                <option value="cost"><?php echo $this->lang->line('cost_search_defaults'); ?></option>
                                                <option value="username"><?php echo $this->lang->line('username_search_defaults'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url() ?><?php if($pro_type == 'product'){ echo "administ/product/"; } else if($pro_type == 'service'){  echo "administ/service/product/"; } else if($pro_type == 'coupon'){  echo "administ/coupon/product/"; }  ?>',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?><?php if($pro_type == 'product'){ echo "administ/product/"; } else if($pro_type == 'service'){  echo "administ/service/product/"; } else if($pro_type == 'coupon'){  echo "administ/coupon/product/"; }  ?>',2)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="begindate"><?php echo $this->lang->line('begindate_search'); ?></option>         
                                                <option value="affiliate">Là Affiliate</option>
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>           
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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?><?php if($pro_type == 'product'){ echo "administ/product/"; } else if($pro_type == 'service'){  echo "administ/service/product/"; } else if($pro_type == 'coupon'){  echo "administ/coupon/product/"; }  ?>',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
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
                                        <td class="title_list">
                                            <?php echo $this->lang->line('cost_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <!--<td class="title_list">
                                            <?php /*echo $this->lang->line('place_sale_list'); */?>
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>province/by/asc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php /*echo $sortUrl; */?>province/by/desc<?php /*echo $pageSort; */?>')" style="cursor:pointer;" border="0" />
                                        </td>-->
                                         <td class="title_list">
                                            <?php echo $this->lang->line('saler_product_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>user/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>user/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('category_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>category/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td  class="title_list">
                                            Hoa hồng AF
                                        </td>
                                        <td  class="title_list">
                                            Giảm thêm AF
                                        </td>
                                        <td  class="title_list">
                                            Là Affiliate
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
<!--                                        <td  class="title_list">-->
<!--                                            Admin Ký gửi hàng online-->
<!--                                        </td>-->
<!--                                        <td  class="title_list">-->
<!--                                            Ngành nghề Ký gửi hàng online-->
<!--                                        </td>-->
                                        <td class="title_list">
                                            <?php echo $this->lang->line('begindate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>begindate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>

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
                                       <!-- <td class="detail_list">

                                                <?php /*echo $productArray->pre_name; */?>

                                        </td>-->
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $productArray->use_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $productArray->use_username; ?>
                                            </a>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('email_tip_defaults'); ?>&nbsp;<?php echo $productArray->use_email; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="detail_list">

                                                <?php echo $productArray->cat_name; ?>

                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php
                                                if($productArray->af_amt > 0) echo number_format($productArray->af_amt , 0, ",", ".")." đ";
                                                if($productArray->af_rate > 0) echo $productArray->af_rate ." %";
                                            ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php
                                            if($productArray->af_dc_amt > 0) echo number_format($productArray->af_dc_amt , 0, ",", ".")." đ";
                                            if($productArray->af_dc_rate > 0) echo $productArray->af_dc_rate ." %";
                                            ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($productArray->is_product_affiliate == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png"  style="cursor:pointer;" border="0"  />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" style="cursor:pointer;" border="0"  />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($productArray->pro_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $productArray->pro_id; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                       <!-- <td class="detail_list" style="text-align:center;">
                                            <div class="modal fade" id="myModal_<?php /*echo $productArray->pro_id*/?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body form-horizontal">
                                                            <div class="form-group">
                                                                <div class="col-lg-5">
                                                                    Chọn ngành nghề Ký gửi hàng online:
                                                                </div>
                                                                <div class="col-lg-7">
                                                                    <select name="shop_category_<?php /*echo $productArray->pro_id;*/?>" id="shop_category_<?php /*echo $productArray->pro_id;*/?>" class="form-control">
                                                                        <option selected value="0">Danh mục ngành nghề</option>
                                                                        <?php /*foreach($shop_name as $item){*/?>
                                                                            <option value="<?php /*echo $item->cat_id; */?>"><?php /*echo $item->cat_name; */?></option>
                                                                        <?php /*}*/?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                                            <button type="button" class="btn btn-primary" onclick="admin_Anhang(<?php /*echo $productArray->pro_id; */?>,1)">Lưu lại</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php /*if($productArray->is_asigned_by_admin == 1){ */?>
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/active.png" onclick="admin_Anhang(<?php /*echo $productArray->pro_id; */?>,0)"  style="cursor:pointer;" border="0" title="<?php /*echo $this->lang->line('deactive_vip'); */?>" />
                                            <?php /*}else{ */?>
                                            <img src="<?php /*echo base_url(); */?>templates/admin/images/deactive.png" data-toggle="modal" data-target="#myModal_<?php /*echo $productArray->pro_id*/?>" style="cursor:pointer;" border="0" title="<?php /*echo $this->lang->line('active_vip'); */?>" />
                                            <?php /*} */?>
                                        </td>-->
                                       <!-- <td>
                                            <?php /*foreach($shop_name as $item){
                                                */?>
                                                <?php /*if($productArray->id_shop_cat == $item->cat_id){
                                                echo $item->cat_name;
                                                    continue;
                                                }
                                                */?>
                                            <?php /*}*/?>
                                        </td>-->
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $productArray->pro_begindate); ?></b></td>

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
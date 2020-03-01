<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

    <tr>
        <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="2"></td>
                    <td width="10" class="left_main" valign="top"></td>
                    <td align="center" valign="top"><!--BEGIN: Main-->

                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td><!--BEGIN: Item Menu-->

                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="5%" height="67" class="item_menu_left"><a href="<?php echo base_url(); ?>administ/showcart/allorder"> <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" /> </a></td>
                                            <td width="40%" height="67" class="item_menu_middle">Chi tiết đơn hàng <?php echo $this->uri->segment(4); ?></td>
                                            <td width="55%" height="67" class="item_menu_right"></td>
                                        </tr>
                                    </table>

                                    <!--END Item Menu--></td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td align="center"><!--BEGIN: Search-->

                                    <!--END Search--></td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <form name="frmShowcart" method="post">
                                <tr>
                                    <td><!--BEGIN: Content-->

                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="25" class="title_list">STT</td>
                                                <td width="20" class="title_list"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmShowcart',0)" /></td>
                                                <td class="title_list">Tên sản phẩm</td>
                                                <td class="title_list">Số lượng</td>
                                                <td class="title_list">Giá</td>
                                                <td class="title_list">Người mua</td>
                                                <td class="title_list">Người bán</td>
                                                <td class="title_list">Trạng thái</td>
                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $sTT = 1; ?>
                                            <?php foreach($detail as $item){ ?>
                                                <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                                    <td class="detail_list" style="text-align:center;"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $item->shc_id; ?>" onclick="DoCheckOne('frmShowcart')" /></td>
                                                    <td class="detail_list"> <a class="menu" href="<?php echo base_url(); ?><?php echo $item->pro_category; ?>/<?php echo $item->pro_id; ?>/<?php echo RemoveSign($item->pro_name); ?>/admin" target="_blank" ><?php echo $item->pro_name; ?></a></td>
                                                    <td class="detail_list" style="text-align:center;"><?php echo $item->shc_quantity; ?></td>
                                                    <td class="detail_list" style="text-align:right;"><span style="color:#F00; font-weight:bold;"><?php echo number_format($item->pro_price,0,",","."); ?> VNĐ</span></td>
                                                    <td class="detail_list" style="text-align:center;" ><a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $item->use_id; ?>" >

                                                            <?php echo $item->use_username; ?></a>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;"><a href="<?php echo base_url(); ?><?php echo $item->sho_link;  ?>"><?php echo $item->sho_name; ?></a></td>
                                                    <td class="detail_list" style="text-align:center;"><?php echo $item->shc_status; ?></td>

                                                </tr>
                                                <?php $idDiv++; ?>
                                            <?php } ?>
                                            <!---->
                                            <tr>
                                                <td class="show_page" colspan="8"><?php echo $linkPage; ?></td>
                                            </tr>
                                        </table>

                                        <!--END Content--></td>
                                </tr>
                            </form>
                        </table>

                        <!--END Main--></td>
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
            </table></td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
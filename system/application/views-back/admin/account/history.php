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
                                                <a href="<?php echo base_url(); ?>administ/account">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo "Lịch sử: ".$this->uri->segment(4); ?></td>
                                            <td width="55%" height="67" class="item_menu_right">

                                            </td>
                                        </tr>
                                    </table>
                                    <!--END Item Menu-->
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

                                                <td class="title_list">
                                                    Ngày tạo
                                                </td>
                                                <td class="title_list">
                                                    Trạng thái
                                                </td>
                                                <td class="title_list">
                                                   Ghi chú
                                                </td>



                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $kk = 0; ?>
                                            <?php foreach($rows as $k=>$item){ ?>
                                                <tr style="background:<?php if($k % 2 == 0){echo '#F7F7F7';}else{echo '#FFF';} ?>;" id="row_<?php echo $item['id']; ?>" onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)" onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $num + $k +1; ?></b></td>

                                                    <td class="detail_list">

                                                            <?php echo $item['created_date']; ?>

                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php foreach($status as $key=>$val){
                                                            if($key == $item['status']){
                                                                echo $val;
                                                                break;
                                                            }
                                                        }?>
                                                    </td>

                                                    <td class="detail_list" >
                                                        <?php echo $item['note'];?>
                                                    </td>

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
<?php $this->load->view('admin/common/footer'); ?>
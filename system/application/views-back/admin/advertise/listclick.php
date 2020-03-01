<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<style>
    .detail_list{
    text-align: center;
        vertical-align: middle!important;
    }
</style>
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
                                        <td width="40%" height="67" class="item_menu_middle">Thống kê lượt click quảng cáo</td>
                                        <td width="55%" height="67" class="item_menu_right">

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
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmAdvertise" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" class="table table-bordered" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td  class="title_list">STT</td>
                                        <td  class="title_list">
                                            Tiêu đề
                                        </td>
                                        <td  class="title_list">
                                            Hình ảnh
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('position_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">Tỉnh thành</td>
                                        <td class="title_list">Ngành hàng</td>
                                        <td class="title_list">
                                          Nhà quảng cáo
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>price/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>price/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>

                                        <td class="title_list">
                                            Tổng số click
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>status/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>status/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>

                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($listposition as $advertiseArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $idDiv; ?></b></td>
                                        <td class="detail_list" align="center" >
                                            <a class="menu" href="<?php echo base_url(); ?>administ/advertise/edit/<?php echo $advertiseArray->adv_id; ?>"><?php echo $advertiseArray->adv_title; ?></a>
                                        </td>
                                        <td class="detail_list" align="center" >
                                            <img width="200" src="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" />

                                            <br>
                                            <a class="menu"  href="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" target="_blank">Xem ảnh đầy đủ</a>
                                            <br>
                                            <a class="menu"  href="<?php echo $advertiseArray->adv_link; ?>" target="_blank">Liên kết Banner</a>
                                        </td>
                                        <td class="detail_list" align="center" >
                                            <?php echo  $advertiseArray->title; ?> - <?php echo  $advertiseArray->adv_page == 'home'? 'Trang danh mục sản phẩm':'Trang chủ Affiliate'; ?>
                                        </td>
                                         <td class="detail_list" align="center" >
                                            <?php echo  $advertiseArray->pre_name; ?>
                                        </td>
                                         <td class="detail_list" align="center" >
                                            <a class="menu"  href="<?php echo base_url(); ?><?php echo  $advertiseArray->cat_id; ?>/<?php echo  RemoveSign($advertiseArray->cat_name);  ?>"><?php echo  $advertiseArray->cat_name; ?></a>
                                        </td>

                                        <td class="detail_list" align="center" >
                                            <a class="menu" href="<?php echo base_url(); ?>administ/user/edit/<?php echo $advertiseArray->use_id; ?>"><?php
                                            echo $advertiseArray->use_fullname;
                                            ?>
                                            </a>
                                            <br>
                                            ĐT: <?php echo  $advertiseArray->use_phone; ?>
                                            <br>
                                            Email: <?php echo  $advertiseArray->use_email; ?>
                                        </td>
                                        <td class="detail_list" align="center"><?php
                                            echo $advertiseArray->total;
                                            ?></td>
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
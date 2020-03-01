<?php $this->load->view('home/common/header'); ?>

<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 pull-right ">
            <div class="col-sm-12">
                <div class="breadcrumbs hidden-xs">
                    <a href="/">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Thông tin người dùng</span>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading text-uppercase"><h2 style="margin:0; font-size:18px">Thông tin thành
                            viên <span style="color:#f00;"><?php echo $user->use_username; ?></span></h2></div>
                    <table class="table table-bordered" width="100%" class="post_main" align="center" cellpadding="0"
                           cellspacing="0" border="0">
                        <tr>

                            <?php
                            $filename = 'media/images/avatar/' . $user->avatar;
                            ?>
                            <td width="200" valign="top" height="35" class="list_post"><font color="#FF0000"></font>
                                Hình đại diện:
                            </td>
                            <td valign="bottom">
                                <?php if($parent != '' && $user->use_group != StaffStoreUser && $user->use_group != StaffUser){ echo '<a href="'. $parent .'/news">'; } ?>
                                <img width="100" src="<?php if ($user->avatar != '') { ?><?php echo DOMAIN_CLOUDSERVER . $filename; } else { ?><?php echo base_url().$avatar_default ?>images/user-avatar-default.png<?php } ?>"
                                     border="0"/>
                                <?php if($parent != '' && $user->use_group != StaffStoreUser && $user->use_group != StaffUser){ echo '</a>';}?>
                            </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('fullname_defaults'); ?>:
                            </td>
                            <td valign="bottom"><?php echo $user->use_fullname; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('username_defaults'); ?>:
                            </td>
                            <td valign="bottom"><?php echo $user->use_username; ?> (<span
                                    style="color: gray;"><?php echo $vt ?></span>)
                            </td>
                        </tr>

                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('store_user'); ?>:
                            </td>
                            <td valign="bottom">
                                <a href="<?php echo base_url() . 'account/listaffiliate/' . $idGH ?>" target="_blank"
                                   alt="listaffiliate"><?php echo $thuocGH; ?></a>

                            </td>
                        </tr>

                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('staffstore_user'); ?>:
                            </td>
                            <td valign="bottom">
                                <a
                                    href="<?php echo base_url() . 'account/listaffiliate/' . $idNVGH ?>" target="_blank"
                                    alt="listaffiliate">
                                    <?php echo $thuocNVGH; ?></a>
                            </td>
                        </tr>

                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('bran_user'); ?>:
                            </td>
                            <td valign="bottom">
                                <a href="<?php echo base_url() . 'account/listaffiliate/' . $idCN ?>" target="_blank"
                                   alt="listaffiliate"><?php echo $thuocCN; ?></a>
                            </td>
                        </tr>

                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('staff_user'); ?>:
                            </td>
                            <td valign="bottom">
                                <a
                                    href="<?php echo base_url() . 'account/listaffiliate/' . $idNV ?>" target="_blank"
                                    alt="listaffiliate">
                                    <?php echo $thuocNV; ?></a>
                            </td>
                        </tr>

                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('sex_defaults'); ?>:
                            </td>
                            <td valign="bottom"><?php if ($user->use_sex == 1) echo "Nam"; else echo "Nữ"; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('address_defaults'); ?>:
                            </td>
                            <td valign="bottom">
                                <?php
                                $dc = $user->use_address ;
                                if($district!= ''){
                                    $dc.=', ' . $district;
                                }
                                if($province!= ''){
                                    $dc.= ', ' . $province;
                                }
                                echo $dc;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('email_defaults'); ?>:
                            </td>
                            <td valign="bottom"><?php echo $user->use_email; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('phone_defaults'); ?>:
                            </td>
                            <td valign="bottom"><?php echo $user->use_mobile; ?></td>
                        </tr>
                        <?php if ($user->use_yahoo != '') { ?>
                            <tr>
                                <td width="150" valign="top" height="35"
                                    class="list_post"><?php echo $this->lang->line('yahoo_defaults'); ?>:
                                </td>
                                <td valign="bottom"><?php echo $user->use_yahoo; ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($user->id_card != '') { ?>
                            <tr>
                                <td width="150" valign="top" height="35" class="list_post">Số CMND:</td>
                                <td valign="bottom"><?php echo $user->id_card; ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($user->tax_code != '') { ?>
                            <tr>
                                <td width="150" valign="top" height="35" class="list_post">Mã số
                                    thuế <?php echo $user->tax_type == 0 ? 'cá nhân' : 'doanh nghiệp'; ?>:
                                </td>
                                <td valign="bottom"><?php echo $user->tax_code; ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($user->use_skype != '') { ?>
                            <tr>
                                <td width="150" valign="top" height="35"
                                    class="list_post"><?php echo $this->lang->line('skype_defaults'); ?>:
                                </td>
                                <td valign="bottom"><?php echo $user->use_skype; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="150" valign="top" height="35" class="list_post"><font
                                    color="#FF0000"></font> <?php echo $this->lang->line('doanhthu_user'); ?>:
                            </td>
                            <td valign="bottom">
                                <?php if($doanhthu>0){  ?>
                                <a href="<?php echo base_url().$detailDT; ?>">
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($doanhthu, 0, ",", "."); ?>
                                        Vnđ</span>
                                </a>
                                <?php }
                                else{ ?>
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($doanhthu, 0, ",", "."); ?>
                                        Vnđ</span>
                              <?php  }?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END LEFT-->

<?php $this->load->view('home/common/footer'); ?>

<?php $this->load->view('home/common/account/header'); ?>


<style>
    .table-bordered {
        background: #fff;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php if ($this->uri->segment(2) == 'detailstatisticlistbran') {
                    echo 'Chi tiết doanh số theo hệ thống chi nhánh';
                } else {
                    echo 'Chi tiết doanh số theo Cộng tác viên online';
                } ?>

            </h4>
            <div class="visible-xs">
                <?php
                if (count($liststoreAF) > 0) {
                    foreach ($liststoreAF as $key => $items) {
                        $get_u = $this->user_model->fetch_join('use_id,parent_id,use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $items['shc_saler'] . '"');
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
                        switch ($get_u[0]->use_group) {
                            case AffiliateStoreUser:
                            case BranchUser:
                                if ($get_u[0]->domain != '') {
                                    $shopLink = $get_u[0]->domain . '/';
                                } else {
                                    $shopLink = $get_u[0]->sho_link . $duoi;
                                }
                                break;
                            case StaffStoreUser:
                            case StaffUser:
                                $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "INNER", "tbtt_shop", "sho_user = use_id", 'sho_user = "' . $get_u[0]->parent_id . '"');

                                if ($get_p[0]->domain != '') {
                                    $shopLink = $get_p[0]->domain . '/';
                                } else {
                                    $shopLink = $get_p[0]->sho_link . $duoi;
                                }

                                break;

                            case AffiliateUser:

                                $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
//                $get_u = $this->user_model->fetch('use_id,parent_id, use_group', 'use_username = "' . $order[0]->use_username . '"');
                                if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                    if ($get_p[0]->domain != '') {
                                        $shopLink = $get_p[0]->domain . '/';
                                    } else {
                                        $shopLink = $get_p[0]->sho_link . $duoi;
                                    }
                                } else {
                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');

                                    if ($get_p1[0]->use_group == AffiliateStoreUser || $get_p1[0]->use_group == BranchUser) {
                                        if ($get_p1[0]->domain != '') {
                                            $shopLink = $get_p1[0]->domain . '/';
                                        } else {
                                            $shopLink = $get_p1[0]->sho_link . $duoi;
                                        }
                                    } else {
                                        $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                        if ($get_p2[0]->use_group == StaffStoreUser || $get_p2[0]->use_group == AffiliateStoreUser) {
                                            if ($get_p2[0]->domain != '') {
                                                $shopLink = $get_p2[0]->domain . '/';
                                            } else {
                                                $shopLink = $get_p2[0]->sho_link . $duoi;
                                            }
                                        }
                                    }
                                }
                                break;
                        }
                        $shopLink = $protocol . $shopLink;

                        if ($items['af_id'] == 0) {
                            $use = $items['use_username'];
                            $info_parent = $items['info_parent'];
                            $p_id = $items['parent_id'];
                            $u_id = $items['use_id'];
                        } else {
                            $get_af = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $items['af_id'] . '" and parent_id = "' . $items['use_id'] . '"');
                            $get_af = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $items['af_id'] . '"');
                            $get_p = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $get_af->parent_id . '"');
                            if ($get_p->use_group == BranchUser) {
                                $cv = 'CN: ';
                            }
                            if ($get_p->use_group == StaffUser) {
                                $cv = 'NV: ';
                            }
                            $use = $get_af->use_username;
                            $p_id = $get_af->parent_id;
                            $u_id = $get_af->use_id;

                            $info_parent = $cv . $get_p->use_username . ', ' . $items['info_parent'];
                        }
                        if ($items['pro_type'] == 2) {
                            $pro_type = 'coupon';
                        } else {
                            if ($items['pro_type'] == 0) {
                                $pro_type = 'product';
                            }
                        }

                        $getofShop_CN = $this->user_model->fetch_join2("parent_id,shc_orderid, use_username, shc_quantity, shc_change_status_date, shc_total, pro_name", "INNER", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'use_id = "' . $this->uri->segment(3) . '"', $sort, $by, $start, '');
                        ?>
                        <div
                            style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                            <?php echo $key + 1 + $stt; ?>
                        </div>
                        <table class="table table-bordered active"
                               style="border-bottom:2px solid #999; background: #fff; font-size: 12px;">
                            <tr>
                                <td width="110"> Tên Cộng tác viên online</td>
                                <td>
                                    <a target="_blank" title="<?php echo $items['info_parent']; ?>"
                                       href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a>
                                    <div class="shop_parent active" style="color: orangered!important;font-size: 12px;">
                                        <!--                                        <a target="_blank" href="-->
                                        <?php //echo base_url(); ?><!--user/profile/-->
                                        <?php //echo $items['parent_id']; ?><!--">-->
                                        <i><?php echo $items['info_parent']; ?></i>
                                        <!--                                        </a>-->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Tên sản phẩm</td>
                                <td>
                                    <a target="_blank" class=""
                                       href="<?php echo $shopLink . 'shop/' . $pro_type ?>/detail/<?php echo $items['pro_id']; ?>/<?php echo RemoveSign($items['pro_name']); ?>">
                                        <?php echo $items['pro_name'] ?>
                                    </a>
                                </td>
                            <tr>
                                <td>Số lượng</td>
                                <td><?php echo $items['shc_quantity'] ?></td>
                            </tr>
                            <tr>
                                <td>Ngày mua</td>
                                <td><?php echo date('d-m-Y', $items['shc_change_status_date']); ?></td>
                            </tr>
                            <tr>
                                <td>Doanh thu</td>
                                <td>
                                    <a class="" target="_blank" title="Chi tiết đơn hàng"
                                       href="<?php echo base_url() . 'account/orderDetailTKSP/' . $items['shc_orderid']; ?>">
                                        <span
                                            style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['shc_total'], 0, ",", "."); ?>
                                            vnđ</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    <?php }
                    echo '<div>' . $linkPage . '</div>';
                } else { ?>
                    <table class="table table-bordered active"
                           style="border-bottom:2px solid #999; background: #fff; font-size: 12px;">
                        <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    </table>
                <?php } ?>

            </div>


            <div class="hidden-xs">
                <div style="overflow: auto; width:100%;">
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <?php if (count($liststoreAF) > 0) { ?>
                            <thead>
                            <tr>
                                <th width="5%" class="title_account_0">STT</th>
                                <th width="20%" class="title_account_2" align="center">
                                    Tên Cộng tác viên online
                                </th>
                                <th width=20%" class="title_account_2" align="center">
                                    Tên sản phẩm
                                </th>
                                <th width=15%" class="title_account_2" align="center">
                                    Số lượng
                                </th>
                                <th width=15%" class="title_account_2" align="center">
                                    Ngày mua
                                </th>
                                <th width=10%" class="title_account_2" align="">
                                    Doanh Thu
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total = 0;
                            foreach ($liststoreAF as $key => $items) {
                                $get_u = $this->user_model->fetch_join('use_id,parent_id,use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $items['shc_saler'] . '"');
                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
                                /*switch ($get_u[0]->use_group) {
                                    case AffiliateStoreUser:
                                    case BranchUser:
                                        if ($get_u[0]->domain != '') {
                                            $shopLink = $get_u[0]->domain.'/';
                                        } else {
                                            $shopLink = $get_u[0]->sho_link.$duoi;
                                        }
                                        break;
                                    case StaffStoreUser:
                                    case StaffUser:
                                        $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "INNER", "tbtt_shop", "sho_user = use_id", 'sho_user = "' . $get_u[0]->parent_id . '"');

                                        if ($get_p[0]->domain != '') {
                                            $shopLink = $get_p[0]->domain.'/';
                                        } else {
                                            $shopLink = $get_p[0]->sho_link.$duoi;
                                        }

                                        break;

                                    case AffiliateUser:

                                        $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
//                $get_u = $this->user_model->fetch('use_id,parent_id, use_group', 'use_username = "' . $order[0]->use_username . '"');
                                        if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                            if ($get_p[0]->domain != '') {
                                                $shopLink = $get_p[0]->domain.'/';
                                            } else {
                                                $shopLink= $get_p[0]->sho_link.$duoi;
                                            }
                                        } else {
                                            $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');

                                            if ($get_p1[0]->use_group == AffiliateStoreUser || $get_p1[0]->use_group == BranchUser) {
                                                if ($get_p1[0]->domain != '') {
                                                    $shopLink = $get_p1[0]->domain.'/';
                                                } else {
                                                    $shopLink = $get_p1[0]->sho_link.$duoi;
                                                }
                                            } else {
                                                $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                                if ($get_p2[0]->use_group == StaffStoreUser || $get_p2[0]->use_group == AffiliateStoreUser) {
                                                    if ($get_p2[0]->domain != '') {
                                                        $shopLink = $get_p2[0]->domain.'/';
                                                    } else {
                                                        $shopLink = $get_p2[0]->sho_link.$duoi;
                                                    }
                                                }
                                            }
                                        }
                                        break;
                                }
                                $shopLink=$protocol.$shopLink;*/

                                if ($items['af_id'] == 0) {
                                    $use = $items['use_username'];
                                    $info_parent = $items['info_parent'];
                                    $p_id = $items['parent_id'];
                                    $u_id = $items['use_id'];
                                } else {
//                                    $get_af = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $items['af_id'] . '" and parent_id = "' . $items['use_id'] . '"');
                                    $get_af = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $items['af_id'] . '"');
                                    $get_p = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $get_af->parent_id . '"');
                                    if ($get_p->use_group == BranchUser) {
                                        $cv = 'CN: ' . $get_p->use_username . ', ';
                                    }
                                    if ($get_p->use_group == StaffUser) {
                                        $cv = 'NV: ' . $get_p->use_username . ', ';
                                        $get_p1 = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $get_p->parent_id . '"');
                                        if ($get_p1->use_group == BranchUser) {
                                            $cv .= 'CN: ' . $get_p1->use_username . ', ';
                                        }
                                    }
                                    $use = $get_af->use_username;
                                    $p_id = $get_af->parent_id;
                                    $u_id = $get_af->use_id;

                                    $info_parent = $cv . $items['info_parent'];
                                }
                                if ($items['pro_type'] == 2) {
                                    $pro_type = 'coupon';
                                } else {
                                    if ($items['pro_type'] == 0) {
                                        $pro_type = 'product';
                                    }
                                }

                                $getofShop_CN = $this->user_model->fetch_join2("parent_id,shc_orderid, use_username, shc_quantity, shc_change_status_date, shc_total, pro_name", "INNER", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'use_id = "' . $this->uri->segment(3) . '"', $sort, $by, $start, '');
                                ?>
                                <tr>
                                    <td width="5%" height="32"
                                        class="line_account_0"><?php echo $key + 1 + $stt; ?></td>
                                    <td width="20%" height="32" class="line_account_2">
                                        <a target="_blank"
                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                            <?php echo $use; ?>
                                        </a>
                                        <div class="shop_parent active"
                                             style="color: orangered!important;font-size: 12px;">
                                            <!--                                        <a target="_blank" href="-->
                                            <?php //echo base_url(); ?><!--user/profile/-->
                                            <?php //echo $items['parent_id']; ?><!--">-->
                                            <i><?php echo $info_parent; ?></i>
                                            <!--                                        </a>-->
                                        </div>
                                    </td>
                                    <td width="20%" height="32" class="line_account_2">
                                        <a target="_blank" class=""
                                           href="<?php echo $protocol.$items['link_sp'] . '/shop/' . $pro_type  //echo $shopLink.'shop/'.$pro_type ?>/detail/<?php echo $items['pro_id']; ?>/<?php echo RemoveSign($items['pro_name']); ?>">
                                            <?php echo $items['pro_name'] ?>
                                        </a>
                                    </td>
                                    <td width="10%" height="32" class="line_account_2">
                                        <?php echo $items['shc_quantity'] ?>
                                    </td>
                                    <td width="10%" height="32" class="line_account_2">
                                        <?php echo date('d-m-Y', $items['shc_change_status_date']); ?>
                                    </td>
                                    <td width="20%" height="32" class="line_account_2" align="right">
                                        <a class="" target="_blank" title="Chi tiết đơn hàng"
                                           href="<?php echo base_url() . 'account/orderDetailTKSP/' . $items['shc_orderid']; ?>">
                                            <span
                                                style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['shc_total'], 0, ",", "."); ?>
                                                vnđ</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center">
                                    Không có dữ liệu!
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <?php echo $linkPage; ?>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>


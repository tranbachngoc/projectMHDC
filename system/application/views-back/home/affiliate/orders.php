<?php $this->load->view('home/common/account/header'); ?>

    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div id="af_products" class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách đơn hàng tôi đã giới thiệu bán</h4> 
                <div class="panel panel-default panel-custom">
                    <div class="panel-body">  
                        <form action="<?php echo $link; ?>" method="post" class="form-inline">
                            <div class="form-group">
                                <select name="month_fitter" autocomplete="off" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option <?php
                                        if ($filter['month_fitter'] && $filter['month_fitter'] > 0 && $filter['month_fitter'] == $i) {
                                            echo 'selected = "selected"';
                                        } elseif ($filter['month_fitter'] == "" && date('n') == $i) {
                                            echo 'selected = "selected"';
                                        }
                                        ?> value="<?php echo $i; ?>">Tháng <?php echo $i; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="year_fitter" autocomplete="off" class="form-control">
                                    <?php for ($i = date('Y',time()); $i >= date('Y',time()) - 10 ; $i--) { ?>
                                        <option <?php
                                        if ($filter['year_fitter'] && $filter['year_fitter'] > 0 && $filter['year_fitter'] == $i) {
                                            echo 'selected = "selected"';
                                        }
                                        ?> value="<?php echo $i; ?>">Năm <?php echo $i; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" autocomplete="off" class="form-control">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($status as $sta): ?>
                                        <option
                                            value="<?php echo $sta['status_id']; ?>" <?php echo ($filter['status'] == $sta['status_id']) ? 'selected="selected"' : ''; ?>><?php echo $sta['text']; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control padding-bottom" type="text" name="df"
                                       value="<?php echo $filter['df']; ?>"
                                       placeholder="Giá từ" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control padding-bottom" type="text" name="dt"
                                       value="<?php echo $filter['dt']; ?>"
                                       placeholder="Đến" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary padding-button">Tìm kiếm</button>
                                <!--<button type="submit" class="sButton"></button>-->
                                <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                            </div>
                        </form>
                    </div>
                </div>                
                <?php  if (count($orders) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>                            
                                <tr>
                                    <th>STT</th>
                                    <?php if ($this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser) { ?>
                                    <th>Người bán</th>
                                    <?php } ?>
                                    <th>Mã ĐH</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>SL</th>
                                    <th>Hoa hồng</th>
                                    <th>Cập nhật</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php foreach ($orders as $k => $order):
                                    if ($order['pro_type'] == 2) {
                                        $pro_type = 'coupon';
                                    } else {
                                        if ($order['pro_type'] == 0) {
                                            $pro_type = 'product';
                                        }
                                    }
                                    if ($this->session->userdata('sessionGroup') == AffiliateUser) {

                                        if ($order['sho_link'] == $parent || $order['domain'] == $parent) {
                                            $shopLink = $protocol . $parent . '.' . domain_site . '/shop/' . $pro_type . '/detail/' . $order['pro_id'] . '/' . RemoveSign($order['pName']);
                                            if ($order['domain'] == $parent) {
                                                $shopLink = $protocol . $parent . '/shop/' . $pro_type . '/detail/' . $order['pro_id'] . '/' . RemoveSign($order['pName']);
                                            }
                                        } else { //Get sho_link cua GH khac
                                            $shopLink = $protocol . $order['sho_link'] . '.' . domain_site . '/shop/' . $pro_type . '/detail/' . $order['pro_id'] . '/' . RemoveSign($order['pName']);
                                            if ($order['domain'] != '') {
                                                $shopLink = $protocol . $order['domain'] . '/shop/' . $pro_type . '/detail/' . $order['pro_id'] . '/' . RemoveSign($order['pName']);
                                            }
                                        }
                                    } else {
                                        $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$order['afId'] . '"');
                                        switch ($get_u[0]->use_group) {
                                            case AffiliateUser:
                                                $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                                                if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                                    if ($get_p[0]->domain != '') {
                                                        $parent = $get_p[0]->domain . '/';
                                                    } else {
                                                        $parent = $get_p[0]->sho_link . '.' . domain_site;
                                                    }
                                                } else {
                                                    if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                                        $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                        if ($get_p1[0]->domain != '') {
                                                            $parent = $get_p1[0]->domain . '/';
                                                        } else {
                                                            $parent = $get_p1[0]->sho_link . '.' . domain_site;
                                                        }
                                                    } else {
                                                        $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                        if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                                            $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                                            if ($get_p1[0]->domain != '') {
                                                                $parent = $get_p2[0]->domain . '/';
                                                            } else {
                                                                $parent = $get_p2[0]->sho_link . '.' . domain_site;
                                                            }
                                                        }
                                                    }
                                                }
                                                break;
                                        }
                                        $shopLink = $protocol . $parent . '/shop/' . $pro_type . '/detail/' . $order['pro_id'] . '/' . RemoveSign($order['pName']);
                                    }

                                    if ($order['af_rate'] > 0 || $order['af_amt'] > 0) {
                                        if ($order['af_rate'] > 0):
                                            $hoahong = $order['af_rate'];
                                            $moneyShop = ($order['shc_total']) * (1 - ($hoahong / 100));
                                            if ($order['em_discount'] > 0):
    //                                                        $hh_giasi = ($order['shc_total'])*(1-($hoahong / 100));
                                                $moneyShop = ($order['shc_total']) * (1 - ($hoahong / 100));
                                            endif;
                                        else:
                                            $hoahong = $order['af_amt'];
                                            $moneyShop = $order['shc_total'] - ($hoahong * $order['qty']); endif;
                                    } else {
                                        $moneyShop = $order['shc_total'];
                                    }

                                    //                                        if($productArray->em_discount>0){
                                    $dongia = $moneyShop / $order['qty'];
                                    //                                        };
                                    ?>
                                    <!-- Modal -->
                                    <div class="modal fade prod_detail_modal" id="myModal<?php echo $k; ?>"
                                         tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><i
                                                            class="fa fa-times-circle text-danger"></i></button>
                                                    <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if ($this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser) { ?>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-xs-4">Người bán:</div>
                                                            <div class="col-lg-9 col-xs-8">

                                                                <a target="_blank"
                                                                   href="<?php echo base_url(); ?>user/profile/<?php echo $order['afId']; ?>"> <?php echo $order['user_af']; ?></a>
                                                                <div class="shop_parent active"
                                                                     style="color: orangered !important; font-size: 12px;">
                                                                    <!--                                                                <a target="_blank" href="-->
                                                                    <?php //echo base_url(); ?><!--user/profile/-->
                                                                    <?php //echo $info_parent[$k]['parentId']; ?><!--">-->
                                                                    <i><?php echo $info_parent[$k]['info_parent'] ?></i>
                                                                    <!--                                                                </a>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Mã đơn hàng:</div>
                                                        <div class="col-lg-9 col-xs-8">

                                                            <a href="<?php echo base_url() ?>account/orderDetailTKSP/<?php echo $order['id']; ?>"
                                                               target="_blank" style="color: #00f">
                                                                <?php echo $order['id']; ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Tên sản phẩm:</div>
                                                        <div class="col-lg-9 col-xs-8"><a href="<?php echo $shopLink ?>"
                                                                                          target="_blank"><?php echo $order['pName']; ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Số lượng:</div>
                                                        <div
                                                            class="col-lg-9 col-xs-8"><?php echo $order['qty']; ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Giá sản phẩm:</div>
                                                        <div class="col-lg-9 col-xs-8">
                                <span
                                    class="product_price"><?php echo number_format($dongia, 0, ",", ".") . ' đ'; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Hoa hồng(đ):</div>
                                                        <div class="col-lg-9 col-xs-8">
                                                                                                        <span class="product_price_green">
                                                                                                                <?php echo number_format($order['af_amt'], 0, ',', '.') . " đ";
                                                        if ($order['af_rate'] > 0) {
                                                            echo '(' . $order['af_rate'] . '%)';
                                                        }; ?>
                                                                                                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Ngày cập nhật:</div>
                                                        <div
                                                            class="col-lg-9 col-xs-8"><?php echo $order['createdDate']; ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Trạng thái</div>
                                                        <div class="col-lg-9 col-xs-8">
                                                            <?php echo $order['pState']; ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td ><?php echo $num + $k + 1; ?></td>
                                        <?php if ($this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser) { ?>
                                            <td >
                                                <a target="_blank"
                                                   href="<?php echo base_url(); ?>user/profile/<?php echo $order['afId']; ?>"> <?php echo $order['user_af']; ?></a>
                                                <div class="shop_parent active"
                                                     style="color: orangered !important; font-size: 12px;">
                                                    <!--                                                <a target="_blank" href="-->
                                                    <?php //echo base_url(); ?><!--user/profile/-->
                                                    <?php //echo $info_parent[$k]['parentId']; ?><!--">-->
                                                    <i><?php echo $info_parent[$k]['info_parent'] ?></i>
                                                    <!--                                                </a>-->
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <td >

                                            <a href="<?php echo base_url() ?>account/orderDetailTKSP/<?php echo $order['id']; ?>"
                                               target="_blank"
                                               style="color: #00f">
                                                <?php echo $order['id']; ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo $shopLink ?>"
                                               target="_blank"><?php echo $order['pName']; ?>
                                            </a>
                                        </td>
                                        <td align="right">
                                            <span
                                                class="product_price"><?php echo number_format($dongia, 0, ",", ".") . ' đ'; ?></span>

                                        </td>
                                        <td align="center" ><?php echo $order['qty']; ?></td>
                                        <td align="right">
                                                                        <span class="product_price_green">
                                                                                <?php

                                        if ($order['af_rate'] > 0) {
                                            echo $order['af_rate'] . ' %';
                                        } else {
                                            echo number_format($order['af_amt'], 0, ',', '.') . " đ";
                                        } ?>
                                                                        </span>

                                        </td>
                                        <td align="center" ><?php echo $order['createdDate']; ?></td>
                                        <td align="center"><?php echo $order['pState']; ?>
                                            <p>
                                                <button type="button" class="btn btn-default1" data-toggle="modal"
                                                        data-target="#myModal<?php echo $k; ?>">
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>
                        <div align="center" class="show_page">
                            <?php echo $pager; ?>
                        </div>

                    </div>
                <?php } else { ?>
                    <div style="border:1px solid #eee; padding: 15px; text-align: center;">Không có đơn hàng nào!</div>
                <?php } ?>
            </div>
        </div>
    </div
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>

        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php echo $this->lang->line('title_my_order_defaults'); ?> của
                <?php
                if ($this->uri->segment(2) == 'bran_order') {
                    $get_u = $this->user_model->fetch('use_username,parent_id, use_group', 'use_id = "' . $this->uri->segment(3) . '"');
                    echo 'Chi Nhánh <span style="color:#f00;">' . $get_u[0]->use_username . '</span>';
                } else echo 'Gian hàng'; ?>
	    </h4>
            <div id="panel_order_af" class="panel panel-default">

                <div class="panel-body">
                    <div id="form_seach_order" class="col-sm-12">
                        <form action="<?php // echo $link;?>" method="post" class="searchBox form-inline">
                            <div class="input-group col-sm-3 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                <input class="form-control input-sm" type="text" name="order_id"
                                       value="<?php echo $params['order_id']; ?>" placeholder="Mã số đơn hàng ...">
                            </div>
                            <div class="input-group col-sm-4 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                <input class="form-control input-sm" type="text" name="username" value="<?php echo $params['username']; ?>" placeholder="Khách hàng ...">
                            </div>
                            <div class="input-group col-sm-4 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                <input class="form-control input-sm" type="text" name="ordmobile" value="<?php echo $params['ordmobile']; ?>" placeholder="SĐT người nhận...">
                            </div>
                            <div class="input-group col-sm-3 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                                <select class="form-control input-sm" type="text" name="order_status">
                                    <option value="">Trạng thái</option>
                                    <?php foreach ($status_order as $item) { ?>
                                        <option value="<?php echo $item['status_id']; ?>"><?php echo $item['text']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="input-group col-sm-4 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control input-sm" type="text" name="daterange" value="<?php echo $params['order_date']; ?>" placeholder="Từ ngày... đến ngày..." readonly/>
                            </div>
                            <div class="input-group col-sm-4 col-xs-12">
                                <div class="input-group-addon"><i class="fa fa-truck"></i></div>
                                <select class="form-control input-sm" type="text" name="ship_order">
                                    <option value="">Nhà vận chuyển</option>
                                    <option value="GHN">Giao hàng nhanh</option>
                                    <option value="VTP">Viettel Post</option>
                                    <option value="GHTK">Giao hàng tiết kiệm</option>
                                    <option value="SHO">Shop giao</option>
                                </select>
                            </div>
                            <?php if ($ismyorder && $ismyorder->id > 0) { ?>
                                <div class="input-group col-sm-3 col-xs-12">
                                    <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                    <input class="form-control input-sm" type="text" name="coupon_code" value="<?php echo $params['coupon_code']; ?>" placeholder="Mã Coupon hoặc dịch vụ ...">
                                </div>
                            <?php } ?>
                            <div class="input-group col-sm-3 col-xs-12">
                                <button type="submit" class="btn btn-azibai input-sm"><i class="fa fa-search"></i> Tìm
                                    kiếm
                                </button>
                            </div>
                            <input type="hidden" name="dir" value="<?php // echo $filter['dir'];              ?>"/>
                            <input type="hidden" name="sort" value="<?php // echo $filter['sort'];              ?>"/>
                        </form>
                    </div>
                </div>

            </div>
            <?php if (count($showcart) > 0) { ?>
                <form name="frmAccountShowcart" method="post">
                    <div style="width: 100%; overflow: auto;">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td width=""> Mã đơn hàng</td>
                                <td width=""> Ngày đặt hàng</td>
                                <td width=""> Thanh toán</td>
                                <?php if ($this->uri->segment(3) != 'coupon') { ?>
                                    <td width=""> Nhà vận chuyển</td>
                                    <td width=""> Trạng thái</td>
                                <?php } ?>
                                <td width="150px"> Tổng tiền</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $idDiv = 1;
                            $temp = 0;
                            ?>
                            <?php foreach ($showcart as $k => $showcartArray) { ?>

                                <?php
                                $protocol = "http://";//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                $duoi = '.' . $_SERVER['HTTP_HOST'];
                                
                                if ($showcartArray->pro_type == 2) {
                                    $pro_type = 'coupon';
                                } else {
                                    if ($showcartArray->pro_type == 0) {
                                        $pro_type = 'product';
                                    }
                                }
                                $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $showcartArray->shc_saler . '"');
                                switch ($get_u[0]->use_group) {
                                    case AffiliateStoreUser:
                                    case BranchUser:
                                        if ($get_u[0]->domain != '') {
                                            $domain1 = $get_u[0]->domain;
                                        } else {
                                            $parent1 = $get_u[0]->sho_link;
                                        }
                                        break;
                                    case StaffStoreUser:
                                    case StaffUser:
                                        $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');

                                        if ($get_p[0]->domain != '') {
                                            $domain1 = $get_p[0]->domain;
                                        } else {
                                            $parent1 = $get_p[0]->sho_link;
                                        }
                                        break;
                                    case AffiliateUser:
                                        $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                                        if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                            if ($get_p[0]->domain != '') {
                                                $domain1 = $get_p[0]->domain;
                                            } else {
                                                $parent1 = $get_p[0]->sho_link;
                                            }
                                        } else {
                                            if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                                $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                if ($get_p1[0]->domain != '') {
                                                    $domain1 = $get_p1[0]->domain;
                                                } else {
                                                    $parent1 = $get_p1[0]->sho_link;
                                                }
                                            } else {
                                                $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                                    $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                                    if ($get_p1[0]->domain != '') {
                                                        $domain1 = $get_p2[0]->domain;
                                                    } else {
                                                        $parent1 = $get_p2[0]->sho_link;
                                                    }
                                                }
                                            }
                                        }
                                        break;

                                }

                                if ($get_u[0]->domain != '') {
                                    $shop = $protocol .$domain1. '/shop/';
                                } else {
                                    $shop = $protocol .$parent1 . '.' . domain_site . '/shop/';
                                }

                                ?>
                                <!-- Modal -->
                                <div class="modal fade prod_detail_modal" id="myModal<?php echo $k; ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><i
                                                        class="fa fa-times-circle text-danger"></i></button>
                                                <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Mã đơn hàng</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php echo $showcartArray->id; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Tên khách hàng</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php echo $showcartArray->use_fullname; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Thời gian đặt hàng</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php echo date('d-m-Y H:i:s', ($showcartArray->date)); ?>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Trạng thái</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php
                                                        echo '</p>';
                                                        echo '<p>';
                                                        switch ($info_user_recivce->sho_payment_stutus) {
                                                            case '01':
                                                                echo '<span class="text-primary">' . status_1 . '</span>';
                                                                break;
                                                            case '02':
                                                                echo '<span class="text-primary">' . status_2 . '</span>';
                                                                break;
                                                            case '03':
                                                                echo '<span class="text-primary">' . status_3 . '</span>';
                                                                break;
                                                            case '04':
                                                                echo '<span class="text-primary">' . status_4 . '</span>';
                                                                break;
                                                            case '05':
                                                                echo '<span class="text-primary">' . status_5 . '</span>';
                                                                break;
                                                            case '06':
                                                                echo '<span class="text-primary">' . status_6 . '</span>';
                                                                break;
                                                            case '99':
                                                                echo '<span class=text-danger">' . status_99 . '</span>';
                                                                break;
                                                            case '98':
                                                                echo '<span class="text-primary">' . status_98 . '</span>';
                                                                break;
                                                        }
                                                        echo '</p>';
                                                        ?>
                                                        <select class="chang_status_order"
                                                                id="<?php echo $showcartArray->id ?>" name="status">
                                                            <option <?php echo ($showcartArray->shc_status == '01') ? "selected=\"selected\"" : ''; ?>
                                                                value="01">Tiếp nhận
                                                            </option>
                                                            <option <?php echo ($showcartArray->shc_status == '02') ? "selected=\"selected\"" : ''; ?>
                                                                value="02">Hoàn tất thanh toán
                                                            </option>
                                                            <option <?php echo ($showcartArray->shc_status == '03') ? "selected=\"selected\"" : ''; ?>
                                                                value="03">Đã xác nhận bởi người bán
                                                            </option>
                                                            <option <?php echo ($showcartArray->shc_status == '99') ? "selected=\"selected\"" : ''; ?>
                                                                value="99">Hủy
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php if ($this->uri->segment(3) != 'coupon') { ?>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Thanh toán:</div>
                                                        <div class="col-lg-9 col-xs-8">
                                                            <?php
                                                            switch ($showcartArray->payment_method) {
                                                                case 'info_nganluong':
                                                                    echo 'Qua Ngân Lượng';
                                                                    break;
                                                                case 'info_cod':
                                                                    echo 'Thanh toán trực tiếp';
                                                                    break;
                                                                case 'info_bank':
                                                                    echo 'Chuyển khoản';
                                                                    break;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-xs-4">Vận chuyển:</div>
                                                        <div class="col-lg-9 col-xs-8"> Nhà vận
                                                            chuyển <?php if ($showcartArray->shipping_method != '') echo $showcartArray->shipping_method; else 'Shop giao'; ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($temp == $showcartArray->id) {
                                    $clas = 'class="row_none"';
                                } else {
                                    $clas = '';
                                }
                                ?>
                                <tr <?php echo $clas; ?> >
                                    <td height="32">
                                        <a class="menu_1 text-primary"
                                           href="<?php echo base_url(); ?>account/order_detail/<?php echo $showcartArray->id; ?>">
                                            #<?php echo $showcartArray->id;
                                            ?>
                                        </a>
                                    </td>
                                    <td height="32" class="">
                                        <?php echo date('d/m/Y H:i:s', ($showcartArray->date)); ?>
                                    </td>
                                    <td height="32" class="">
                                        <?php
                                        switch ($showcartArray->payment_status) {
                                            case '0':
                                                echo 'Chưa thanh toán';
                                                break;
                                            case '1':
                                                echo 'Đã thanh toán';
                                                break;
                                        }
                                        ?>
                                    </td>

                                    <?php if ($this->uri->segment(3) != 'coupon') { ?>
                                        <td height="32" class="">

                                            <?php if ($showcartArray->order_coupon_code == '') { ?><?php
                                                switch ($showcartArray->shipping_method) {
                                                    case 'GHN':
                                                        echo 'Giao hàng nhanh';
                                                        break;
                                                    case 'VTP':
                                                        echo 'Viettel Post';
                                                        break;
                                                    case 'GHTK':
                                                        echo 'Giao hàng tiết kiệm';
                                                        break;
                                                    default:
                                                        echo 'Shop giao';
                                                        break;
                                                }
                                                ?>
                                                <?php
                                            } ?>
                                        </td>
                                        <td height="32">
                                            <?php
                                            echo '<p>';
                                            switch ($showcartArray->order_status) {
                                                case '01':
                                                    echo '<span class="text-primary">' . status_1 . '</span>';
                                                    break;
                                                case '02':
                                                    echo '<span class="text-primary">' . status_2 . '</span>';
                                                    break;
                                                case '03':
                                                    echo '<span class="text-primary">' . status_3 . '</span>';
                                                    break;
                                                case '04':
                                                    echo '<span class="text-primary">' . status_4 . '</span>';
                                                    break;
                                                case '05':
                                                    echo '<span class="text-primary">' . status_5 . '</span>';
                                                    break;
                                                case '06':
                                                    echo '<span class="text-primary">' . status_6 . '</span>';
                                                    break;
                                                case '99':
                                                    echo '<span class=text-danger">' . status_99 . '</span>';
                                                    break;
                                                case '98':
                                                    echo '<span class="text-primary">' . status_98 . '</span>';
                                                    break;
                                            }
                                            echo '</p>';
                                            ?>
                                            <!--<select class="chang_status_order" id="<?php /* echo $showcartArray->id */ ?>" name="status">
                                        <option <?php /* echo ($showcartArray->shc_status == '01')? "selected=\"selected\"": ''; */ ?> value="01">Tiếp nhận</option>
                                        <option <?php /* echo ($showcartArray->shc_status == '02')? "selected=\"selected\"": ''; */ ?> value="02">Hoàn tất thanh toán</option>
                                        <option <?php /* echo ($showcartArray->shc_status == '03')? "selected=\"selected\"": ''; */ ?> value="03">Đã xác nhận bởi người bán</option>
                                        <option <?php /* echo ($showcartArray->shc_status == '99')? "selected=\"selected\"": ''; */ ?> value="99">Hủy</option>
                                    </select>-->
                                        </td>
                                    <?php } ?>
                                    <td height="32">
                                        <span
                                            class="text-danger"><b><?php echo number_format($showcartArray->shc_total, 0, ',', '.'); ?>
                                                đ</b></span>
                                    </td>
                                    <!--                                <td class="visible-xs">
                                    <p>
                                        <button type="button" class="btn btn-default1" data-toggle="modal" data-target="#myModal<?php echo $k; ?>">
                                            <i class="fa fa-newspaper-o"></i>
                                        </button>
                                    </p>
                                </td>-->
                                </tr>
                                <tr>
                                    <td>
                                        <a class="menu_1" target="_blank" href="<?php echo $shop. $pro_type . '/detail/' . $showcartArray->pro_id . '/' . RemoveSign($showcartArray->pro_name); ?>">
                                            <?php
                                            if($showcartArray->shc_dp_pro_id > 0){
                                                 $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $showcartArray->pro_dir . '/thumbnail_1_' . $showcartArray->dp_images;
                                            }else{
                                                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $showcartArray->pro_dir . '/thumbnail_1_' . explode(',',$showcartArray->pro_image)[0];
                                            }
                                            if ($showcartArray->dp_images != '' || $showcartArray->pro_image != '') {//file_exists($filename) && $filename != ''
                                                ?>
                                                <img width="80" src="<?php echo $filename; ?>"/>
                                            <?php } else { ?>
                                                <img width="80"
                                                     src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                            <?php } ?>
                                        </a>
                                    </td>

                                    <?php if ($this->uri->segment(3) != 'coupon') {
                                        $colspan = 2;
                                    } else $colspan = 1; ?>
                                    <td colspan="<?php echo $colspan ?>">
                                        <a class="menu_1" target="_blank" href="<?php echo $shop. $pro_type . '/detail/' . $showcartArray->pro_id . '/' . RemoveSign($showcartArray->pro_name);  ?>">
                                            <?php echo $showcartArray->pro_name; ?>
                                        </a>
                                    </td>
                                    <td colspan="<?php echo $colspan ?>">Mã SP: <span
                                            class="text-primary"><?php echo $showcartArray->pro_sku; ?></span></td>
                                    <td>Số lượng: <span class="text-primary"><?php echo $showcartArray->shc_quantity; ?>
                                    </td>
                                </tr>
                                <?php //if(empty($viewbyparent)):    ?>
                                <tr id="DivRow_<?php echo $idDiv; ?>">
                                    <td colspan="6">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?php if ($showcartArray->pro_type != 0 && $showcartArray->order_status == '98' && $showcartArray->order_saler == (int)$this->session->userdata('sessionUser')) { ?>
                                                    <?php if ($showcartArray->status_use == 1) { ?>
                                                        <a class="btn btn-default1"
                                                           onclick="Action_apply(<?php echo $showcartArray->id; ?>)"
                                                           href="javascript:void(0)">
                                                            <i class="fa fa-check"></i> Đã sử dụng
                                                        </a>
                                                        <p class="text-info"><i><b>Xác nhận <?php
                                                                    if ($showcartArray->pro_type == 2) {
                                                                        echo 'coupon';
                                                                    } elseif ($showcartArray->pro_type == 1) {
                                                                        echo 'dịch vụ';
                                                                    }
                                                                    ?> đã được sử dụng</b></i></p>
                                                    <?php } elseif ($showcartArray->status_use == 2) { ?>
                                                        <p class="text-success"><b>Đã sử
                                                                dụng: <?php echo date('d/m/Y : H:m:i', $showcartArray->change_status_date); ?></b>
                                                        </p>
                                                    <?php } elseif ($showcartArray->status_use == 0) { ?>
                                                        <p><b>Chưa sử dụng</b></p>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php if (isset($showcartArray->ord_note) && $showcartArray->ord_note != '') { ?>
                                                    <span><i>Ghi chú: <?php echo $showcartArray->ord_note; ?></i></span>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php if ($showcartArray->pro_type == 2 && $showcartArray->order_saler == (int)$this->session->userdata('sessionUser') && $showcartArray->order_status != '99') { ?>
                                                    <?php //if ($showcartArray->order_status < 2 && $showcartArray->order_coupon_code != '') { ?>
                                                    <!--                                                        <p class="text-center"><b>Mã coupon: --><?php //echo $showcartArray->order_coupon_code; ?><!--</b></p>-->
                                                    <?php // } else
//                                                        if ($showcartArray->order_status == '02' && $showcartArray->order_coupon_code != '') {
                                                    if ($showcartArray->order_status == '02') { ?>
                                                        <p class="text-center"><b>Mã coupon: <span
                                                                    style="text-decoration: line-through"><?php echo $showcartArray->order_coupon_code; ?></span></b>
                                                        </p>
                                                    <?php } else { ?>
                                                        <p class="text-center"><b>Mã coupon: Chờ xác nhận</b></p>
                                                    <?php } ?>
                                                <?php } else
                                                    if ($showcartArray->pro_type == 2 && $showcartArray->order_status == '99') { ?>
                                                        <p class="text-center">Mã coupon: <b>Đã hủy</b></p>
                                                    <?php } ?>
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <a class="btn btn-danger btn-sm"
                                                   href="<?php echo base_url(); ?>account/order_detail/<?php echo $showcartArray->id; ?>">
                                                    <i class="fa fa-sign-in"></i> Chi tiết
                                                </a>
                                            </div>
                                        </div>
                                        <?php if ($showcartArray->pro_type == 0) { ?>
                                            <div class="text-warning"><b>Bạn cần xử lý đơn hàng này trong
                                                    vòng <?php echo process_oder_time; ?></b></div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php //endif; ?>
                                <?php $idDiv++; ?>
                                <?php $sTT++; ?>
                                <?php $temp = $showcartArray->id; ?>
                            <?php } ?>
                            </tbody>
                            <?php if (isset($linkPage) && $linkPage != '') { ?>
                                <tfoot>
                                <tr>
                                    <td colspan="6" class="show_page"><?php echo $linkPage; ?></td>
                                </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </form>
            <?php } else { ?>
                <div class="none_record">
                    <p class="text-center">Không có đơn hàng nào</p>
                </div>
            <?php } ?>

        </div>

    </div>
</div>
<input id="baseUrl" type="hidden" value="<?php echo base_url() ?>"/>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($successAddShowcart) && trim($successAddShowcart) != '') { ?>
    <script>
        alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/daterangepicker.css"/>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>templates/home/js/moment.js"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>templates/home/js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>templates/home/js/daterangepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>templates/home/js/vi.js"></script>
<script type="text/javascript">
    function Action_apply(id) {
        confirm(function (e1, btn) {
            e1.preventDefault();
            var url = '<?php echo base_url(); ?>account/order/coupon/apply/' + id;
            window.location.href = url;
        });
        return false
    }
    $(function () {
        $('input[name="daterange"]').daterangepicker({
            ranges: {
                'Hôm nay': [moment(), moment()],
                'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Trong vòng 7 ngày': [moment().subtract(6, 'days'), moment()],
                'Trong vòng 30 ngày': [moment().subtract(29, 'days'), moment()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Hủy',
                applyLabel: 'Xác nhận'
            },
            cancelClass: 'btn-danger',
            alwaysShowCalendars: true,
            autoApply: false
        });
        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    });
</script>

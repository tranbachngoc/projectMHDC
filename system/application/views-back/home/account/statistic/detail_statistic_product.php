<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                THỐNG KÊ DOANH SỐ Từ NGƯỜI MUA
            </h2>
            <div class="visible-xs">
                <?php
                if (count($staffs) > 0) {
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
                    $sum = 0;
                    foreach ($staffs as $key => $items) {
                        ?>
                        <div
                            style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                            <?php echo $stt + 1 + $key; ?>
                        </div>
                        <table class="table table-bordered active"
                               style="border-bottom:2px solid #999; background: #fff; font-size: 12px;">
                            <tr>
                                <td width="110">Tài khoản</td>
                                <td>
                                    <?php
                                    if ($items->use_username == '') {
                                        foreach ($shopname as $key => $itemst) {
                                            echo $itemst->use_username;
                                        }
                                    } else {
                                        echo $items->use_username;
//                                    echo '<a href="'.base_url().'user/profile/'.$items->use_id.'" target="_blank"> '.$items->use_username.'</a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Loại tài khoản</td>
                                <td>
                                    <?php if ($items->gro_descr != '') {
                                        echo $items->gro_descr;
                                    } else { ?>
                                        Gian hàng có phí và miễn phí
                                    <?php } ?>
                                </td>
                            <tr>
                                <td>Số lượng</td>
                                <td><?php echo $items->shc_quantity; ?></td>
                            </tr>
                            <tr>
                                <td>Đơn giá</td>
                                <td><?php echo number_format($items->pro_cost, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>Doanh số</td>
                                <td>
                                    <a class="dso" target="_blank" title="Chi tiết đơn hàng"
                                       href="<?php echo base_url() . 'account/orderDetailTKSP/' . $items->shc_orderid; ?>">
                                        <?php
                                        $gia = $items->shc_quantity * $items->pro_price;
                                        if ($items->em_discount > 0) {
                                            $gia = ($items->shc_quantity * $items->pro_price) - $items->em_discount;
                                        }
                                        /*$promotions=$this->product_promotion_model->getPromotion(array('pro_id' => $items->pro_id));
                                        if(!empty($promotions)):
                                            foreach($promotions as $vt=>$pro):
                                                if(($pro['limit_from']<=$items->shc_quantity && $pro['limit_to']>=$items->shc_quantity)||($pro['limit_from']<=$gia && $pro['limit_to']>=$gia)) {
                                                    $gia = ($items->shc_quantity * $items->pro_price) - $pro['dc_amount'];
                                                }
                                            endforeach;
                                        endif;*/

                                        $sum += $gia;
                                        echo number_format($gia, 0, ",", "."); ?>
                                    </a>
                                    <?php if ($items->pro_price_rate > 0 || $items->pro_price_amt > 0) { ?>
                                        <br/>
                                        Khuyến mãi:
                                        <?php if (!empty($items->pro_price_rate)): ?>
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->pro_price_rate, 0, ",", "."); ?>
                                                %</span>
                                        <?php else: ?>
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->pro_price_amt, 0, ",", "."); ?>
                                                vnđ</span>
                                        <?php endif; ?>
                                        <?php
                                        if ($items->em_discount > 0) {
                                            ?>
                                            <br/>
                                            Giảm giá sỉ:
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->em_discount, 0, ",", "."); ?>
                                                đ</span>
                                        <?php } ?>
                                        <?php
                                    }
                                    //                                if ($product->af_id > 0) {
                                    if ($items->af_dc_amt > 0) {
                                        $type = 'VND';
                                    } else {
                                        $type = '%';
                                    }
                                    //                                }
                                    if ($items->af_id > 0) {
                                        if ($items->af_dc_amt > 0 || $items->af_dc_rate > 0) {

                                            ?>
                                            <br/> Giảm qua CTV:
                                            <?php if ($items->af_dc_amt > 0): ?>
                                                <span
                                                    class="text-success text-right"><?php echo number_format($items->af_dc_amt, 0, ",", "."); ?>
                                                    <?php echo $type ?></span>
                                            <?php else: ?>
                                                <span
                                                    class="text-success text-right"><?php echo number_format($items->af_dc_rate, 0, ",", "."); ?>
                                                    <?php echo $type ?></span>
                                            <?php endif; ?>
                                            <?php
                                        }
                                        if ($items->af_amt > 0) {
                                            $type = 'VND';
                                        } else {
                                            $type = '%';
                                        }
                                        if ($this->session->userdata('sessionGroup') == AffiliateUser) {
                                            if ($items->af_rate > 0 || $items->af_amt > 0) {
                                                ?>
                                                <br/>Hoa hồng CTV:
                                                <?php if (!empty($items->af_rate)): ?>
                                                    <span
                                                        class="text-success text-right"><?php echo number_format($items->af_rate, 0, ",", "."); ?>
                                                        %</span>
                                                <?php else: ?>
                                                    <span
                                                        class="text-success text-right"><?php echo number_format($items->af_amt, 0, ",", "."); ?>
                                                        vnđ</span>
                                                <?php endif; ?>
                                                <p class="clear"></p>
                                            <?php }
                                        }
                                    } ?>
                                    <style>
                                        .dso {
                                            color: #f00 !important;
                                        }
                                    </style>
                                </td>
                            </tr>

                        </table>
                
                        <?php
                    }
                    ?>
                <strong style="float:right;font-size: 14px;">Tổng cộng: <span style="color:#F00"><b><?php echo number_format($sum, 0, ",", "."); ?> đ</b></span></strong>
                <?php
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
                <?php }
                ?>

            </div>

            <div class="hidden-xs">
                <div class="db_table" style="overflow: auto; width:100%">
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="5%" class="title_account_0">STT</th>
                            <th width="15%" class="title_account_2" align="center">
                                Tài khoản
                            </th>
                            <th width="20%" class="title_account_2" align="center">
                                Loại tài khoản
                            </th>
                            <th width="10%" class="title_account_2" align="center">
                                Số lượng
                            </th>
                            <th width="15%" class="title_account_2" align="center">
                                Đơn giá(vnđ)
                            </th>
                            <th width="15%" class="title_account_2" align="center">
                                Doanh số(vnđ)
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/asc<?php echo $pageSort; ?>')"
                                     border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/desc<?php echo $pageSort; ?>')"
                                     border="0" style="cursor:pointer;" alt=""/>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sum = 0;
                        foreach ($staffs as $key => $items) {
                            ?>
                            <tr>
                                <td width="5%" height="32" class="line_account_0"><?php echo $key + 1 + $stt; ?></td>
                                <td width="15%" height="32" class="line_account_2">

                                    <?php
                                    if ($items->use_username == '') {
                                        foreach ($shopname as $key => $itemst) {
                                            echo $itemst->use_username;
                                        }
                                    } else {
                                        echo $items->use_username;
//                                    echo '<a href="'.base_url().'user/profile/'.$items->use_id.'" target="_blank"> '.$items->use_username.'</a>';
                                    }
                                    ?>

                                </td>
                                <?php if ($items->gro_descr != '') { ?>
                                    <td width="20%" height="32" class="line_account_2">
                                        <?php echo $items->gro_descr; ?>
                                    </td>
                                <?php } else { ?>
                                    <td width="20%" height="32" class="line_account_2">
                                        Gian hàng có phí và miễn phí
                                    </td>
                                <?php } ?>
                                <td width="10%" height="32" class="line_account_2">
                                    <?php echo $items->shc_quantity; ?>
                                </td>
                                <td width="15%" height="32" class="line_account_2">
                                    <?php echo number_format($items->pro_cost, 0, ",", "."); ?>
                                </td>
                                <td width="25%" height="32" class="line_account_2">
                                    <a class="dso" target="_blank" title="Chi tiết đơn hàng"
                                       href="<?php echo base_url() . 'account/orderDetailTKSP/' . $items->shc_orderid; ?>">
                                        <?php
                                        $gia = $items->shc_quantity * $items->pro_price;
                                        if ($items->em_discount > 0) {
                                            $gia = ($items->shc_quantity * $items->pro_price) - $items->em_discount;
                                        }
                                        /*$promotions=$this->product_promotion_model->getPromotion(array('pro_id' => $items->pro_id));
                                        if(!empty($promotions)):
                                            foreach($promotions as $vt=>$pro):
                                                if(($pro['limit_from']<=$items->shc_quantity && $pro['limit_to']>=$items->shc_quantity)||($pro['limit_from']<=$gia && $pro['limit_to']>=$gia)) {
                                                    $gia = ($items->shc_quantity * $items->pro_price) - $pro['dc_amount'];
                                                }
                                            endforeach;
                                        endif;*/

                                        $sum += $gia;
                                        echo number_format($gia, 0, ",", "."); ?>
                                    </a>
                                    <?php if ($items->pro_price_rate > 0 || $items->pro_price_amt > 0) { ?>
                                        <br/>
                                        Khuyến mãi:
                                        <?php if (!empty($items->pro_price_rate)): ?>
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->pro_price_rate, 0, ",", "."); ?>
                                                %</span>
                                        <?php else: ?>
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->pro_price_amt, 0, ",", "."); ?>
                                                vnđ</span>
                                        <?php endif; ?>
                                        <?php
                                        if ($items->em_discount > 0) {
                                            ?>
                                            <br/>
                                            Giảm giá sỉ:
                                            <span
                                                class="text-success text-right"><?php echo number_format($items->em_discount, 0, ",", "."); ?>
                                                đ</span>
                                        <?php } ?>
                                        <?php
                                    }
                                    //                                if ($product->af_id > 0) {
                                    if ($items->af_dc_amt > 0) {
                                        $type = 'VND';
                                    } else {
                                        $type = '%';
                                    }
                                    //                                }
                                    if ($items->af_id > 0) {
                                        if ($items->af_dc_amt > 0 || $items->af_dc_rate > 0) {

                                            ?>
                                            <br/> Giảm qua CTV:
                                            <?php if ($items->af_dc_amt > 0): ?>
                                                <span
                                                    class="text-success text-right"><?php echo number_format($items->af_dc_amt, 0, ",", "."); ?>
                                                    <?php echo $type ?></span>
                                            <?php else: ?>
                                                <span
                                                    class="text-success text-right"><?php echo number_format($items->af_dc_rate, 0, ",", "."); ?>
                                                    <?php echo $type ?></span>
                                            <?php endif; ?>
                                            <?php
                                        }
                                        if ($items->af_amt > 0) {
                                            $type = 'VND';
                                        } else {
                                            $type = '%';
                                        }
                                        if ($this->session->userdata('sessionGroup') == AffiliateUser) {
                                            if ($items->af_rate > 0 || $items->af_amt > 0) {
                                                ?>
                                                <br/>Hoa hồng CTV:
                                                <?php if (!empty($items->af_rate)): ?>
                                                    <span
                                                        class="text-success text-right"><?php echo number_format($items->af_rate, 0, ",", "."); ?>
                                                        %</span>
                                                <?php else: ?>
                                                    <span
                                                        class="text-success text-right"><?php echo number_format($items->af_amt, 0, ",", "."); ?>
                                                        vnđ</span>
                                                <?php endif; ?>
                                                <p class="clear"></p>
                                            <?php }
                                        }
                                    } ?>
                                    <style>
                                        .dso {
                                            color: #f00 !important;
                                        }
                                    </style>
                                </td>
                            </tr>
                        <?php } ?>
                        <td colspan="5" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng
                            cộng:
                        </td>
                        <td colspan="2" class="detail_list"><span
                                style="color:#F00; font-size: 15px"><b><?php echo number_format($sum, 0, ",", "."); ?>
                                    đ</b></span>
                        </td>
                        </tbody>
                    </table>
                    <?php if (count($linkPage) > 0) { ?>
                        <tr>
                            <td colspan="7"><?php echo $linkPage; ?></td>
                        </tr>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_data_hidden_field(shop_name, user_id, username) {
        $('#shop_name').text(shop_name);
        $('#shop_id').val(user_id);
    }

    function add_shop_for_user() {
        if ($('#child_list').val() != '') {
            use_id = $('#child_list').val();
            shop_id = $('#shop_id').val();
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + 'account/tree/store',
                cache: false,
                data: {use_id: use_id, shop_id: shop_id},
                dataType: 'text',
                success: function (data) {
                    if (data == '1') {
                        alert("Cập nhật thành công!");
                        $('.modal').modal('hide');
                        location.reload();
                    } else {
                        errorAlert('Có lỗi xảy ra', 'Thông báo');
                    }
                }
            });
        } else {
            alert("Vui lòng chọn thành viên cần gán!");
        }
        return false;
    }
</script>

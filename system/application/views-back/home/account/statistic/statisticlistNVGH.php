<style>
    #statistic .tab-pane {
        padding-top: 20px;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        padding: 10px;
    }
</style>
<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">Thống kê chung </h2>

            <div id="panel_direct">

                <div id="main">
                    <?php //if ($this->session->userdata('sessionGroup') == 3): ?>
                    <ul class="nav nav-tabs">
                        <li class="<?php if ($this->uri->segment(5) != 'detailstatisticlistaffiliate') echo 'active'; ?>"
                            id="tab1"
                            style="<?php if ($this->session->userdata('sessionGroup') == BranchUser) echo 'display:none'; ?>">
                            <a aria-expanded="true" href="#tab2success" data-toggle="tab">Doanh
                                thu Chi Nhánh</a></li>
                        <li class="<?php if (($this->uri->segment(5) != '' && $this->uri->segment(5) == 'detailstatisticlistaffiliate') || $this->session->userdata('sessionGroup') == BranchUser) echo 'active'; ?>"
                            id="tab2"><a aria-expanded="false" href="#tab1success" data-toggle="tab">Doanh
                                thu Cộng tác viên</a></li>
                        <form name="frmAccountPro" id="frmAccountPro" style="display: none;"
                              action="<?php echo base_url(); ?>account/statisticlistNVGH/userid/<?php echo $this->uri->segment(4); ?>"
                              method="post">
                            <label>
                                <div style="display: none;" class="checkbox">
                                    <input type="text" id="no_store" value="0"/>
                            </label>
                </div>
                </form>
                </ul>

                <?php //endif; ?>
                <div class="tab-content" id="statistic">
                    <?php // if($this->session->userdata('sessionGroup') == 3):?>
                    <div
                        class="tab-pane fade <?php if ($this->uri->segment(5) != 'detailstatisticlistaffiliate') echo 'active in'; ?>"
                        id="tab2success"
                        style="<?php if ($this->session->userdata('sessionGroup') == BranchUser) echo 'display:none'; ?>">
                        <div class="box_div">
                            <?php
                            if ($this->uri->segment(5) == 'detailstatisticlistbran') {
                                ?>
                                <h2 class="page-title text-uppercase">
                                    THỐNG KÊ DOANH SỐ CỦA CHI NHÁNH <span style="color: #f00"><?php echo $name ?></span>
                                </h2>
                                <div class="db_table" style="overflow: auto; width:100%">

                                    <table class="table table-bordered" width="100%" border="0" cellpadding="0"
                                           cellspacing="0">
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
                                            $i = 0;
                                            foreach ($liststoreAF as $key => $items) {
                                                if ($items['af_id'] == 0) {
                                                    $use = $items['use_username'];
                                                    $info_parent = $items['info_parent'];
                                                    $p_id = $items['parent_id'];
                                                    $u_id = $items['use_id'];
                                                } else {
//                                                    $get_af = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $items['af_id'] . '" and parent_id = "' . $items['use_id'] . '"');
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
//                                                    $use =  $items['use_username'];
//                                                    $info_parent = $items['info_parent'];

                                                $get_u = $this->user_model->fetch_join('use_id,parent_id,use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $items['use_id'] . '"');
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
                                                if ($items['pro_type'] == 2) {
                                                    $pro_type = 'coupon';
                                                } else {
                                                    if ($items['pro_type'] == 0) {
                                                        $pro_type = 'product';
                                                    }
                                                }
                                                ?>
                                                <tr style="<?php //if(($items['af_id'] != 0) && ($get_af->parent_id != $items['use_id'])){ echo 'display: none';} ?>">
                                                    <td width="5%" height="32"
                                                        class="line_account_0"><?php echo $key + 1; ?></td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <a target="_blank"
                                                           href="<?php echo base_url(); ?>user/profile/<?php echo $u_id; ?>">
                                                            <?php echo $use; ?>
                                                        </a>
                                                        <div class="shop_parent active"
                                                             style="font-size: 12px;color: orangered!important;">
                                                            <!--                                                            <a target="_blank" href="-->
                                                            <?php //echo base_url(); ?><!--user/profile/-->
                                                            <?php //echo $p_id; ?><!--">-->
                                                            <i><?php echo $info_parent; ?></i>
                                                            <!--                                                            </a>-->
                                                        </div>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <a target="_blank" class=""
                                                           href="<?php echo $shopLink . 'shop/' . $pro_type ?>/detail/<?php echo $items['pro_id']; ?>/<?php echo RemoveSign($items['pro_name']); ?>">
                                                            <?php echo $items['pro_name'] ?>
                                                        </a>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo $items['shc_quantity'] ?>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo date('d-m-Y', $items['shc_change_status_date']); ?>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2"
                                                        align="right">
                                                        <a class="" target="_blank" title="Chi tiết đơn hàng"
                                                           href="<?php echo base_url() . 'account/orderDetailTKSP/' . $items['shc_orderid']; ?>">
                                                                    <span
                                                                        style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['shc_total'], 0, ",", "."); ?>
                                                                        vnđ</span>
                                                        </a>
                                                        <!--                                                            --><?php //if ($items['use_group'] == BranchUser) { ?>
                                                        <!--                                                                <a class="" target="_blank" title="Chi tiết đơn hàng"-->
                                                        <!--                                                                   href="-->
                                                        <?php //echo base_url() . 'account/orderDetailTKSP/' . $items['shc_orderid']; ?><!--">-->
                                                        <!--                                                                    <span-->
                                                        <!--                                                                        style="color: #ff0000; font-weight: 600">  --><?php //echo number_format($items['shc_total'], 0, ",", "."); ?>
                                                        <!--                                                                        vnđ</span>-->
                                                        <!--                                                                </a>-->
                                                        <!--                                                            --><?php //} else { ?>
                                                        <!--                                                                <a href="-->
                                                        <?php //echo base_url(); ?><!--account/statisticlistNVGH/userid/-->
                                                        <?php //echo $this->uri->segment(4) ?><!--/detailstatisticlistaffiliate/-->
                                                        <?php //echo $items['use_id']; ?><!--">-->
                                                        <!--                                                                    <span-->
                                                        <!--                                                                        style="color: #ff0000; font-weight: 600"> --><?php //echo number_format($items['shc_total'], 0, ",", "."); ?>
                                                        <!--                                                                        vnđ</span>-->
                                                        <!--                                                                </a>-->
                                                        <!--                                                            --><?php //} ?>
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
                                <?php
                            } else {
                                ?>
                                <h2 class="page-title text-uppercase">
                                    THỐNG KÊ DOANH SỐ THEO CHI NHÁNH
                                </h2>
                                <div class="db_table" style="overflow: auto; width:100%">
                                    <form class="form-inline" action="" style="float: left;width: 100%"
                                          method="post">
                                        <br>
                                        <div class="form-group">
                                            <label for="date1"> Lọc doanh số từ ngày: </label>
                                            <input type="date" class="form-control" id="datefrom"
                                                   name="datefrom"
                                                   value="<?php echo $afsavedatefrom ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="date2"> Đến ngày: </label>
                                            <input type="date" class="form-control" id="dateto"
                                                   name="dateto"
                                                   value="<?php echo $afsavedateto ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="filter"></label>
                                            <button type="submit" class="btn btn-primary">Thực hiện</button>
                                        </div>
                                    </form>
                                    <?php
                                    $total = 0;
                                    //Chỉ lay doanh thu của GH cha k lấy doanh thu từ GH khác
                                    if ($this->session->userdata('sessionGroup') != StaffUser) {
                                        if ($tree != '') {
                                            $shc_saler = ' and shc_saler IN(' . $tree . ')';
                                        }

                                    } else {
                                        $get_p = $this->user_model->get('parent_id', 'use_id = ' . $this->session->userdata('sessionUser'));
                                        $shc_saler = ' and shc_saler IN(' . $get_p->parent_id . ')';
                                    }
                                    //END lay doanh thu của GH cha k lấy doanh thu từ GH khác

                                    foreach ($staffs as $key => $items) {
                                        //get CN cua NVGH co AF co DT
                                        $shc_saler = ' and ((shc_saler IN(' . $items->parent_id . ') and parent_id IN(' . $items->use_id . ')) OR (shc_saler IN(' . $items->use_id . ') and parent_id IN(' . $items->parent_id . ')))';
                                        $where = 'use_status = 1 and shc_status IN(01,02,03,98) and (use_group =' . AffiliateUser . ' or  use_group =' . BranchUser . ')' . $shc_saler;
                                        //join bang de dat dieu kien pro_of_shop
                                        $get_aff = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items->use_id);
                                        $get_p = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items->parent_id);
                                        $paGH_saler = $items->parent_id;
                                        $paCN_saler = $items->use_id;
                                        if ($get_p->use_group == StaffStoreUser || $get_p->use_group == StaffUser) {
                                            $paGH_saler = $get_p->parent_id;
                                            if ($get_aff->use_group == AffiliateUser) {
                                                $paCN_saler = $get_p->parent_id;
                                            }
                                        }
                                        $shc_saler = ' and ( ( shc_saler IN(' . $paGH_saler . ') and parent_id IN(' . $items->use_id . ')) OR (shc_saler IN(' . $paCN_saler . ') AND parent_id IN(' . $items->parent_id . ')) )';
                                        $where = 'use_status = 1 and shc_status IN(01,02,03,98) and (use_group =' . AffiliateUser . ' or  use_group =' . BranchUser . ')' . $shc_saler . $saler;
                                        $where_af = $where . $saler;//.' AND pro_of_shop != 0 '  ;OR parent_id IN(' . $items['parent_id'] . ')


//                                        $ds = $this->user_model->fetch_join3("use_id,use_username, use_fullname,use_email,use_mobile,tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id,tbtt_showcart.*, SUM(shc_total) As showcarttotal,", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", "LEFT","tbtt_product","tbtt_showcart.shc_product = tbtt_product.pro_id", $where_af, $sort, $by, $start, $limit);
                                        $join_4 = "LEFT";
                                        $table_4 = "tbtt_order";
                                        $on_4 = "tbtt_showcart.shc_orderid = tbtt_order.id"; //join bang de dat dieu kien pro_of_shop
                                        $group_by = 'id, tbtt_showcart.af_id, pro_id';
                                        $ds = $this->user_model->fetch_join4("use_id,use_username, use_fullname,use_email,use_mobile,tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id,tbtt_showcart.*, SUM(shc_total) As showcarttotal,", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $join_4, $table_4, $on_4, $where_af, $sort, $by, $start, $limit, true, $group_by);

                                        $total += $ds[0]->showcarttotal;

                                    }
                                    ?>
                                    <div colspan="6" class="text-right detail_list"
                                         style="font-weight: 600; font-size: 15px">Tổng doanh thu chi nhánh: <span
                                            style="color:#F00; font-size: 15px"><b><?php echo number_format($total, 0, ",", "."); ?>
                                                VNĐ</b></span></div>

                                    <table class="table table-bordered" width="100%" border="0" cellpadding="0"
                                           cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="5%" class="title_account_0">STT</th>
                                            <th width="20%" class="title_account_2" align="center">
                                                Chi nhánh
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/asc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/desc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                            </th>
                                            <th width="20%" class="title_account_2" align="center">
                                                Tên đăng nhập
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                            </th>
                                            <th width=25%" class="title_account_2" align="center">
                                                Họ tên
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                                <img
                                                    src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                    onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')"
                                                    border="0" style="cursor:pointer;" alt=""/>
                                            </th>
                                            <th width=15%" class="title_account_2" align="center">
                                                Email - Số điện thoại
                                            </th>
                                            <th width=10%" class="title_account_2" align="center">
                                                Doanh Thu (Vnđ)
                                                <!--<img
                                                        src="<?php /*echo base_url(); */ ?>templates/home/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php /*echo $sortUrl; */ ?>doanhthu/by/asc<?php /*echo $pageSort; */ ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>
                                                    <img
                                                        src="<?php /*echo base_url(); */ ?>templates/home/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php /*echo $sortUrl; */ ?>doanhthu/by/desc<?php /*echo $pageSort; */ ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>-->
                                            </th>
                                            <!--                        <th width=15%" class="title_account_2" align="center" >-->
                                            <!--                            Gán-->
                                            <!--                        </th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $total = 0;
                                        $stt = 0;
                                        ?>
                                        <?php
                                        if ($this->session->userdata('sessionGroup') != StaffUser) {
                                            if ($tree != '') {
                                                $shc_saler = ' OR shc_saler IN(' . $tree . ') OR af_id IN(' . $tree . ')';
                                            } else {
                                                $shc_saler = ' OR shc_saler IN(' . $tree . ') OR af_id IN(' . $tree . ')';
                                            }
                                        } else {
                                            $get_p = $this->user_model->get('parent_id', 'use_id = ' . $this->session->userdata('sessionUser'));
                                            $shc_saler = ' OR shc_saler IN(' . $get_p->parent_id . ')';
                                            $tree = $get_p->use_id;
                                        }

                                        foreach ($staffs as $key => $items) {
                                            $get_aff = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items->use_id);
                                            $get_p = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items->parent_id);
                                            $paGH_saler = $items->parent_id;
                                            $paCN_saler = $items->use_id;
                                            if ($get_p->use_group == StaffStoreUser || $get_p->use_group == StaffUser) {
                                                $paGH_saler = $get_p->parent_id;
                                                if ($get_aff->use_group == AffiliateUser) {
                                                    $paCN_saler = $get_p->parent_id;
                                                }
                                            }
//                                            $shc_saler = ' and ((shc_saler IN(' . $items->parent_id . ') and parent_id IN(' . $items->use_id . ')) OR (shc_saler IN(' . $items->use_id . ') AND af_id=0 and parent_id IN(' . $items->parent_id . ')))';
                                            //get CN cua NVGH co AF co DT
//                                            $shc_saler = ' and ((shc_saler IN(' . $items->parent_id . ') and parent_id IN(' . $items->use_id . ')) OR (shc_saler IN(' . $items->use_id . ') and parent_id IN(' . $items->parent_id . ')))';
//                                            $shc_saler = ' and (parent_id IN(' . $items->use_id . ') OR parent_id IN(' . $items->parent_id . '))';
//                                            $shc_saler = ' and (parent_id IN(' . $items->use_id.','. $items->parent_id. '))';
                                            $shc_saler = ' and ( ( shc_saler IN(' . $paGH_saler . ') and parent_id IN(' . $items->use_id . ')) OR (shc_saler IN(' . $paCN_saler . ') AND parent_id IN(' . $items->parent_id . ')) )';
                                            $where = 'use_status = 1 and shc_status IN(01,02,03,98) and (use_group =' . AffiliateUser . ' or  use_group =' . BranchUser . ')' . $shc_saler . $saler;
                                            /*if($this->session->userdata('sessionGroup') == AffiliateStoreUser){
                                                $where .= ' AND pro_of_shop != 0 ';
                                            }*/

                                            //.' AND pro_of_shop != 0 '  ;OR parent_id IN(' . $items['parent_id'] . ')
//                                            $ds = $this->user_model->fetch_join3("use_id,use_username, use_fullname,use_email,use_mobile,tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id,tbtt_showcart.*,SUM(tbtt_showcart.shc_total) As showcarttotal,", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", "LEFT","tbtt_product","tbtt_showcart.shc_product = tbtt_product.pro_id", $where, $sort, $by, $start, $limit);
                                            $join_4 = "LEFT";
                                            $table_4 = "tbtt_order";
                                            $on_4 = "tbtt_showcart.shc_orderid = tbtt_order.id"; //join bang de dat dieu kien pro_of_shop
                                            $group_by = 'id, tbtt_showcart.af_id, pro_id';
                                            $ds = $this->user_model->fetch_join4("use_id,use_username, use_fullname,use_email,use_mobile,tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id,tbtt_showcart.*, SUM(shc_total) As showcarttotal,", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $join_4, $table_4, $on_4, $where, $sort, $by, $start, $limit, true, $group_by);

                                            if ($ds[0]->showcarttotal != '') {
                                                $p1 = $this->user_model->get('use_username,use_id, parent_id, use_group', 'use_id = ' . $items->parent_id);
                                                $shop = $this->user_model->fetch_join('use_username,use_id, parent_id, use_group, sho_link, domain', 'LEFT', 'tbtt_shop', 'sho_user = use_id', 'sho_user =' . $p1->parent_id);

                                                $info_parent .= 'GH: ' . $p1->use_username;
                                                if ($p1->use_group == StaffStoreUser) {
                                                    $info_parent = 'NVGH: ' . $p1->use_username . ', ';
                                                    $get_p1 = $this->user_model->get('use_id, parent_id, use_group, use_username', 'use_id = "' . $p1->parent_id . '"');
                                                    $info_parent .= 'GH: ' . $get_p1->use_username;
                                                }

                                                ?>
                                                <tr>
                                                    <td width="5%" height="32"
                                                        class="line_account_0"><?php echo $key + 1; ?></td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <?php
                                                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                                        $domainName = $_SERVER['HTTP_HOST'];
                                                        if ($items->domain != '') {
                                                            $domain = $protocol . $items->domain;
                                                        } else {
                                                            if ($shop[0]->domain != '') {
                                                                $domain = $protocol . $shop[0]->domain . '/' . $items->sho_link;
                                                            } else {
                                                                $domain = $protocol . $shop[0]->sho_link . '.' . substr(base_url(), 7, strlen(base_url())) . $items->sho_link;
                                                            }
                                                        }

                                                        ?>
                                                        <a target="_blank" href="<?php echo $domain ?>/shop">
                                                            <?php echo $items->sho_name; ?></a>
                                                    </td>
                                                    <td width="25%" height="32" class="line_account_2">
                                                        <div
                                                            class=" <?php if ($items->parent_id == $this->session->userdata('sessionUser')) { ?>active<?php } ?>">
                                                            <a href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"
                                                               target="_blank">
                                                                <?php echo $items->use_username; ?></a>
                                                            <div class="shop_parent active"
                                                                 style="font-size: 12px;color: orangered!important;">
                                                                <!--                                                                <a target="_blank" href="-->
                                                                <?php //echo base_url(); ?><!--user/profile/-->
                                                                <?php //echo $p1->use_id; ?><!--">-->
                                                                <i><?php echo $info_parent ?></i>
                                                                <!--                                                                </a>-->
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="15%" height="32" class="line_account_2">
                                                        <?php echo $items->use_fullname; ?>
                                                    </td>
                                                    <td width="15%" height="32" class="line_account_2">
                                                        <i class="fa fa-envelope-o fa-fw"></i>
                                                        <a href="mailto:<?php echo $items->use_email; ?>"><?php echo $items->use_email; ?></a>
                                                        <br/>
                                                        <i class="fa fa-phone fa-fw"></i><?php echo $items->use_mobile; ?>
                                                    </td>
                                                    <td width="15%" height="32" class="line_account_2"
                                                        align="right">
                                                        <?php
                                                        $total += $ds[0]->showcarttotal; ?>
                                                        <a href="<?php echo base_url(); ?>account/statisticlistNVGH/userid/<?php echo $this->uri->segment(4) ?>/detailstatisticlistbran/<?php echo $items->use_id ?>">
                                    <span
                                        style="color: #ff0000; font-weight: 600"> <?php
                                        echo number_format($ds[0]->showcarttotal, 0, ",", ".");
                                        //                                        echo number_format($items->shc_total, 0, ",", ".");
                                        ?>
                                        </span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } ?>

                                        <?php
                                        if (isset($total)) {
                                            if ($total > 0) { ?>
                                                <td colspan="5" class="text-right detail_list"
                                                    style="font-weight: 600; font-size: 15px">Tổng doanh
                                                    thu:
                                                </td>
                                                <td colspan="2" class="detail_list"><span
                                                        style="color:#F00; font-size: 15px"><b><?php echo number_format($total, 0, ",", "."); ?>
                                                            VNĐ</b></span></td>


                                                <?php
                                            } else { ?>
                                                <tr>
                                                    <td colspan="8">
                                                        <div class="nojob">Không có chi nhánh nào!</div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                    <?php if (count($linkPage) > 0) { ?>
                                        <tr>
                                            <td colspan="8"><?php echo $linkPage; ?></td>
                                        </tr>
                                    <?php } ?>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal_Shop" tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Chọn thành viên cần
                                                        gán
                                                        cho <span
                                                            id="shop_name"></span></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <select name="child_list" id="child_list">
                                                        <option value="">--Chọn thành viên--</option>
                                                        <?php foreach ($tree_list as $itemtree) { ?>
                                                            <option
                                                                value="<?php echo $itemtree->use_id; ?>"><?php echo $itemtree->use_username; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="shop_id" id="shop_id" value="0"/>
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">
                                                        Hủy
                                                    </button>
                                                    <button type="button" onclick="add_shop_for_user();"
                                                            class="btn btn-primary">Lưu lại
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade <?php if (($this->uri->segment(5) != '' && $this->uri->segment(5) == 'detailstatisticlistaffiliate') || ($this->session->userdata('sessionGroup') == BranchUser)) echo 'fade active in'; ?>"
                        id="tab1success">
                        <div class="box_div">
                            <?php
                            if ($this->uri->segment(5) == 'detailstatisticlistaffiliate') {
                                ?>
                                <h2 class="page-title text-uppercase">
                                    Thống kê doanh số của ctv <span style="color: #f00"><?php echo $name ?></span>
                                </h2>
                                <div class="db_table" style="overflow: auto; width:100%">

                                    <table class="table table-bordered" width="100%" border="0" cellpadding="0"
                                           cellspacing="0">
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
                                                if ($items['pro_type'] == 2) {
                                                    $pro_type = 'coupon';
                                                } else {
                                                    if ($items['pro_type'] == 0) {
                                                        $pro_type = 'product';
                                                    }
                                                }


                                                ?>
                                                <tr>
                                                    <td width="5%" height="32"
                                                        class="line_account_0"><?php echo $key + 1; ?></td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <a target="_blank"
                                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                                            <?php echo $items['use_username']; ?>
                                                        </a>
                                                        <div class="shop_parent active"
                                                             style="font-size: 12px;color: orangered!important;">
                                                            <!--                                                            <a target="_blank" href="-->
                                                            <?php //echo base_url(); ?><!--user/profile/-->
                                                            <?php //echo $items['parent_id']; ?><!--">-->
                                                            <i><?php echo $items['info_parent']; ?></i>
                                                            <!--                                                            </a>-->
                                                        </div>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <a target="_blank" class=""
                                                           href="<?php echo $shopLink . 'shop/' . $pro_type ?>/detail/<?php echo $items['pro_id']; ?>/<?php echo RemoveSign($items['pro_name']); ?>">
                                                            <?php echo $items['pro_name'] ?>
                                                        </a>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo $items['shc_quantity'] ?>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo date('d-m-Y', $items['shc_change_status_date']); ?>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2"
                                                        align="right">
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
                                <?php
                            } else {
                                ?>
                                <h2 class="page-title text-uppercase">
                                    Thống kê doanh số theo Cộng tác viên online
                                </h2>

                                <div class="text-right detail_list" style="font-weight: 600; font-size: 15px ;">
                                    <form class="form-inline" action="" style="float: left;width: 100%"
                                          method="post">
                                        <br>
                                        <div class="form-group">
                                            <label for="date1"> Lọc doanh số từ ngày: </label>
                                            <input type="date" class="form-control" id="datefrom" name="datefrom"
                                                   value="<?php echo $afsavedatefrom ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="date2"> Đến ngày: </label>
                                            <input type="date" class="form-control" id="dateto" name="dateto"
                                                   value="<?php echo $afsavedateto ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="filter"></label>
                                            <button type="submit" class="btn btn-primary">Thực hiện</button>
                                        </div>
                                    </form>
                                    <?php
                                    //foreach($staffs as $key => $items)
                                    $total = 0;
                                    foreach ($liststoreAF1 as $items) {
                                        $total += $items['shc_total'];
                                    }
                                    ?>
                                    Tổng doanh thu các Cộng tác viên: <span
                                        style="color:#F00; font-size: 15px"><b><?php echo number_format($total, 0, ",", "."); ?>
                                            VNĐ</b></span>
                                </div>

                                <div style="overflow: auto; width:100%">
                                    <table class="table table-bordered" style="min-width: 600px;">
                                        <?php if ($liststoreAF1[0]['use_id'] != '') { ?>
                                            <thead>
                                            <tr>
                                                <th width="5%" class="title_account_0">STT</th>
                                                <th width="20%" class="title_account_2" align="center">
                                                    Tài khoản
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>
                                                </th>
                                                <th width="20%" class="title_account_2" align="center">
                                                    Tên Gian hàng
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                        onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')"
                                                        border="0" style="cursor:pointer;" alt=""/>
                                                </th>
                                                <th width="10%" class="title_account_2" align="center">
                                                    Link Gian hàng

                                                </th>
                                                <th width="10%" class="title_account_2" align="center">
                                                    Email - Điện thoại
                                                </th>
                                                <th width="10%" class="title_account_2" align="center">
                                                    Doanh Thu (Vnđ)
                                                    <!--<img
                                                            src="<?php /*echo base_url(); */ ?>templates/home/images/sort_asc.gif"
                                                            onclick="ActionSort('<?php /*echo $sortUrl; */ ?>doanhthu/by/asc<?php /*echo $pageSort; */ ?>')"
                                                            border="0" style="cursor:pointer;" alt=""/>
                                                        <img
                                                            src="<?php /*echo base_url(); */ ?>templates/home/images/sort_desc.gif"
                                                            onclick="ActionSort('<?php /*echo $sortUrl; */ ?>doanhthu/by/desc<?php /*echo $pageSort; */ ?>')"
                                                            border="0" style="cursor:pointer;" alt=""/>-->
                                                </th>
                                                <?php if ((int)$this->session->userdata('sessionGroup') == AffiliateStoreUser) { ?>
                                                    <th width="10%" class="title_account_2" align="center">
                                                        Cấu hình
                                                    </th>
                                                <?php } ?>
                                                <!--                            --><?php //if($this->session->userdata('sessionGroup') > 3) {           ?>
                                                <!--                                <th width=10%" class="title_account_2" align="center" >-->
                                                <!--                                    Gán gian hàng-->
                                                <!--                                </th>-->
                                                <!--                            --><?php //}           ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!--        --><?php
                                            //foreach($staffs as $key => $items)
                                            $total = 0;

                                            foreach ($liststoreAF1 as $items) {
                                                $stt++;

                                                $get_u = $this->user_model->fetch_join('use_id,parent_id,use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $items['use_id'] . '"');
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
                                                ?>
                                                <tr>
                                                    <td width="5%" height="32"
                                                        class="line_account_0"><?php echo $stt; ?></td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <a target="_blank"
                                                           title="<?php echo $items['info_parent']; ?>"
                                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a>
                                                        <br>
                                                        <div class="shop_parent active"
                                                             style="font-size: 12px;color: orangered!important;">
                                                            <!--                                                            <a target="_blank" href="-->
                                                            <?php //echo base_url(); ?><!--user/profile/-->
                                                            <?php //echo $items['parent_id']; ?><!--">-->
                                                            <i><?php echo $items['info_parent']; ?></i>
                                                            <!--                                                            </a>-->
                                                        </div>
                                                        <p style="font-size: 12px; color: #f57420"><i>
                                                                <!-- <?php
                                                                foreach ($liststoreAF as $itemshop) {
                                                                    if ($items['parent_shop'] == $itemshop['sho_user']) {
                                                                        echo 'Thuộc gian hàng: ' . $itemshop['sho_name'];
                                                                    }
                                                                }
                                                                ?> -->

                                                            </i></p>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2">

                                                        <?php
                                                        echo $items['sho_name'] != '' ? '<a href="' . $shopLink . $items['sho_link'] . '/news" target="_blank">' . $items['sho_name'] : "Chưa cập nhật";
                                                        ?>
                                                    </td>

                                                    <?php
                                                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                                    $domainName = $_SERVER['HTTP_HOST'];
                                                    ?>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <?php /*if ($items['sho_link'] != '') { */ ?><!--
                                                                <a target="_blank" <?php /*if ($items['haveDomain'] != '' && $items['pgroup'] == 3) { */ ?> href="<?php /*echo $protocol . $items['haveDomain'] . '/' . $items['sho_link']; */ ?>" <?php /*} elseif ($items['haveDomain'] == '' && $items['pgroup'] == 3) { */ ?> href="<?php /*echo $protocol . $items['pshop'] . '.' . $domainName . '/' . $items['sho_link']; */ ?>" <?php /*} else { */ ?> href="<?php /*echo $protocol . $items['sho_link'] . '.' . $domainName; */ ?>" <?php /*} */ ?> >
                                                                    <?php /*echo $items['sho_link']; */ ?>

                                                                </a>
                                                            <?php /*} else { */ ?>
                                                                Chưa cập nhật
                                                            --><?php /*} */ ?>
                                                        <a href="<?php echo $shopLink . $items['sho_link'] ?>/shop"
                                                           target="_blank"><?php echo $items['sho_link'] ?></a>

                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <i class="fa fa-envelope-o fa-fw"></i>
                                                        <a href="mailto:<?php echo $items['use_email']; ?>"><?php echo $items['use_email']; ?></a>
                                                        <br/>
                                                        <i class="fa fa-phone fa-fw"></i><?php echo $items['use_mobile']; ?>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">

                                                        <a href="<?php echo base_url(); ?>account/statisticlistNVGH/userid/<?php echo $this->uri->segment(4) ?>/detailstatisticlistaffiliate/<?php echo $items['use_id']; ?>">
                                        <span
                                            style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['shc_total'], 0, ",", "."); ?>
                                            </span>
                                                        </a>
                                                    </td>
                                                    <?php if ((int)$this->session->userdata('sessionGroup') == AffiliateStoreUser) { ?>
                                                        <td width="5%" height="32"
                                                            class="line_account_2 text-center">
                                                            <a href="<?php echo base_url() . 'account/affiliate/configforuseraff/' . $items['use_id']; ?>"
                                                               title="CH thưởng thêm <?php echo $items['use_username']; ?>"><i
                                                                    class="fa fa-cogs"></i></a>
                                                        </td>
                                                    <?php } ?>
                                                    <?php $total += $items['shc_total']; ?>
                                                </tr>
                                            <?php } ?>

                                            <tr>

                                                <td colspan="<?php if ((int)$this->session->userdata('sessionGroup') == AffiliateStoreUser) {
                                                    echo '7';
                                                } else echo '6'; ?>" class="text-right detail_list"
                                                    style="font-weight: 600; font-size: 15px">
                                                    Tổng doanh thu: <span
                                                        style="color:#F00; font-size: 15px"><b><?php echo number_format($total, 0, ",", "."); ?>
                                                            Đ</b></span>
                                                </td>
                                                <!--                                            <td colspan="2" class="detail_list">-->

                                                <!--                                            </td>-->
                                            </tr>
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
                                <?php
                            }
                            ?>
                            <div><?php echo $linkPage_AFF; ?></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php // endif; ?>
                    <?php // if($group_3_charts): ?>
                    <?php echo $service_charts; ?>
                    <?php // else: ?>
                    <?php // echo $other_charts; ?>
                    <?php // endif; ?>
                </div>
            </div>

        </div>
    </div>
    <!--BEGIN: RIGHT-->
</div>
</div>
<script>

    jQuery(document).ready(function (jQuery) {
//        $('#catsub').change(function () {
//            $('#frmAccountPro').submit();
//        });

        /*$('#tab1').addClass('active');
         $("#tab2").click(function (ev) {
         $('#no_store').val('2');
         $('#tab2').addClass('active');
         $('#tab1').removeClass('active');
         $('#tab1success').addClass('  active in');
         $('#tab2success').removeClass('  active in');
         });
         $("#tab1").click(function () {
         $('#no_store').val('1');
         $('#tab2').removeClass('active');
         $('#tab2success').addClass('  active in');
         $('#tab1success').removeClass('  active in');
         });*/
    });

</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
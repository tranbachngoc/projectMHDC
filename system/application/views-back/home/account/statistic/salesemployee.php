<?php $this->load->view('home/common/header'); ?>


<?php
    /*$total = 0;
    if ($this->session->userdata('sessionGroup') != StaffUser) {
        $shc_saler = ' and shc_saler IN(' . $tree . ')';
    } else {
        $get_p = $this->user_model->get('parent_id', 'use_id = ' . $this->session->userdata('sessionUser'));
        $shc_saler = ' and shc_saler IN(' . $get_p->parent_id . ')';
    }
    $left3 = "LEFT";
    $tb3 = "tbtt_product";
    $join3 = "tbtt_showcart.shc_product = tbtt_product.pro_id"; //join bang de dat dieu kien pro_of_shop
    $join_4 = "LEFT";
    $table_4 = "tbtt_order";
    $on_4 = "tbtt_showcart.shc_orderid = tbtt_order.id"; //join bang de dat dieu kien pro_of_shop
    //$groupBy = 'id,tbtt_showcart.af_id,pro_id';
    $groupBy = '';
    foreach ($liststoreAF as $key => $items) {
        /*$tree = array();
        $tree[] = (int)$this->session->userdata('sessionUser');
        $sub_tructiep = $this->user_model->get_list_user('use_id, use_group', 'use_group IN (15,14, 11,2) AND use_status = 1 AND parent_id = "' . $items['use_id'] . '"');

        if (!empty($sub_tructiep)) {
            foreach ($sub_tructiep as $key => $value) {
                $tree[] = $value->use_id;
                //Nếu là chi nhánh, lấy danh sách nhân viên
                if ($value->use_group == StaffStoreUser) {
                    $sub_nv = $this->user_model->get_list_user('use_id, use_group', 'use_group IN (14, 11,2) AND use_status = 1 AND parent_id = ' . $value->use_id);
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                            if ($v->use_group == BranchUser) {
                                $sub_nvcn = $this->user_model->get_list_user('use_id, use_group', 'use_group IN (11,2) AND use_status = 1 AND parent_id = ' . $v->use_id);
                                if (!empty($sub_nvcn)) {
                                    foreach ($sub_nvcn as $k => $vlue) {
                                        $tree[] = $vlue->use_id;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($value->use_group == BranchUser) {
                    $tree[] = $value->use_id;
                    $sub_nv = $this->user_model->get_list_user('use_id, use_group', 'use_group IN (11,2) AND use_status = 1 AND parent_id = ' . $value->use_id);
                    if (!empty($sub_nv)) {
                        foreach ($sub_nv as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }

            }
        }
        $id = implode(',', $tree);
        $shc_saler = ' and (( (shc_saler IN(' . $id . ')) and parent_id IN(' . $items['use_id'] . ')) OR (shc_saler IN(' . $id . ') and parent_id IN(' . $items['use_id'] . ')) )';
*/
        /*//bo sug
        $get_aff = $this->user_model->get('use_group,parent_id', 'use_id = ' .$items['use_id']);
        $get_p = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items['parent_id']);
        $paGH_saler = $items['parent_id'];
        $paCN_saler = $items['use_id'];
        if ($get_p->use_group == StaffStoreUser || $get_p->use_group == StaffUser) {
            $paGH_saler = $get_p->parent_id;
            if ($get_aff->use_group == AffiliateUser) {
                $paCN_saler = $get_p->parent_id;
            }
        }
        $shc_saler = ' and ( ( shc_saler IN(' . $paGH_saler . ') and parent_id IN(' . $items['use_id'] . ')) OR (shc_saler IN(' . $paCN_saler . ') AND parent_id IN(' . $items['parent_id'] . ')) )';
        //end bo sung*/
/*
        $get_aff = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items['use_id']);
        $get_p = $this->user_model->get('use_group,parent_id', 'use_id = ' . $items['parent_id']);
        if ($get_aff->use_group == StaffUser) {
            $shc_saler = ' and (( (shc_saler IN(' . $get_aff->parent_id . ')) and parent_id IN(' . $items['use_id'] . ')) OR (shc_saler IN(' . $get_aff->parent_id . ') and parent_id IN(' . $items['use_id'] . ')) )';
        }
        $get_aff = $this->user_model->get('use_group,parent_id', 'use_id IN(' . $id . ') and use_group = ' . AffiliateUser);
        if (!empty($get_aff)) {
            foreach ($get_aff as $vl) {
                $get_p = $this->user_model->get('use_group,parent_id', 'use_id = "' . $vl->parent_id . '"');
                if ($get_p->use_group == StaffUser) {
                    $tree .= ',' . $get_p->parent_id;
                }
            }
        }

        if (!empty($tree)) {
            $where_af = 'use_status = 1 and shc_status IN(01,02,03,98) and (use_group =' . AffiliateUser . ' or  use_group =' . BranchUser . ')' . $shc_saler . $searchtime . $saler;
            $ds = $this->user_model->fetch_join4("use_id,use_username, use_fullname,use_email,use_mobile,tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id,tbtt_showcart.*,SUM(tbtt_showcart.shc_total) As showcarttotal,", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", $left3, $tb3, $join3, $join_4, $table_4, $on_4, $where_af, $sort, $by, $start, $limit, false, $groupBy);


            $moneyNV = $ds[0]->showcarttotal;

            $liststoreAF[$key]['doanhso'] = $moneyNV;

            $total += $moneyNV;


        }
    } */?> 


<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Thống kê doanh số theo nhân viên
            </h4>  
            <?php if($total>0 || afsavedateto || afsavedatefrom) { ?>
            <style>
            @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
                table, thead, tbody, th, td, tr {
                    display: block; 
                }
                table { border: none !important;}
                thead tr {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                } 
                tr { border: none !important; border-bottom: 1px solid #eee !important;
                   margin-bottom: 20px; }
                td {
                    border: 1px solid #eee !important;
                    border-bottom: none !important; 
                    position: relative;
                    padding-left: 140px !important;
                }

                td:before {    
                    background: #fdfdfd;
                    position: absolute;
                    left: 0; top:0; bottom:0;
                    width: 132px;  padding: 8px;
                    border-right:1px solid #eee;
                    white-space: nowrap; text-align: right;
                }
                td:nth-of-type(1):before { content: "STT"; }
                td:nth-of-type(2):before { content: "Tài khoản"; }
                td:nth-of-type(3):before { content: "Họ & Tên"; }
                td:nth-of-type(4):before { content: "Email"; }
                td:nth-of-type(5):before { content: "Điện thoại"; }
                td:nth-of-type(6):before { content: "Doanh Thu"; }
            }
        </style>
                <div class="panel panel-default panel-custom">
                    <div class="panel-body">
                        <form class="form-inline" action="" method="post">                                
                            <label for="date1"> Lọc doanh số từ ngày: </label>
                            <input type="date" class="form-control" id="datefrom" name="datefrom"
                                   value="<?php echo $afsavedateto ?>">
                            <br class="visible-xs">
                            <label for="date2"> Đến ngày: </label>
                            <input type="date" class="form-control" id="dateto" name="dateto"
                                   value="<?php echo $afsavedatefrom ?>">
                            <br class="visible-xs">
                            <label for="filter"></label>
                            <button type="submit" class="btn btn-azibai">Thực hiện</button>                                
                        </form>
                    </div>  
                </div>
                <?php if($total>0) { ?>
            
                <div style="overflow:auto; width:100%;">
                    <table class="table table-bordered" style="margin:15px 0">                                        
                        <thead>
                            <tr>
                                <th class="title_account_0">STT</th>
                                <th class="title_account_2" align="center">
                                    Tài khoản
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                </th>
                                <th class="title_account_2" align="center">
                                    Họ & Tên
                                </th>
                                <th class="title_account_2" align="center">
                                    Email
                                </th>
                                <th class="title_account_2" align="center">
                                    Điện thoại
                                </th>
                                <th class="title_account_2" align="center">
                                    Doanh Thu
                                    <!--                                <img src="-->
                                    <?php //echo base_url(); ?><!--templates/home/images/sort_asc.gif"-->
                                    <!--                                     onclick="ActionSort('<?php //echo $sortUrl; ?>//doanhthu/by/asc<?php //echo $pageSort; ?>//')"
    //                                     border="0" style="cursor:pointer;" alt=""/>
    //                                <img src="<?php //echo base_url(); ?><!--templates/home/images/sort_desc.gif"-->
                                    <!--                                     onclick="ActionSort('<?php //echo $sortUrl; ?>//doanhthu/by/desc<?php //echo $pageSort; ?>//')"
    //                                     border="0" style="cursor:pointer;" alt=""/>-->
                                </th>
                            </tr>
                        </thead>

                        <tbody>                            
                            <?php foreach ($liststoreAF as $key => $items) { ?>  
                                <?php //if ($items['doanhso'] != '') { ?>
                                        <tr>
                                            <td class="line_account_0"><?php echo ++$stt; ?></td>
                                            <td class="line_account_2">
                                                <a target="_blank"
                                                   href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                                    <?php echo $items['use_username']; ?></a>
                                                <div class="shop_parent active"
                                                     style="font-size: 12px;color: orangered!important;">
                                                    <!--                                                <a target="_blank" href="-->
                                                    <?php //echo base_url(); ?><!--user/profile/-->
                                                    <?php //echo $items['parent_id']; ?><!--">-->
                                                    <i><?php echo $items['info_parent']; ?></i>
                                                    <!--                                                </a>-->
                                                </div>
                                            </td>
                                            <td class="line_account_2">
                                                <?php echo $items['use_fullname'] != '' ? $items['use_fullname'] : "Chưa cập nhật"; ?>
                                            </td>
                                            <td class="line_account_2">
                                                <a href="mailto:<?php echo $items['use_email']; ?>"><?php echo $items['use_email']; ?></a>
                                            </td>
                                            <td class="line_account_2">
                                                <?php echo $items['use_mobile']; ?>
                                            </td>
                                            <td class="line_account_2" align="right">
                                                <a href="<?php echo base_url(); ?>account/statisticlistNVGH/userid/<?php echo $items['use_id']; ?>">
                                            <span
                                                style="color: #ff0000; font-weight: 600"><?php echo number_format($items['showcarttotal'], 0, ",", "."); ?>
                                                vnđ</span></a>
                                            </td>
                                        </tr>
                                    <?php //} ?>
                             <?php } ?>
                        </tbody>                    
                    </table>
                    <div class="text-right">
                        <strong>Tổng doanh thu: </strong>
                        <strong style="color:#F00; font-size: 15px"><?php echo number_format($total, 0, ",", "."); ?> VNĐ</styrong>
                    </div>
                </div>
                <?php echo $linkPage; ?>
                <?php }else { ?>
                    <div style="text-align: center; padding: 10px; border:1px solid #eee;">Không có dữ liệu được tìm thấy.</div>
                <?php } ?>

            
            <?php } else { ?> 
                <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
            <?php } ?>
            <br>            
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

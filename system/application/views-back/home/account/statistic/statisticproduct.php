<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Thống kê doanh số theo sản phẩm
            </h4>
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
                        td:nth-of-type(2):before { content: "Hình ảnh"; }
                        td:nth-of-type(3):before { content: "Tên sản phẩm"; }
                        td:nth-of-type(4):before { content: "Số lượng"; }
                        td:nth-of-type(5):before { content: "Đơn giá(vnđ)"; }
                        td:nth-of-type(6):before { content: "Doanh số(vnđ)"; }
                        td:nth-of-type(7):before { content: "Danh mục"; }
                    }
                </style>
                <!-- Ẩn theo task trello ngày 12/09/2018 -->
                <!-- <div class="panel panel-default panel-custom">
                    <div class="panel-body">
                        <form class="form-inline" action="" style="float: left; width: 100%" method="post">
                            <label for="date1"> Lọc doanh số từ ngày: </label>
                            <input type="date" class="form-control" id="datefrom" name="datefrom"
                                   value="<?php echo $afsavedatefrom ?>">
                            <br class="visible-xs">
                            <label for="date2"> Đến ngày: </label>
                            <input type="date" class="form-control" id="dateto" name="dateto"
                                   value="<?php echo $afsavedateto ?>">
                            <br class="visible-xs">
                            <label for="filter"></label>
                            <button type="submit" class="btn btn-azibai">Thực hiện</button>
                        </form>    
                    </div>
                </div> -->
            <?php if ($total_sum_staff > 0) { ?>
                <div class="db_table">
                    <div class="text-right">                    
                        <strong>Tổng doanh thu các sản phẩm: </strong>
                        <strong style="color:#F00;"><?php echo number_format($total_sum_staff, 0, ",", "."); ?> VNĐ</strong>
                    </div>
                
                    <table class="table table-bordered" style="margin:15px 0">
                        <thead>
                            <tr>
                                <th class="title_account_0">STT</th>
                                <th  class="title_account_2" align="center">
                                    Hình ảnh
                                </th>
                                <th class="title_account_2" align="center">
                                    Tên sản phẩm
                                </th>
                                <th class="title_account_2" align="center">
                                    Số lượng
                                </th>
                                <th  class="title_account_2" align="center">
                                    Đơn giá(vnđ)
                                </th>
                                <th class="title_account_2" align="center">
                                    Doanh số(vnđ)
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/asc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/desc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                </th>
                                <th  class="title_account_2" align="center">
                                    Danh mục
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($staffs) > 0) {
                            $total = 0;
                            $protocol = "http://";//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                            $duoi = '.' . $_SERVER['HTTP_HOST'].'/';

                            if ($this->uri->segment(3) == 'page') {
                                if ($this->uri->segment(4) != '') {
                                    $stt = $this->uri->segment(4);
                                } else {
                                    $stt = 0;
                                }
                            } else {
                                $stt = 0;
                            }

                            foreach ($staffs as $key => $items) {

                                if ($items->pro_type == 2) {
                                    $pro_type = 'coupon';
                                } else {
                                    if ($items->pro_type == 0) {
                                        $pro_type = 'product';
                                    }
                                }
                                $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'sho_link = "' . $items->sho_link . '"');
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
                                    $domain = $protocol . $domain1 . '/shop/';
                                } else {
                                    $domain = $protocol . $parent1 . $duoi . 'shop/';
                                }
//                                $domain = $protocol . $parent . 'shop/' . $pro_type . '/detail/' . $items->pro_id . '/' . RemoveSign($items->pro_name);
                                if ($this->session->userdata('sessionGroup') == AffiliateUser) {
                                    if (($items->sho_link == $parent || $items->domain == $parent) && $parent != '') {
                                        $domain = $protocol . $parent . $duoi . 'shop/';
                                        if ($items->domain == $parent) {
                                            $domain = $protocol . $parent . '/shop/' ;
                                        }
                                    } else { //Get sho_link cua GH khac
                                        $domain = $protocol . $items->sho_link . $duoi . 'shop/' ;
                                        if ($items->domain != '') {
                                            $domain = $protocol . $items->domain . '/shop/' ;
                                        }
                                    }
                                }
                                if ($doanhthu[$items->pro_id] > 0) {
                                    ?>
                                    <tr>
                                        <td class="line_account_0"><?php echo $key + 1 + $stt; ?></td>
                                        <td class="line_account_2">
                                            <?php
                                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $items->pro_dir . '/thumbnail_1_' . explode(',',$items->pro_image)[0];
                                            $imglager = DOMAIN_CLOUDSERVER . 'media/images/product/' . $items->pro_dir . '/thumbnail_3_' . explode(',',$items->pro_image)[0];
                                            if ($items->pro_image != '') { //file_exists($filename) && 
                                                ?>
                                                <a rel="tooltip" data-toggle="tooltip" data-html="true"
                                                   data-placement="auto right"
                                                   data-original-title="<img src='<?php echo $imglager; ?>' />">
                                                    <img width="80" src="<?php echo $filename; ?>"/>
                                                </a>
                                            <?php } else {
                                                ?>
                                                <img width="80"
                                                     src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                            <?php } ?>
                                        </td>
                                        <td class="line_account_2">                                            
                                            <a target="_blank" class="" href="<?php echo $domain. $pro_type . '/detail/' . $items->pro_id . '/' . RemoveSign($items->pro_name) ?>">
                                                <?php echo sub($items->pro_name, 100); ?>
                                            </a>
                                        </td>
                                        <td class="line_account_2">
                                            <?php echo number_format($items->showcarttotal, 0, ",", "."); ?>
                                        </td>
                                        <td class="line_account_2">
                                            <?php echo number_format($items->pro_cost, 0, ",", "."); ?>
                                        </td>
                                        <td class="line_account_2">
                                            <a href="<?php echo base_url(); ?>account/detail_statistic_product/<?php echo $items->pro_id ?>"
                                               class="dso">
                                                <?php
                                                echo number_format($doanhthu[$items->pro_id], 0, ",", "."); ?>
                                            </a>
                                            <?php
                                            if ($items->pro_price_rate > 0 || $items->pro_price_amt > 0) {

                                                ?>
                                                <br/>
                                                Khuyến mãi:
                                                <?php if ($items->pro_price_rate > 0): ?>
                                                    <span
                                                        class="text-success"><?php echo number_format($items->pro_price_rate, 0, ",", "."); ?>
                                                        %</span>
                                                <?php else: ?>
                                                    <span
                                                        class="text-success"><?php echo number_format($items->pro_price_amt, 0, ",", "."); ?>
                                                        vnđ</span>
                                                <?php endif; ?>
                                                <?php
                                            }
                                            //                                if ($product->af_id > 0) {
                                            if ($items->af_dc_amt > 0) {
                                                $type = 'VND';
                                            } else {
                                                $type = '%';
                                            }
                                            //   }
                                            if ($items->af_id > 0) {
                                                if ($items->af_dc_amt > 0 || $items->af_dc_rate > 0) {
                                                    ?>
                                                    <br/> Giảm qua CTV:
                                                    <?php if ($items->af_dc_amt > 0): ?>
                                                        <span
                                                            class="text-success"><?php echo number_format($items->af_dc_amt, 0, ",", "."); ?><?php echo $type ?></span>
                                                    <?php else: ?>
                                                        <span
                                                            class="text-success"><?php echo number_format($items->af_dc_rate, 0, ",", "."); ?>
                                                            <?php echo $type ?></span>
                                                    <?php endif; ?>

                                                    <?php
                                                }
                                                if ($items->af_rate > 0 || $items->af_amt > 0) {

                                                    if ($this->session->userdata('sessionGroup') == AffiliateUser) { ?>
                                                        <br/>Hoa hồng CTV:
                                                        <?php if ($items->af_rate > 0): ?>
                                                            <span
                                                                class="text-success"><?php echo number_format($items->af_rate, 0, ",", "."); ?>
                                                                %</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="text-success"><?php echo number_format($items->af_amt, 0, ",", "."); ?>
                                                                vnđ</span>
                                                        <?php endif; ?>
                                                    <?php }
                                                }
                                            }
                                            ?>
                                            <style>
                                                .dso {
                                                    color: #f00 !important;
                                                }
                                            </style>
                                        </td>
                                        <td  class="line_account_2">
                                            <?php echo $items->cat_name; ?>
                                        </td>
                                    </tr>
                                <?php }
                            }
                        }//endif;
                        ?>                        
                        </tbody>
                    </table>               
                
                    <div class="text-right">                    
                        <strong>Tổng doanh thu các sản phẩm: </strong>
                        <strong style="color:#F00;"><?php echo number_format($total_sum_staff, 0, ",", "."); ?> VNĐ</strong>
                    </div>
                
                    <?php if (count($linkPage) > 0) { ?>
                        <?php echo $linkPage; ?>                       
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
            <?php } ?>
            <br>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>


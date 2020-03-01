<?php $this->load->view('home/common/account/header'); ?>
<style>
    @media only screen and (max-width: 767px)  {
        .table-responsive {border:0px solid !important;}
        table, thead, tbody, th, td, tr {
            display: block; 
        }
        table { border: none !important;}
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        } 
        tr { border: none !important;
             border-bottom: 1px solid #ddd !important;
             margin-bottom: 20px;
             box-shadow: 0 1px 1px #ccc;
        }
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
        
        td:nth-of-type(1){      
            width: 133px;
            padding: 8px !important;
            display: inline-block;
            text-align: center;
            background: #eee; 
            font-weight: bold;
        }
 
        td:nth-of-type(2):before { content: "Tài khoản"; }
        td:nth-of-type(3):before { content: "Gian hàng"; }
        td:nth-of-type(4):before { content: "Link"; }
        td:nth-of-type(5):before { content: "Email/Điện thoại"; }
        td:nth-of-type(6):before { content: "Cấu hình"; }
        td:nth-of-type(7):before { content: "Nhắn tin"; }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <?php
        $group_id = (int)$this->session->userdata('sessionGroup');
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        ?>

        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
                Danh sách Cộng tác viên
            </h4>

            <div class="row">
                <div class="col-sm-6">
                    
                    
                    <form action="<?php echo base_url() . 'account/allaffiliateunder'; ?>" method="post"
                          accept-charset="utf-8">
                        
                        <div class="input-group">
                            <select name="chinhanh" class="form-control">
                                <option value="">-- Chọn chi nhánh/nhân viên --</option>
                                <?php
                                if (isset($list_sub) && count($list_sub) > 0) {
                                    foreach ($list_sub as $key => $value) {
                                        $group = $value->group;
                                        if ($group == BranchUser) {
                                            $vitri = 'Chi nhánh';
                                        }
                                        if ($group == StaffStoreUser) {
                                            $vitri = 'Nhân viên';
                                        }
                                        ?>
                                        <option <?php
                                        if ($this->input->post('chinhanh') == $value->id) {
                                            echo "selected";
                                        }
                                        ?>
                                            value="<?php echo $value->id; ?>"><?php echo $value->name . ' [ - ' . $vitri . ' - ]'; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                                <option value="">-- Xem tất cả --</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-azibai btn-block">Tìm kiếm</button>
                            </span>
                        </div>
                    </form>
                </div>
                <p class="col-sm-6" style="text-align: right">
                    <strong> Tổng CTV toàn công ty: <span style="color:#f00;"><?php echo $totalRecord ?></span></strong>
                </p>
            </div>
            <?php
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
            $url = explode('//', base_url());
            $duoi = $url[1];
            ?>

            

            <?php if (count($totalaff) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th width="" align="center">
                                    Tài khoản
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>/name/by/asc')" border="0"
                                         style="cursor:pointer;" alt="">
                                    <img src="/templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>/name/by/desc')" border="0"
                                         style="cursor:pointer;" alt="">
                                </th>
                                <?php
                                if ($group_id != CoreAdminUser && $group_id != CoreMemberUser && $group_id != Partner1User && $group_id != Partner2User && $group_id != Developer1User && $group_id != Developer2User) {
                                    ?>

                                    <th width="" align="center">
                                        Tên gian hàng
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>/sho_name/by/asc')" border="0"
                                             style="cursor:pointer;" alt="">
                                        <img src="/templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>/sho_name/by/desc')" border="0"
                                             style="cursor:pointer;" alt="">
                                    </th>
                                    <th width="" align="center">
                                        Link gian hàng
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>/sho_link/by/asc')" border="0"
                                             style="cursor:pointer;" alt="">
                                        <img src="/templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>/sho_link/by/desc')" border="0"
                                             style="cursor:pointer;" alt="">
                                    </th>
                                <?php } ?>
                                <th align="center">
                                    Email - Điện thoại
                                </th>
                                <?php if ($group_id == AffiliateStoreUser) { ?>
                                    <th align="center">
                                        Cấu hình
                                    </th>
                                <?php } ?>
                                <th align="center">
                                    Nhắn tin
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($totalaff as $key => $items) {
                                $i++;
                                $tenDomain = '';
                                $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$items['use_id'] . '"');
                                switch ($get_u[0]->use_group) {
                                    case AffiliateUser:
                                        $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                                        if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                            if ($get_p[0]->domain != '') {
                                                $tenDomain = $get_p[0]->domain;
                                            } else {
                                                $parent = $get_p[0]->sho_link;
                                            }
                                        } else {
                                            if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                                $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                if ($get_p1[0]->domain != '') {
                                                    $tenDomain = $get_p1[0]->domain;
                                                } else {
                                                    $parent = $get_p1[0]->sho_link;
                                                }
                                            } else {
                                                $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                                    $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                                    if ($get_p1[0]->domain != '') {
                                                        $tenDomain = $get_p2[0]->domain;
                                                    } else {
                                                        $parent = $get_p2[0]->sho_link;
                                                    }
                                                }
                                            }
                                        }
                                        break;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $sTT + $i; ?></td>
                                    <td>
                                        <a target="_blank" title="<?php echo $items['info_parent']; ?>"
                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                            <?php echo $items['use_username']; ?>
                                        </a>
                                        <br>
                                        <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">
                                            <i><?php echo $info_parent[$key]['info_parent']; ?></i>
                                        </div>
                                    </td>
                                    <?php
                                    if ($group_id != CoreAdminUser && $group_id != CoreMemberUser && $group_id != Partner1User && $group_id != Partner2User && $group_id != Developer1User && $group_id != Developer2User) {
                                        ?>
                                        <td>
                                            <a href="<?php echo $items['link_gh'] . '/news'; ?>" target="_blank">
                                                <?php echo $items['sho_name']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a target="_blank" href="<?php echo $items['link_gh'] . '/shop'; ?>">
                                                <?php echo $items['sho_link']; ?>
                                            </a>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <span class="text-primary"><?php echo $items['use_email']; ?></span><br/>
                                        <span class="text-success"><?php echo $items['use_mobile']; ?></span>
                                    </td>

                                    <?php if ($group_id == AffiliateStoreUser) { ?>
                                    <td  class="text-center">
                                        <a class="btn btn-default btn-sm"
                                        account/affiliate/configaffiliate
                                           href="<?php echo base_url() . 'account/affiliate/configaffiliate/' . $items['use_id']; ?>"
                                           title="CH thưởng thêm <?php echo $items['use_username']; ?>">
                                           <i class="fa fa-cogs fa-fw"></i>
                                        </a>
                                    </td>
                                    <?php } ?>

                                    <td align="center">

                                        <div class="hidden-xs">
                                        <?php if ($items['use_message']) { ?>
                                            <a class="btn btn-info btn-sm" href="<?php echo $items['use_message']; ?>"
                                               title="Gửi tin nhắn">
                                                <i class="fa fa-commenting-o fa-fw"></i>
                                            </a>
                                        <?php } ?> 
                                        </div>

                                        <div class="visible-xs">
                                        <?php if ($items['use_message']) { ?>
                                            <a class="btn btn-info btn-sm" href="<?php echo $items['use_message']; ?>"
                                               title="Gửi tin nhắn">
                                                <i class="fa fa-commenting-o fa-fw"></i> Gửi tin nhắn
                                            </a>
                                        <?php } ?> 
                                            &nbsp;
                                        <?php if ($items['use_mobile']) { ?>                                    
                                            <a class="btn btn-info btn-sm" href="sms:<?php echo $items['use_mobile']; ?>"
                                               title="Gửi tin SMS">
                                                <i class="fa fa-comment fa-fw"></i> Gửi tin SMS
                                            </a>                                  
                                        <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <?php echo $linkPage; ?>
                </div>                
            
            <?php } else { ?>
            <div style="padding: 10px; border:1px solid #eee; text-align: center;">Không có dữ liệu!</div>
            <?php } ?>            
            <br>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
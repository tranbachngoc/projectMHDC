<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <?php
        $group_id = (int)$this->session->userdata('sessionGroup');
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Thống kê doanh số theo cộng tác viên
            </h4>
            
            <?php if($totalnopage > 0) { ?>
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
                        td:nth-of-type(3):before { content: "Tên Gian hàng"; }
                        td:nth-of-type(4):before { content: "Link Gian hàng"; }
                        td:nth-of-type(5):before { content: "Email/Điện thoại"; }
                        td:nth-of-type(6):before { content: "Doanh Thu"; }
                        td:nth-of-type(7):before { content: "Cấu hình"; }
                    }
                </style>
                <!-- Ẩn theo task trello ngày 12/09/2018 -->
                <!-- <div class="panel panel-default panel-custom">
                    <div class="panel-body">
                        <form class="form-inline" action="" style="float: left;width: 100%" method="post">                        
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
            
                <div class="text-right">
                    <strong>Tổng doanh thu: </strong>
                    <strong style="color:#F00; font-size: 15px"><?php echo number_format($totalnopage, 0, ",", "."); ?> VNĐ</strong>
                </div>
            
                <table class="table table-bordered" style="margin:15px 0">
                    
                        <thead>
                        <tr>
                            <th class="title_account_0">STT</th>
                            <th class="title_account_2" align="center">Tài khoản
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                            </th>
                            <th class="title_account_2" align="center">Gian hàng
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')"
                                     border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                            </th>
                            <!-- <th class="title_account_2" align="center">Link gian hàng</th> -->
                            <th class="title_account_2" align="center">Email - Điện thoại</th>
                            <th class="title_account_2" align="center">Doanh thu
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt=""/>
                            </th>
                            <!-- <?php if ($group_id == AffiliateStoreUser) { ?>
                                <th  class="title_account_2" align="center">
                                    Cấu hình
                                </th>
                            <?php } ?> -->                           
                        </tr>
                        </thead>
                        <tbody>
                        <?php                        
                        $total = 0;
                        if ($this->uri->segment(3) == 'page') {
                            if ($this->uri->segment(4) != '') {
                                $stt = $this->uri->segment(4);
                            } else {
                                $stt = 0;
                            }
                        } else {
                            $stt = 0;
                        }

                        foreach ($liststoreAF as $items) { $stt++; ?>
                            <tr>
                                <td class="line_account_0"><?php echo $stt; ?></td>
                            <?php if($items["isShow"] == 1) { ?>
                                <td class="line_account_2">
                                    <a target="_blank" title="<?php echo $items['info_parent']; ?>"
                                       href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a>
                                    <br>
                                    <div class="shop_parent active"
                                         style="font-size: 12px;color: orangered!important;">
                                        <i><?php echo $items['info_parent']; ?></i>
                                    </div>                                    
                                </td>
                                <td class="line_account_2">
                                    <a href="<?php echo $items['link_gh'] . '/news'; ?>"
                                       target="_blank">
                                        <?php echo $items['sho_name']; ?>
                                    </a>
                                </td>
                                <td class="line_account_2">
                                    <i class="fa fa-envelope-o fa-fw"></i>
                                    <a href="mailto:<?php echo $items['use_email']; ?>"><?php echo $items['use_email']; ?></a>
                                    <br/>
                                    <i class="fa fa-phone fa-fw"></i><?php echo $items['use_mobile']; ?>
                                </td>
                                <td class="line_account_2">
                                    <?php $total += $items['showcarttotal']; ?>
                                    <a href="<?php echo base_url(); ?>account/detailstatisticlistaffiliate/<?php echo $items['use_id']; ?>">
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['showcarttotal'], 0, ",", "."); ?>
                                        đ</span>
                                    </a>
                                </td>
                            <?php } else { ?>
                                <td class="line_account_2">
                                    Cộng Tác Viên Azibai
                                </td>
                                <td class="line_account_2">
                                    Cộng Tác Viên Azibai
                                </td>
                                <td class="line_account_2">
                                    
                                </td>
                                <td class="line_account_2">
                                    <?php $total += $items['showcarttotal']; ?>
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($items['showcarttotal'], 0, ",", "."); ?>
                                        đ</span>
                                    </a>
                                </td>
                            <?php } ?>
                                
                                <?php if ($this->session->userdata('sessionGroup') > 3) { ?>
                                    <td class="line_account_2" hidden>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_<?php echo $items['use_id']; ?>">
                                            Chọn
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal_<?php echo $items['use_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $items['use_id']; ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel_<?php echo $items['use_id']; ?>">Chọn
                                                            gian
                                                            hàng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select
                                                            name="parent_shop_id_<?php echo $items['use_id']; ?>"
                                                            id="parent_shop_id_<?php echo $items['use_id']; ?>">
                                                            <option value="">--Chọn gian hàng--</option>
                                                            <?php foreach ($liststore as $itemshop) { ?>
                                                                <option
                                                                    value="<?php echo $itemshop['use_id']; ?>"><?php echo $itemshop['use_username']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Hủy
                                                        </button>
                                                        <button type="button" onclick="add_parent_shop(<?php echo $items['use_id']; ?>);" class="btn btn-primary">Lưu lại
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                <?php } ?>
                               <!--  <?php if ($group_id == AffiliateStoreUser) { ?>
                                    <td class="line_account_2 text-center">
                                        <a href="<?php echo base_url() . 'account/affiliate/configforuseraff/' . $items['use_id']; ?>"
                                           title="CH thưởng thêm <?php echo $items['use_username']; ?>"><i
                                                class="fa fa-cogs"></i></a>
                                    </td>
                                <?php } ?> -->
                            </tr>
                        <?php } ?>

                        <?php if ($group_id == AffiliateStoreUser) { $colsp = 3;
                        } else { $colsp = 2; } ?>
                        </tbody>
                </table>
                
                <div class="text-right">
                    <strong>Tổng doanh thu: </strong>
                    <strong style="color:#F00; font-size: 15px"><?php echo number_format($totalnopage, 0, ",", "."); ?> VNĐ</strong>
                </div> 

                <div><?php echo $linkPage; ?></div>
            <?php } else { ?>               
                <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
            <?php } ?>    
            <br/>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_parent_shop(use_id) {
        var shop_id = $('#parent_shop_id_' + use_id).val();
        if (shop_id == '') {
            errorAlert('Bạn chưa chọn gian hàng');
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + 'home/account/statisticlistaffiliate',
                cache: false,
                data: {use_id: use_id, parent_shop_id: shop_id},
                dataType: 'text',
                success: function (data) {
                    if (data == '1') {
                        $('.modal').modal('hide');
                    } else {
                        errorAlert('Có lỗi xảy ra', 'Thông báo');
                    }
                }
            });
        }
        return false;
    }
</script>

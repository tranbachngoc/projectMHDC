<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
	
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
                Thống kê doanh số theo chi nhánh
            </h4>
            <div class="db_table" style="overflow: auto; width:100%">                               
                <?php if(count($listbranch) > 0) { ?>                
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
                            td:nth-of-type(2):before { content: "Tên đăng nhập"; }
                            td:nth-of-type(3):before { content: "Họ & Tên"; }
                            td:nth-of-type(4):before { content: "Email"; }
                            td:nth-of-type(5):before { content: "Điện thoại"; }
                            td:nth-of-type(6):before { content: "Doanh Thu"; }
                        }
                    </style>
                    <!-- Ẩn theo task trello ngày 12/09/2018 -->
                    <!-- <div class="panel panel-default panel-custom">
                        <div class="panel-body">
                            <form class="form-inline" action="" method="post">
                                <label for="date1"> Lọc doanh số từ ngày: </label>
                                <input type="date" class="form-control" id="datefrom" name="datefrom"
                                       value="<?php echo $afsavedatefrom ?>">
                                <br class="visible-xs">
                                <label for="date2"> Đến ngày: </label>
                                <input type="date" class="form-control" id="dateto" name="dateto"
                                       value="<?php echo $afsavedateto ?>">
                                <br class="visible-xs">
                                <button type="submit" class="btn btn-azibai">Thực hiện</button>

                            </form>
                        </div>
                    </div>  -->                
                
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> STT </th> 
                                <th> Tài khoản </th>
                                <th> Họ tên </th>
                                <th> Email - Điện thoại </th> 
                                <th> Doanh thu </th>                             
                            </tr>
                        </thead>
                        <tbody>                             
                        <?php                            
                            $stt = 0;
                            $total = 0;                            
                            foreach ($listbranch as $key => $item) { ?>
                                <tr>
                                    <td><?php echo ++$stt; ?></td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $item->use_id; ?>">
                                            <?php echo $item->use_username; ?></a>
                                        <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">
                                            <i><?php echo $item->info_parent; ?></i>   
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo ($item->use_fullname != '') ? $item->use_fullname : 'Chưa cập nhật'; ?>
                                    </td>
                                    <td>
                                        <i class="fa fa-envelope-o fa-fw"></i>
                                        <a href="mailto:<?php echo $item->use_email; ?>"><?php echo $item->use_email; ?></a>
                                        <br/>
                                        <i class="fa fa-phone fa-fw"></i><?php echo $item->use_mobile; ?>
                                    </td>
                                    <td>
                                        <!-- <a href="<?php echo base_url(); ?>account/detailstatisticlistbran/<?php echo $item->use_id; ?>"> -->
                                        <span style="color: #ff0000; font-weight: 600"><?php echo number_format($item->order_total, 0, ",", "."); ?>
                                        vnđ</span>
                                        <!-- </a> -->
                                    </td>
                                </tr>                                   
                            <?php 
                            $total += $item->order_total;
                        } ?>
                        </tbody>
                    </table>                    
                    <p class="text-right detail_list">
                        <strong>Tổng doanh thu: </strong>
                        <strong style="color:#F00; font-size: 15px"><?php echo number_format($total, 0, ",", "."); ?> VNĐ</strong>
                    </p>
                    <?php if (count($linkPage) > 0) { ?>
                        <?php echo $linkPage; ?>                       
                    <?php } ?>                    
                <?php } else { ?>
                    <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu.</div>
                <?php }  ?>                    
                <br>                
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
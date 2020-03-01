<?php $this->load->view('home/common/account/header'); ?>
<?php
    $text = 'Thống kê nhân viên mở Chi Nhánh';
    $txt = 'Chi Nhánh';
    if ($this->uri->segment(2) == 'statisticalemployee') {
        $text = 'Thống kê nhân viên mở Cộng Tác Viên';
        $txt = 'CTV';
    } 
?>
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
            tr { border: none !important; border-bottom: 1px solid #ddd !important; margin-bottom: 20px; }
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
            td:nth-of-type(3):before { content: "Tên nhân viên"; }
            td:nth-of-type(4):before { content: "Email"; }
            td:nth-of-type(5):before { content: "Điện thoại"; }
            td:nth-of-type(6):before { content: "SL <?php echo $txt ?>"; } 
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            
             <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
                    <?php echo $text ?>
                </h4>
                <?php if (count($staffs) > 0) { ?>
                 
                <div style="width:100%; overflow-x: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="40">STT</th>
                                <th width="" class="text-left">
                                    Tài khoản
                                </th>
                                <th width="" class="text-left">
                                    Họ tên nhân viên
                                </th>
                                <th width=200" class="text-left">
                                    Email
                                </th>
                                <th width=100" class="text-center">
                                    Điện thoại
                                </th>
                                <th width="100" class="text-center">
                                    SL <?php echo $txt ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($staffs as $key => $items) {
                            ?>
                            <tr>
                                <td><?php echo $stt + $key;; ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>" target="_blank"> <?php echo $items->use_username; ?></a>
                                    <div class="shop_parent active" style="font-size: 12px; color: orangered!important;">
                                        <i><?php echo $info_parent[$key]['info_parent']; ?></i>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $items->use_fullname; ?>
                                </td>
                                <td>
                                    <?php echo $items->use_email; ?>
                                </td>
                                <td>
                                    <?php echo $items->use_mobile; ?>
                                </td>
                                <td>
                                    <?php if(!empty($items->sl)) { ?>
                                    <a href="<?php echo base_url(); ?>account/<?php
                                    if ($this->uri->segment(2) == 'statisticalbran') {
                                        echo 'listbran';
                                    } else echo 'listaffiliate'; ?>/<?php echo $items->use_id; ?>">
                                        <span class="badge">
                                            <?php echo $items->sl; ?>
                                        </span>
                                    </a>
                                    <?php } else { ?>
                                    <span class="badge">0</span>
                                    <?php } ?>
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
                
                <div style="padding: 20px; text-align: center; border:1px solid #eee">
                    <?php
                    if ($this->uri->segment(2) == 'statisticalbran') {
                        echo ' Không có Chi Nhánh nào!';
                    } else 
                        echo ' Không có Cộng Tác Viên nào!'; ?>
                </div>
                        
                <?php } ?>
            </div>
        </div>
    </div>
    <!--END RIGHT-->

<?php $this->load->view('home/common/footer'); ?>
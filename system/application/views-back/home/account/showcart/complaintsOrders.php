<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Danh sách đơn hàng khiếu nại (<?php echo count($listComplaintsOrders); ?>)
            </h4>
            <?php if (count($listComplaintsOrders) > 0) { ?>
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
                    td:nth-of-type(1):before { content: "Stt"; }
                    td:nth-of-type(2):before { content: "Mã đơn hàng"; }
                    td:nth-of-type(3):before { content: "Trạng thái"; }
                    td:nth-of-type(4):before { content: "Hình thức"; }
                    td:nth-of-type(5):before { content: "Email"; }
                    td:nth-of-type(6):before { content: "Ngày khiếu nại"; }
                }
                .red_money{text-align: right;}
            </style>
            <div style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    
                        <thead>
                            <tr>
                                <th>Stt</th>
                                <th>Mã đơn hàng</th>
                                <th>Trạng thái</th>
                                <th>Hình thức</th>
                                <th>Email khách hàng</th>
                                <th>Ngày khiếu nại</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php foreach($listComplaintsOrders as $k=>$vals): ?>

                                <!--div class="modal fade prod_detail_modal" id="myModal<?php echo $k;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle text-danger"></i></button>
                                                <h4 class="modal-title" id="myModalLabel">Chi tiết đơn hàng khiếu nại</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Mã đơn hàng:</div>
                                                    <div class="col-lg-9 col-xs-8"><b><a href="<?php echo base_url().'account/complaintsOrdersForm/'.$vals->id; ?>">#<?php echo $vals->order_id; ?></a></b></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Trạng thái:</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php
                                                        switch($vals->status_id){
                                                            case '01':
                                                                $status_id = "Yêu cầu khiếu nại Mới";
                                                                break;
                                                            case '02':
                                                                $status_id = "Chờ thành viên gởi mẫu vận chuyển";
                                                                break;
                                                            case '03':
                                                                if($vals->type_id == 1){
                                                                    $status_id = "Xác nhận và tạo đơn hàng mới cho thành viên";
                                                                } else {
                                                                    $status_id = "Xác nhận và hoàn tiền cho thành viên";
                                                                }

                                                                $comment    =   $this->delivery_comments_model->get('content','id_request = '.$vals->id.' AND status_changedelivery = "02"');
                                                                $pos        =   strpos($comment->content, "reply_icon.png");
                                                                if ($pos === false) {

                                                                } else {
                                                                    $status_id .= " <span style='color:red;font-weight:bold;'>(Bạn có yêu cầu bắt buộc phải xử lý)</span>";
                                                                }
                                                                break;
                                                            case '04':
                                                                $status_id = "Hoàn tất";
                                                                break;
                                                        }
                                                        echo $status_id;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Hình thức:</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php echo ($vals->type_id == 1)?'Đổi hàng':'Trả hàng'; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Email khách hàng:</div>
                                                    <div class="col-lg-9 col-xs-8">
                                                        <?php echo $vals->email; ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-xs-4">Ngày khiếu nại:</div>
                                                    <div class="col-lg-9 col-xs-8"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div-->
                            
                            <?php
                                switch($vals->status_id){
                                    case '01':
                                        $status_id = "Yêu cầu khiếu nại Mới";
                                        break;
                                    case '02':
                                        $status_id = "Chờ thành viên gởi mẫu vận chuyển";
                                        break;
                                    case '03':
                                        if($vals->type_id == 1){
                                            $status_id = "Xác nhận và tạo đơn hàng mới cho thành viên";
                                        } else {
                                            $status_id = "Xác nhận và hoàn tiền cho thành viên";
                                        }

                                        $comment    =   $this->delivery_comments_model->get('content','id_request = '.$vals->id.' AND status_changedelivery = "02"');
                                        $pos        =   strpos($comment->content, "reply_icon.png");
                                        if ($pos === false) {

                                        } else {
                                            $status_id .= " <span style='color:red;font-weight:bold;'>(Bạn có yêu cầu bắt buộc phải xử lý)</span>";
                                        }
                                        break;
                                    case '04':
                                        $status_id = "Hoàn tất";
                                        break;
                                }                                
                            ?>  
                            <?php 
                            $a = '#'.$vals->order_id;
                            if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14){
                                $a = '<a href="'.base_url().'account/complaintsOrdersForm/'.$vals->id.'">#'.$vals->order_id.'</a>';
                            } ?>
                            <tr>
                                <td><?php echo $k+1; ?></td>
                                <td class="order_id"><b><?php echo $a; ?></b></td>
                                <td class="bk_email hidden-xs">
                                    <?php echo $status_id; ?>
                                </td>
                                <td class="bk_email"><?php echo ($vals->type_id == 1)?'Đổi hàng':'Trả hàng'; ?></td>
                                <td class="bk_email hidden-xs"><?php echo $vals->email; ?></td>
                                <td class="bk_email"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></td>
                                
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    
                </table>
            </div>
            <?php } else { ?>
                <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
            <?php } ?>
            <br>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
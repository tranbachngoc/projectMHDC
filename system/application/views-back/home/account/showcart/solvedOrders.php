<?php $this->load->view('home/common/account/header'); ?>
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
        td:nth-of-type(1):before { content: "Mã đơn hàng"; }
        td:nth-of-type(2):before { content: "Trạng thái"; }
        td:nth-of-type(3):before { content: "Hình thức"; }
        td:nth-of-type(4):before { content: "Email"; }
        td:nth-of-type(5):before { content: "Ngày khiếu nại"; }
    }
    .red_money{text-align: right;}
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
       <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php echo 'Danh sách đơn hàng khiếu nại'; ?>
            </h4>
            <?php if (count($listSolvedOrders) > 0) { ?>
            <div style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">                    
                    <thead>
                        <tr>
                            <th align="center">Mã đơn hàng</th>
                            <th align="center">Trạng thái</th>
                            <th align="center">Hình thức</th>
                            <th align="center">Email khách hàng</th>
                            <th align="center">Ngày khiếu nại</th>
                        </tr>
                    </thead>
                    <tbody> 
                            <?php foreach($listSolvedOrders as $vals):
                            $a = '#'.$vals->order_id;
                            if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14){
                                $a = '<a href="'.base_url().'account/complaintsOrdersForm/'.$vals->id.'">#'.$vals->order_id.'</a>';
                            } ?>
                            <tr>
                                <td class="order_id"><b><?php echo $a; ?></b></td>
                                <td class="bk_email">
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
                                            break;
                                        case '04':
                                            $status_id = "Hoàn tất";
                                            break;
                                    }
                                    echo $status_id;
                                    ?>
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
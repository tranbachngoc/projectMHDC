<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen'/>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>

<!--BEGIN: LEFT-->
<div id="main" class="container-fluid">
    <div class="row">        
        <!--BEGIN: Left menu-->
        <?php if ($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionGroup') == StaffStoreUser) {
            $this->load->view('home/common/left');
        } ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px;">DANH SÁCH ĐƠN HÀNG KHIẾU NẠI</h4>
            <?php if ($totalRecord > 0) { ?>
            <p style="text-align: right; font-weight: bold;">Số đơn hàng khiếu nại:
            <span style="color:#f00;">
                <?php echo $totalRecord ?>
            </span>
            </p>
            <div style="overflow: auto; width:100%">
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
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
                        <?php foreach ($listComplaintsOrders as $key => $obj) { ?>
                        <tr>
                            <td><?php echo $obj->stt; ?></td>
                            <td class="order_id"><b><a href="<?php echo getAliasDomain() . 'account/complaintsOrdersForm/' . $obj->id; ?>"><?php echo '#' . $obj->order_id; ?></a></b></td>
                            <td class="bk_email hidden-xs"><?php echo $obj->status_mean; ?></td>
                            <td class="bk_email"><?php echo $obj->type_mean; ?></td>
                            <td class="bk_email hidden-xs"><?php echo $obj->email; ?></td>
                            <td class="bk_email"><?php echo $obj->lastupdated; ?></td>
                        </tr>
                        <?php 
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <?php echo $linkPage; ?>
            </div>
        <?php 
    } else { ?>
            <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
        <?php 
    } ?>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>

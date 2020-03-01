<?php $this->load->view('home/common/header'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/changedelivery.css" />

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <?php
        $menu_breadrum = "";
        if(isset($delivery) && $delivery->type_id == 1){
            $menu_breadrum = "Đổi hàng";
        } elseif($delivery->type_id == 2){
            $menu_breadrum = "Trả hàng";
        }

        $message        = "";
        $alert_success  = "";
        $title          = "";
        if($all_comments[0]->status_changedelivery == "01"){
            $message                        = "Chờ Shop xác nhận";
            $alert_success                  = "";
            $title                          = "Trạng thái";
        } else if($all_comments[0]->status_changedelivery == "02"){
            if($all_comments[0]->status_comment == "1"){
                $alert_success                  = "Bạn nhắn tin và upload mẫu vận đơn";
                $title                          = "Giao hàng và upload mẫu vận đơn";
            } else {
                $alert_success                  = "Shop không đồng ý yêu cầu của bạn! Nếu bạn không đồng ý check vào ô không đồng ý và ngược lại";
                $title                          = "Xác nhận lại";
            }
            
        } else if($all_comments[0]->status_changedelivery == "03"){
            if($delivery->type_id == 1){
                $message                        = "Chờ Shop xác nhận và tạo đơn hàng mới";
            } else {
                $message                        = "Chờ Shop xác nhận và hoàn tiền lại cho bạn";
            }
            $title                              = "Trạng thái";
        } else if($all_comments[0]->status_changedelivery == "04"){
            $message                            = "Hoàn tất ".$menu_breadrum;
            $title                              = "Trạng thái";
        }
        ?>
        <div class="col-lg-10 col-lg-offset-2 " style="min-height:528px">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span><?php echo ($delivery) ? $menu_breadrum : 'Gởi yêu cầu'; ?></span>
            </div>
            
            <div class="wraper container-fluid">
                <div class="page-title"> 
                    <h4 class="_title1 text-center" style="text-transform: uppercase"><?php echo ($menu_breadrum) ? 'TRANG KIỂM TRA TRẠNG THÁI '. $menu_breadrum : 'GỬI YÊU CẦU KHIẾU NẠI SẢN PHẨM AZIBAI.COM'; ?></h4> 
                </div>
                <?php if($order_info):?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="date-box">
                                <?php if($order_info->order_id):?>
                                    <span class="title"><b>Mã đơn hàng</b></span>
                                    <span>: <?php echo $order_info->order_id; ?></span><br>
                                <?php endif; ?>

                                <?php if($delivery->client_code_new) : ?>
                                    <span class="title"><b>Mã vận chuyển</b></span>
                                    <span>: <?php echo $delivery->client_code_new;//'<a target="_blank" href="'. clientOrderCode . $delivery->client_code_new .'">'. $delivery->client_code_new .'</a>';?></span><br>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <!-- Basic example -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title"><?php echo ($title) ? $title : 'Gởi yêu cầu'; ?></h3></div>
                            <div class="panel-body">
                                <?php
                                if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){
                                    ?>
                                    <div class="message success">
                                        <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                                            <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                    
                                <?php if($message == ""): ?>
                                    <?php if($alert_success != ""): ?>
                                        <div class="message success">
                                            <div class="alert alert-success">
                                                <?php echo $alert_success; ?>
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                    if($order_info->order_id){
                                        $action = base_url() .'submit-request-delivery/'. $order_info->order_id .'?order_token='. $_REQUEST['order_token'];
                                    } else {
                                        $action = base_url() .'submit-request-delivery?order_token='. $_REQUEST['order_token'];
                                    }
                                    ?>

                                    <form role="form" action="<?php echo $action; ?>" method="post" name="formDelivery" id="formDelivery" enctype="multipart/form-data">
                                        <?php if($status_comment == FALSE || $order_info): ?>

                                        <?php else: ?>
                                            <div class="form-group" style="<?php echo $clone; ?>">
                                                <label for="email">Email</label>
                                                <input required="required" type="email" class="form-control" id="email" name="email" placeholder="Vui lòng nhập email" value="<?php echo isset($user_receive_token) ? $user_receive_token->ord_semail : $order_info->ord_semail; ?>">
                                            </div>
                                        <?php if(isset($order_id_token)): ?>
                                            <?php $order_readonly = 'readonly="true"'; ?>
                                        <?php else: ?>
                                            <?php $order_readonly = ''; ?>
                                        <?php endif; ?>
                                            <div class="form-group" style="<?php echo $clone; ?>">
                                                <label for="order_id">Mã đơn hàng</label>
                                                <input <?php echo $order_readonly;?> required="required" type="text" class="form-control" id="order_id" name="order_id" placeholder="Vui lòng nhập mã đơn hàng" value="<?php echo (isset($order_id_token)) ? $order_id_token->id : $order_info->order_id; ?>">
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label for="content">Tin nhắn</label>
                                            <textarea required="required" class="form-control" rows="5" name="content" id="content" placeholder="Vui lòng nhập tin nhắn"></textarea>
                                        </div>

                                        <?php if($all_comments[0]->status_changedelivery == "02" && $status_comment == TRUE): ?>
                                            <div class="form-group">
                                                <div class="fileUpload btn btn-default1">
                                                    <span><i class="fa fa-upload"></i> Upload mẫu vận đơn</span>
                                                    <input type="file" name="image_mavandon" id="image_mavandon" class="upload"/>
                                                </div>
                                                &nbsp;&nbsp;<span id="image_mavandon_before"></span>
                                            </div>
                                        
                                        <?php endif; ?>

                                        <?php if(empty($order_info)): ?>
                                        <div class="form-group">
                                            <div class="radio-inline">
                                                <label class="cr-styled" for="type_id_1">
                                                    <input type="radio" id="type_id_1" name="type_id" value="1" checked> 
                                                    <i class="fa"></i>
                                                    Đổi hàng 
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label class="cr-styled" for="type_id_2">
                                                    <input type="radio" id="type_id_2" name="type_id" value="2"> 
                                                    <i class="fa"></i>
                                                    Trả hàng
                                                </label>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if($status_comment == FALSE): ?>
                                            <div class="form-group">
                                                <div class="radio-inline">
                                                    <label class="cr-styled" for="status_comment_1">
                                                        <input type="radio" id="status_comment_1" name="status_comment" value="1" checked> 
                                                        <i class="fa"></i>
                                                        Đồng ý 
                                                    </label>
                                                </div>
                                                <div class="radio-inline">
                                                    <label class="cr-styled" for="status_comment_2">
                                                        <input type="radio" id="status_comment_2" name="status_comment" value="2"> 
                                                        <i class="fa"></i>
                                                        Không Đồng ý 
                                                    </label>
                                                </div>
                                            </div>   
                                        <?php endif; ?>
                                        <?php
                                        if(isset($order_id_token->id)){
                                            $buttonDisabled = "";
                                        } else {
                                            if($status_comment == FALSE || $order_info){
                                                $buttonDisabled = "";
                                            } else {
                                                $buttonDisabled = "disabled='disabled'";
                                            }
                                        }
                                        
                                        ?>
                                        <input type="hidden" value="<?php isset($_REQUEST['order_token']) ? $_REQUEST['order_token'] : '' ?>">
                                        <div class="form-group">
                                            <button id="formRequest" type="submit" class="btn btn-purple" <?php echo $buttonDisabled; ?>>Xác nhận</button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <?php echo $message; ?>
                                <?php endif; ?>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-->
                    
                    <!-- Horizontal form -->
                    <?php if ($order_info): ?>
                        <?php $this->load->view('home/changedelivery/historyDelivery'); ?>
                    <?php else: ?>
                        <?php $this->load->view('home/changedelivery/checkDelivery'); ?>
                    <?php endif; ?>
                </div>
                <?php if ($this->session->userdata('sessionUser') > 0): ?>
                    <div class="row">
                        <?php $this->load->view('home/changedelivery/listDelivery'); ?>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    
    
    $( "#order_id" ).focus(function() {
        $("#formRequest").attr('disabled','disabled');
    });
    
    $('#formDelivery').submit(function() {
        if($("#content").val() == ""){
            alert("Vui lòng nhập nội dung!");
            return false;
        } else {
            $(this).find("button[type='submit']").prop('disabled',true);
        }
    });
    
    $("#image_mavandon").change(function(event) {
        $("#image_mavandon_before").html(this.files[0].name).show();
    });
    
});
</script>

<?php $this->load->view('home/common/footer'); ?>
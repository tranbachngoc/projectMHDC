<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/changedelivery.css" />
<div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-8' : 'col-md-9' ?> col-xs-12">
    
    <?php
    if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){
        ?>
        <div class="message success" >
            <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
        <?php
    }
    ?>
    
    <?php
        $menu_breadrum = "";
        if(isset($delivery) && $delivery[0]->type_id == 1){
            $menu_breadrum = "Đổi hàng";
        } elseif($delivery[0]->type_id == 2){
            $menu_breadrum = "Trả hàng";
        }
    ?>
    <div id="panel_order_af" class="panel panel-default">
        <div class="panel-heading"><h4><?php echo 'Chi tiết khiếu nại '.$menu_breadrum.' đơn hàng số #'.$delivery[0]->order_id; ?></h4></div>
        <div class="panel-body">
                <div class="row">
                    <!-- Basic example -->
                    <?php
                    $status_changedelivery = "01";
                    
                    if($all_comments[0]->status_changedelivery == "01"){
                        $title                      = "Xác nhận yêu cầu";
                        $status_changedelivery      = "02";
                        $button                     = "Xác nhận";
                        $image                      =  FALSE;
                    } else if($all_comments[0]->status_changedelivery == "02"){
                        $title                      = "Trạng thái";
                    } else if($all_comments[0]->status_changedelivery == "03"){
                        $title                      = "Xác nhận tạo đơn hàng";
                        $status_changedelivery      = "04";
                        $button                     = "Xác nhận và tạo đơn hàng mới";
                        $image                      =  TRUE;
                        
                        if($delivery[0]->type_id == 2){
                            $button                 = "Xác nhận trả hàng và hoàn tiền";
                        }
                    } else if($all_comments[0]->status_changedelivery == "04"){
                        $title                      = "Trạng thái";
                    }
                    
                    $message = "";
                    if($all_comments[0]->status_changedelivery == "02"){
                        if($all_comments[0]->status_comment == 2){
                            $message                      = "Chờ thành viên xác nhận";
                        } else {
                            $message                      = "Chờ thành viên xác nhận - upload mẫu vận chuyển";
                        }
                    } else if($all_comments[0]->status_changedelivery == "04"){
                        $message                      = "Hoàn tất ".$menu_breadrum;
                    }
                    
                    ?>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4><?php echo $title; ?></h4></div>
                            <div class="panel-body">
                                <?php if($message == ""): ?>
                                
                                    <?php
                                        $pos    =   strpos($all_comments[1]->content, "reply_icon.png");
                                        if ($pos === false) {

                                        } else {
                                            ?>
                                                <div class="message success">
                                                    <div class="alert alert-danger">
                                                        Bạn có yêu cầu bắt buộc phải xử lý.
                                                        <button data-dismiss="alert" class="close" type="button">×</button>
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                
                                    <form role="form" action="<?php echo base_url().'account/submitComplaintsOrdersForm'; ?>" method="post" name="formDelivery" id="formDelivery">
                                        <div class="form-group">
                                            <label for="content">Nội dung</label>
                                            <textarea required="required" class="form-control" rows="5" name="content" id="content" placeholder="Vui lòng nhập nội dung"></textarea>
                                        </div>
                                        <?php if($status_changedelivery == "02"): ?>
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

                                        <?php if($image):?>
                                            <div class="form-group">
                                                <label for="content">Hình mã vận đơn</label><br/>
                                                <img width="50%" src="<?php echo DOMAIN_CLOUDSERVER.'media/images/mauvandon/'.$delivery[0]->bill; ?>" alt="Hình ảnh mã vận đơn" title="Hình ảnh mã vận đơn"/>    
                                            </div>
                                        <?php endif; ?>

                                        <input type="hidden" value="<?php echo $all_comments[0]->id_request; ?>" name="id_request"/>
                                        <input type="hidden" value="<?php echo $status_changedelivery; ?>" name="status_changedelivery"/>
                                        <button type="submit" class="btn btn-purple"><?php echo $button;?></button>
                                        <?php if($status_changedelivery == "04" && $delivery[0]->type_id == 1):?>
                                            <div style="padding:10px 0">Xác nhận bạn sẽ mất phí vận chuyển : <span id="shippingfee" style="color:red;padding:10px 0;font-weight:bold;">loading....</span></div>
                                        <?php endif; ?>
                                    </form>
                                <?php else :?>
                                    <?php echo $message; ?>
                                <?php endif; ?>
                            </div><!-- panel-body -->
                        </div> <!-- panel -->
                    </div>
                    
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4>Lịch sử tin nhắn</h4></div>
                            <div class="panel-body">
                                <div id="user-activities" class="tab-pane active">
                                    <div class="timeline-2">
                                        <?php if($all_comments): ?>
                                            <?php foreach($all_comments as $key => $vals): ?>
                                                <div class="time-item">
                                                    <div class="item-info">
                                                        <div class="text-muted"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></div>
                                                        <p class="history_group">
                                                            <a class="history_logo" target="_blank" href="//<?php echo $_thumb[$key]['link'];?>">
                                                                <img width="100%" src="<?php echo DOMAIN_CLOUDSERVER.$_thumb[$key]['logo'];?>" title="<?php echo $_thumb[$key]['name']; ?>" alt="<?php echo $_thumb[$key]['name']; ?>"/>
                                                            </a>
                                                            
                                                            <strong><?php echo $vals->content; ?></strong>
                                                            <div class="bill">
                                                                <?php if($_thumb[$key]['bill']): ?>
                                                                    <img id="bill" width="80%" src="<?php echo DOMAIN_CLOUDSERVER.$_thumb[$key]['bill'];?>" title="Hóa đơn - click phóng to" alt="Hóa đơn"/>
                                                                <?php endif; ?>
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            Không có dữ liệu.
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                    
                    
                </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Mẫu hóa đơn</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
        <img src="" id="imagepreview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    <?php if($status_changedelivery == "04"):?>
        getShippingFee();
    <?php endif; ?>
    function getShippingFee(){
        var order_id = "<?php echo $delivery[0]->order_id; ?>";
        $.ajax({
            type: "POST",
            url: siteUrl + "account/getShippingFee/"+order_id,
            success: function(responseData) {
               var data    = JSON.parse(responseData);
               if(data){
                   document.getElementById('shippingfee').innerHTML          = data.ServiceFee.toLocaleString('vi-VI') + ' đ';
               }
            }
        });
    }
    
    $("#bill").on("click", function() {
       $('#imagepreview').attr('src', $('#bill').attr('src')); // here asign the image to the modal when the user click the enlarge link
       $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });
    
    $('form').submit(function() {
        if($("#content").val() == ""){
            alert("Vui lòng nhập tin nhắn!");
            return false;
        } else {
            $(this).find("button[type='submit']").prop('disabled',true);
        }
    });
</script>
<?php $this->load->view('home/common/footer'); ?>
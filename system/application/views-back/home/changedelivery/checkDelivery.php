<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Kiểm tra đơn hàng khiếu nại</h3></div>
        <div class="panel-body">
            <p>Vui lòng nhập thông tin mã đơn hàng cần kiểm tra.</p>
            <form name="frmCheckDelivery" method="post" id="frmCheckDelivery" class="form-inline" role="form">
                <div class="form-group">
                    <div class="col-lg-12">
                        <input class="form-control" name="left_order_id" id="left_order_id" placeholder="Nhập mã đơn hàng" type="text" style="width:400px">
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4">
                        <button type="submit" class="btn btn-purple" id="checkDeliveryButton">Kiểm tra</button>
                        <span id="checkDeliveryLoading"></span>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4" style="padding:10px 0">
                        <span id="checkDeliveryResult"></span>
                    </div>
                </div>
            </form>
        </div> <!-- panel-body -->
    </div> <!-- panel -->
</div> <!-- col -->

<script type="text/javascript">
$(document).ready(function() { 
    $("#frmCheckDelivery").submit(function(e)
    {
        if($("#left_order_id").val() == ""){
            alert("Vui lòng nhập mã đơn hàng cần kiểm tra!");return false;
        }
        
        $('#checkDeliveryButton').attr('disabled','disabled');
        var postData = $(this).serializeArray();
        $.ajax(
        {
            url : '<?php echo base_url().'check-delivery'; ?>',
            type: "POST",
            data : postData,
            success:function(data) 
            {  
                
                var obj = JSON.parse(data);
                if(obj.error == 0){
                   location.reload();
                } else if (obj.error == 1){
                    window.location.href = "<?php echo base_url().'change-delivery/';?>"+$("#left_order_id").val()+ '?order_token=' + obj.order_token;
                    //$("#formRequest").removeAttr('disabled');
                } else if (obj.error == 2){
                    window.location.href = "<?php echo base_url().'change-delivery/';?>"+$("#left_order_id").val() + '?order_token=' + obj.order_token;
                }
            },
            error: function() 
            {
                alert("Sent error!!!");
            }
        });
        e.preventDefault();	//STOP default action
    });
});
</script>
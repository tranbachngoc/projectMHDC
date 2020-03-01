<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/style_azibai_bao.css" />
<script type="text/javascript">setTimeout(function(){location.href="<?php echo base_url().'account'; ?>"} , 5000);</script>
<div class="nganluong_cancle">
    <div class="error-template">
        <h1>
            Dịch vụ gian hàng thông báo</h1>
        <h2><?php echo $flash_message; ?></h2>
        <div class="error-details">
            Để tiếp tục sử dụng dịch vụ vui lòng gia hạn gói tại đây.
        </div>
        <div class="error-actions">
            <a href="<?php echo base_url().'account'; ?>" class="btn btn-azibai btn-lg"><span class="glyphicon glyphicon-home"></span>
                Quay lại </a>
        </div>
    </div>
</div>